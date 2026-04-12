<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
        $this->middleware(['auth', 'XSS']);
    }

    /**
     * Get all active currencies as JSON (Public API)
     */
    public function listPublic()
    {
        $currencies = Currency::where('active', true)->orderBy('name')->get();

        return response()->json($currencies);
    }

    /**
     * Show all currencies and switch interface
     */
    public function index()
    {
        $currencies = Currency::where('active', true)->orderBy('name')->get();
        $currentCurrency = $this->currencyService->getUserCurrency();

        return view('currencies.index', compact('currencies', 'currentCurrency'));
    }

    /**
     * Switch user currency
     */
    public function switch(Request $request)
    {
        $request->validate([
            'currency_code' => 'required|exists:currencies,code|exists:currencies,active,true',
        ]);

        $this->currencyService->setUserCurrency(auth()->id(), $request->currency_code);

        return response()->json([
            'success' => true,
            'message' => 'Currency switched successfully',
            'currency' => $request->currency_code,
        ]);
    }

    /**
     * Get current user currency
     */
    public function getCurrent()
    {
        $currency = $this->currencyService->getUserCurrency();

        return response()->json([
            'code' => $currency->code,
            'symbol' => $currency->symbol,
            'name' => $currency->name,
            'rate' => $currency->exchange_rate,
        ]);
    }

    /**
     * Convert amount
     */
    public function convert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'from' => 'required|exists:currencies,code',
            'to' => 'required|exists:currencies,code',
        ]);

        $converted = $this->currencyService->convert(
            $request->amount,
            $request->from,
            $request->to
        );

        $rate = $this->currencyService->getRate($request->from, $request->to);

        return response()->json([
            'original' => $request->amount,
            'converted' => round($converted, 2),
            'from' => $request->from,
            'to' => $request->to,
            'rate' => round($rate, 6),
        ]);
    }

    /**
     * Admin: Update exchange rates
     */
    public function updateRates()
    {
        $this->authorize('manage-settings'); // Adjust permission as needed

        $success = $this->currencyService->updateExchangeRates();

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Exchange rates updated successfully' : 'Failed to update rates',
        ]);
    }

    /**
     * Admin: List all currencies
     */
    public function manage()
    {
        $this->authorize('manage-settings');

        $currencies = Currency::orderBy('name')->get();
        $defaultCurrency = Currency::where('is_default', true)->first();

        return view('settings.currencies', compact('currencies', 'defaultCurrency'));
    }

    /**
     * Admin: Toggle currency active status
     */
    public function toggle(Currency $currency)
    {
        $this->authorize('manage-settings');

        $currency->update(['active' => !$currency->active]);

        return response()->json([
            'success' => true,
            'active' => $currency->active,
        ]);
    }

    /**
     * Admin: Set default currency
     */
    public function setDefault(Currency $currency)
    {
        $this->authorize('manage-settings');

        Currency::query()->update(['is_default' => false]);
        $currency->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Default currency updated',
        ]);
    }
}
