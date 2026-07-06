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
            
            $isRudraProposal = ($this->proposal_id == 1 || $this->proposal_id == 2 || $this->id == 1 || $this->id == 2 || (isset($this->customer) && str_contains(strtolower($this->customer->name ?? ''), 'rudra')));
            $isKpstaProposal = ($this->proposal_id == 3 || $this->id == 3 || $this->url_slug == 'kpsta-website' || (isset($this->customer) && (str_contains(strtolower($this->customer->name ?? ''), 'kpsta') || str_contains(strtolower($this->customer->name ?? ''), 'kerala pradesh') || str_contains(strtolower($this->customer->name ?? ''), 'teacher'))));
            
            if ($isKpstaProposal) {
                $kpstaSegmentsEn = [
                    "Website Development and Maintenance Proposal for Kerala Pradesh School Teacher's Association, K.P.S.T.A.",
                    "Section 1: Project Scope. We are developing a modern, responsive static website for K.P.S.T.A., complete with a custom Admin Panel. This admin panel will allow your leadership team to easily upload and manage photo galleries, PDF circulars and academic documents, and association news and announcements.",
                    "Section 2: Hosting and Deployment. Total website development fee is quoted at a fixed price of 7,000 rupees. No hosting or server renewal fees are charged from our side! You provide your preferred hosting and domain, and we will handle the complete deployment, database setup, and turnkey handover at no extra cost.",
                    "Section 3: One Month Free Maintenance Scope. Following site handover and launch, we include 1 full month of complimentary maintenance. This free maintenance covers technical bug fixes, display troubleshooting, security checks, admin panel training for staff, and minor content or text adjustments. New feature additions or major redesigns outside the agreed scope will be quoted separately.",
                    "Section 4: Payment Terms and Options. Total project fee is 7,000 rupees. We offer two convenient payment plans: Option A is a 50 percent advance payment of 3,500 rupees to commence development, with the remaining 3,500 rupees due upon completion and handover. Option B is a 100 percent upfront payment of 7,000 rupees for streamlined priority development.",
                    "Section 5: Next Steps. To initiate development, simply approve this proposal and select your preferred payment option below. We look forward to building a prestigious online home for Kerala's teachers!"
                ];

                $kpstaSegmentsMl = [
                    "കേരള പ്രദേശ് സ്കൂൾ ടീച്ചേഴ്സ് അസോസിയേഷൻ, കെ.പി.എസ്.ടി.എ-യ്ക്ക് വേണ്ടിയുള്ള വെബ്സൈറ്റ് വികസനവും പരിപാലനവും സംബന്ധിച്ച കരാർ.",
                    "ഭാഗം 1: പ്രോജക്റ്റ് വിവരണം. കെ.പി.എസ്.ടി.എ-യ്ക്ക് വേണ്ടി അതിവേഗവും സുരക്ഷിതവുമായ ഒരു സ്റ്റാറ്റിക് വെബ്സൈറ്റും അത് എളുപ്പത്തിൽ നിയന്ത്രിക്കാനുള്ള കസ്റ്റം അഡ്മിൻ പാനലും ഞങ്ങൾ വികസിപ്പിക്കുന്നു. ഫോട്ടോ ഗാലറികൾ, പി.ഡി.എഫ് സർക്കുലറുകൾ, വാർത്തകളും അറിയിപ്പുകളും കോഡിംഗ് അറിവില്ലാതെ തന്നെ അഡ്മിൻ പാനൽ വഴി എളുപ്പത്തിൽ കൈകാര്യം ചെയ്യാം.",
                    "ഭാഗം 2: ഹോസ്റ്റിംഗും കൈമാറ്റവും. ആകെ നിർമ്മാണ ചെലവ് 7,000 രൂപയാണ്. ഞങ്ങളുടെ ഭാഗത്തുനിന്ന് വാർഷിക ഹോസ്റ്റിംഗ് ചാർജുകളോ റിന്യൂവൽ ഫീസോ ഈടാക്കുന്നതല്ല! താങ്കൾ നൽകുന്ന സെർവറിലും ഡൊമൈനിലും വെബ്സൈറ്റ് പൂർണ്ണമായി സജ്ജീകരിച്ച് സുരക്ഷിതമായി കൈമാറുന്നതാണ്.",
                    "ഭാഗം 3: 1 മാസത്തെ സൗജന്യ പരിപാലനം. വെബ്സൈറ്റ് ലോഞ്ച് ചെയ്തതിനു ശേഷം 1 മാസത്തേക്ക് പൂർണ്ണ സൗജന്യ സാങ്കേതിക പരിപാലനം നൽകുന്നു. സാങ്കേതിക തകരാറുകൾ പരിഹരിക്കൽ, അഡ്മിൻ പാനൽ ഉപയോഗിക്കാൻ ജീവനക്കാർക്ക് പരിശീലനം, സുരക്ഷാ പരിശോധന, ചെറിയ തിരുത്തലുകൾ എന്നിവ ഇതിൽ ഉൾപ്പെടുന്നു.",
                    "ഭാഗം 4: പേയ്മെന്റ് ഓപ്ഷനുകൾ. ആകെ തുക 7,000 രൂപയാണ്. രണ്ട് പേയ്മെന്റ് രീതികൾ ലഭ്യമാണ്: ഓപ്ഷൻ എ - ജോലി ആരംഭിക്കാൻ 3,500 രൂപ അഡ്വാൻസ് നൽകുക, ബാക്കി 3,500 രൂപ വെബ്സൈറ്റ് പൂർത്തിയായി കൈമാറിയ ശേഷം നൽകാം. ഓപ്ഷൻ ബി - പ്രോജക്റ്റിന് മുൻഗണന ലഭിക്കാൻ 7,000 രൂപ മുഴുവൻ തുകയും ഒന്നിച്ച് അടയ്ക്കാം.",
                    "ഭാഗം 5: അടുത്ത പടികൾ. പ്രോജക്റ്റ് ആരംഭിക്കുന്നതിനായി താഴെ കാണുന്ന അംഗീകരിക്കുക ബട്ടൺ ക്ലിക്ക് ചെയ്ത് പേയ്മെന്റ് രീതി തിരഞ്ഞെടുക്കാം. കേരളത്തിലെ അദ്ധ്യാപക സമൂഹത്തിനായി മികച്ചൊരു വെബ്സൈറ്റ് നിർമ്മിക്കാൻ ഞങ്ങൾ സദാ സജ്ജമാണ്!"
                ];
                $segments = ($lang === 'ml') ? $kpstaSegmentsMl : $kpstaSegmentsEn;
            } elseif ($isRudraProposal) {
                if ($this->url_slug == 'rudra-spirit-agreement' || ($this->proposal_id == 1 && $this->url_slug != 'rudra-spirit-hosting')) {
                    $agreementSegmentsEn = [
                        "Proposal 1: Initial Website Development and Maintenance Agreement for rudraspirit.com.",
                        "Section 1: Scope of Work. The project included a premium custom website of up to 20 pages, 2 payment gateway integrations, inventory management, product variants, customer dashboard, and e-commerce tracking.",
                        "Section 2: Financial Schedule. The total development cost was 40,000 rupees, payable across three milestones: 20,000 rupees advance, 10,000 rupees mid-development, and 10,000 rupees upon completion. This amount has been paid in full.",
                        "Section 3: Hosting and Renewal Terms. As stated in Sections 3 and 7 of the agreement, the initial 40,000 rupees fee included domain registration and hosting services for one year only. Section 7.2 explicitly states that subsequent hosting renewal is not included in maintenance and is charged separately at the current market rate.",
                        "Section 4: Maintenance and Support. The agreement provided 6 months of free post-launch support. After 6 months, ongoing maintenance is billed at 3,000 rupees per month.",
                        "Section 5: Current Status. This initial agreement is fully executed and paid. To view current hosting renewal charges and reactivate development, please switch to Proposal 2."
                    ];
                    $agreementSegmentsHi = [
                        "प्रस्ताव 1: रूद्र स्पिरिट डॉट कॉम के लिए प्रारंभिक वेबसाइट निर्माण और रखरखाव समझौता।",
                        "भाग 1: कार्य का दायरा। इस प्रोजेक्ट में 20 पेजों तक की कस्टम डिज़ाइन वेबसाइट, 2 पेमेंट गेटवे इंटीग्रेशन, इन्वेंट्री मैनेजमेंट, और ई-कॉमर्स ट्रैकिंग शामिल थे।",
                        "भाग 2: वित्तीय अनुसूची। वेबसाइट निर्माण की कुल लागत 40,000 रुपये थी, जिसका भुगतान तीन चरणों में किया गया: 20,000 रुपये अग्रिम, 10,000 रुपये मध्य-निर्माण, और 10,000 रुपये पूर्ण होने पर। यह पूरी राशि प्राप्त हो चुकी है।",
                        "भाग 3: होस्टिंग और नवीनीकरण शर्तें। समझौते के भाग 3 और 7 के अनुसार, प्रारंभिक 40,000 रुपये के शुल्क में केवल एक वर्ष के लिए डोमेन और होस्टिंग सेवा शामिल थी। भाग 7.2 स्पष्ट करता है कि इसके बाद होस्टिंग नवीनीकरण रखरखाव में शामिल नहीं है और इसे वर्तमान बाजार दर पर अलग से लिया जाएगा।",
                        "भाग 4: रखरखाव और सहायता। समझौते में लॉन्च के बाद 6 महीने की निःशुल्क सहायता शामिल थी। 6 महीने के बाद, निरंतर सहायता शुल्क 3,000 रुपये प्रति माह निर्धारित है।",
                        "भाग 5: वर्तमान स्थिति। यह प्रारंभिक समझौता पूर्ण और भुगतान किया हुआ है। वर्तमान होस्टिंग नवीनीकरण शुल्क देखने और काम दोबारा शुरू करने के लिए, कृपया प्रस्ताव 2 पर जाएं।"
                    ];
                    $segments = ($lang === 'hi') ? $agreementSegmentsHi : $agreementSegmentsEn;
                } else {
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
                }
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
