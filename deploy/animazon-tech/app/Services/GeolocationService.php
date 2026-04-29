<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GeolocationService
{
    /**
     * Mapping of countries to currencies
     */
    private const COUNTRY_CURRENCY_MAP = [
        // Asia
        'IN' => 'INR',  // India
        'PK' => 'PKR',  // Pakistan
        'BD' => 'BDT',  // Bangladesh
        'LK' => 'LKR',  // Sri Lanka
        'NP' => 'NPR',  // Nepal
        'TH' => 'THB',  // Thailand
        'MY' => 'MYR',  // Malaysia
        'SG' => 'SGD',  // Singapore
        'ID' => 'IDR',  // Indonesia
        'PH' => 'PHP',  // Philippines
        'VN' => 'VND',  // Vietnam
        'CN' => 'CNY',  // China
        'JP' => 'JPY',  // Japan
        'KR' => 'KRW',  // South Korea
        'HK' => 'HKD',  // Hong Kong
        'TW' => 'TWD',  // Taiwan
        'TL' => 'USD',  // East Timor (use USD as fallback)
        
        // Europe
        'DE' => 'EUR',  // Germany
        'FR' => 'EUR',  // France
        'GB' => 'GBP',  // United Kingdom
        'IT' => 'EUR',  // Italy
        'ES' => 'EUR',  // Spain
        'NL' => 'EUR',  // Netherlands
        'BE' => 'EUR',  // Belgium
        'AT' => 'EUR',  // Austria
        'CH' => 'CHF',  // Switzerland
        'SE' => 'SEK',  // Sweden
        'NO' => 'NOK',  // Norway
        'DK' => 'DKK',  // Denmark
        'FI' => 'EUR',  // Finland
        'PL' => 'PLN',  // Poland
        'CZ' => 'CZK',  // Czech Republic
        'RO' => 'RON',  // Romania
        'TR' => 'TRY',  // Turkey
        'RU' => 'RUB',  // Russia
        'UA' => 'UAH',  // Ukraine
        'GR' => 'EUR',  // Greece
        'PT' => 'EUR',  // Portugal
        'IE' => 'EUR',  // Ireland
        
        // Americas
        'US' => 'USD',  // United States
        'CA' => 'CAD',  // Canada
        'MX' => 'MXN',  // Mexico
        'BR' => 'BRL',  // Brazil
        'AR' => 'ARS',  // Argentina
        'CL' => 'CLP',  // Chile
        'CO' => 'COP',  // Colombia
        'PE' => 'PEN',  // Peru
        'VE' => 'VEF',  // Venezuela
        
        // Africa
        'ZA' => 'ZAR',  // South Africa
        'EG' => 'EGP',  // Egypt
        'NG' => 'NGN',  // Nigeria
        'KE' => 'KES',  // Kenya
        'GH' => 'GHS',  // Ghana
        
        // Oceania
        'AU' => 'AUD',  // Australia
        'NZ' => 'NZD',  // New Zealand
    ];

    /**
     * Supported currencies for this app
     */
    private const SUPPORTED_CURRENCIES = [
        'USD', 'INR', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 
        'CHF', 'CNY', 'SEK', 'NZD', 'MXN', 'SGD', 'HKD', 
        'NOK', 'KRW', 'TRY', 'RUB', 'BRL', 'ZAR', 'PKR', 
        'BDT', 'THB', 'MYR', 'PHP', 'IDR', 'VND', 'LKR',
        'NPR', 'TW', 'TWD', 'DKK', 'PLN', 'CZK', 'RON',
        'UAH', 'EGP', 'NGN', 'KES', 'GHS', 'ARS', 'CLP',
        'COP', 'PEN', 'VEF'
    ];

    /**
     * Get user's country code from IP address
     */
    public function getCountryFromIP($ip = null)
    {
        if (!$ip) {
            $ip = request()->ip();
        }

        // Check cache first
        $cacheKey = "geolocation:country:{$ip}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            // Using ipapi.co (free, no key required)
            $response = Http::timeout(5)
                ->retry(2, 100)
                ->get("https://ipapi.co/{$ip}/json/");

            if ($response->successful()) {
                $data = $response->json();
                $countryCode = strtoupper($data['country_code'] ?? 'US');
                
                // Cache for 30 days
                Cache::put($cacheKey, $countryCode, 60 * 60 * 24 * 30);
                
                return $countryCode;
            }
        } catch (\Exception $e) {
            Log::warning("Geolocation lookup failed for IP {$ip}: " . $e->getMessage());
        }

        // Fallback to US
        return 'US';
    }

    /**
     * Get currency code for a country
     */
    public function getCurrencyForCountry($countryCode)
    {
        $countryCode = strtoupper($countryCode);
        
        $currency = self::COUNTRY_CURRENCY_MAP[$countryCode] ?? 'USD';

        // Check if currency is supported
        if (!in_array($currency, self::SUPPORTED_CURRENCIES)) {
            return 'USD';
        }

        return $currency;
    }

    /**
     * Get currency based on IP address
     */
    public function getCurrencyFromIP($ip = null)
    {
        $countryCode = $this->getCountryFromIP($ip);
        return $this->getCurrencyForCountry($countryCode);
    }

    /**
     * Get country code for authenticated user
     */
    public function getUserCountry($userId = null)
    {
        if (!$userId && auth()->check()) {
            $userId = auth()->id();
        }

        if (!$userId) {
            return $this->getCountryFromIP();
        }

        $cacheKey = "user:country:{$userId}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Could store user's country in users table
        // For now, detect from IP
        $country = $this->getCountryFromIP();
        Cache::put($cacheKey, $country, 60 * 60 * 24 * 7); // 7 days

        return $country;
    }

    /**
     * Get all supported currencies
     */
    public function getSupportedCurrencies()
    {
        return self::SUPPORTED_CURRENCIES;
    }

    /**
     * Get all country to currency mappings
     */
    public function getCountryCurrencyMap()
    {
        return self::COUNTRY_CURRENCY_MAP;
    }
}
