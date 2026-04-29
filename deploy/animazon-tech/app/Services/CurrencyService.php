<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    const FRANKFURTER_BASE_URL = 'https://api.frankfurter.app';
    const CACHE_DURATION = 3600; // 1 hour

    /**
     * Fetch exchange rates from Frankfurter API
     */
    public function updateExchangeRates()
    {
        try {
            // Get all active currency codes
            $currencies = Currency::where('active', true)->pluck('code')->toArray();
            
            if (empty($currencies)) {
                return false;
            }

            // Get base currency from settings
            $baseCurrency = \App\Models\Utility::getValByName('site_currency') ?? 'USD';

            // We need to fetch the rate of our base currency as well
            $currenciesToFetch = array_unique(array_merge($currencies, [$baseCurrency]));

            // Fetch rates from Frankfurter API (base is EUR)
            $response = Http::timeout(10)
                ->get(self::FRANKFURTER_BASE_URL . '/latest', [
                    'base' => 'EUR',
                    'symbols' => implode(',', $currenciesToFetch)
                ]);

            if (!$response->successful()) {
                return false;
            }

            $rates = $response->json()['rates'] ?? [];
            $rates['EUR'] = 1.0;

            // Get EUR rate in the base currency
            $eurToBaseRate = $rates[$baseCurrency] ?? 1.0;

            // Update database
            foreach ($rates as $code => $rate) {
                // We don't need to update currencies that aren't in our active list
                if (!in_array($code, $currencies)) {
                    continue;
                }
                
                // Convert EUR-based rate to site base currency rate
                $baseRate = $rate / $eurToBaseRate;

                Currency::where('code', $code)->update([
                    'exchange_rate' => $baseRate,
                    'last_updated' => now(),
                ]);
            }

            // Flush cache
            Cache::forget('all_currencies');
            Cache::forget('active_currencies');

            return true;
        } catch (\Exception $e) {
            \Log::error('Currency update failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get EUR to USD rate
     */
    private function getEURtoUSD()
    {
        try {
            $response = Http::timeout(10)
                ->get(self::FRANKFURTER_BASE_URL . '/latest', [
                    'base' => 'EUR',
                    'symbols' => 'USD'
                ]);

            if ($response->successful()) {
                return $response->json()['rates']['USD'] ?? 1.0;
            }
        } catch (\Exception $e) {
            \Log::error('EUR/USD fetch failed: ' . $e->getMessage());
        }

        return 1.0;
    }

    /**
     * Convert amount from one currency to another
     */
    public function convert($amount, $fromCode, $toCode)
    {
        if ($fromCode === $toCode) {
            return $amount;
        }

        $from = Currency::where('code', $fromCode)->first();
        $to = Currency::where('code', $toCode)->first();

        if (!$from || !$to) {
            return $amount;
        }

        // Convert through USD as intermediate
        $amountInUSD = $amount / $from->exchange_rate;
        return $amountInUSD * $to->exchange_rate;
    }

    /**
     * Get conversion rate between two currencies
     */
    public function getRate($fromCode, $toCode)
    {
        if ($fromCode === $toCode) {
            return 1.0;
        }

        $from = Currency::where('code', $fromCode)->first();
        $to = Currency::where('code', $toCode)->first();

        if (!$from || !$to) {
            return 1.0;
        }

        // Rate = (To amount in USD) / (From amount in USD)
        return $to->exchange_rate / $from->exchange_rate;
    }

    /**
     * Get all active currencies
     */
    public function getActiveCurrencies()
    {
        return Cache::remember('active_currencies', self::CACHE_DURATION, function () {
            return Currency::where('active', true)
                ->orderBy('name')
                ->get()
                ->toArray();
        });
    }

    /**
     * Get default currency
     */
    public function getDefaultCurrency()
    {
        return Currency::getDefault();
    }

    /**
     * Set user's preferred currency
     */
    public function setUserCurrency($userId, $currencyCode)
    {
        $currency = Currency::where('code', $currencyCode)->first();
        if ($currency && $currency->active) {
            cache(["user_currency_$userId" => $currencyCode], 86400 * 30);
            return true;
        }
        return false;
    }

    /**
     * Get user's preferred currency
     */
    public function getUserCurrency($userId = null)
    {
        if ($userId === null && auth()->check()) {
            $userId = auth()->id();
        }

        if ($userId) {
            $cached = cache("user_currency_$userId");
            if ($cached) {
                $currency = Currency::where('code', $cached)->first();
                if ($currency) {
                    return $currency;
                }
            }
        }

        // Auto-detect from geolocation
        try {
            $geolocation = app('App\Services\GeolocationService');
            $currencyCode = $geolocation->getCurrencyFromIP();
            
            $currency = Currency::where('code', $currencyCode)
                ->where('active', true)
                ->first();

            if ($currency) {
                return $currency;
            }
        } catch (\Exception $e) {
            \Log::debug("Geolocation currency detection failed: " . $e->getMessage());
        }

        return $this->getDefaultCurrency();
    }
}
