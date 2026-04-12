# Quick Reference - Currency System

## What Was Done

✅ **Automatic currency detection** based on user's country (from IP)  
✅ **Manual currency selector** dropdown on calculator page  
✅ **Real-time cost conversion** showing local currency and USD  
✅ **Admin dashboard** for managing currencies  
✅ **25 core global currencies** seeded and ready  
✅ **Exchange rates** auto-fetched from Frankfurter API  
✅ **All tests passing** - system production ready  

---

## Quick Start

### For Users
1. Open cost calculator: `/cost-calculator`
2. Your currency auto-detected (based on country)
3. See estimated cost in your local currency
4. Can switch currency from dropdown anytime
5. Estimate saves with selected currency

### For Admins
1. Visit: `/admin/currencies/manage`
2. See all currencies and current rates
3. Toggle currencies active/inactive
4. Click "Update Exchange Rates" to force refresh
5. Set default currency (USD default)

### For Developers
```php
// Get user's currency
$currency = get_user_currency();    // Currency model

// Format amount
currency_format(15000, 'INR');      // ₹15000.00

// Convert amount
convert_currency(1000, 'USD', 'INR');  // 83150.00

// Get symbol
get_currency_symbol('INR');         // ₹
```

---

## Key Files

| File | Purpose |
|------|---------|
| `app/Services/GeolocationService.php` | IP → Country → Currency |
| `app/Services/CurrencyService.php` | Currency logic & conversions |
| `app/Http/Controllers/CurrencyController.php` | HTTP endpoints |
| `database/seeders/CurrencySeeder.php` | 25 core currencies |
| `resources/views/settings/currencies.blade.php` | Admin dashboard |
| `resources/views/cost-calculator/calculator.blade.php` | Calculator with selector |

---

## Commands

```bash
# Setup
php artisan migrate               # Create tables
php artisan db:seed --class=CurrencySeeder  # Seed currencies

# Update rates manually
php artisan currency:update       # Fetch latest rates from Frankfurter

# Test system
php artisan test:currency         # Run all tests
```

---

## How It Works

**User visits calculator:**
1. JavaScript calls `/currencies/current`
2. Server detects country from IP (geolocation)
3. Maps country to currency (e.g., India → INR)
4. Returns user's currency
5. Dropdown auto-selects it
6. User fills form and calculates
7. Cost shown in user's currency + USD reference
8. Preference cached for 30 days

**Database:**
- `currencies` table: All available currencies with exchange rates
- `cost_estimates` table: Now includes `currency_code` column
- Rates update daily at 2 AM (if scheduler configured)

---

## Supported Currencies

**Default List:**
USD, INR, EUR, GBP, JPY, AUD, CAD, CHF, CNY, SEK, NZD, MXN, SGD, HKD, NOK, KRW, TRY, ZAR, PKR, BDT, THB, MYR, PHP, LKR, BRL

**Country Mapping:**
- India → INR (₹)
- Canada → CAD (C$)
- US → USD ($)
- UK → GBP (£)
- Australia → AUD (A$)
- Germany → EUR (€)
- ... 50+ more countries

---

## Features

### Frontend
- ✅ Auto-detected currency
- ✅ Manual dropdown selector
- ✅ Real-time calculation
- ✅ Shows both local and USD
- ✅ Saves preference for 30 days
- ✅ Shows currency per estimate

### Backend
- ✅ Geolocation from IP
- ✅ Country-to-currency mapping
- ✅ Exchange rate fetching
- ✅ Caching (1hr rates, 30-day prefs)
- ✅ Error handling & fallbacks
- ✅ Global helper functions

### Admin
- ✅ Currency management dashboard
- ✅ Toggle active/inactive
- ✅ Set default currency
- ✅ Manual rate update button
- ✅ Statistics display
- ✅ Clean, organized UI

---

## Important Notes

1. **Auto-detect is automatic** - No user action needed
2. **Preferences persist** - Saved for 30 days
3. **Offline fallback** - Uses cached rates if API unavailable
4. **Unknown countries** - Default to USD
5. **Admin-only** - Currency management requires admin permission
6. **Cost stored with currency** - Can recreate amounts later

---

## Troubleshooting

**Currency not switching?**
→ Clear cache: `php artisan cache:clear`

**Rates not updating?**
→ Run manually: `php artisan currency:update`

**Geolocation incorrect?**
→ Can manually select in dropdown

**Exchange rates too old?**
→ Configure scheduler to run `currency:update` daily at 2 AM

---

## Testing

Run: `php artisan test:currency`

Verifies:
- ✓ Currencies in database
- ✓ Geolocation service
- ✓ Currency service
- ✓ Helper functions
- ✓ Database schema
- ✓ Core currencies availability

---

## File Structure

```
app/
├── Services/
│   ├── CurrencyService.php
│   └── GeolocationService.php (NEW)
├── Http/Controllers/
│   └── CurrencyController.php (NEW)
└── Console/Commands/
    ├── UpdateCurrencyRates.php (NEW)
    └── TestCurrencySystem.php (NEW)

database/
├── migrations/
│   ├── *_create_currencies_table.php (NEW)
│   └── *_add_currency_to_cost_estimates.php (NEW)
└── seeders/
    └── CurrencySeeder.php (UPDATED)

resources/views/
├── settings/
│   └── currencies.blade.php (NEW - Admin)
└── cost-calculator/
    ├── calculator.blade.php (UPDATED)
    └── estimates-list.blade.php (UPDATED)
```

---

## Support Documentation

- **Full Setup Guide:** `CURRENCY_SETUP.md`
- **Implementation Details:** `IMPLEMENTATION_COMPLETE.md`
- **Admin Dashboard:** `/admin/currencies/manage`
- **Test Suite:** `php artisan test:currency`

---

## Summary

✅ System **fully functional and production-ready**  
✅ Currency auto-detection **working**  
✅ All tests **passing**  
✅ Exchange rates **updating correctly**  
✅ Admin interface **complete**  

**Next: Restart your server for full functionality!**

---

*Last Updated: March 31, 2026 | Status: ✅ Ready to Deploy*
