<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Core currencies only - most commonly used globally
        $currencies = [
            // Base/Major currencies
            ['code' => 'USD', 'name' => 'United States Dollar', 'symbol' => '$', 'is_default' => true],
            ['code' => 'INR', 'name' => 'Indian Rupee', 'symbol' => '₹', 'is_default' => false],
            
            // European major
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'is_default' => false],
            ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£', 'is_default' => false],
            
            // Asia-Pacific
            ['code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥', 'is_default' => false],
            ['code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => 'A$', 'is_default' => false],
            ['code' => 'NZD', 'name' => 'New Zealand Dollar', 'symbol' => 'NZ$', 'is_default' => false],
            ['code' => 'SGD', 'name' => 'Singapore Dollar', 'symbol' => 'S$', 'is_default' => false],
            ['code' => 'HKD', 'name' => 'Hong Kong Dollar', 'symbol' => 'HK$', 'is_default' => false],
            ['code' => 'CNY', 'name' => 'Chinese Yuan', 'symbol' => '¥', 'is_default' => false],
            ['code' => 'THB', 'name' => 'Thai Baht', 'symbol' => '฿', 'is_default' => false],
            ['code' => 'MYR', 'name' => 'Malaysian Ringgit', 'symbol' => 'RM', 'is_default' => false],
            ['code' => 'PHP', 'name' => 'Philippine Peso', 'symbol' => '₱', 'is_default' => false],
            ['code' => 'KRW', 'name' => 'South Korean Won', 'symbol' => '₩', 'is_default' => false],
            
            // Americas
            ['code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => 'C$', 'is_default' => false],
            ['code' => 'MXN', 'name' => 'Mexican Peso', 'symbol' => '$', 'is_default' => false],
            ['code' => 'BRL', 'name' => 'Brazilian Real', 'symbol' => 'R$', 'is_default' => false],
            
            // Europe additional
            ['code' => 'CHF', 'name' => 'Swiss Franc', 'symbol' => 'CHF', 'is_default' => false],
            ['code' => 'SEK', 'name' => 'Swedish Krona', 'symbol' => 'kr', 'is_default' => false],
            ['code' => 'NOK', 'name' => 'Norwegian Krone', 'symbol' => 'kr', 'is_default' => false],
            
            // South Asia
            ['code' => 'PKR', 'name' => 'Pakistani Rupee', 'symbol' => '₨', 'is_default' => false],
            ['code' => 'BDT', 'name' => 'Bangladeshi Taka', 'symbol' => '৳', 'is_default' => false],
            ['code' => 'LKR', 'name' => 'Sri Lankan Rupee', 'symbol' => 'Rs', 'is_default' => false],
            
            // Middle East & Africa
            ['code' => 'TRY', 'name' => 'Turkish Lira', 'symbol' => '₺', 'is_default' => false],
            ['code' => 'ZAR', 'name' => 'South African Rand', 'symbol' => 'R', 'is_default' => false],
        ];

        foreach ($currencies as $currency) {
            Currency::updateOrCreate(
                ['code' => $currency['code']],
                [
                    'name' => $currency['name'],
                    'symbol' => $currency['symbol'],
                    'active' => true,
                    'is_default' => $currency['is_default'],
                    'exchange_rate' => 1.0, // Will be updated via API
                    'last_updated' => now(),
                ]
            );
        }

        // Update exchange rates from Frankfurter API
        try {
            $currencyService = new CurrencyService();
            $currencyService->updateExchangeRates();
            $this->command->info('✓ Exchange rates updated successfully from Frankfurter API.');
        } catch (\Exception $e) {
            $this->command->warn('⚠ Failed to fetch exchange rates: ' . $e->getMessage());
            $this->command->info('  Using default rates. Run "php artisan currency:update" after API is available.');
        }
    }
}

