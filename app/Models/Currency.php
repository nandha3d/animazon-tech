<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'symbol',
        'exchange_rate',
        'last_updated',
        'active',
        'is_default',
    ];

    protected $casts = [
        'exchange_rate' => 'decimal:6',
        'last_updated' => 'datetime',
        'active' => 'boolean',
        'is_default' => 'boolean',
    ];

    public static function getDefault()
    {
        return self::where('is_default', true)->first() ?? self::where('code', 'USD')->first();
    }

    public static function getActive()
    {
        return self::where('active', true)->orderBy('name')->get();
    }

    public static function convertAmount($amount, $fromCurrency, $toCurrency)
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        $from = self::where('code', $fromCurrency)->first();
        $to = self::where('code', $toCurrency)->first();

        if (!$from || !$to) {
            return $amount;
        }

        // Convert to base currency (USD) first, then to target
        $inUSD = $amount / $from->exchange_rate;
        return $inUSD * $to->exchange_rate;
    }
}
