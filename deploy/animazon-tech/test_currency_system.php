<?php

// Test script for currency system
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test 1: Check currencies in database
echo "\n=== Test 1: Checking Currencies in Database ===\n";
$currencies = \App\Models\Currency::where('active', true)->limit(5)->get();
if ($currencies->count() > 0) {
    echo "✓ Found " . $currencies->count() . " active currencies\n";
    foreach ($currencies as $curr) {
        echo "  - {$curr->code} ({$curr->symbol}) - Rate: {$curr->exchange_rate}\n";
    }
} else {
    echo "✗ No currencies found in database\n";
}

// Test 2: Check geolocation service
echo "\n=== Test 2: Testing GeolocationService ===\n";
try {
    $geo = new \App\Services\GeolocationService();
    $usCurrency = $geo->getCurrencyForCountry('US');
    $indiaCurrency = $geo->getCurrencyForCountry('IN');
    $canadaCurrency = $geo->getCurrencyForCountry('CA');
    
    echo "✓ GeolocationService working:\n";
    echo "  - US -> {$usCurrency}\n";
    echo "  - IN -> {$indiaCurrency}\n";
    echo "  - CA -> {$canadaCurrency}\n";
} catch (\Exception $e) {
    echo "✗ GeolocationService error: " . $e->getMessage() . "\n";
}

// Test 3: Check CurrencyService
echo "\n=== Test 3: Testing CurrencyService ===\n";
try {
    $currencyService = new \App\Services\CurrencyService();
    $default = $currencyService->getDefaultCurrency();
    echo "✓ Default currency: {$default->code}\n";
    
    $active = $currencyService->getActiveCurrencies();
    echo "✓ Active currencies count: " . count($active) . "\n";
    
    $converted = $currencyService->convert(1000, 'USD', 'INR');
    echo "✓ Conversion test: 1000 USD = " . number_format($converted, 2) . " INR\n";
} catch (\Exception $e) {
    echo "✗ CurrencyService error: " . $e->getMessage() . "\n";
}

// Test 4: Check helper functions
echo "\n=== Test 4: Testing Helper Functions ===\n";
try {
    $formatted = currency_format(15000, 'INR');
    echo "✓ currency_format(15000, 'INR'): {$formatted}\n";
    
    $converted = convert_currency(1000, 'USD', 'USD');
    echo "✓ convert_currency(1000, 'USD', 'USD'): {$converted}\n";
    
    $symbol = get_currency_symbol('INR');
    echo "✓ get_currency_symbol('INR'): {$symbol}\n";
} catch (\Exception $e) {
    echo "✗ Helper function error: " . $e->getMessage() . "\n";
}

// Test 5: Check Cost Estimates table
echo "\n=== Test 5: Checking Cost Estimates Table ===\n";
try {
    $tableColumns = \DB::getSchemaBuilder()->getColumnListing('cost_estimates');
    if (in_array('currency_code', $tableColumns)) {
        echo "✓ currency_code column exists in cost_estimates table\n";
    } else {
        echo "✗ currency_code column missing from cost_estimates table\n";
    }
} catch (\Exception $e) {
    echo "✗ Error checking table: " . $e->getMessage() . "\n";
}

echo "\n=== Tests Complete ===\n\n";
