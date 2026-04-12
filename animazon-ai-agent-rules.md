# Animazon – AI Agent Development Rules

> **Purpose:** This document defines the mandatory rules and architecture conventions that all AI agents must follow when working on the Animazon codebase. These rules exist to ensure consistency, prevent hardcoding, and preserve the project's modular Laravel architecture.

---

## Table of Contents

1. [Stack Overview](#1-stack-overview)
2. [Golden Rules — Non-Negotiable](#2-golden-rules--non-negotiable)
3. [Environment Variables — Never Hardcode](#3-environment-variables--never-hardcode)
4. [Module Architecture Rules](#4-module-architecture-rules)
5. [Controller Conventions](#5-controller-conventions)
6. [Model Conventions](#6-model-conventions)
7. [Routing Conventions](#7-routing-conventions)
8. [Blade View Conventions](#8-blade-view-conventions)
9. [Tailwind CSS Conventions](#9-tailwind-css-conventions)
10. [Database & Migration Rules](#10-database--migration-rules)
11. [Configuration Rules](#11-configuration-rules)
12. [Security Rules](#12-security-rules)
13. [File & Asset Rules](#13-file--asset-rules)
14. [Forbidden Patterns](#14-forbidden-patterns)
15. [Checklist Before Submitting Code](#15-checklist-before-submitting-code)

---

## 1. Stack Overview

Before writing any code, understand and respect the existing stack:

| Layer | Technology | Version |
|---|---|---|
| Backend | Laravel | ^11.44.1 |
| Language | PHP | ^8.2 |
| Templating | Blade | Built-in |
| Frontend Build | Vite + laravel-vite-plugin | ^5.0 / ^1.0 |
| CSS Framework | Tailwind CSS | Latest |
| HTTP Client | Axios | ^1.6.4 |
| Module System | nwidart/laravel-modules | ^11.1 |
| Auth / Tokens | Laravel Sanctum | ^4.0 |
| Permissions | spatie/laravel-permission | ^6.9 |
| Database | MySQL | 8.x |

**Do not introduce new frameworks, build tools, or languages without explicit approval.**

---

## 2. Golden Rules — Non-Negotiable

These rules apply to every single file, function, and line of code written in this project.

### Rule 1 — No Hardcoded Values. Ever.
Never write raw strings, URLs, credentials, IDs, or configuration values directly into code. Every environment-specific value must come from `.env` via `config()` or `env()`.

```php
// ❌ WRONG
$apiKey = 'sk-live-abc123xyz';
$fromEmail = 'hello@animazon.com';
$appName = 'Animazon';
$dbHost = '127.0.0.1';

// ✅ CORRECT
$apiKey = config('services.stripe.key');
$fromEmail = config('mail.from.address');
$appName = config('app.name');
$dbHost = config('database.connections.mysql.host');
```

### Rule 2 — No Hardcoded Route URLs in Views or Controllers
Use named routes. Always.

```php
// ❌ WRONG
<a href="/contact">Contact</a>
return redirect('/dashboard');

// ✅ CORRECT
<a href="{{ route('contact.index') }}">Contact</a>
return redirect()->route('dashboard');
```

### Rule 3 — No Hardcoded Text Strings (Use Lang/Translation Keys)
All user-facing strings must go through Laravel's `__()` translation helper so the site can be localized.

```php
// ❌ WRONG
return back()->with('error', 'Permission denied.');
$title = 'Medical Animation Services';

// ✅ CORRECT
return back()->with('error', __('Permission denied.'));
$title = __('services.medical.title');
```

### Rule 4 — Respect the Module Boundary
Code for a module lives inside that module. Do not reach into another module's internals directly. Cross-module communication goes through service classes or Laravel events.

### Rule 5 — Follow Existing Patterns
Before writing anything new, read the existing equivalent file. Match the pattern, naming, and structure already in use.

---

## 3. Environment Variables — Never Hardcode

### Reading Variables Correctly

Always access environment values through the `config()` helper — never call `env()` directly in application code (only in `config/*.php` files).

```php
// ❌ WRONG — env() outside of config files is unreliable (cached builds break it)
$key = env('STRIPE_KEY');

// ✅ CORRECT — use config() in controllers, models, and services
$key = config('services.stripe.key');
```

### Defining New Variables

When a new configurable value is needed:

**Step 1:** Add it to `.env.example` with a placeholder:
```env
# Step 1 — .env.example
ANIMAZON_CONTACT_EMAIL=
ANIMAZON_CALENDLY_URL=
```

**Step 2:** Add it to `.env` (your local instance):
```env
# Step 2 — .env (never commit this file)
ANIMAZON_CONTACT_EMAIL=hello@animazon.com
ANIMAZON_CALENDLY_URL=https://calendly.com/animazon/30min
```

**Step 3:** Register it in the appropriate `config/*.php` file:
```php
// config/animazon.php
return [
    'contact_email' => env('ANIMAZON_CONTACT_EMAIL', 'hello@animazon.com'),
    'calendly_url'  => env('ANIMAZON_CALENDLY_URL', ''),
];
```

**Step 4:** Use in code via `config()`:
```php
$email = config('animazon.contact_email');
$url   = config('animazon.calendly_url');
```

### Standard Variables Already Defined

| Variable | Access via |
|---|---|
| App name | `config('app.name')` |
| App URL | `config('app.url')` |
| App environment | `config('app.env')` |
| Database config | `config('database.connections.mysql.*')` |
| Mail from address | `config('mail.from.address')` |
| Mail from name | `config('mail.from.name')` |
| Pusher credentials | `config('broadcasting.connections.pusher.*')` |
| Queue driver | `config('queue.default')` |
| Cache driver | `config('cache.default')` |
| Session driver | `config('session.driver')` |

---

## 4. Module Architecture Rules

The project uses **nwidart/laravel-modules**. All features must be built as self-contained modules under `Modules/`.

### Module Directory Structure

Every module must follow this exact structure:

```
Modules/
└── YourModule/
    ├── Config/
    │   └── config.php              ← Module-level config (no hardcoded values)
    ├── Console/                    ← Artisan commands for this module
    ├── Database/
    │   ├── Migrations/             ← Module-specific migrations
    │   ├── Seeders/                ← Module-specific seeders
    │   └── factories/              ← Model factories
    ├── Entities/                   ← Eloquent models (or use app/Models if shared)
    ├── Http/
    │   ├── Controllers/            ← Module controllers
    │   ├── Middleware/             ← Module-specific middleware
    │   └── Requests/               ← Form request validation classes
    ├── Providers/
    │   ├── YourModuleServiceProvider.php
    │   └── RouteServiceProvider.php
    ├── Resources/
    │   ├── assets/
    │   │   ├── css/
    │   │   └── js/
    │   └── views/                  ← Blade views (namespaced: module::view)
    ├── Routes/
    │   ├── web.php
    │   └── api.php
    ├── Tests/
    ├── composer.json
    ├── module.json
    └── vite.config.js
```

### Creating a New Module

```bash
# Always use the artisan command — never create module folders manually
php artisan module:make YourModuleName

# Create a controller inside a module
php artisan module:make-controller YourController YourModuleName

# Create a model inside a module
php artisan module:make-model YourModel YourModuleName

# Create a migration inside a module
php artisan module:make-migration create_your_table YourModuleName
```

### Module View Namespacing

Views inside modules are accessed with the `module::` prefix:

```php
// ❌ WRONG
return view('services.medical');

// ✅ CORRECT — use the module namespace
return view('services::medical.index');
return view('landingpage::landingpage.homesection');
```

### Module Config

Each module has its own `Config/config.php`. All module-level settings go here — never hardcoded inline:

```php
// Modules/Portfolio/Config/config.php
return [
    'items_per_page'   => env('PORTFOLIO_PER_PAGE', 12),
    'allowed_formats'  => ['mp4', 'webm', 'gif'],
    'max_upload_mb'    => env('PORTFOLIO_MAX_UPLOAD_MB', 50),
];

// Usage in a controller
$perPage = config('portfolio.items_per_page');
```

---

## 5. Controller Conventions

### Namespace Pattern
```php
<?php

namespace Modules\YourModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\YourModule\Entities\YourModel;
```

### Resourceful Controllers

Follow RESTful conventions. Use standard method names:

| Method | HTTP Verb | Purpose |
|---|---|---|
| `index()` | GET | List all resources |
| `create()` | GET | Show creation form |
| `store()` | POST | Save new resource |
| `show($id)` | GET | Display one resource |
| `edit($id)` | GET | Show edit form |
| `update(Request, $id)` | PUT/PATCH | Update resource |
| `destroy($id)` | DELETE | Delete resource |

### Validation — Use Form Request Classes

Never validate inside the controller method itself. Always create a dedicated Request class:

```php
// ❌ WRONG — validation inline in controller
public function store(Request $request)
{
    $request->validate(['name' => 'required|string']);
}

// ✅ CORRECT — dedicated Form Request
public function store(StoreContactRequest $request)
{
    // $request is already validated by StoreContactRequest
}
```

```bash
# Generate a Form Request
php artisan module:make-request StoreContactRequest Contact
```

### Response Patterns

```php
// Success redirect with flash message
return redirect()->route('contact.index')->with('success', __('Message sent successfully.'));

// Error redirect
return redirect()->back()->with('error', __('Permission denied.'));

// Return view with data
return view('contact::index', compact('enquiries', 'stats'));

// JSON API response
return response()->json(['status' => 'success', 'data' => $result], 200);
```

### Permission Checks

Use spatie/laravel-permission — check permissions before any action:

```php
public function destroy($id)
{
    if (!Auth::user()->can('delete contact enquiry')) {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
    // proceed with deletion
}
```

---

## 6. Model Conventions

### Namespace Pattern
```php
<?php

namespace Modules\YourModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
```

### Always Define `$fillable`

Never use `$guarded = []`. Always explicitly list fillable fields:

```php
// ❌ WRONG
protected $guarded = [];

// ✅ CORRECT
protected $fillable = [
    'name',
    'email',
    'project_type',
    'budget_range',
    'message',
    'status',
    'created_by',
];
```

### Casting and Dates

```php
protected $casts = [
    'metadata'   => 'array',
    'is_active'  => 'boolean',
    'published_at' => 'datetime',
];
```

### Scopes for Common Queries

```php
// Define reusable query scopes — don't repeat WHERE clauses in controllers
public function scopeActive($query)
{
    return $query->where('is_active', true);
}

public function scopeForUser($query, $userId)
{
    return $query->where('created_by', $userId);
}

// Usage in controller
$enquiries = ContactEnquiry::active()->forUser(Auth::id())->latest()->paginate(20);
```

---

## 7. Routing Conventions

### Always Name Every Route

```php
// ❌ WRONG — unnamed routes break refactoring
Route::get('/portfolio', [PortfolioController::class, 'index']);

// ✅ CORRECT — named routes are required
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolio.show');
```

### Group Routes with Middleware

```php
// Modules/Portfolio/Routes/web.php
Route::group([
    'middleware' => ['XSS'],
    'prefix'     => 'portfolio',
    'as'         => 'portfolio.',
], function () {
    Route::get('/', [PortfolioController::class, 'index'])->name('index');
    Route::get('/{slug}', [PortfolioController::class, 'show'])->name('show');
});

// Auth-protected admin routes
Route::group([
    'middleware' => ['auth', 'XSS'],
    'prefix'     => 'admin/portfolio',
    'as'         => 'admin.portfolio.',
], function () {
    Route::resource('/', PortfolioController::class);
});
```

### Route Parameter Naming

Use descriptive names — never generic `$id` when you can use `$slug` or a resource name:

```php
// ❌ WRONG
Route::get('/case-studies/{id}', ...);

// ✅ CORRECT
Route::get('/case-studies/{caseStudy}', ...); // triggers model binding
Route::get('/blog/{slug}', ...);
```

---

## 8. Blade View Conventions

### Layout Inheritance

Always extend the module layout, never build standalone HTML pages:

```blade
{{-- ✅ CORRECT --}}
@extends('layouts.admin')

@section('title', __('Portfolio'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Portfolio') }}</li>
@endsection

@section('content')
    {{-- page content here --}}
@endsection
```

### No Inline Styles

Use Tailwind utility classes only. Never write `style=""` attributes:

```blade
{{-- ❌ WRONG --}}
<div style="background-color: #0A0A0F; padding: 40px;">

{{-- ✅ CORRECT --}}
<div class="bg-animazon-black p-10">
```

### Variables — Always Escape Output

```blade
{{-- ❌ WRONG — XSS vulnerability --}}
{!! $userInput !!}

{{-- ✅ CORRECT — escaped by default --}}
{{ $userInput }}

{{-- Only use {!! !!} for trusted, sanitized HTML from the application itself --}}
{!! $setting->rich_text_content !!}
```

### Translations in Views

```blade
{{-- ❌ WRONG --}}
<h1>Turn Complex Ideas into Visual Experiences</h1>

{{-- ✅ CORRECT --}}
<h1>{{ __('hero.headline') }}</h1>
{{-- or for inline with no lang file needed: --}}
<h1>{{ __('Turn Complex Ideas into Visual Experiences') }}</h1>
```

### Assets — Always Use Vite Helper

```blade
{{-- ❌ WRONG --}}
<link rel="stylesheet" href="/css/app.css">
<script src="/js/app.js"></script>

{{-- ✅ CORRECT --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

---

## 9. Tailwind CSS Conventions

### Use Config-Defined Colors (No Raw Hex in Templates)

Define all brand colors in `tailwind.config.js`, then reference them by name:

```javascript
// tailwind.config.js — define once
theme: {
    extend: {
        colors: {
            'animazon-black':     '#0A0A0F',
            'animazon-navy':      '#0F1020',
            'animazon-blue':      '#2563EB',
            'animazon-purple':    '#7C3AED',
            'animazon-highlight': '#38BDF8',
            'animazon-white':     '#F8FAFC',
            'animazon-muted':     '#94A3B8',
        },
        fontFamily: {
            heading: ['Montserrat', 'Poppins', 'sans-serif'],
            body:    ['Inter', 'sans-serif'],
        },
    },
}
```

```blade
{{-- ❌ WRONG — arbitrary values bypass the design system --}}
<div class="bg-[#0A0A0F] text-[#F8FAFC]">

{{-- ✅ CORRECT — uses named config tokens --}}
<div class="bg-animazon-black text-animazon-white">
```

### Component Classes for Repeated Patterns

Extract repeated Tailwind patterns into Blade components or CSS `@apply` blocks — never copy-paste the same class string multiple times:

```css
/* resources/css/app.css */
@layer components {
    .btn-primary {
        @apply bg-animazon-blue text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200;
    }
    .btn-ghost {
        @apply border border-animazon-blue text-animazon-blue px-6 py-3 rounded-lg hover:bg-animazon-blue hover:text-white transition-colors duration-200;
    }
    .card-dark {
        @apply bg-animazon-navy border border-animazon-muted/20 rounded-xl p-6;
    }
}
```

```blade
{{-- Usage --}}
<a href="{{ route('contact.index') }}" class="btn-primary">{{ __('Start Your Project') }}</a>
```

---

## 10. Database & Migration Rules

### Always Write Reversible Migrations

Every `up()` method must have a corresponding `down()` method that fully reverses it:

```php
// ✅ CORRECT
public function up(): void
{
    Schema::create('contact_enquiries', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->string('company')->nullable();
        $table->string('project_type');
        $table->string('budget_range')->nullable();
        $table->text('message');
        $table->enum('status', ['new', 'read', 'replied', 'closed'])->default('new');
        $table->unsignedBigInteger('created_by')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}

public function down(): void
{
    Schema::dropIfExists('contact_enquiries');
}
```

### Naming Conventions

| Item | Convention | Example |
|---|---|---|
| Table name | snake_case, plural | `contact_enquiries` |
| Column name | snake_case | `project_type`, `created_by` |
| Foreign key | `{table_singular}_id` | `user_id`, `module_id` |
| Index | descriptive | `contact_enquiries_email_index` |
| Migration file | timestamp_action_table | `2025_01_01_create_contact_enquiries_table` |

### No Raw SQL in Application Code

```php
// ❌ WRONG — raw SQL bypasses security and ORM benefits
$results = DB::select("SELECT * FROM users WHERE email = '$email'");

// ✅ CORRECT — use Eloquent or Query Builder with parameterized queries
$results = User::where('email', $email)->get();
$results = DB::table('users')->where('email', $email)->get();
```

---

## 11. Configuration Rules

### All Config Must Live in `config/*.php`

Never add application logic to `.env`. The `.env` file only holds values — logic lives in `config/`:

```php
// config/animazon.php
return [

    /*
    |--------------------------------------------------------------------------
    | Contact & Enquiry Settings
    |--------------------------------------------------------------------------
    */
    'contact' => [
        'email'            => env('ANIMAZON_CONTACT_EMAIL', 'hello@animazon.com'),
        'reply_within_hrs' => env('ANIMAZON_REPLY_HOURS', 24),
        'calendly_url'     => env('ANIMAZON_CALENDLY_URL', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Portfolio Settings
    |--------------------------------------------------------------------------
    */
    'portfolio' => [
        'per_page'        => env('ANIMAZON_PORTFOLIO_PER_PAGE', 12),
        'max_upload_mb'   => env('ANIMAZON_MAX_UPLOAD_MB', 50),
        'allowed_formats' => ['mp4', 'webm', 'gif', 'jpg', 'png', 'webp'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Blog Settings
    |--------------------------------------------------------------------------
    */
    'blog' => [
        'posts_per_page' => env('ANIMAZON_BLOG_PER_PAGE', 10),
        'excerpt_length' => 200,
    ],

];
```

---

## 12. Security Rules

### XSS — Blade Auto-Escaping

Blade's `{{ }}` syntax auto-escapes output. Only use `{!! !!}` for content that has been explicitly sanitized by the application:

```blade
{{-- ✅ Safe — auto-escaped --}}
{{ $enquiry->name }}
{{ $enquiry->message }}

{{-- ✅ Acceptable only for own-generated HTML --}}
{!! $page->content !!}

{{-- ❌ NEVER — raw user input in unescaped output --}}
{!! $request->input('message') !!}
```

### CSRF Protection

All POST/PUT/DELETE forms must include `@csrf`. This is non-negotiable:

```blade
<form method="POST" action="{{ route('contact.store') }}">
    @csrf
    {{-- form fields --}}
    <button type="submit">{{ __('Send Message') }}</button>
</form>
```

### File Upload Validation

Always validate uploaded files by extension AND MIME type. Never trust client-provided MIME types alone:

```php
// In Form Request
'portfolio_file' => [
    'required',
    'file',
    'max:' . (config('animazon.portfolio.max_upload_mb') * 1024),
    'mimes:mp4,webm,gif,jpg,jpeg,png,webp,pdf',
],
```

### Authorization Before Every Action

Check permissions before any data modification:

```php
public function destroy($id)
{
    $enquiry = ContactEnquiry::findOrFail($id);

    if (Auth::user()->type !== 'super admin' && $enquiry->created_by !== Auth::id()) {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    $enquiry->delete();
    return redirect()->route('contact.index')->with('success', __('Enquiry deleted.'));
}
```

---

## 13. File & Asset Rules

### Upload Directory Structure

All user uploads go through Laravel's filesystem — never hardcode absolute paths:

```php
// ❌ WRONG
$path = '/var/www/animazon/public/uploads/' . $filename;
move_uploaded_file($_FILES['file']['tmp_name'], $path);

// ✅ CORRECT — use Laravel's Storage facade
$path = $request->file('portfolio_video')->store(
    'uploads/portfolio',
    config('filesystems.default') // reads from config, not hardcoded
);
$url = Storage::url($path);
```

### Filesystem Config (`config/filesystems.php`)

```php
// Storage disk selection via env
'default' => env('FILESYSTEM_DISK', 'local'),

'disks' => [
    'local' => [
        'driver' => 'local',
        'root'   => storage_path('app'),
    ],
    's3' => [
        'driver' => 's3',
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
    ],
],
```

---

## 14. Forbidden Patterns

The following patterns are **absolutely prohibited** in this codebase. If you see them, refactor before proceeding.

| ❌ Forbidden Pattern | ✅ Correct Alternative |
|---|---|
| `env('KEY')` in controllers/models | `config('file.key')` |
| Hardcoded API keys, passwords, secrets | `.env` + `config()` |
| Raw hex colors in Blade files | Tailwind config tokens |
| Hardcoded URLs like `'https://animazon.com/...'` | `route('name')` or `url('path')` |
| Hardcoded email addresses | `config('animazon.contact.email')` |
| `$guarded = []` on models | Explicit `$fillable = [...]` |
| Inline validation in controllers | Dedicated Form Request classes |
| Raw SQL strings | Eloquent ORM / Query Builder |
| `style=""` attributes in Blade | Tailwind utility classes |
| `{!! $userInput !!}` | `{{ $userInput }}` |
| POST forms without `@csrf` | Always include `@csrf` |
| Creating module folders manually | `php artisan module:make` |
| Accessing other module internals directly | Laravel Events or Service classes |
| Hardcoded pagination limits like `->paginate(12)` | `->paginate(config('animazon.portfolio.per_page'))` |
| Hardcoded text strings | `__('translation.key')` |

---

## 15. Checklist Before Submitting Code

Run through this checklist before marking any task complete:

**Environment & Config**
- [ ] No `env()` calls outside of `config/*.php` files
- [ ] No hardcoded credentials, API keys, or secrets
- [ ] All new configurable values added to `.env.example`, `config/*.php`, and accessed via `config()`

**Routes**
- [ ] All routes are named
- [ ] Routes are grouped with appropriate middleware
- [ ] No hardcoded URLs in views or controllers — only `route()` or `url()`

**Controllers**
- [ ] Validation extracted to Form Request classes
- [ ] Authorization check at the start of any mutation (store/update/destroy)
- [ ] Flash messages use `__()` translation helper
- [ ] Responses use `redirect()->route()` — never hardcoded URL strings

**Models**
- [ ] `$fillable` explicitly defined — no `$guarded = []`
- [ ] Casts defined for boolean, array, and date fields
- [ ] Reusable queries extracted as scopes

**Blade Views**
- [ ] `@csrf` included in every form
- [ ] `{{ }}` used for all output (not `{!! !!}` unless content is application-generated)
- [ ] No `style=""` attributes — Tailwind only
- [ ] All user-visible text wrapped in `{{ __('...') }}`
- [ ] Assets loaded via `@vite()` helper

**Database**
- [ ] Migration has both `up()` and `down()` methods
- [ ] Table and column names follow snake_case convention
- [ ] No raw SQL strings

**Module**
- [ ] New feature built as a module under `Modules/`
- [ ] Module created via `php artisan module:make`
- [ ] Views referenced with `module::view` namespace
- [ ] Module config in `Modules/YourModule/Config/config.php`

**Security**
- [ ] File uploads validated by both extension and MIME type
- [ ] File size limits read from config (not hardcoded)
- [ ] XSS protection confirmed (Blade escaping in place)

---

*Document version: 1.0*
*Stack: Laravel 11 + PHP 8.2 + Vite + Tailwind CSS + nwidart/laravel-modules*
*Apply these rules to every file, every function, every PR.*
