# Code Examples - Currency System

## Using Currency in Views

### Display Cost with Auto-Detected Currency
```blade
<!-- In blade template -->
@php
    $currency = get_user_currency();
@endphp

<h2>Total Cost: {{ $currency->symbol }}{{ number_format($estimate->grand_total, 2) }}</h2>
<small>≈ ${{ number_format(convert_currency($estimate->grand_total, $estimate->currency_code ?? 'USD', 'USD'), 2) }} USD</small>
```

### Currency Selector Component
```blade
<!-- Reusable component -->
<x-currency-selector />

<!-- With custom options -->
<x-currency-selector 
    label="Select Your Currency" 
    selected="INR"
/>
```

---

## Using Currency in Controllers

### Get User's Currency
```php
use App\Services\CurrencyService;

class CalculatorController extends Controller {
    protected $currencyService;
    
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }
    
    public function calculate(Request $request)
    {
        // Get user's detected/saved currency
        $userCurrency = $this->currencyService->getUserCurrency();
        
        // Convert cost to user's currency
        $totalCostUSD = 15000;
        $converted = $this->currencyService->convert(
            $totalCostUSD,
            'USD',
            $userCurrency->code
        );
        
        return response()->json([
            'cost_usd' => $totalCostUSD,
            'cost_converted' => $converted,
            'currency' => $userCurrency->code,
            'symbol' => $userCurrency->symbol
        ]);
    }
}
```

### Manual Currency Selection
```php
public function switchCurrency(Request $request)
{
    $request->validate([
        'currency_code' => 'required|exists:currencies,code'
    ]);
    
    $this->currencyService->setUserCurrency(
        auth()->id(),
        $request->currency_code
    );
    
    return response()->json(['success' => true]);
}
```

---

## Using Currency Helper Functions

### Format Currency
```php
// In views or controllers
// Use user's preferred currency
currency_format(15000)           // ₹15000.00

// Specific currency
currency_format(15000, 'INR')    // ₹15000.00
currency_format(15000, 'CAD')    // C$15000.00
currency_format(1000.5, 'USD')   // $1000.50
```

### Convert Between Currencies
```php
// Convert to user's currency
convert_currency(1000)           // 1000 USD → INR (if user is Indian)

// Specific conversion
convert_currency(1000, 'USD', 'INR')      // 83150.00
convert_currency(1000, 'EUR', 'GBP')      // 850.00
convert_currency(5000, 'CAD', 'USD')      // 3705.00
```

### Get Currency Symbol
```php
get_currency_symbol('INR')       // ₹
get_currency_symbol('CAD')       // C$
get_currency_symbol('USD')       // $
get_currency_symbol('EUR')       // €
get_currency_symbol('XXX')       // XXX (fallback)
```

### Get User's Currency Model
```php
$currency = get_user_currency();

echo $currency->code;            // USD
echo $currency->symbol;          // $
echo $currency->name;            // United States Dollar
echo $currency->exchange_rate;   // 1.000000
```

---

## Geolocation Service

### Detect Currency from IP
```php
use App\Services\GeolocationService;

$geo = new GeolocationService();

// Get currency from IP
$currency = $geo->getCurrencyFromIP('8.8.8.8');  // USD

// Get country from IP
$country = $geo->getCountryFromIP('203.0.113.0'); // IN

// Map country to currency
$currency = $geo->getCurrencyForCountry('IN');  // INR
$currency = $geo->getCurrencyForCountry('CA');  // CAD
$currency = $geo->getCurrencyForCountry('GB');  // GBP
```

---

## Currency Service

### Basic Operations
```php
use App\Services\CurrencyService;

$service = new CurrencyService();

// Get default currency (USD)
$default = $service->getDefaultCurrency();

// Get all active currencies (cached)
$active = $service->getActiveCurrencies();

// Convert amount
$converted = $service->convert(1000, 'USD', 'INR');  // 83150.00

// Get conversion rate
$rate = $service->getRate('USD', 'INR');  // 83.15

// Get user currency
$userCurrency = $service->getUserCurrency(auth()->id());

// Save user preference
$service->setUserCurrency(auth()->id(), 'INR');
```

### Update Exchange Rates
```php
$service = new CurrencyService();

try {
    $success = $service->updateExchangeRates();
    if ($success) {
        echo 'Rates updated successfully';
    }
} catch (Exception $e) {
    echo 'Update failed: ' . $e->getMessage();
}
```

---

## Database Queries

### Query Currencies
```php
use App\Models\Currency;

// Get all active currencies
$active = Currency::where('active', true)->get();

// Get specific currency
$inr = Currency::where('code', 'INR')->first();

// Get default
$default = Currency::where('is_default', true)->first();

// Order by name
$sorted = Currency::orderBy('name')->get();

// With exchange rate
$currencies = Currency::where('active', true)
    ->select('code', 'name', 'symbol', 'exchange_rate')
    ->get();
```

### Update Currency
```php
$currency = Currency::where('code', 'INR')->first();

$currency->update([
    'exchange_rate' => 84.25,
    'last_updated' => now(),
    'active' => true
]);
```

---

## JavaScript/Frontend

### Auto-Detect Currency
```javascript
// On page load
fetch('/currencies/current', {
    method: 'GET',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
})
.then(response => response.json())
.then(data => {
    console.log('User currency: ' + data.code);
    console.log('Symbol: ' + data.symbol);
    
    // Auto-select in dropdown
    document.getElementById('currencySelect').value = data.code;
});
```

### Switch Currency
```javascript
document.getElementById('currencySelect').addEventListener('change', function() {
    const currencyCode = this.value;
    
    fetch('/currencies/switch', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ currency_code: currencyCode })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Currency switched to ' + currencyCode);
            // Recalculate costs
            calculateCost();
        }
    });
});
```

### Convert Currency
```javascript
function convertCurrency() {
    const amount = 1000;
    const from = 'USD';
    const to = 'INR';
    
    fetch('/currencies/convert', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            amount: amount,
            from: from,
            to: to
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(`${data.original} ${data.from} = ${data.converted} ${data.to}`);
        console.log(`Rate: ${data.rate}`);
    });
}
```

---

## Blade Views

### Cost Calculator with Currency
```blade
<form id="calculatorForm">
    @csrf
    
    <!-- Currency Selector -->
    <div class="mb-3">
        <label class="form-label">Currency</label>
        <select id="currencySelect" class="form-select">
            <option value="">Auto-detecting...</option>
        </select>
        <input type="hidden" name="currency_code" id="currencyCode">
    </div>
    
    <!-- Questions... -->
    
    <!-- Results -->
    <div id="results" style="display: none;">
        <h3>
            <span id="symbol">$</span><span id="total">0.00</span>
            <small class="text-muted">≈ $<span id="totalUSD">0.00</span> USD</small>
        </h3>
    </div>
</form>

<script>
    // Load currencies on page load
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/currencies/current')
            .then(r => r.json())
            .then(data => {
                document.getElementById('currencyCode').value = data.code;
                document.getElementById('symbol').textContent = data.symbol;
            });
    });
</script>
```

---

## Admin Dashboard Example
```blade
@extends('layouts.admin')

@section('content')
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Rate (vs USD)</th>
                <th>Active</th>
                <th>Default</th>
            </tr>
        </thead>
        <tbody>
            @foreach($currencies as $currency)
                <tr>
                    <td><strong>{{ $currency->code }}</strong></td>
                    <td>{{ $currency->name }}</td>
                    <td><code>{{ $currency->exchange_rate }}</code></td>
                    <td>
                        <input type="checkbox" {{ $currency->active ? 'checked' : '' }}
                            onchange="toggleCurrency({{ $currency->id }})">
                    </td>
                    <td>
                        <input type="radio" name="default" value="{{ $currency->id }}"
                            {{ $currency->is_default ? 'checked' : '' }}
                            onchange="setDefault({{ $currency->id }})">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
```

---

## Testing

### Run Test Suite
```bash
php artisan test:currency
```

### Test Specific Functionality
```php
// In unit test
$service = new CurrencyService();
$converted = $service->convert(1000, 'USD', 'INR');
$this->assertGreaterThan(80000, $converted);
```

---

## Artisan Commands

### Update Rates
```bash
php artisan currency:update
```

### Run Tests
```bash
php artisan test:currency
```

### Clear Cache
```bash
php artisan cache:clear
```

### Database Commands
```bash
php artisan migrate                         # Run migrations
php artisan db:seed --class=CurrencySeeder  # Seed currencies
php artisan tinker                          # Interactive shell
```

---

## Common Patterns

### Save Estimate with Currency
```php
// In controller
Estimate::create([
    'project_name' => $request->project_name,
    'total_cost' => $totalCostUSD,
    'currency_code' => $request->currency_code ?? 'USD',  // New field
    // ... other fields
]);
```

### Display in List
```blade
@foreach($estimates as $estimate)
    <tr>
        <td>{{ $estimate->project_name }}</td>
        <td>
            @php
                $currency = Currency::find($estimate->currency_code ?? 'USD');
            @endphp
            {{ $currency->symbol ?? '$' }}{{ $estimate->total_cost }}
        </td>
    </tr>
@endforeach
```

### Retrieve Later
```php
// When viewing estimate, show in saved currency
$estimate = Estimate::find($id);
$currency = Currency::where('code', $estimate->currency_code)->first();

return view('estimate.show', [
    'estimate' => $estimate,
    'symbol' => $currency->symbol,
    'currency_code' => $estimate->currency_code
]);
```

---

## Troubleshooting Code

### Debug Geolocation
```php
$geo = new GeolocationService();
$country = $geo->getCountryFromIP(request()->ip());
dd($country); // Shows: "IN", "US", etc.
```

### Debug Currency Service
```php
$service = new CurrencyService();
$currencies = $service->getActiveCurrencies();
dd($currencies); // Shows all active currencies
```

### Debug Helper Functions
```php
dd(get_user_currency());      // Shows user's currency model
dd(convert_currency(1000));   // Shows conversion
dd(get_currency_symbol('INR')); // Shows ₹
```

---

*Last Updated: March 31, 2026*
