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

        if (file_exists($outputPath)) {
            return asset('storage/tts/' . $fileName);
        }

        return '';
    }

}
