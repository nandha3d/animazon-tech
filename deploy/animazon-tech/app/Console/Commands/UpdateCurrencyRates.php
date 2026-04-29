<?php

namespace App\Console\Commands;

use App\Services\CurrencyService;
use Illuminate\Console\Command;

class UpdateCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Update exchange rates from Frankfurter API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating currency exchange rates...');

        try {
            $currencyService = new CurrencyService();
            $currencyService->updateExchangeRates();

            $this->info('✓ Exchange rates updated successfully');
            $this->line('All currencies are now up-to-date with the latest rates.');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('✗ Failed to update exchange rates: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
