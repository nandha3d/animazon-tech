<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Services\CurrencyService;
use App\Services\GeolocationService;
use Illuminate\Console\Command;

class TestCurrencySystem extends Command
{
    protected $signature = 'test:currency';
    protected $description = 'Test the currency system components';

    public function handle()
    {
        $this->info('=== Testing Currency System ===');

        // Test 1: Currencies in database
        $this->line('\n--- Test 1: Currencies in Database ---');
        $currencies = Currency::where('active', true)->limit(5)->get();
        if ($currencies->count() > 0) {
            $this->info("✓ Found {$currencies->count()} active currencies");
            foreach ($currencies as $curr) {
                $this->line("  - {$curr->code} ({$curr->symbol}) - Rate: {$curr->exchange_rate}");
            }
        } else {
            $this->error('✗ No currencies found');
        }

        // Test 2: GeolocationService
        $this->line('\n--- Test 2: GeolocationService ---');
        try {
            $geo = new GeolocationService();
            $usCurrency = $geo->getCurrencyForCountry('US');
            $indiaCurrency = $geo->getCurrencyForCountry('IN');
            $canadaCurrency = $geo->getCurrencyForCountry('CA');
            $unknownCurrency = $geo->getCurrencyForCountry('XX');
            
            $this->info('✓ GeolocationService working:');
            $this->line("  - US → {$usCurrency}");
            $this->line("  - IN → {$indiaCurrency}");
            $this->line("  - CA → {$canadaCurrency}");
            $this->line("  - XX (unknown) → {$unknownCurrency} (fallback)");
        } catch (\Exception $e) {
            $this->error('✗ GeolocationService error: ' . $e->getMessage());
        }

        // Test 3: CurrencyService
        $this->line('\n--- Test 3: CurrencyService ---');
        try {
            $currencyService = new CurrencyService();
            $default = $currencyService->getDefaultCurrency();
            $this->info("✓ Default currency: {$default->code}");
            
            $active = $currencyService->getActiveCurrencies();
            $this->info("✓ Active currencies in cache: " . count($active));
            
            $converted = $currencyService->convert(1000, 'USD', 'INR');
            $this->info("✓ Conversion: 1000 USD = " . number_format($converted, 2) . " INR");
        } catch (\Exception $e) {
            $this->error('✗ CurrencyService error: ' . $e->getMessage());
        }

        // Test 4: Helper functions
        $this->line('\n--- Test 4: Helper Functions ---');
        try {
            $formatted = currency_format(15000, 'INR');
            $this->info("✓ currency_format(15000, 'INR'): {$formatted}");
            
            $converted = convert_currency(1000, 'USD', 'USD');
            $this->info("✓ convert_currency(1000, 'USD', 'USD'): {$converted}");
            
            $symbol = get_currency_symbol('INR');
            $this->info("✓ get_currency_symbol('INR'): {$symbol}");
            
            $usdSymbol = get_currency_symbol('XXX');
            $this->info("✓ get_currency_symbol('XXX'): {$usdSymbol} (fallback)");
        } catch (\Exception $e) {
            $this->error('✗ Helper function error: ' . $e->getMessage());
        }

        // Test 5: Database schema
        $this->line('\n--- Test 5: Database Schema ---');
        try {
            $tableColumns = \DB::getSchemaBuilder()->getColumnListing('cost_estimates');
            if (in_array('currency_code', $tableColumns)) {
                $this->info('✓ currency_code column exists in cost_estimates table');
            } else {
                $this->error('✗ currency_code column missing from cost_estimates table');
            }
            
            $currenciesColumns = \DB::getSchemaBuilder()->getColumnListing('currencies');
            if (in_array('exchange_rate', $currenciesColumns)) {
                $this->info('✓ exchange_rate column exists in currencies table');
            }
        } catch (\Exception $e) {
            $this->error('✗ Error checking schema: ' . $e->getMessage());
        }

        // Test 6: Most common currencies available
        $this->line('\n--- Test 6: Core Currencies Availability ---');
        $requiredCurrencies = ['USD', 'INR', 'EUR', 'GBP', 'CAD'];
        $available = Currency::whereIn('code', $requiredCurrencies)->where('active', true)->pluck('code');
        foreach ($requiredCurrencies as $code) {
            if ($available->contains($code)) {
                $this->info("✓ {$code} available");
            } else {
                $this->warn("⚠ {$code} missing");
            }
        }

        $this->info('\n=== All Tests Complete ===');
    }
}
