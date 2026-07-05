<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'url_slug',
        'proposal_id',
        'customer_id',
        'issue_date',
        'valid_till',
        'status',
        'category_id',
        'terms',
        'is_convert',
        'converted_invoice_id',
        'accepted_at',
        'declined_at',
        'decline_reason',
        'created_by',
    ];

    protected $casts = [
        'issue_date'  => 'date',
        'valid_till'  => 'date',
        'accepted_at' => 'datetime',
        'declined_at' => 'datetime',
    ];

    public static $statues = [
        'Draft',
        'Open',
        'Accepted',
        'Declined',
        'Close',
    ];


    public function tax()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\ProposalProduct', 'proposal_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    /** Payments recorded against this proposal (client pay-now on the tracking page). */
    public function payments()
    {
        return $this->hasMany(ProposalPayment::class, 'proposal_id');
    }

    public function amountPaid()
    {
        return $this->payments->sum('amount');
    }

    public function isExpired(): bool
    {
        return $this->valid_till && now()->startOfDay()->gt($this->valid_till);
    }

    public function isAccepted(): bool
    {
        return (int) $this->status === 2;
    }

    public function isDeclined(): bool
    {
        return (int) $this->status === 3;
    }

    public function getSubTotal()
    {
        $subTotal = 0;
        foreach($this->items as $product)
        {
            $subTotal += ($product->price * $product->quantity);
        }

        return $subTotal;
    }


    public function getTotalTax()
    {
        $taxData = Utility::getTaxData();
        $totalTax = 0;
        foreach($this->items as $product)
        {
            // $taxes = Utility::totalTaxRate($product->tax);

            $taxArr = explode(',', $product->tax);
            $taxes = 0;
            foreach ($taxArr as $tax) {
                // $tax = TaxRate::find($tax);
                $taxes += !empty($taxData[$tax]['rate']) ? $taxData[$tax]['rate'] : 0;
            }

            $totalTax += ($taxes / 100) * ($product->price * $product->quantity);
        }

        return $totalTax;
    }

    public function getTotalDiscount()
    {
        $totalDiscount = 0;
        foreach($this->items as $product)
        {
            $totalDiscount += $product->discount;
        }

        return $totalDiscount;
    }

    public function getTotal()
    {
        return ($this->getSubTotal() -$this->getTotalDiscount()) + $this->getTotalTax();
    }

    public function getDue()
    {
        $paid = 0;
        foreach($this->payments as $payment)
        {
            $paid += $payment->amount;
        }

        return $this->getTotal() - $paid;
    }

    public static function change_status($proposal_id, $status)
    {

        $proposal         = Proposal::find($proposal_id);
        $proposal->status = $status;
        $proposal->update();
    }

    public function category()
    {
        return $this->hasOne('App\Models\ProductServiceCategory', 'id', 'category_id');
    }

    public function taxes()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax');
    }

    public function getPublicUrl()
    {
        if (!empty($this->url_slug)) {
            return route('proposal.link.copy', $this->url_slug);
        }
        return route('proposal.link.copy', \Illuminate\Support\Facades\Crypt::encrypt($this->id));
    }

    public function getSpeechSegments(array $settings = []): array
    {
        $segments = [];

        // 1. Billed To
        if (!empty($this->customer->billing_name)) {
            $segments[] = "Proposal billed to " . $this->customer->billing_name . ".";
        } else {
            $segments[] = "Proposal.";
        }

        // 2. Line Items
        foreach ($this->items as $item) {
            $name = !empty($item->product) ? $item->product->name : '';
            $qty = $item->quantity;
            $rate = $this->speechAmount($item->price, $settings);
            $itemText = "Item: " . $name . ". Quantity: " . $qty . ". Rate: " . $rate . ".";
            if (!empty($item->description)) {
                $itemText .= " Description: " . $item->description . ".";
            }
            $segments[] = $itemText;
        }

        // 3. Sub Total
        $segments[] = "Sub total " . $this->speechAmount($this->getSubTotal(), $settings) . ".";

        // 4. Discount
        if ($this->getTotalDiscount() > 0) {
            $segments[] = "Discount " . $this->speechAmount($this->getTotalDiscount(), $settings) . ".";
        }

        // 5. Each Tax Line
        $taxesData = [];
        $getTaxData = Utility::getTaxData();
        foreach ($this->items as $item) {
            if (!empty($item->tax)) {
                foreach (explode(',', $item->tax) as $taxId) {
                    if (!empty($getTaxData[$taxId])) {
                        $taxRate = $getTaxData[$taxId]['rate'];
                        $taxName = $getTaxData[$taxId]['name'];
                        $discount = !empty($item->discount) ? $item->discount : 0;
                        $taxPrice = \Utility::taxRate($taxRate, $item->price, $item->quantity, $discount);
                        
                        if (array_key_exists($taxName, $taxesData)) {
                            $taxesData[$taxName] += $taxPrice;
                        } else {
                            $taxesData[$taxName] = $taxPrice;
                        }
                    }
                }
            }
        }
        foreach ($taxesData as $taxName => $taxPrice) {
            if ($taxPrice > 0) {
                $segments[] = "Tax: " . $taxName . " " . $this->speechAmount($taxPrice, $settings) . ".";
            }
        }

        // 6. Total / Due
        $segments[] = "Total " . $this->speechAmount($this->getTotal(), $settings) . ".";

        // 7. Terms
        if (!empty($this->terms)) {
            $segments[] = "Terms and conditions: " . $this->normalizeTermsForSpeech($this->terms);
        }

        return $segments;
    }

    private function speechAmount($amount, array $settings): string
    {
        $amount = (float) $amount;
        if (floor($amount) == $amount) {
            $amountStr = (string) (int) $amount;
        } else {
            $amountStr = number_format($amount, 2, '.', '');
        }

        $currencyCode = !empty($settings['site_currency']) ? strtoupper($settings['site_currency']) : 'USD';
        
        $currencyMap = [
            'INR' => 'rupees',
            'USD' => 'dollars',
            'EUR' => 'euros',
            'GBP' => 'pounds',
        ];

        $currencyWord = isset($currencyMap[$currencyCode]) ? $currencyMap[$currencyCode] : $currencyCode;

        return $amountStr . " " . $currencyWord;
    }

    private function normalizeTermsForSpeech($terms): string
    {
        $normalized = str_replace(["\r\n", "\r", "\n"], ". ", $terms);
        $normalized = preg_replace('/\.(\s*\.)+/', '.', $normalized);
        $normalized = preg_replace('/\s+/', ' ', $normalized);
        return trim($normalized);
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($proposal) {
            $directory = public_path('storage/tts');
            if (file_exists($directory)) {
                foreach (glob($directory . '/proposal-' . $proposal->id . '-*.wav') as $file) {
                    @unlink($file);
                }
            }
        });
    }

    public function getTtsAudioUrl($lang = 'en')
    {
        $fileName = 'proposal-' . $this->id . '-' . $lang . '.wav';
        $directory = public_path('storage/tts');
        $outputPath = $directory . '/' . $fileName;

        if (!file_exists($outputPath)) {
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            
            $isRudraProposal = ($this->proposal_id == 1 || $this->id == 1 || (isset($this->customer) && str_contains(strtolower($this->customer->name ?? ''), 'rudra')));
            
            if ($isRudraProposal) {
                $rudraSegmentsEn = [
                    "Restart Fee and Dues for rudraspirit.com.",
                    "Section 1: Context. The rudraspirit.com website was completed, delivered, and the build fee paid in full of 40,000 rupees. Work then paused for roughly 6 months with no active development or feedback. Two amounts are now due to resume: unpaid hosting and domain charges of 2,400 rupees per month, running since 22 December 2025, and a restart fee to bring the dormant project back to a working, current, deployable state. There is no kill fee and nothing extra on the completed build.",
                    "Section 2: Why the restart fee applies. Six months of dormancy creates real, billable work before development can resume: rebuilding the local dev environment, re-establishing deployment, WordPress and plugin updates, security review and patching, PHP and server compatibility, and context re-familiarization.",
                    "Section 3: Upgrade to Premium VPS Hosting. To prioritize search engine optimization and support business scaling, we migrated the website from Hostinger Shared Hosting to a high-performance, dedicated Virtual Private Server. Benefits of VPS hosting include lightning-fast loading speeds for higher Google SEO rankings, exclusive CPU and RAM to handle high concurrent traffic during promotion, isolated security with dedicated IP, and proactive 24/7 server monitoring.",
                    "Section 4: Amount payable now. Congratulations! We have waived off your 6,000 rupees restart fee as a goodwill gesture. You pay 0 rupees for reactivation and only settle the pending web hosting charges of 16,800 rupees. Unpaid hosting and domain renewal since 22 December 2025 is 16,800 rupees. The 6,000 rupees restart fee is waived. Total payable now is 16,800 rupees.",
                    "Section 5: Terms to resume. Total of 16,800 rupees is payable in advance before development resumes. Hosting renewal is mandatory at 2,400 rupees per month or automated auto pay subscription."
                ];

                $rudraSegmentsHi = [
                    "रूद्र स्पिरिट डॉट कॉम के लिए पुनः आरंभ शुल्क और बकाया राशि।",
                    "भाग 1: संदर्भ। रूद्र स्पिरिट डॉट कॉम वेबसाइट पूरी हो चुकी थी, डिलीवर कर दी गई थी, और निर्माण शुल्क 40,000 रुपये का पूरा भुगतान कर दिया गया था। इसके बाद लगभग 6 महीने तक कोई काम या फीडबैक नहीं मिला। काम फिर से शुरू करने के लिए दो राशियाँ देय हैं: 22 दिसंबर 2025 से बकाया होस्टिंग और डोमेन शुल्क 2,400 रुपये प्रति माह, और प्रोजेक्ट को फिर से चालू करने का पुनः आरंभ शुल्क।",
                    "भाग 2: पुनः आरंभ शुल्क क्यों लागू होता है। 6 महीने की निष्क्रियता के बाद काम दोबारा शुरू करने से पहले वास्तविक काम करना पड़ता है: लोकल डेवलपमेंट एनवायरनमेंट दोबारा बनाना, डिप्लॉयमेंट दोबारा स्थापित करना, वर्डप्रेस और प्लगइन अपडेट, सुरक्षा जाँच और पैचिंग, पीएचपी और सर्वर संगतता, और प्रोजेक्ट संदर्भ दोबारा समझना।",
                    "भाग 3: प्रीमियम वीपीएस होस्टिंग में अपग्रेड। आपके व्यवसाय की वृद्धि और एसईओ अनुकूलन को प्राथमिकता देने के लिए हमने वेबसाइट को होस्टिंगर शेयर्ड होस्टिंग से एक समर्पित वर्चुअल प्राइवेट सर्वर पर माइग्रेट कर दिया है। वीपीएस होस्टिंग के लाभों में गूगल एसईओ रैंकिंग बढ़ाने के लिए सुपर-फ़ास्ट लोडिंग स्पीड, बेहतर ट्रैफिक क्षमता, और दैनिक बैकअप के साथ उन्नत सुरक्षा शामिल है।",
                    "भाग 4: अभी देय राशि। बधाई हो! हमने सद्भावना स्वरूप आपका 6,000 रुपये का पुनः आरंभ शुल्क माफ़ कर दिया है! आपको पुनःसक्रियण के लिए 0 रुपये देना होगा और केवल बकाया वेब होस्टिंग शुल्क 16,800 रुपये का भुगतान करना होगा। 22 दिस॰ 2025 से बकाया होस्टिंग और डोमेन नवीनीकरण 16800 रुपये है। 6,000 रुपये पुनः आरंभ शुल्क माफ़ है। अभी देय कुल राशि 16,800 रुपये है।",
                    "भाग 5: दोबारा शुरू करने की शर्तें। काम शुरू होने से पहले केवल बकाया होस्टिंग और डोमेन के 16,800 रुपये अग्रिम देय हैं। 2,400 रुपये प्रति माह पर निरंतर वेब होस्टिंग नवीनीकरण अनिवार्य है।"
                ];
                $segments = ($lang === 'hi') ? $rudraSegmentsHi : $rudraSegmentsEn;
            } else {
                $segments = $this->getSpeechSegments(\App\Models\Utility::settingsById($this->created_by));
            }

            $voice = 'af_sarah';
            try {
                $serviceUrl = env('KOKORO_TTS_SERVICE_URL', 'http://localhost:8000') . '/api/tts/generate';
                $response = \Illuminate\Support\Facades\Http::timeout(60)->post($serviceUrl, [
                    'segments' => $segments,
                    'voice' => $voice,
                    'lang' => $lang,
                ]);

                if ($response->successful()) {
                    file_put_contents($outputPath, $response->body());
                } else {
                    \Log::warning("Kokoro TTS microservice error: Status " . $response->status() . " - " . $response->body());
                }
            } catch (\Exception $e) {
                \Log::error("Failed to connect to Kokoro TTS microservice: " . $e->getMessage());
            }
        }

        return asset('storage/tts/' . $fileName);
    }

}
