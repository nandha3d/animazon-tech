@php
    // $logo=asset(Storage::url('uploads/logo/'));
    $logo = \App\Models\Utility::get_file('uploads/logo');
    $company_favicon = Utility::companyData($invoice->created_by, 'company_favicon');
    $setting = DB::table('settings')->where('created_by', $user->creatorId())->pluck('value', 'name')->toArray();
    $settings_data = \App\Models\Utility::settingsById($invoice->created_by);
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if (isset($setting['color_flag']) && $setting['color_flag'] == 'true') {
        $themeColor = 'custom-color';
    } else {
        $themeColor = $color;
    }
    $company_setting = \App\Models\Utility::settingsById($invoice->created_by);
    $getseo = App\Models\Utility::getSeoSetting();
    $metatitle = isset($getseo['meta_title']) ? $getseo['meta_title'] : '';
    $metsdesc = isset($getseo['meta_desc']) ? $getseo['meta_desc'] : '';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($getseo['meta_image']) ? $getseo['meta_image'] : '';
    $get_cookie = \App\Models\Utility::getCookieSetting();

@endphp
<!DOCTYPE html>

<html lang="en" dir="{{ $settings_data['SITE_RTL'] == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>
        {{ Utility::companyData($invoice->created_by, 'title_text') ? Utility::companyData($invoice->created_by, 'title_text') : config('app.name', 'ANIMAZON') }}
        - {{ __('Invoice') }}</title>

    <meta name="title" content="{{ $metatitle }}">
    <meta name="description" content="{{ $metsdesc }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ $metatitle }}">
    <meta property="og:description" content="{{ $metsdesc }}">
    <meta property="og:image" content="{{ $meta_image . $meta_logo }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ $metatitle }}">
    <meta property="twitter:description" content="{{ $metsdesc }}">
    <meta property="twitter:image" content="{{ $meta_image . $meta_logo }}">

    <link rel="icon"
        href="{{ $logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') }}"
        type="image" sizes="16x16">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}">


    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- vendor css -->
    @if ($settings_data['SITE_RTL'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if ($settings_data['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="style">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="style">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" id="main-style-link">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">

    <style>
        :root {
            --color-customColor: <?=$color ?>;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/custom-color.css') }}">
    @stack('css-page')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #card-element {
            border: 1px solid #a3afbb !important;
            border-radius: 10px !important;
            padding: 10px !important;
        }
    </style>
</head>

<body class="{{ $themeColor }}">
    <header class="header header-transparent" id="header-main">

    </header>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .inv-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #f1f5f9;
        margin: 20px auto 40px;
        max-width: 980px;
    }

    .inv-main-card {
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5), 0 0 40px rgba(59, 130, 246, 0.08);
        overflow: hidden;
        position: relative;
    }

    /* Ambient glow at top */
    .inv-main-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0284c7, #06b6d4, #3b82f6, #6366f1);
        box-shadow: 0 0 16px rgba(56, 189, 248, 0.6);
    }

    .inv-body {
        padding: 36px 40px;
    }

    /* Top Brand & Action Bar */
    .inv-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        flex-wrap: wrap;
        padding-bottom: 28px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .inv-brand-box {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .inv-brand-icon {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #2563eb 0%, #06b6d4 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #ffffff;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
    }

    .inv-brand-title {
        font-family: 'Outfit', sans-serif;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #ffffff;
        margin: 0 0 2px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .inv-brand-tagline {
        font-size: 13px;
        color: #94a3b8;
        margin: 0;
    }

    .inv-action-pills {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-inv-print {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 12px;
        color: #f1f5f9;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-inv-print:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #38bdf8;
        border-color: #38bdf8;
        transform: translateY(-1px);
    }

    .btn-inv-pay {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        background: linear-gradient(135deg, #2563eb, #06b6d4);
        border: none;
        border-radius: 12px;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-inv-pay:hover {
        background: linear-gradient(135deg, #1d4ed8, #0891b2);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.6);
        color: #fff;
    }

    /* Meta & Badges Bar */
    .inv-meta-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr;
        gap: 16px;
        margin: 28px 0;
        align-items: stretch;
    }

    @media (max-width: 768px) {
        .inv-meta-grid {
            grid-template-columns: 1fr;
        }
    }

    .inv-meta-box {
        background: rgba(30, 41, 59, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 16px;
        padding: 18px 20px;
    }

    .inv-meta-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #94a3b8;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .inv-meta-num {
        font-family: 'Outfit', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.5px;
    }

    .inv-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .inv-status-unpaid {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .inv-status-paid {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    /* Parties Bento Grid (Billed To vs Provider) */
    .inv-parties-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 640px) {
        .inv-parties-grid {
            grid-template-columns: 1fr;
        }
    }

    .inv-party-card {
        background: rgba(30, 41, 59, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 20px;
    }

    .inv-party-title {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #38bdf8;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .inv-party-name {
        font-size: 17px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 6px;
    }

    .inv-party-details {
        font-size: 13px;
        color: #94a3b8;
        line-height: 1.6;
    }

    .inv-party-details div {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
    }

    /* Modern Table */
    .inv-table-wrapper {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(15, 23, 42, 0.4);
        margin-bottom: 28px;
    }

    .inv-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .inv-table thead {
        background: #1e293b;
    }

    .inv-table th {
        padding: 14px 18px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: #cbd5e1;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .inv-table tbody tr {
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        transition: background 0.15s ease;
    }

    .inv-table tbody tr:hover {
        background: rgba(59, 130, 246, 0.04);
    }

    .inv-table td {
        padding: 18px 18px;
        vertical-align: middle;
        color: #e2e8f0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .inv-index-pill {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.06);
        color: #94a3b8;
        font-weight: 700;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .inv-item-name {
        font-size: 14px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 4px;
    }

    .inv-item-desc {
        font-size: 12px;
        color: #94a3b8;
        line-height: 1.5;
    }

    .inv-rate-pill {
        font-weight: 600;
        color: #cbd5e1;
    }

    .inv-amount-cell {
        font-family: 'Outfit', sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: #38bdf8;
        text-align: right;
    }

    /* Bottom Summary & Settlement Grid */
    .inv-bottom-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 768px) {
        .inv-bottom-grid {
            grid-template-columns: 1fr;
        }
    }

    .inv-bank-card {
        background: linear-gradient(145deg, rgba(30, 41, 59, 0.6) 0%, rgba(15, 23, 42, 0.8) 100%);
        border: 1px solid rgba(56, 189, 248, 0.25);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        border-radius: 16px;
        padding: 22px;
    }

    .inv-bank-title {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #38bdf8;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .bank-lbl {
        color: #94a3b8;
    }

    .bank-val {
        color: #ffffff;
    }

    .bank-val-accent {
        color: #38bdf8;
        letter-spacing: 0.5px;
    }

    .inv-bank-row {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        padding: 6px 0;
        border-bottom: 1px dashed rgba(255, 255, 255, 0.06);
    }

    .inv-bank-row:last-child {
        border-bottom: none;
    }

    .inv-bank-label {
        color: #94a3b8;
    }

    .inv-bank-val {
        color: #ffffff;
        font-weight: 600;
    }

    .inv-summary-card {
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 18px;
        padding: 22px;
    }

    .inv-calc-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        padding: 8px 0;
        color: #94a3b8;
    }

    .inv-calc-val {
        color: #e2e8f0;
        font-weight: 600;
    }

    .inv-total-row {
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }

    .inv-total-label {
        font-family: 'Outfit', sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .inv-total-amount {
        font-family: 'Outfit', sans-serif;
        font-size: 28px;
        font-weight: 800;
        color: #38bdf8;
        letter-spacing: -0.5px;
    }

    /* Print Styles (Strict Light Mode, High-End Clean Corporate Layout) */
    @media print {
        @page {
            size: A4 portrait;
            margin: 8mm 10mm;
        }
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        body {
            background: #ffffff !important;
            color: #0f172a !important;
            padding: 0 !important;
            margin: 0 !important;
            font-size: 11px !important;
        }
        .inv-wrapper {
            margin: 0 !important;
            max-width: 100% !important;
            padding: 0 !important;
            color: #0f172a !important;
        }
        .inv-main-card {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            box-shadow: none !important;
            color: #0f172a !important;
            padding: 0 !important;
        }
        .inv-body {
            padding: 16px 20px !important;
        }
        .inv-main-card::before,
        .inv-action-pills,
        .header,
        .modal,
        .modal-backdrop,
        #bottom_pay_btn,
        #top_pay_btn,
        .btn-pay-razorpay-direct {
            display: none !important;
        }
        .inv-logo-light {
            display: none !important;
        }
        .inv-logo-dark {
            display: block !important;
            max-height: 40px !important;
        }
        .inv-header-bar {
            border-bottom: 1px solid #e2e8f0 !important;
            padding-bottom: 12px !important;
        }
        .inv-brand-title {
            color: #0f172a !important;
            font-size: 18px !important;
        }
        .inv-brand-tagline {
            color: #64748b !important;
            font-size: 10px !important;
        }
        .inv-meta-grid {
            margin: 12px 0 !important;
            gap: 10px !important;
        }
        .inv-meta-box {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 10px 14px !important;
        }
        .inv-meta-label {
            color: #64748b !important;
            font-size: 9px !important;
        }
        .inv-meta-num {
            color: #0284c7 !important;
            font-size: 16px !important;
        }
        .inv-meta-box div {
            color: #0f172a !important;
        }
        .inv-status-pill.inv-status-unpaid {
            background: #fef3c7 !important;
            color: #b45309 !important;
            border: 1px solid #fde68a !important;
        }
        .inv-status-pill.inv-status-paid {
            background: #dcfce7 !important;
            color: #15803d !important;
            border: 1px solid #bbf7d0 !important;
        }
        .inv-parties-grid {
            margin-bottom: 14px !important;
            gap: 12px !important;
        }
        .inv-party-card {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 12px 14px !important;
        }
        .inv-party-title {
            color: #0284c7 !important;
            font-size: 9.5px !important;
        }
        .inv-party-name {
            color: #0f172a !important;
            font-size: 13px !important;
        }
        .inv-party-details, .inv-party-details div {
            color: #475569 !important;
            font-size: 10.5px !important;
        }
        .inv-table-wrapper {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            margin-bottom: 14px !important;
        }
        .inv-table thead th {
            background: #0f172a !important;
            color: #ffffff !important;
            font-size: 9.5px !important;
            padding: 8px 12px !important;
            border-bottom: 1px solid #0f172a !important;
        }
        .inv-table td {
            color: #1e293b !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 8px 12px !important;
            font-size: 10.5px !important;
        }
        .inv-index-pill {
            background: #f1f5f9 !important;
            color: #475569 !important;
            border: 1px solid #e2e8f0 !important;
        }
        .inv-item-name {
            color: #0f172a !important;
            font-size: 11.5px !important;
        }
        .inv-item-desc {
            color: #64748b !important;
            font-size: 9.5px !important;
        }
        .inv-rate-pill {
            color: #1e293b !important;
        }
        .inv-amount-cell {
            color: #0f172a !important;
            font-size: 12px !important;
        }
        .inv-bottom-grid {
            gap: 14px !important;
        }
        .inv-bank-card {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 10px 14px !important;
            box-shadow: none !important;
        }
        .inv-bank-title {
            color: #0284c7 !important;
        }
        .inv-bank-card strong, .inv-bank-card span, .bank-val {
            color: #0f172a !important;
        }
        .inv-bank-card .bank-lbl {
            color: #64748b !important;
        }
        .inv-bank-card .bank-val-accent {
            color: #0284c7 !important;
        }
        .inv-qr-container {
            border: 1px solid #e2e8f0 !important;
            box-shadow: none !important;
            padding: 6px !important;
        }
        .inv-summary-card {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 10px 14px !important;
        }
        .inv-calc-row {
            color: #64748b !important;
            font-size: 11px !important;
            padding: 3px 0 !important;
        }
        .inv-calc-val {
            color: #0f172a !important;
        }
        .inv-total-row {
            border-top: 2px solid #0f172a !important;
            margin-top: 6px !important;
            padding-top: 6px !important;
        }
        .inv-total-label {
            color: #0f172a !important;
            font-size: 13px !important;
        }
        .inv-total-amount {
            color: #0284c7 !important;
            font-size: 18px !important;
        }
    }
</style>

<div class="inv-wrapper">
    <div class="inv-main-card">
        <div class="inv-body">
            
            <!-- Header Brand & Actions -->
            <div class="inv-header-bar">
                <div class="inv-brand-box">
                    <a href="{{ url('/') }}" style="display:flex; align-items:center; text-decoration:none;">
                        <img src="{{ \App\Models\Utility::get_file('uploads/logo/logo-light.png') }}" alt="Animazon Logo" class="inv-logo-light" style="max-height: 48px; width: auto; object-fit: contain;" onerror="this.onerror=null; this.src='/storage/uploads/logo/logo-light.png';">
                        <img src="{{ \App\Models\Utility::get_file('uploads/logo/logo-dark.png') }}" alt="Animazon Logo" class="inv-logo-dark" style="max-height: 48px; width: auto; object-fit: contain; display:none;" onerror="this.onerror=null; this.src='/storage/uploads/logo/logo-dark.png';">
                    </a>
                    <div style="border-left: 1px solid rgba(255,255,255,0.15); padding-left: 14px; margin-left: 6px;">
                        <h1 class="inv-brand-title" style="font-size: 20px;">ANIMAZON <span style="font-size:12px; font-weight:600; color:#38bdf8; background:rgba(56,189,248,0.12); padding:2px 8px; border-radius:6px; border:1px solid rgba(56,189,248,0.25);">WEB STUDIO</span></h1>
                        <p class="inv-brand-tagline">Web Development, AI Video & High-Impact Digital Solutions</p>
                    </div>
                </div>
                
                <div class="inv-action-pills">
                    <button type="button" class="btn-inv-print" onclick="window.print()">
                        <i class="ti ti-printer"></i> {{ __('Print / PDF') }}
                    </button>
                    <a href="{{ route('invoice.pdf', Crypt::encrypt($invoice->id)) }}" target="_blank" class="btn-inv-print">
                        <i class="ti ti-download"></i> {{ __('Download') }}
                    </a>
                    @if ($invoice->status != 4 && $invoice->getDue() > 0)
                        <button type="button" class="btn-inv-pay" id="top_pay_btn" onclick="payNowWithRazorpay()">
                            <i class="ti ti-bolt"></i> {{ __('Pay with Razorpay') }}
                        </button>
                    @endif
                </div>
            </div>

            <!-- Invoice Meta Grid -->
            <div class="inv-meta-grid">
                <div class="inv-meta-box">
                    <div class="inv-meta-label">{{ __('Invoice Number') }}</div>
                    <div class="d-flex align-items-center justify-content-between">
                        @php
                            $invDisplayNum = '#INVO' . sprintf('%04d', $invoice->invoice_id);
                        @endphp
                        <div class="inv-meta-num">{{ $invDisplayNum }}</div>
                        @if(!empty($invoice->ref_number))
                            <span style="font-size:11px; background:rgba(255,255,255,0.06); padding:3px 8px; border-radius:6px; color:#cbd5e1;">Ref: {{ $invoice->ref_number }}</span>
                        @endif
                    </div>
                </div>

                <div class="inv-meta-box">
                    <div class="inv-meta-label">{{ __('Issue Date') }}</div>
                    <div style="font-size:16px; font-weight:700; color:#ffffff;">
                        {{ Utility::dateFormat($settings, $invoice->issue_date) }}
                    </div>
                    <div style="font-size:11px; color:#94a3b8; margin-top:2px;">
                        Due: {{ Utility::dateFormat($settings, $invoice->due_date) }}
                    </div>
                </div>

                <div class="inv-meta-box">
                    <div class="inv-meta-label">{{ __('Payment Status') }}</div>
                    <div>
                        @if ($invoice->status == 4)
                            <span class="inv-status-pill inv-status-paid"><i class="ti ti-check"></i> {{ __('Paid in Full') }}</span>
                        @elseif ($invoice->status == 0)
                            <span class="inv-status-pill inv-status-unpaid"><i class="ti ti-clock"></i> {{ __('Payment Pending') }}</span>
                        @elseif ($invoice->status == 1)
                            <span class="inv-status-pill inv-status-unpaid"><i class="ti ti-send"></i> {{ __('Invoice Sent') }}</span>
                        @else
                            <span class="inv-status-pill inv-status-unpaid"><i class="ti ti-alert-circle"></i> {{ __(\App\Models\Invoice::$statues[$invoice->status] ?? 'Open') }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Parties Bento Grid (Billed To vs Provider) -->
            <div class="inv-parties-grid">
                <div class="inv-party-card">
                    <div class="inv-party-title"><i class="ti ti-user"></i> {{ __('Billed To (Client)') }}</div>
                    <div class="inv-party-name">
                        {{ !empty($customer->name) ? $customer->name : (!empty($customer->billing_name) ? $customer->billing_name : 'Client') }}
                    </div>
                    <div class="inv-party-details">
                        @if(!empty($customer->email))
                            <div><i class="ti ti-mail" style="color:#38bdf8;"></i> {{ $customer->email }}</div>
                        @endif
                        @if(!empty($customer->contact) || !empty($customer->billing_phone))
                            <div><i class="ti ti-phone" style="color:#38bdf8;"></i> {{ $customer->contact ?: $customer->billing_phone }}</div>
                        @endif
                        @if(!empty($customer->billing_address))
                            <div><i class="ti ti-map-pin" style="color:#38bdf8;"></i> {{ $customer->billing_address }}, {{ $customer->billing_city }} {{ $customer->billing_state }} {{ $customer->billing_zip }}</div>
                        @endif
                    </div>
                </div>

                <div class="inv-party-card">
                    <div class="inv-party-title"><i class="ti ti-building"></i> {{ __('Issued By') }}</div>
                    <div class="inv-party-name">Animazon Web Studio</div>
                    <div class="inv-party-details">
                        <div><i class="ti ti-world" style="color:#38bdf8;"></i> www.animazon.in</div>
                        <div><i class="ti ti-mail" style="color:#38bdf8;"></i> info@animazon.in</div>
                        <div><i class="ti ti-phone" style="color:#38bdf8;"></i> +91 80894 05950</div>
                        <div><i class="ti ti-map-pin" style="color:#38bdf8;"></i> 155, Narayana Valasu, Nasiyanur Road, Above Bake Mart, Erode, TN - 638011</div>
                    </div>
                </div>
            </div>

            <!-- Itemized Work Table -->
            <div class="inv-table-wrapper">
                <table class="inv-table">
                    <thead>
                        <tr>
                            <th style="width: 45px;">#</th>
                            <th>{{ __('Description & Deliverables') }}</th>
                            <th style="width: 80px; text-align:center;">{{ __('Qty') }}</th>
                            <th style="width: 130px; text-align:right;">{{ __('Unit Rate') }}</th>
                            <th style="width: 140px; text-align:right;">{{ __('Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($iteams as $key => $iteam)
                            @php
                                $product = $iteam->product;
                                $itemTotal = ($iteam->price * $iteam->quantity) - $iteam->discount;
                            @endphp
                            <tr>
                                <td>
                                    <div class="inv-index-pill">{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td>
                                    <div class="inv-item-name">
                                        {{ !empty($product) ? $product->name : ($iteam->description ?? 'Service Item') }}
                                    </div>
                                    @if(!empty($iteam->description) && (!empty($product) && $product->name !== $iteam->description))
                                        <div class="inv-item-desc">{{ $iteam->description }}</div>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    <span class="inv-rate-pill">{{ $iteam->quantity }}</span>
                                </td>
                                <td style="text-align:right;">
                                    <span class="inv-rate-pill">₹{{ number_format((float)$iteam->price, 2, '.', ',') }}</span>
                                </td>
                                <td class="inv-amount-cell">
                                    ₹{{ number_format((float)$itemTotal, 2, '.', ',') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary & Payment Bento Grid -->
            <div class="inv-bottom-grid">
                <!-- Direct Bank Transfer & Razorpay Payment Card -->
                <div class="inv-bank-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="inv-bank-title" style="margin-bottom:0; color:#38bdf8;">
                            <i class="ti ti-building-bank"></i> {{ __('Bank Details & Direct Settlement') }}
                        </div>
                        <span style="font-size:10px; font-weight:700; background:rgba(56, 189, 248, 0.15); color:#38bdf8; border:1px solid rgba(56,189,248,0.3); padding:2px 8px; border-radius:12px; text-transform:uppercase;">Verified Account</span>
                    </div>

                    <div style="display:flex; gap:18px; align-items:flex-start; flex-wrap:wrap;">
                        <!-- QR Code Container -->
                        <div class="inv-qr-container" style="background:#ffffff; padding:10px; border-radius:14px; box-shadow:0 8px 20px rgba(0,0,0,0.35); text-align:center; flex-shrink:0;">
                            @php
                                $dueAmount = number_format((float)$invoice->getDue(), 2, '.', '');
                                $invCleanNum = 'INVO' . sprintf('%04d', $invoice->invoice_id);
                                $upiLink = "upi://pay?pa=nandhu3d@oksbi" .
                                          "&pn=" . rawurlencode("Animazon Web Studio") .
                                          "&am=" . $dueAmount .
                                          "&cu=INR" .
                                          "&tn=" . rawurlencode("Invoice " . $invCleanNum);
                            @endphp
                            <div style="display:inline-block;">
                                {!! DNS2D::getBarcodeHTML($upiLink, 'QRCODE', 4.2, 4.2, '#0f172a') !!}
                            </div>
                            <div style="font-size:9.5px; font-weight:800; color:#0f172a; margin-top:6px; letter-spacing:0.5px;">
                                SCAN & PAY VIA UPI
                            </div>
                            <div style="font-size:8px; font-weight:600; color:#475569; margin-top:2px;">
                                GPay • PhonePe • Paytm • BHIM
                            </div>
                        </div>

                        <!-- Bank Details -->
                        <div style="flex:1; min-width:200px; font-size:12px; color:#cbd5e1; line-height:1.6;">
                            <div style="display:grid; grid-template-columns: 95px 1fr; gap:3px 8px; margin-bottom:12px;">
                                <span class="bank-lbl">Bank Name:</span>
                                <strong class="bank-val">INDIAN BANK</strong>

                                <span class="bank-lbl">A/C Name:</span>
                                <strong class="bank-val">G.Nandhakumar</strong>

                                <span class="bank-lbl">A/C Number:</span>
                                <strong class="bank-val bank-val-accent">975099385</strong>

                                <span class="bank-lbl">IFSC Code:</span>
                                <strong class="bank-val">IDIB000P106</strong>

                                <span class="bank-lbl">Branch:</span>
                                <span class="bank-val">Perundurai Road</span>

                                <span class="bank-lbl">GPay / UPI ID:</span>
                                <strong class="bank-val bank-val-accent">nandhu3d@oksbi</strong>
                            </div>

                            @if ($invoice->status != 4 && $invoice->getDue() > 0)
                                <button type="button" class="btn btn-sm w-100 btn-pay-razorpay-direct" id="bottom_pay_btn" style="background:linear-gradient(135deg, #0284c7, #2563eb); color:#fff; font-weight:700; font-size:12px; border-radius:10px; padding:10px 12px; border:none; box-shadow:0 4px 12px rgba(37,99,235,0.4); display:flex; align-items:center; justify-content:center; gap:6px; cursor:pointer;" onclick="payNowWithRazorpay()">
                                    <i class="ti ti-bolt"></i> {{ __('Pay Online via Razorpay Gateway') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Financial Calculation Card -->
                <div class="inv-summary-card">
                    <div class="inv-calc-row">
                        <span>{{ __('Sub Total') }}</span>
                        <span class="inv-calc-val">₹{{ number_format((float)$invoice->getSubTotal(), 2, '.', ',') }}</span>
                    </div>
                    @if ($invoice->getTotalDiscount() > 0)
                        <div class="inv-calc-row">
                            <span>{{ __('Discount') }}</span>
                            <span class="inv-calc-val" style="color:#34d399;">- ₹{{ number_format((float)$invoice->getTotalDiscount(), 2, '.', ',') }}</span>
                        </div>
                    @endif
                    @if ($invoice->getTotalTax() > 0)
                        <div class="inv-calc-row">
                            <span>{{ __('Taxes') }}</span>
                            <span class="inv-calc-val">+ ₹{{ number_format((float)$invoice->getTotalTax(), 2, '.', ',') }}</span>
                        </div>
                    @endif
                    @if ($invoice->getDue() < $invoice->getTotal() && $invoice->getDue() > 0)
                        <div class="inv-calc-row">
                            <span>{{ __('Amount Paid') }}</span>
                            <span class="inv-calc-val" style="color:#34d399;">- ₹{{ number_format((float)($invoice->getTotal() - $invoice->getDue()), 2, '.', ',') }}</span>
                        </div>
                        <div class="inv-calc-row">
                            <span>{{ __('Balance Due') }}</span>
                            <span class="inv-calc-val" style="color:#f59e0b;">₹{{ number_format((float)$invoice->getDue(), 2, '.', ',') }}</span>
                        </div>
                    @endif

                    <div class="inv-total-row">
                        <span class="inv-total-label">{{ __('Total Payable') }}</span>
                        <span class="inv-total-amount">₹{{ number_format((float)$invoice->getTotal(), 2, '.', ',') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function openRazorpayTab() {
        setTimeout(function() {
            var razorpayTabLink = document.querySelector('a[href="#razorpay-payment"]');
            if (razorpayTabLink) {
                var tab = new bootstrap.Tab(razorpayTabLink);
                tab.show();
            }
        }, 300);
    }
</script>

            <div class="col-12">
                <h5 class="h4 d-inline-block font-weight-400 mb-2">{{ __('Receipt Summary') }}</h5><br>
                @if ($user_plan->storage_limit <= $user->storage_limit)
                    <small
                        class="text-danger font-bold">{{ __('Your plan storage limit is over , so you can not see customer uploaded payment receipt') }}</small><br>
                @endif
                <div class="card mt-1">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th class="text-dark">{{ __('Date') }}</th>
                                    <th class="text-dark">{{ __('Amount') }}</th>
                                    <th class="text-dark">{{ __('Payment Type') }}</th>
                                    <th class="text-dark">{{ __('Account') }}</th>
                                    <th class="text-dark">{{ __('Reference') }}</th>
                                    <th class="text-dark">{{ __('Description') }}</th>
                                    <th class="text-dark">{{ __('Receipt') }}</th>
                                    <th class="text-dark">{{ __('OrderId') }}</th>
                                </tr>
                                @php
                                    $path = \App\Models\Utility::get_file('uploads/order');
                                @endphp

                                @if (!empty($invoice->payments) && $invoice->bankPayments)
                                    @foreach ($invoice->payments as $key => $payment)
                                        <tr>
                                            <td>{{ Utility::dateFormat($settings, $payment->date) }}</td>
                                            <td>{{ Utility::priceFormat($settings, $payment->amount) }}</td>
                                            <td>{{ $payment->payment_type }}</td>
                                            <td>{{ !empty($payment->bankAccount) ? $payment->bankAccount->bank_name . ' ' . $payment->bankAccount->holder_name : '--' }}
                                            </td>
                                            <td>{{ !empty($payment->reference) ? $payment->reference : '--' }}</td>
                                            <td>{{ !empty($payment->description) ? $payment->description : '--' }}
                                            </td>

                                            @if ($user_plan->storage_limit <= $user->storage_limit)
                                                <td>
                                                    --
                                                </td>
                                            @else
                                                <td>
                                                    @if (!empty($payment->receipt))
                                                        <a href="{{ $path . '/' . $payment->receipt }}"
                                                            target="_blank">
                                                            <i class="ti ti-file"></i>{{ __('Receipt') }}</a>
                                                    @elseif(!empty($payment->add_receipt))
                                                        <a href="{{ asset(Storage::url('uploads/payment')) . '/' . $payment->add_receipt }}"
                                                            target="_blank">
                                                            <i class="ti ti-file"></i>{{ __('Receipt') }}</a>
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                            @endif
                                            <td>{{ !empty($payment->order_id) ? $payment->order_id : '--' }}</td>
                                        </tr>
                                    @endforeach


                                    @foreach ($invoice->bankPayments as $key => $bankPayment)
                                        <tr>
                                            <td>{{ Utility::dateFormat($settings, $bankPayment->date) }}</td>
                                            <td>{{ Utility::priceFormat($settings, $bankPayment->amount) }}</td>
                                            <td>{{ __('Bank Transfer') }}</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>

                                            @if ($user_plan->storage_limit <= $user->storage_limit)
                                                <td>
                                                    --
                                                </td>
                                            @else
                                                <td>
                                                    @if ($user_plan->storage_limit <= $user->storage_limit)
                                                        @if (!empty($bankPayment->receipt))
                                                            <a href="{{ $path . '/' . $bankPayment->receipt }}"
                                                                target="_blank">
                                                                <i class="ti ti-file"></i> {{ __('Receipt') }}
                                                            </a>
                                                        @endif
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                            @endif
                                            <td>{{ !empty($bankPayment->order_id) ? $bankPayment->order_id : '--' }}
                                            </td>
                                            @can('delete invoice product')
                                                <td>
                                                    @if ($bankPayment->status == 'Pending')
                                                        <div class="action-btn">
                                                            <a href="#"
                                                                data-url="{{ URL::to('invoice/' . $bankPayment->id . '/action') }}"
                                                                data-size="lg" data-ajax-popup="true"
                                                                data-title="{{ __('Payment Status') }}"
                                                                class="mx-3 btn btn-sm align-items-center bg-warning"
                                                                data-bs-toggle="tooltip"
                                                                title="{{ __('Payment Status') }}"
                                                                data-original-title="{{ __('Payment Status') }}">
                                                                <i class="ti ti-caret-right text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <div class="action-btn ms-2">
                                                        {!! Form::open([
                                                            'method' => 'post',
                                                            'route' => ['invoice.payment.destroy', $invoice->id, $bankPayment->id],
                                                            'id' => 'delete-form-' . $bankPayment->id,
                                                        ]) !!}

                                                        <a href="#"
                                                            class="mx-3 btn btn-sm align-items-center bs-pass-para bg-danger"
                                                            data-bs-toggle="tooltip" title="Delete"
                                                            data-original-title="{{ __('Delete') }}"
                                                            data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="document.getElementById('delete-form-{{ $bankPayment->id }}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="{{ Gate::check('delete invoice product') ? '9' : '8' }}"
                                            class="text-center text-dark">
                                            <p>{{ __('No Data Found') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($invoice->getDue() > 0)
            <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog"
                aria-labelledby="paymentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalLabel">{{ __('Add Payment') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card bg-none card-box">
                                <section class="nav-tabs p-2">
                                    @if (
                                        (isset($company_payment_setting['is_stripe_enabled']) && $company_payment_setting['is_stripe_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_bank_transfer_enabled']) &&
                                                $company_payment_setting['is_bank_transfer_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_paypal_enabled']) &&
                                                $company_payment_setting['is_paypal_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_paystack_enabled']) &&
                                                $company_payment_setting['is_paystack_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_flutterwave_enabled']) &&
                                                $company_payment_setting['is_flutterwave_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_razorpay_enabled']) &&
                                                $company_payment_setting['is_razorpay_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_mercado_enabled']) &&
                                                $company_payment_setting['is_mercado_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_paytm_enabled']) && $company_payment_setting['is_paytm_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_mollie_enabled']) &&
                                                $company_payment_setting['is_mollie_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_skrill_enabled']) &&
                                                $company_payment_setting['is_skrill_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_coingate_enabled']) &&
                                                $company_payment_setting['is_coingate_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_paymentwall_enabled']) &&
                                                $company_payment_setting['is_paymentwall_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_toyyibpay_enabled']) &&
                                                $company_payment_setting['is_toyyibpay_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_payfast_enabled']) &&
                                                $company_payment_setting['is_payfast_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_iyzipay_enabled']) &&
                                                $company_payment_setting['is_iyzipay_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_sspay_enabled']) && $company_payment_setting['is_sspay_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_paytab_enabled']) &&
                                                $company_payment_setting['is_paytab_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_benefit_enabled']) &&
                                                $company_payment_setting['is_benefit_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_cashfree_enabled']) &&
                                                $company_payment_setting['is_cashfree_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_aamarpay_enabled']) &&
                                                $company_payment_setting['is_aamarpay_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_paytr_enabled']) && $company_payment_setting['is_paytr_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_yookassa_enabled']) &&
                                                $company_payment_setting['is_yookassa_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_midtrans_enabled']) &&
                                                $company_payment_setting['is_midtrans_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_xendit_enabled']) &&
                                                $company_payment_setting['is_xendit_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_nepalste_enabled']) &&
                                                $company_payment_setting['is_nepalste_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_paiementpro_enabled']) &&
                                                $company_payment_setting['is_paiementpro_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_cinetpay_enabled']) &&
                                                $company_payment_setting['is_cinetpay_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_fedapay_enabled']) &&
                                                $company_payment_setting['is_fedapay_enabled'] == 'on') ||
                                            (isset($company_payment_setting['is_payhere_enabled']) &&
                                                $company_payment_setting['is_payhere_enabled'] == 'on') ||
                                            (isset($company_payment_setting['tap_payment_is_on']) &&
                                                $company_payment_setting['tap_payment_is_on'] == 'on') ||
                                            (isset($company_payment_setting['authorizenet_payment_is_on']) &&
                                                $company_payment_setting['authorizenet_payment_is_on'] == 'on') ||
                                            (isset($company_payment_setting['khalti_payment_is_on']) &&
                                                $company_payment_setting['khalti_payment_is_on'] == 'on') ||
                                            (isset($company_payment_setting['easebuzz_payment_is_on']) &&
                                                $company_payment_setting['easebuzz_payment_is_on'] == 'on'  ||
                                            (isset($company_payment_setting['company_ozow_payment_is_enabled']) &&
                                                $company_payment_setting['company_ozow_payment_is_enabled'] == 'on')))

                                        <ul class="nav nav-pills  mb-3" role="tablist">
                                            @if ($company_payment_setting['is_bank_transfer_enabled'] == 'on' && !empty($company_payment_setting['bank_details']))
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 active"
                                                        data-bs-toggle="tab" href="#bank-transfer-payment"
                                                        role="tab" aria-controls="bank"
                                                        aria-selected="true">{{ __('Bank Transfer') }}</a>
                                                </li>
                                            @endif

                                            @if (
                                                $company_payment_setting['is_stripe_enabled'] == 'on' &&
                                                    !empty($company_payment_setting['stripe_key']) &&
                                                    !empty($company_payment_setting['stripe_secret']))
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1"
                                                        data-bs-toggle="tab" href="#stripe-payment" role="tab"
                                                        aria-controls="stripe"
                                                        aria-selected="true">{{ __('Stripe') }}</a>
                                                </li>
                                            @endif

                                            @if (
                                                $company_payment_setting['is_paypal_enabled'] == 'on' &&
                                                    !empty($company_payment_setting['paypal_client_id']) &&
                                                    !empty($company_payment_setting['paypal_secret_key']))
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#paypal-payment" role="tab"
                                                        aria-controls="paypal"
                                                        aria-selected="false">{{ __('Paypal') }}</a>
                                                </li>
                                            @endif

                                            @if (
                                                $company_payment_setting['is_paystack_enabled'] == 'on' &&
                                                    !empty($company_payment_setting['paystack_public_key']) &&
                                                    !empty($company_payment_setting['paystack_secret_key']))
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#paystack-payment" role="tab"
                                                        aria-controls="paystack"
                                                        aria-selected="false">{{ __('Paystack') }}</a>
                                                </li>
                                            @endif

                                            @if (isset($company_payment_setting['is_flutterwave_enabled']) &&
                                                    $company_payment_setting['is_flutterwave_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#flutterwave-payment"
                                                        role="tab" aria-controls="flutterwave"
                                                        aria-selected="false">{{ __('Flutterwave') }}</a>
                                                </li>
                                            @endif

                                            @if (isset($company_payment_setting['is_razorpay_enabled']) && $company_payment_setting['is_razorpay_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#razorpay-payment" role="tab"
                                                        aria-controls="razorpay"
                                                        aria-selected="false">{{ __('Razorpay') }}</a>
                                                </li>
                                            @endif


                                            @if (isset($company_payment_setting['is_mercado_enabled']) && $company_payment_setting['is_mercado_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#mercado-payment" role="tab"
                                                        aria-controls="mercado"
                                                        aria-selected="false">{{ __('Mercado') }}</a>
                                                </li>
                                            @endif

                                            @if (isset($company_payment_setting['is_paytm_enabled']) && $company_payment_setting['is_paytm_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#paytm-payment" role="tab"
                                                        aria-controls="paytm"
                                                        aria-selected="false">{{ __('Paytm') }}</a>
                                                </li>
                                            @endif

                                            @if (isset($company_payment_setting['is_mollie_enabled']) && $company_payment_setting['is_mollie_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#mollie-payment" role="tab"
                                                        aria-controls="mollie"
                                                        aria-selected="false">{{ __('Mollie') }}</a>
                                                </li>
                                            @endif

                                            @if (isset($company_payment_setting['is_skrill_enabled']) && $company_payment_setting['is_skrill_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#skrill-payment" role="tab"
                                                        aria-controls="skrill"
                                                        aria-selected="false">{{ __('Skrill') }}</a>
                                                </li>
                                            @endif

                                            @if (isset($company_payment_setting['is_coingate_enabled']) && $company_payment_setting['is_coingate_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#coingate-payment" role="tab"
                                                        aria-controls="coingate"
                                                        aria-selected="false">{{ __('Coingate') }}</a>
                                                </li>
                                            @endif

                                            @if (
                                                $company_payment_setting['is_paymentwall_enabled'] == 'on' &&
                                                    !empty($company_payment_setting['paymentwall_public_key']) &&
                                                    !empty($company_payment_setting['paymentwall_private_key']))
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#paymentwall-payment"
                                                        role="tab" aria-controls="paymentwall"
                                                        aria-selected="false">{{ __('PaymentWall') }}</a>
                                                </li>
                                            @endif

                                            @if (isset($company_payment_setting['is_toyyibpay_enabled']) && $company_payment_setting['is_toyyibpay_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#toyyibpay-payment" role="tab"
                                                        aria-controls="toyyibpay"
                                                        aria-selected="false">{{ __('Toyyibpay') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_payfast_enabled']) && $company_payment_setting['is_payfast_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        onclick=get_payfast_status() data-bs-toggle="tab"
                                                        href="#payfast-payment" role="tab"
                                                        aria-controls="payfast"
                                                        aria-selected="false">{{ __('PayFast') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_iyzipay_enabled']) && $company_payment_setting['is_iyzipay_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#iyzipay-payment" role="tab"
                                                        aria-controls="iyzipay"
                                                        aria-selected="false">{{ __('Iyzipay') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_sspay_enabled']) && $company_payment_setting['is_sspay_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#sspay-payment" role="tab"
                                                        aria-controls="sspay"
                                                        aria-selected="false">{{ __('SSPay') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_paytab_enabled']) && $company_payment_setting['is_paytab_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#paytab-payment" role="tab"
                                                        aria-controls="paytab"
                                                        aria-selected="false">{{ __('PayTab') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_benefit_enabled']) && $company_payment_setting['is_benefit_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#benefit-payment" role="tab"
                                                        aria-controls="benefit"
                                                        aria-selected="false">{{ __('Benefit') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_cashfree_enabled']) && $company_payment_setting['is_cashfree_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#cashfree-payment" role="tab"
                                                        aria-controls="cashfree"
                                                        aria-selected="false">{{ __('Cashfree') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_aamarpay_enabled']) && $company_payment_setting['is_aamarpay_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#aamarpay-payment" role="tab"
                                                        aria-controls="aamarpay"
                                                        aria-selected="false">{{ __('AamarPay') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_paytr_enabled']) && $company_payment_setting['is_paytr_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#paytr-payment" role="tab"
                                                        aria-controls="paytr"
                                                        aria-selected="false">{{ __('PayTR') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_yookassa_enabled']) && $company_payment_setting['is_yookassa_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#yookassa-payment" role="tab"
                                                        aria-controls="yookassa"
                                                        aria-selected="false">{{ __('Yookassa') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_midtrans_enabled']) && $company_payment_setting['is_midtrans_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#midtrans-payment" role="tab"
                                                        aria-controls="midtrans"
                                                        aria-selected="false">{{ __('Midtrans') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_xendit_enabled']) && $company_payment_setting['is_xendit_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#xendit-payment" role="tab"
                                                        aria-controls="xendit"
                                                        aria-selected="false">{{ __('Xendit') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_nepalste_enabled']) && $company_payment_setting['is_nepalste_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#nepalste-payment" role="tab"
                                                        aria-controls="nepalste"
                                                        aria-selected="false">{{ __('Nepalste') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_paiementpro_enabled']) &&
                                                    $company_payment_setting['is_paiementpro_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#paiementpro-payment"
                                                        role="tab" aria-controls="paiementpro"
                                                        aria-selected="false">{{ __('Paiement Pro') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_cinetpay_enabled']) && $company_payment_setting['is_cinetpay_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#cinetpay-payment"
                                                        role="tab" aria-controls="cinetpay"
                                                        aria-selected="false">{{ __('Cinetpay') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_fedapay_enabled']) && $company_payment_setting['is_fedapay_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#fedapay-payment"
                                                        role="tab" aria-controls="fedapay"
                                                        aria-selected="false">{{ __('Fedapay') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['is_payhere_enabled']) && $company_payment_setting['is_payhere_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#payhere-payment"
                                                        role="tab" aria-controls="payhere"
                                                        aria-selected="false">{{ __('PayHere') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['tap_payment_is_on']) && $company_payment_setting['tap_payment_is_on'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#tap-payment"
                                                        role="tab" aria-controls="tap"
                                                        aria-selected="false">{{ __('Tap') }}</a>
                                                </li>
                                             @endif
                                             @if (isset($company_payment_setting['authorizenet_payment_is_on']) && $company_payment_setting['authorizenet_payment_is_on'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#authorizenet-payment"
                                                        role="tab" aria-controls="tap"
                                                        aria-selected="false">{{ __('AuthorizeNet') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['khalti_payment_is_on']) && $company_payment_setting['khalti_payment_is_on'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#khalti-payment"
                                                        role="tab" aria-controls="tap"
                                                        aria-selected="false">{{ __('Khalti') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['easebuzz_payment_is_on']) && $company_payment_setting['easebuzz_payment_is_on'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#easebuzz-payment"
                                                        role="tab" aria-controls="tap"
                                                        aria-selected="false">{{ __('Easebuzz') }}</a>
                                                </li>
                                            @endif
                                            @if (isset($company_payment_setting['company_ozow_payment_is_enabled']) && $company_payment_setting['company_ozow_payment_is_enabled'] == 'on')
                                                <li class="nav-item mb-2">
                                                    <a class="btn btn-outline-primary btn-sm me-1 ml-1"
                                                        data-bs-toggle="tab" href="#ozow-payment"
                                                        role="tab" aria-controls="ozow"
                                                        aria-selected="false">{{ __('Ozow') }}</a>
                                                </li>
                                            @endif
                                        </ul>
                                    @endif

                                    <div class="tab-content">
                                        @if (
                                            !empty($company_payment_setting) &&
                                                ($company_payment_setting['is_bank_transfer_enabled'] == 'on' &&
                                                    !empty($company_payment_setting['bank_details'])))
                                            <div class="tab-pane fade active show" id="bank-transfer-payment"
                                                role="tabpanel" aria-labelledby="bank-transfer-payment">
                                                <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                                    enctype="multipart/form-data"
                                                    action="{{ route('customer.pay.with.bank') }}">

                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">

                                                    <div class="row">
                                                        <div class="col-6 ">
                                                            <div class="custom-radio">
                                                                <label
                                                                    class="font-16 font-bold">{{ __('Bank Details') }}
                                                                    :</label>
                                                            </div>
                                                            <p class="mb-0 pt-1 text-sm">
                                                                {!! $company_payment_setting['bank_details'] !!}
                                                            </p>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ Form::label('payment_receipt', __('Payment Receipt'), ['class' => 'form-label']) }}
                                                            <div class="choose-file form-group">
                                                                <input type="file" name="payment_receipt"
                                                                    id="image" class="form-control" required>
                                                                <p class="upload_file"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="form-group col-md-12">
                                                            <label for="amount">{{ __('Amount') }}</label>
                                                            <div class="input-group">
                                                                <span class="input-group-prepend"><span
                                                                        class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                                <input class="form-control" required="required"
                                                                    min="0" name="amount" type="number"
                                                                    value="{{ $invoice->getDue() }}" min="0"
                                                                    step="0.01" max="{{ $invoice->getDue() }}"
                                                                    id="amount">
                                                                @error('amount')
                                                                    <span class="invalid-amount" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (
                                            !empty($company_payment_setting) &&
                                                ($company_payment_setting['is_stripe_enabled'] == 'on' &&
                                                    !empty($company_payment_setting['stripe_key']) &&
                                                    !empty($company_payment_setting['stripe_secret'])))
                                            <div class="tab-pane fade" id="stripe-payment" role="tabpanel"
                                                aria-labelledby="stripe-payment">
                                                <form method="post"
                                                    action="{{ route('customer.payment', $invoice->id) }}"
                                                    class="require-validation" id="payment-form">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <div class="custom-radio">
                                                                <label
                                                                    class="font-16 font-weight-bold">{{ __('Credit / Debit Card') }}</label>
                                                            </div>
                                                            <p class="mb-0 pt-1 text-sm">
                                                                {{ __('Safe money transfer using your bank account. We support Mastercard, Visa, Discover and American express.') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label
                                                                    for="card-name-on">{{ __('Name on card') }}</label>
                                                                <input type="text" name="name"
                                                                    id="card-name-on" class="form-control required" placeholder="{{ __('Enter Name') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div id="card-element">
                                                                <div id="card-errors" role="alert"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <br>
                                                            <label for="amount">{{ __('Amount') }}</label>
                                                            <div class="input-group">
                                                                <span class="input-group-prepend"><span
                                                                        class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                                <input class="form-control" required="required"
                                                                    min="0" name="amount" type="number"
                                                                    value="{{ $invoice->getDue() }}" min="0"
                                                                    step="0.01" max="{{ $invoice->getDue() }}"
                                                                    id="amount" placeholder="{{ __('Enter Amount') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="error" style="display: none;">
                                                                <div class='alert-danger alert'>
                                                                    {{ __('Please correct the errors and try again.') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (
                                            !empty($company_payment_setting) &&
                                                ($company_payment_setting['is_paypal_enabled'] == 'on' &&
                                                    !empty($company_payment_setting['paypal_client_id']) &&
                                                    !empty($company_payment_setting['paypal_secret_key'])))
                                            <div class="tab-pane fade" id="paypal-payment" role="tabpanel"
                                                aria-labelledby="paypal-payment">
                                                <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                                    id="payment-form"
                                                    action="{{ route('customer.pay.with.paypal', $invoice->id) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="amount">{{ __('Amount') }}</label>
                                                            <div class="input-group">
                                                                <span class="input-group-prepend"><span
                                                                        class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                                <input class="form-control" required="required"
                                                                    min="0" name="amount" type="number"
                                                                    value="{{ $invoice->getDue() }}" min="0"
                                                                    step="0.01" max="{{ $invoice->getDue() }}"
                                                                    id="amount" placeholder="{{ __('Enter Amount') }}">
                                                                @error('amount')
                                                                    <span class="invalid-amount" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_paystack_enabled']) &&
                                                $company_payment_setting['is_paystack_enabled'] == 'on' &&
                                                !empty($company_payment_setting['paystack_public_key']) &&
                                                !empty($company_payment_setting['paystack_secret_key']))
                                            <div class="tab-pane fade " id="paystack-payment" role="tabpanel"
                                                aria-labelledby="paypal-payment">
                                                <form class="w3-container w3-display-middle w3-card-4" method="POST"
                                                    id="paystack-payment-form"
                                                    action="{{ route('customer.pay.with.paystack') }}">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_paystack"
                                                            type="button">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_flutterwave_enabled']) &&
                                                $company_payment_setting['is_flutterwave_enabled'] == 'on' &&
                                                !empty($company_payment_setting['paystack_public_key']) &&
                                                !empty($company_payment_setting['paystack_secret_key']))
                                            <div class="tab-pane fade " id="flutterwave-payment" role="tabpanel"
                                                aria-labelledby="paypal-payment">
                                                <form role="form"
                                                    action="{{ route('customer.pay.with.flaterwave') }}"
                                                    method="post" class="require-validation"
                                                    id="flaterwave-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_flaterwave"
                                                            type="button">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_razorpay_enabled']) && $company_payment_setting['is_razorpay_enabled'] == 'on')
                                            <div class="tab-pane fade " id="razorpay-payment" role="tabpanel"
                                                aria-labelledby="paypal-payment">
                                                <form role="form"
                                                    action="{{ route('customer.pay.with.razorpay') }}"
                                                    method="post" class="require-validation"
                                                    id="razorpay-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_razorpay"
                                                            type="button">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_mercado_enabled']) && $company_payment_setting['is_mercado_enabled'] == 'on')
                                            <div class="tab-pane fade " id="mercado-payment" role="tabpanel"
                                                aria-labelledby="mercado-payment">
                                                <form role="form"
                                                    action="{{ route('customer.pay.with.mercado') }}" method="post"
                                                    class="require-validation" id="mercado-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_mercado"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_paytm_enabled']) && $company_payment_setting['is_paytm_enabled'] == 'on')
                                            <div class="tab-pane fade" id="paytm-payment" role="tabpanel"
                                                aria-labelledby="paytm-payment">
                                                <form role="form" action="{{ route('customer.pay.with.paytm') }}"
                                                    method="post" class="require-validation"
                                                    id="paytm-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="flaterwave_coupon"
                                                                class=" text-dark">{{ __('Mobile Number') }}</label>
                                                            <input type="text" id="mobile" name="mobile"
                                                                class="form-control mobile" data-from="mobile"
                                                                placeholder="{{ __('Enter Mobile Number') }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_paytm"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_mollie_enabled']) && $company_payment_setting['is_mollie_enabled'] == 'on')
                                            <div class="tab-pane fade " id="mollie-payment" role="tabpanel"
                                                aria-labelledby="mollie-payment">
                                                <form role="form"
                                                    action="{{ route('customer.pay.with.mollie') }}" method="post"
                                                    class="require-validation" id="mollie-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_mollie"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_skrill_enabled']) && $company_payment_setting['is_skrill_enabled'] == 'on')
                                            <div class="tab-pane fade " id="skrill-payment" role="tabpanel"
                                                aria-labelledby="skrill-payment">
                                                <form role="form"
                                                    action="{{ route('customer.pay.with.skrill') }}" method="post"
                                                    class="require-validation" id="skrill-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    @php
                                                        $skrill_data = [
                                                            'transaction_id' => md5(
                                                                date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id',
                                                            ),
                                                            'user_id' => 'user_id',
                                                            'amount' => 'amount',
                                                            'currency' => 'currency',
                                                        ];
                                                        session()->put('skrill_data', $skrill_data);
                                                    @endphp
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_skrill"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_coingate_enabled']) && $company_payment_setting['is_coingate_enabled'] == 'on')
                                            <div class="tab-pane fade " id="coingate-payment" role="tabpanel"
                                                aria-labelledby="coingate-payment">
                                                <form role="form"
                                                    action="{{ route('customer.pay.with.coingate') }}"
                                                    method="post" class="require-validation"
                                                    id="coingate-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_coingate"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (
                                            !empty($company_payment_setting) &&
                                                isset($company_payment_setting['is_paymentwall_enabled']) &&
                                                $company_payment_setting['is_paymentwall_enabled'] == 'on' &&
                                                !empty($company_payment_setting['paymentwall_public_key']) &&
                                                !empty($company_payment_setting['paymentwall_private_key']))
                                            <div class="tab-pane fade " id="paymentwall-payment" role="tabpanel"
                                                aria-labelledby="paypal-payment">
                                                <form class="w3-container w3-display-middle w3-card-4" method="POST"
                                                    id="paymentwall-payment-form"
                                                    action="{{ route('invoice.paymentwallpayment') }}">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">

                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend">

                                                                <span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span>
                                                            </span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_coingate"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_toyyibpay_enabled']) && $company_payment_setting['is_toyyibpay_enabled'] == 'on')
                                            <div class="tab-pane fade" id="toyyibpay-payment" role="tabpanel"
                                                aria-labelledby="toyyibpay-payment">
                                                <form role="form"
                                                    action="{{ route('customer.pay.with.toyyibpay') }}"
                                                    method="post" class="require-validation"
                                                    id="toyyibpay-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_toyyibpay"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif


                                        @if (
                                            !empty($company_payment_setting) &&
                                                isset($company_payment_setting['is_payfast_enabled']) &&
                                                $company_payment_setting['is_payfast_enabled'] == 'on' &&
                                                !empty($company_payment_setting['is_payfast_enabled']) &&
                                                !empty($company_payment_setting['is_payfast_enabled']))
                                            <div class="tab-pane fade " id="payfast-payment" role="tabpanel"
                                                aria-labelledby="payfast-payment">
                                                @php
                                                    $pfHost =
                                                        $company_payment_setting['payfast_mode'] == 'sandbox'
                                                            ? 'sandbox.payfast.co.za'
                                                            : 'www.payfast.co.za';
                                                @endphp
                                                <form role="form"
                                                    action={{ 'https://' . $pfHost . '/eng/process' }} method="post"
                                                    id="payfast-payment-form">
                                                    @csrf
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="pay_fast_amount" onchange=get_payfast_status()  placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div id="get-payfast-inputs"></div>
                                                    <div class="form-group mt-3">
                                                        <input type="hidden" name="invoice_id" id="invoice_id"
                                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_payfast"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_iyzipay_enabled']) && $company_payment_setting['is_iyzipay_enabled'] == 'on')
                                            <div class="tab-pane fade" id="iyzipay-payment" role="tabpanel"
                                                aria-labelledby="iyzipay-payment">
                                                <form role="form"
                                                    action="{{ route('customer.pay.with.iyzipay') }}" method="post"
                                                    class="require-validation" id="iyzipay-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_toyyibpay"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_sspay_enabled']) && $company_payment_setting['is_sspay_enabled'] == 'on')
                                            <div class="tab-pane fade" id="sspay-payment" role="tabpanel"
                                                aria-labelledby="sspay-payment">
                                                <form role="form" action="{{ route('customer.pay.with.sspay') }}"
                                                    method="post" class="require-validation"
                                                    id="sspay-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_sspay"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_paytab_enabled']) && $company_payment_setting['is_paytab_enabled'] == 'on')
                                            <div class="tab-pane fade" id="paytab-payment" role="tabpanel"
                                                aria-labelledby="paytab-payment">
                                                <form role="form"
                                                    action="{{ route('customer.pay.with.paytab') }}" method="post"
                                                    class="require-validation" id="paytab-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_paytab"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_benefit_enabled']) && $company_payment_setting['is_benefit_enabled'] == 'on')
                                            <div class="tab-pane fade" id="benefit-payment" role="tabpanel"
                                                aria-labelledby="benefit-payment">
                                                <form role="form"
                                                    action="{{ route('invoice.benefit.initiate') }}" method="post"
                                                    class="require-validation" id="benefit-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_benefit"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_cashfree_enabled']) && $company_payment_setting['is_cashfree_enabled'] == 'on')
                                            <div class="tab-pane fade" id="cashfree-payment" role="tabpanel"
                                                aria-labelledby="cashfree-payment">
                                                <form role="form"
                                                    action="{{ route('customer.pay.with.cashfree') }}"
                                                    method="post" class="require-validation"
                                                    id="cashfree-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_cashfree"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                        @if (isset($company_payment_setting['is_aamarpay_enabled']) && $company_payment_setting['is_aamarpay_enabled'] == 'on')
                                            <div class="tab-pane fade" id="aamarpay-payment" role="tabpanel"
                                                aria-labelledby="aamarpay-payment">
                                                <form role="form"
                                                    action="{{ route('customer.pay.with.aamarpay') }}"
                                                    method="post" class="require-validation"
                                                    id="aamarpay-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_aamarpay"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                        @if (isset($company_payment_setting['is_paytr_enabled']) && $company_payment_setting['is_paytr_enabled'] == 'on')
                                            <div class="tab-pane fade" id="paytr-payment" role="tabpanel"
                                                aria-labelledby="paytr-payment">
                                                <form role="form"
                                                    action="{{ route('customer.pay.with.paytr') }}" method="post"
                                                    class="require-validation" id="paytr-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_paytr"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                        @if (isset($company_payment_setting['is_yookassa_enabled']) && $company_payment_setting['is_yookassa_enabled'] == 'on')
                                            <div class="tab-pane fade" id="yookassa-payment" role="tabpanel"
                                                aria-labelledby="yookassa-payment">
                                                <form role="form"
                                                    action="{{ route('customer.with.yookassa') }}" method="post"
                                                    class="require-validation" id="yookassa-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_yookassa"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                        @if (isset($company_payment_setting['is_midtrans_enabled']) && $company_payment_setting['is_midtrans_enabled'] == 'on')
                                            <div class="tab-pane fade" id="midtrans-payment" role="tabpanel"
                                                aria-labelledby="midtrans-payment">
                                                <form role="form"
                                                    action="{{ route('customer.with.midtrans') }}" method="post"
                                                    class="require-validation" id="midtrans-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_midtrans"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_xendit_enabled']) && $company_payment_setting['is_xendit_enabled'] == 'on')
                                            <div class="tab-pane fade" id="xendit-payment" role="tabpanel"
                                                aria-labelledby="xendit-payment">
                                                <form role="form" action="{{ route('customer.with.xendit') }}"
                                                    method="post" class="require-validation"
                                                    id="xendit-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_xendit"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif


                                        @if (isset($company_payment_setting['is_nepalste_enabled']) && $company_payment_setting['is_nepalste_enabled'] == 'on')
                                            <div class="tab-pane fade" id="nepalste-payment" role="tabpanel"
                                                aria-labelledby="nepalste-payment">
                                                <form role="form"
                                                    action="{{ route('customer.with.nepalste') }}" method="post"
                                                    class="require-validation" id="nepalste-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_nepalste"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_paiementpro_enabled']) &&
                                                $company_payment_setting['is_paiementpro_enabled'] == 'on')
                                            <div class="tab-pane fade" id="paiementpro-payment" role="tabpanel"
                                                aria-labelledby="paiementpro-payment">
                                                <form role="form"
                                                    action="{{ route('customer.with.paiementpro') }}"
                                                    method="post" class="require-validation"
                                                    id="paiementpro-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="paiementpro_mobile_number"
                                                                    class="form-control-label text-dark">{{ __('Mobile Number') }}</label>
                                                                <input type="text" id="paiementpro_mobile_number"
                                                                    name="mobile_number"
                                                                    class="form-control mobile_number"
                                                                    data-from="paiementpro"
                                                                    placeholder="{{ __('Enter Mobile Number') }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="paiementpro_channel"
                                                                    class="form-control-label text-dark">{{ __('Channel') }}</label>
                                                                <input type="text" id="paiementpro_channel"
                                                                    name="channel" class="form-control channel"
                                                                    data-from="paiementpro"
                                                                    placeholder="{{ __('Enter Channel') }}" required>
                                                                <small class="text-danger">Example : OMCIV2 , MOMO ,
                                                                    CARD , FLOOZ , PAYPAL</small>
                                                            </div>
                                                        </div>
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_paiementpro"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_cinetpay_enabled']) && $company_payment_setting['is_cinetpay_enabled'] == 'on')
                                            <div class="tab-pane fade" id="cinetpay-payment" role="tabpanel"
                                                aria-labelledby="cinetpay-payment">
                                                <form role="form"
                                                    action="{{ route('customer.with.cinetpay') }}"
                                                    method="post" class="require-validation"
                                                    id="cinetpay-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_cinetpay"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_fedapay_enabled']) && $company_payment_setting['is_fedapay_enabled'] == 'on')
                                            <div class="tab-pane fade" id="fedapay-payment" role="tabpanel"
                                                aria-labelledby="fedapay-payment">
                                                <form role="form"
                                                    action="{{ route('customer.with.fedapay') }}"
                                                    method="post" class="require-validation"
                                                    id="fedapay-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_fedapay"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['is_payhere_enabled']) && $company_payment_setting['is_payhere_enabled'] == 'on')
                                            <div class="tab-pane fade" id="payhere-payment" role="tabpanel"
                                                aria-labelledby="payhere-payment">
                                                <form role="form"
                                                    action="{{ route('customer.with.payhere') }}"
                                                    method="post" class="require-validation"
                                                    id="payhere-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_payhere"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['tap_payment_is_on']) && $company_payment_setting['tap_payment_is_on'] == 'on')
                                            <div class="tab-pane fade" id="tap-payment" role="tabpanel"
                                                aria-labelledby="tap-payment">
                                                <form role="form"
                                                    action="{{ route('invoice.pay.with.tap') }}"
                                                    method="post" class="require-validation"
                                                    id="tap-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_tap"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['authorizenet_payment_is_on']) && $company_payment_setting['authorizenet_payment_is_on'] == 'on')
                                            <div class="tab-pane fade" id="authorizenet-payment" role="tabpanel"
                                                aria-labelledby="authorizenet-payment">
                                                <form role="form"
                                                    action="{{ route('invoice.pay.with.authorizenet') }}"
                                                    method="post" class="require-validation"
                                                    id="authorizenet-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_authorizenet"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['khalti_payment_is_on']) && $company_payment_setting['khalti_payment_is_on'] == 'on')
                                            <div class="tab-pane fade" id="khalti-payment" role="tabpanel"
                                                aria-labelledby="khalti-payment">
                                                @csrf
                                                    <input type="hidden" name="invoice_id" id="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control amount" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_khalti"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                            </div>
                                        @endif

                                        @if (isset($company_payment_setting['easebuzz_payment_is_on']) && $company_payment_setting['easebuzz_payment_is_on'] == 'on')
                                            <div class="tab-pane fade" id="easebuzz-payment" role="tabpanel"
                                                aria-labelledby="easebuzz-payment">
                                                <form role="form"
                                                    action="{{ route('invoice.pay.with.easebuzz') }}"
                                                    method="post" class="require-validation"
                                                    id="easebuzz-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_easebuzz"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif


                                        @if (isset($company_payment_setting['company_ozow_payment_is_enabled']) && $company_payment_setting['company_ozow_payment_is_enabled'] == 'on')
                                            <div class="tab-pane fade" id="ozow-payment" role="tabpanel"
                                                aria-labelledby="ozow-payment">
                                                <form role="form"
                                                    action="{{ route('invoice.pay.with.ozow') }}"
                                                    method="post" class="require-validation"
                                                    id="ozow-payment-form">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount">{{ __('Amount') }}</label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span
                                                                    class="input-group-text">{{ $company_setting['site_currency'] }}</span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="{{ $invoice->getDue() }}" min="0"
                                                                step="0.01" max="{{ $invoice->getDue() }}"
                                                                id="amount" placeholder="{{ __('Enter Amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" name="submit"
                                                            id="pay_with_easebuzz"
                                                            type="submit">{{ __('Make Payment') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif



                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
        <div id="liveToast" class="toast text-white  fade" role="alert" aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"> </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    <footer id="footer-main">
        <div class="footer-dark">
            <div class="container">
                <div class="row align-items-center justify-content-md-between py-4 mt-4 delimiter-top">
                    <div class="col-md-6">
                        <div class="copyright text-sm font-weight-bold text-center text-md-left">
                            {{ !empty($companySettings['footer_text']) ? $companySettings['footer_text']->value : '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/dash.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>

    <!-- Apex Chart -->
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>


    <script src="{{ asset('js/jscolor.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @if ($message = Session::get('success'))
        <script>
            show_toastr('success', '{!! $message !!}');
        </script>
    @endif
    @if ($message = Session::get('error'))
        <script>
            show_toastr('error', '{!! $message !!}');
        </script>
    @endif


    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>

    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script> -->
    <script>

    var config = {
        "publicKey": "{{ isset($company_payment_setting['khalti_public_key']) ? $company_payment_setting['khalti_public_key'] : '' }}",
        "productIdentity": "1234567890",
        "productName": "demo",
        "productUrl": "{{env('APP_URL')}}",
        "paymentPreference": [
            "KHALTI",
            "EBANKING",
            "MOBILE_BANKING",
            "CONNECT_IPS",
            "SCT",
        ],
        "eventHandler": {
            onSuccess (payload) {
                if(payload.status==200) {
                    $.ajaxSetup({
                            headers: {
                                'X-CSRF-Token': '{{csrf_token()}}'
                            }
                        });
                    $.ajax({
                        url: '{{ route('invoice.pay.with.khalti') }}',
                        method: 'POST',
                        data : {
                            'payload' : payload,
                            'invoice_id' : $('#invoice_id').val(),
                            'amount' : $('.amount').val(),
                        },
                        beforeSend: function () {
                            $(".loader-wrapper").removeClass('d-none');
                        },
                        success: function(data) {
                            $(".loader-wrapper").addClass('d-none');
                            if(data.status_code === 200){
                                show_toastr('Success','Payment Done Successfully', 'success');
                                setTimeout(() => {
                                    location.reload();
                                }, 100);
                            }
                            else{
                                show_toastr('Error','Payment Failed', 'error');
                            }
                        },
                        error: function(err) {
                            show_toastr('Error', err.response, 'error')
                        },
                    });
                }
            },
            onError (error) {
                show_toastr('Error', error, 'error')
            },
            onClose () {
            }
        }

    };

    $(document).on('click', '#pay_with_khalti', function () {
        var account = "{{$khaltiAccount}}";
        if(account == '')
        {
            show_toastr('Error', '{{ __("Bank account not connected with Khalti.") }}', 'error')
            return;
        } 
        var checkout = new KhaltiCheckout(config);
            var btn = document.getElementById("pay_with_khalti");
            btn.onclick = function () {
                let price =  $('.amount').val()*100;
                checkout.show({amount: price});
        }
    });
</script>

    <script type="text/javascript">
        @if (
            $invoice->status != 0 &&
                $invoice->getDue() > 0 &&
                !empty($company_payment_setting) &&
                $company_payment_setting['is_stripe_enabled'] == 'on' &&
                !empty($company_payment_setting['stripe_key']) &&
                !empty($company_payment_setting['stripe_secret']))
            var stripe = Stripe('{{ $company_payment_setting['stripe_key'] }}');
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            var style = {
                base: {
                    // Add your base input styles here. For example:
                    fontSize: '14px',
                    color: '#32325d',
                },
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {
                style: style
            });

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

            // Create a token or display an error when the form is submitted.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        $("#card-errors").html(result.error.message);
                        show_toastr('error', result.error.message, 'error');
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });

            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        @endif

        @if (isset($company_payment_setting['paystack_public_key']))
            $(document).on("click", "#pay_with_paystack", function() {
                var account = "{{$paystackAccount}}";
                if(account == '')
                {
                    show_toastr('Error', '{{ __("Bank account not connected with Paystack.") }}', 'error')
                    return;
                } 
                $('#paystack-payment-form').ajaxForm(function(res) {
                    var amount = res.total_price;
                    if (res.flag == 1) {
                        var paystack_callback = "{{ url('/customer/paystack') }}";

                        var handler = PaystackPop.setup({
                            key: '{{ $company_payment_setting['paystack_public_key'] }}',
                            email: res.email,
                            amount: res.total_price * 100,
                            currency: res.currency,
                            ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                                1
                            ), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                            metadata: {
                                custom_fields: [{
                                    display_name: "Email",
                                    variable_name: "email",
                                    value: res.email,
                                }]
                            },

                            callback: function(response) {

                                window.location.href = paystack_callback + '/' + response
                                    .reference + '/' + '{{ encrypt($invoice->id) }}' +
                                    '?amount=' + amount;
                            },
                            onClose: function() {
                            }
                        });
                        handler.openIframe();
                    } else if (res.flag == 2) {
                        show_toastr('error', res.msg);
                    } else {
                        show_toastr('error', res.message);
                    }

                }).submit();
            });
        @endif

        @if (isset($company_payment_setting['flutterwave_public_key']))
            //    Flaterwave Payment
            $(document).on("click", "#pay_with_flaterwave", function() {
                var account = "{{$flutterwaveAccount}}";
                if(account == '')
                {
                    show_toastr('Error', '{{ __("Bank account not connected with Flutterwave.") }}', 'error')
                    return;
                } 
                $('#flaterwave-payment-form').ajaxForm(function(res) {

                    if (res.flag == 1) {
                        var amount = res.total_price;
                        var API_publicKey = '{{ $company_payment_setting['flutterwave_public_key'] }}';
                        var nowTim = "{{ date('d-m-Y-h-i-a') }}";
                        var flutter_callback = "{{ url('/customer/flaterwave') }}";
                        var x = getpaidSetup({
                            PBFPubKey: API_publicKey,
                            customer_email: '{{ $user->email }}',
                            amount: res.total_price,
                            currency: '{{ $company_setting['site_currency'] }}',
                            txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) +
                                'fluttpay_online-' + '{{ date('Y-m-d') }}',
                            meta: [{
                                metaname: "payment_id",
                                metavalue: "id"
                            }],
                            onclose: function() {},
                            callback: function(response) {
                                var txref = response.tx.txRef;
                                if (
                                    response.tx.chargeResponseCode == "00" ||
                                    response.tx.chargeResponseCode == "0"
                                ) {
                                    window.location.href = flutter_callback + '/' + txref +
                                        '/' +
                                        '{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }} ?amount=' +
                                        amount;
                                } else {
                                    // redirect to a failure page.
                                }
                                x
                                    .close(); // use this to close the modal immediately after payment.
                            }
                        });
                    } else if (res.flag == 2) {
                        toastrs('Error', res.msg, 'msg');
                    } else {
                        toastrs('Error', data.message, 'msg');
                    }

                }).submit();
            });
        @endif

        // Direct Razorpay Payment Function (Bypasses intermediate modal)
        function payNowWithRazorpay() {
            var $topBtn = $('#top_pay_btn');
            var $btmBtn = $('#bottom_pay_btn');
            
            $topBtn.prop('disabled', true).html('<i class="ti ti-loader rotate"></i> Connecting...');
            $btmBtn.prop('disabled', true).html('<i class="ti ti-loader rotate"></i> Connecting Gateway...');

            $.ajax({
                url: "{{ route('customer.pay.with.razorpay') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    invoice_id: "{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}",
                    amount: "{{ $invoice->getDue() }}"
                },
                success: function(res) {
                    $topBtn.prop('disabled', false).html('<i class="ti ti-bolt"></i> {{ __('Pay with Razorpay') }}');
                    $btmBtn.prop('disabled', false).html('<i class="ti ti-bolt"></i> {{ __('Pay Online via Razorpay Gateway') }}');

                    if (res.flag == 1) {
                        var amount = res.total_price;
                        var razorPay_callback = '{{ url('/customer/razorpay') }}';
                        var totalAmount = Math.round(parseFloat(res.total_price) * 100);
                        var options = {
                            "key": "{{ $company_payment_setting['razorpay_public_key'] ?? '' }}",
                            "amount": totalAmount,
                            "name": "ANIMAZON",
                            "description": "Invoice Payment {{ $invDisplayNum }}",
                            "currency": (res.currency && res.currency !== '') ? res.currency : 'INR',
                            "prefill": {
                                "name": "{{ !empty($customer->name) ? $customer->name : (!empty($customer->billing_name) ? $customer->billing_name : '') }}",
                                "email": "{{ !empty($customer->email) ? $customer->email : '' }}",
                                "contact": "{{ !empty($customer->contact) ? $customer->contact : (!empty($customer->billing_phone) ? $customer->billing_phone : '') }}"
                            },
                            "notes": {
                                "invoice_id": "{{ $invoice->id }}",
                                "invoice_number": "{{ $invDisplayNum }}"
                            },
                            "handler": function(response) {
                                window.location.href = razorPay_callback + '/' + response.razorpay_payment_id + '/' + '{{ \Illuminate\Support\Facades\Crypt::encrypt($invoice->id) }}' + '?amount=' + amount;
                            },
                            "theme": {
                                "color": "#0284c7"
                            }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.on('payment.failed', function (response){
                            alert("Payment Failed: " + (response.error.description || response.error.reason));
                        });
                        rzp1.open();
                    } else if (res.flag == 2) {
                        toastrs('Error', res.msg, 'error');
                    } else {
                        toastrs('Error', res.message || 'Payment processing error', 'error');
                    }
                },
                error: function(xhr) {
                    $topBtn.prop('disabled', false).html('<i class="ti ti-bolt"></i> {{ __('Pay with Razorpay') }}');
                    $btmBtn.prop('disabled', false).html('<i class="ti ti-bolt"></i> {{ __('Pay Online via Razorpay Gateway') }}');
                    alert('Unable to initialize Razorpay checkout. Please try again.');
                }
            });
        }

        @if (isset($company_payment_setting['razorpay_public_key']))
            $(document).on("click", "#pay_with_razorpay", function(e) {
                e.preventDefault();
                payNowWithRazorpay();
            });
        @endif

        //start payfast payment

        @if (isset($company_payment_setting['is_payfast_enabled']) &&
                $company_payment_setting['is_payfast_enabled'] == 'on' &&
                !empty($company_payment_setting['payfast_merchant_id']) &&
                !empty($company_payment_setting['payfast_merchant_key']))
            function get_payfast_status() {
                var invoice_id = $('#invoice_id').val();
                var amount = $('#pay_fast_amount').val();

                $.ajax({
                    url: '{{ route('invoice.with.payfast') }}',
                    method: 'POST',
                    data: {
                        'invoice_id': invoice_id,
                        'amount': amount,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.success == true) {
                            $('#get-payfast-inputs').append(data.inputs);

                        } else {
                            show_toastr('Error', data.inputs, 'error')
                        }
                    }
                });
            }
        @endif

        @if (isset($company_payment_setting['is_payfast_enabled']) && $company_payment_setting['is_payfast_enabled'] == 'on')
            function get_payfast_status() {
                var invoice_id = $('#invoice_id').val();
                var amount = $('#pay_fast_amount').val();

                $.ajax({
                    url: '{{ route('invoice.with.payfast') }}',
                    method: 'POST',
                    data: {
                        'invoice_id': invoice_id,
                        'amount': amount,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {

                        if (data.success == true) {
                            $('#get-payfast-inputs').append(data.inputs);

                        } else {
                            show_toastr('Error', data.inputs, 'error')
                        }
                    }
                });
            }
        @endif

        //end payfast payment

    </script>
    @if ($get_cookie['enable_cookie'] == 'on')
        @include('layouts.cookie_consent')
    @endif

</body>

</html>
