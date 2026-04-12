<?php

if (!function_exists('currency_format')) {
    /**
     * Format a number as currency
     *
     * @param float $amount
     * @param string|null $currencyCode
     * @return string
     */
    function currency_format($amount, $currencyCode = null)
    {
        $currencyService = app('App\Services\CurrencyService');
        
        if (!$currencyCode) {
            $currency = $currencyService->getUserCurrency();
            $currencyCode = $currency->code;
        } else {
            $currency = \App\Models\Currency::where('code', $currencyCode)->first();
        }

        if (!$currency) {
            return number_format($amount, 2);
        }

        $symbol = $currency->symbol;
        $formatted = number_format($amount, 2);

        // Format based on currency position convention
        if (in_array($currency->code, ['USD', 'EUR', 'GBP', 'CHF', 'AUD', 'CAD', 'NZD', 'SGD', 'HKD'])) {
            return $symbol . $formatted;
        } else {
            return $formatted . ' ' . $symbol;
        }
    }
}

if (!function_exists('convert_currency')) {
    /**
     * Convert an amount between two currencies
     *
     * @param float $amount
     * @param string $fromCode
     * @param string $toCode
     * @return float
     */
    function convert_currency($amount, $fromCode = 'USD', $toCode = null)
    {
        $currencyService = app('App\Services\CurrencyService');
        
        if (!$toCode) {
            $currency = $currencyService->getUserCurrency();
            $toCode = $currency->code;
        }

        return $currencyService->convert($amount, $fromCode, $toCode);
    }
}

if (!function_exists('get_currency_symbol')) {
    /**
     * Get symbol for a currency code
     *
     * @param string $currencyCode
     * @return string|null
     */
    function get_currency_symbol($currencyCode)
    {
        $currency = \App\Models\Currency::where('code', $currencyCode)->first();
        return $currency ? $currency->symbol : $currencyCode;
    }
}

if (!function_exists('get_user_currency')) {
    /**
     * Get the user's preferred currency
     *
     * @return \App\Models\Currency
     */
    function get_user_currency()
    {
        $currencyService = app('App\Services\CurrencyService');
        return $currencyService->getUserCurrency();
    }
}
