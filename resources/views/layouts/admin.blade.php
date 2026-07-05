@php
    use App\Models\Utility;
    $setting = \App\Models\Utility::settings();

    $logo = \App\Models\Utility::get_file('uploads/logo');

    $company_favicon = $setting['company_favicon'] ?? '';

    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }

    $primary_color = $setting['primary_color'] ?? '#00c1de';
    $secondary_color = $setting['secondary_color'] ?? '#ff6122';

    $SITE_RTL = $setting['SITE_RTL'] ?? '';

    $lang = \App::getLocale('lang');
    if ($lang == 'ar' || $lang == 'he') {
        $SITE_RTL = 'on';
    }

    $metatitle = isset($setting['meta_title']) ? $setting['meta_title'] : '';
    $metsdesc = isset($setting['meta_desc']) ? $setting['meta_desc'] : '';
    $meta_logo = isset($setting['meta_image']) ? $setting['meta_image'] : '';

@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">

<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

<head>
    <title>{{ $setting['title_text'] ? $setting['title_text'] : config('app.name', 'ANIMAZON') }} - @yield('page-title')
    </title>

    <meta name="title" content="{{ $metatitle }}">
    <meta name="description" content="{{ $metsdesc }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ $metatitle }}">
    <meta property="og:description" content="{{ $metsdesc }}">
    <meta property="og:image" content="{{ \App\Models\Utility::get_file('uploads/meta/' . $meta_logo) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ $metatitle }}">
    <meta property="twitter:description" content="{{ $metsdesc }}">
    <meta property="twitter:image" content="{{ \App\Models\Utility::get_file('uploads/meta/' . $meta_logo) }}">


    <script src="{{ asset('js/html5shiv.js') }}"></script>


    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="url" content="{{ url('') . '/' . config('chatify.path') }}" data-user="{{ Auth::user()->id }}">
    <link rel="icon"
        href="{{ \App\Models\Utility::get_file('uploads/logo/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png'))  . '?' . time() }}"
        type="image" sizes="16x16">

    <!-- Favicon icon -->
    <!-- Calendar-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!--bootstrap switch-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">

    <!-- vendor css -->

    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif

    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style-link">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{ time() }}">
    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('css/custom-dark.css') }}?v={{ time() }}">
        <style>
            body.dash-sidebar-dark .client-card,
            body.dash-sidebar-dark .user-card,
            body.dash-sidebar-dark .support-user-card,
            .client-card, .user-card, .support-user-card {
                background-color: #2b2d39 !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
            }
            .client-card h5, .client-card h6, .client-card a, .client-card .text-dark,
            .user-card h5, .user-card h6, .user-card a, .user-card .text-dark,
            .support-user-card h5, .support-user-card h6, .support-user-card a, .support-user-card .text-dark {
                color: #ffffff !important;
            }
            .client-card .text-muted, .user-card .text-muted, .support-user-card .text-muted {
                color: #9ea4b4 !important;
            }
        </style>
    @endif
    <link rel="stylesheet" href="{{ asset('css/custom-color.css') }}">
    @stack('css-page')

    <style>
        /* ================================================================
           ANIMAZON ADMIN DESIGN SYSTEM v2 — Modern Flat UI
           No gradients. No glow. Clean, professional, SaaS-grade.
           ================================================================ */

        :root {
            --color-customColor: {{ $primary_color }};
            --primary: {{ $primary_color }};
            --secondary: {{ $secondary_color }};
            --bs-primary: {{ $primary_color }};
            --bs-primary-rgb: {{ implode(',', Utility::hex2rgb($primary_color)) }};
            --bs-success: {{ $primary_color }};
            --bs-success-rgb: {{ implode(',', Utility::hex2rgb($primary_color)) }};
        }

        /* ===== SIDEBAR: Always dark, permanently ===== */
        .dash-sidebar, .dash-sidebar.light-sidebar {
            background: #13151a !important;
            box-shadow: 1px 0 0 rgba(255,255,255,0.04) !important;
            border-right: none !important;
        }
        .dash-sidebar .navbar-wrapper .m-header {
            height: 52px !important;
            min-height: 52px !important;
            max-height: 52px !important;
            border-bottom: 1px solid rgba(255,255,255,0.06) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .dash-sidebar .dash-navbar .dash-item .dash-link {
            padding: 7px 12px !important;
            font-size: 0.8125rem !important;
            color: #8b90a0 !important;
            border-radius: 6px !important;
            margin: 1px 8px !important;
            width: calc(100% - 16px) !important;
            transition: color 0.15s ease, background-color 0.15s ease !important;
            background: transparent !important;
            box-shadow: none !important;
        }
        .dash-sidebar .dash-navbar .dash-item .dash-link i,
        .dash-sidebar .dash-navbar .dash-item .dash-link .dash-micon i {
            color: #5c6070 !important;
            font-size: 1.1rem !important;
            transition: color 0.15s ease !important;
        }
        /* Hover: subtle tint, no slide animation */
        .dash-sidebar .dash-navbar .dash-item:not(.active) > .dash-link:hover {
            background-color: rgba(255,255,255,0.05) !important;
            color: #d0d4e0 !important;
            transform: none !important;
        }
        .dash-sidebar .dash-navbar .dash-item:not(.active) > .dash-link:hover i,
        .dash-sidebar .dash-navbar .dash-item:not(.active) > .dash-link:hover .dash-micon i {
            color: var(--primary) !important;
            transform: none !important;
        }
        /* Active parent (has submenu): transparent, just show it's expanded */
        .dash-sidebar .dash-navbar .dash-item.dash-hasmenu.active > .dash-link,
        .dash-sidebar .dash-navbar .dash-item.dash-hasmenu.dash-trigger > .dash-link,
        .dash-sidebar.light-sidebar .dash-navbar .dash-item.dash-hasmenu.active > .dash-link {
            background: transparent !important;
            box-shadow: none !important;
            color: #e0e3eb !important;
        }
        .dash-sidebar .dash-navbar .dash-item.dash-hasmenu.active > .dash-link i,
        .dash-sidebar .dash-navbar .dash-item.dash-hasmenu.dash-trigger > .dash-link i,
        .dash-sidebar.light-sidebar .dash-navbar .dash-item.dash-hasmenu.active > .dash-link i {
            color: var(--primary) !important;
        }
        /* Active leaf submenu item: solid primary fill, no gradient, no glow */
        .dash-sidebar .dash-navbar .dash-submenu > .dash-item.active > .dash-link {
            background: var(--primary) !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: none !important;
            border-radius: 6px !important;
        }
        .dash-sidebar .dash-navbar .dash-submenu > .dash-item.active > .dash-link i {
            color: #ffffff !important;
        }
        /* Active standalone top-level item (no children): solid primary */
        .dash-sidebar .dash-navbar > .dash-item.active:not(.dash-hasmenu) > .dash-link {
            background: var(--primary) !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: none !important;
            border-radius: 6px !important;
        }
        .dash-sidebar .dash-navbar > .dash-item.active:not(.dash-hasmenu) > .dash-link i {
            color: #ffffff !important;
        }
        /* Hide legacy circle bullet/icon in submenus to prevent text overlapping */
        .dash-sidebar .dash-navbar .dash-submenu .dash-item::before,
        .dash-sidebar .dash-navbar .dash-submenu .dash-link::before,
        .dash-sidebar .dash-navbar .dash-submenu .dash-item::after,
        .dash-sidebar .dash-navbar .dash-submenu .dash-link::after {
            display: none !important;
            content: none !important;
        }
        /* Submenu container & clean indentation */
        .dash-sidebar .dash-navbar .dash-submenu {
            padding: 4px 0 4px !important;
            margin: 0 !important;
            list-style: none !important;
        }
        .dash-sidebar .dash-navbar .dash-submenu .dash-item {
            position: relative !important;
            margin: 2px 8px !important;
            padding: 0 !important;
            border: none !important;
        }
        .dash-sidebar .dash-navbar .dash-submenu .dash-link {
            padding: 7px 12px 7px 32px !important;
            font-size: 0.8rem !important;
            display: block !important;
            border-radius: 6px !important;
        }
        /* Sidebar caption / category headers */
        .dash-sidebar .dash-caption {
            color: #4a4e5c !important;
            font-size: 0.65rem !important;
            letter-spacing: 0.08em !important;
            text-transform: uppercase !important;
            padding: 12px 20px 4px !important;
        }

        /* ===== HEADER BAR ===== */
        .dash-header {
            min-height: 56px !important;
            padding: 0 1.25rem !important;
            border-bottom: 1px solid transparent !important;
            box-shadow: none !important;
        }
        .dash-header .header-wrapper {
            min-height: 56px !important;
        }
        .dash-header .header-wrapper .ms-auto .dash-head-link > i,
        .dash-header .header-wrapper .dash-navbar-left .dash-link i {
            font-size: 1.15rem !important;
        }
        .dash-header .drp-language .drp-text,
        .dash-header .dash-head-link > i:not(.nocolor) {
            color: var(--primary) !important;
        }
        /* Header dropdown menus */
        .dash-h-dropdown, .dropdown-menu {
            border-radius: 10px !important;
            border: 1px solid rgba(0,0,0,0.08) !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08) !important;
            overflow: hidden !important;
        }

        /* ===== BUTTONS — FLAT, NO GRADIENTS ===== */
        .btn {
            padding: 0.45rem 1rem !important;
            font-size: 0.8125rem !important;
            border-radius: 8px !important;
            font-weight: 500 !important;
            transition: background-color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease !important;
            background-image: none !important;
            box-shadow: none !important;
        }
        .btn-sm, .btn-group-sm > .btn {
            padding: 0.25rem 0.65rem !important;
            font-size: 0.75rem !important;
            border-radius: 6px !important;
        }
        .btn-primary, .btn-success, .btn-info, .btn-secondary, .btn-dark,
        .bg-primary, .bg-success, .bg-info, .bg-secondary, .bg-dark,
        .badge-success, .badge-primary, .badge-info,
        .dash-link.btn-primary {
            background-color: {{ $primary_color }} !important;
            background-image: none !important;
            border-color: {{ $primary_color }} !important;
            color: #ffffff !important;
            box-shadow: none !important;
        }
        .btn-primary:hover, .btn-success:hover {
            background-color: {{ $secondary_color }} !important;
            border-color: {{ $secondary_color }} !important;
            box-shadow: none !important;
        }
        .btn-warning, .bg-warning {
            background-color: {{ $secondary_color }} !important;
            border-color: {{ $secondary_color }} !important;
            color: #ffffff !important;
        }
        .btn-light-primary {
            background: rgba({{ implode(',', Utility::hex2rgb($primary_color)) }}, 0.08) !important;
            color: {{ $primary_color }} !important;
            border-color: transparent !important;
        }
        .btn-light-primary:hover {
            background: {{ $primary_color }} !important;
            color: #fff !important;
            border-color: {{ $primary_color }} !important;
        }
        .btn-outline-primary {
            color: {{ $primary_color }} !important;
            border-color: {{ $primary_color }} !important;
            background: transparent !important;
        }
        .btn-outline-primary:hover {
            background: {{ $primary_color }} !important;
            color: #fff !important;
        }
        /* Remove gradient from nav pills */
        .nav-pills .nav-link.active,
        .nav-pills .show > .nav-link {
            background: {{ $primary_color }} !important;
            background-image: none !important;
            color: #fff !important;
            box-shadow: none !important;
        }
        /* List group active */
        .list-group-item.active {
            background: {{ $primary_color }} !important;
            background-image: none !important;
            border-color: {{ $primary_color }} !important;
            box-shadow: none !important;
        }
        /* Dropdown active */
        .dropdown-item.active, .dropdown-item:active {
            background-color: {{ $primary_color }} !important;
            color: #fff !important;
        }

        /* ===== TEXT & BORDER ACCENTS ===== */
        .text-primary, .text-success, .dash-link.text-primary, .dash-link.text-success {
            color: {{ $primary_color }} !important;
        }
        [style*="border-color: rgb(111, 217, 67)"],
        [style*="border-color: #6fd943"],
        .border-primary, .border-success,
        .section-title, .page-header h4 {
            border-color: {{ $primary_color }} !important;
            border-left-color: {{ $primary_color }} !important;
        }
        .form-check-input:checked {
            background-color: {{ $primary_color }} !important;
            border-color: {{ $primary_color }} !important;
        }
        .page-header .breadcrumb-item.active {
            color: {{ $primary_color }} !important;
        }

        /* ===== CARDS ===== */
        .card {
            margin-bottom: 1.25rem !important;
            border-radius: 10px !important;
            transition: box-shadow 0.2s ease !important;
        }
        .card:hover {
            transform: none !important; /* no bounce */
        }
        .card-header {
            padding: 0.85rem 1.25rem !important;
        }
        .card-body {
            padding: 1.25rem !important;
        }
        .card-footer {
            padding: 0.75rem 1.25rem !important;
            background-color: transparent !important;
        }

        /* ===== TABLES ===== */
        .table th, .table td {
            padding: 0.6rem 0.85rem !important;
            font-size: 0.8125rem !important;
            vertical-align: middle !important;
        }
        .table thead th {
            font-weight: 600 !important;
            text-transform: uppercase !important;
            font-size: 0.7rem !important;
            letter-spacing: 0.5px !important;
        }

        /* ===== FORMS ===== */
        .form-control, .form-select {
            padding: 0.45rem 0.85rem !important;
            font-size: 0.8125rem !important;
            border-radius: 8px !important;
            transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba({{ implode(',', Utility::hex2rgb($primary_color)) }}, 0.12) !important;
        }

        /* ===== BADGES ===== */
        .badge {
            border-radius: 6px !important;
            font-weight: 600 !important;
            font-size: 0.7rem !important;
            letter-spacing: 0.01em !important;
            background-image: none !important;
        }

        /* ===== MODALS ===== */
        .modal-content {
            border-radius: 14px !important;
            border: none !important;
            overflow: hidden !important;
        }
        .modal-header {
            border-bottom: 1px solid rgba(0,0,0,0.06) !important;
            padding: 1rem 1.25rem !important;
        }
        .modal-footer {
            border-top: 1px solid rgba(0,0,0,0.06) !important;
            padding: 0.85rem 1.25rem !important;
        }

        /* ===== BREADCRUMBS ===== */
        .breadcrumb {
            font-size: 0.8125rem !important;
        }
        .breadcrumb-item a {
            color: #6b7280 !important;
        }
        .breadcrumb-item.active {
            color: var(--primary) !important;
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            margin-bottom: 1.25rem !important;
        }
        .page-header-title h4 {
            font-weight: 700 !important;
            font-size: 1.15rem !important;
        }
        .dash-content {
            padding: 1.25rem 1.5rem !important;
        }

        /* ================================================================
           THEME-SPECIFIC: Light vs Dark content pane
           Sidebar stays dark in both themes.
           ================================================================ */
        @if($setting['cust_darklayout'] != 'on')
        /* ---------- LIGHT THEME ---------- */
        body, body.custom-color, .dash-container, .dash-content {
            background-color: #f0f2f5 !important;
            color: #1e2229 !important;
        }
        .dash-header {
            background: #ffffff !important;
            border-bottom: 1px solid #e8ecf1 !important;
        }
        .dash-header .header-wrapper .ms-auto .dash-head-link > i.nocolor,
        .dash-header .drp-text,
        .dash-header .hide-mob {
            color: #4a5060 !important;
        }
        .card {
            background-color: #ffffff !important;
            border: 1px solid #e5e8ed !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;
            color: #1e2229 !important;
        }
        .card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.06) !important;
        }
        .card-header {
            border-bottom: 1px solid #eef0f3 !important;
            background-color: #fafbfc !important;
            color: #1e2229 !important;
        }
        .table th {
            background-color: #f7f8fa !important;
            color: #475569 !important;
            border-bottom: 2px solid #eef0f3 !important;
        }
        .table td {
            border-bottom: 1px solid #f1f4f8 !important;
            color: #333a48 !important;
        }
        .form-control, .form-select {
            background-color: #ffffff !important;
            border-color: #d4d9e1 !important;
            color: #1e2229 !important;
        }
        .form-control::placeholder {
            color: #9ca3b0 !important;
        }
        .modal-content {
            background-color: #fff !important;
            box-shadow: 0 16px 48px rgba(0,0,0,0.12) !important;
        }
        .modal-header {
            border-bottom-color: #eef0f3 !important;
        }
        .modal-footer {
            border-top-color: #eef0f3 !important;
        }
        .text-muted {
            color: #7a8291 !important;
        }
        .dash-h-dropdown, .dropdown-menu {
            background: #fff !important;
            border-color: #e5e8ed !important;
        }
        /* Light progress bar track */
        .progress {
            background-color: #e9ecf0 !important;
        }
        @else
        /* ---------- DARK THEME ---------- */
        body, body.custom-color {
            background: #0f1117 !important;
            color: #d0d4e0 !important;
        }
        .dash-container, .dash-content {
            background-color: #0f1117 !important;
        }
        .dash-header {
            background: #1a1d25 !important;
            border-bottom: 1px solid rgba(255,255,255,0.06) !important;
        }
        .dash-header .header-wrapper .ms-auto .dash-head-link > i.nocolor,
        .dash-header .drp-text,
        .dash-header .hide-mob {
            color: #9ea4b6 !important;
        }
        .dash-sidebar.light-sidebar {
            background: #13151a !important;
        }
        .card {
            background-color: #1a1d25 !important;
            border: 1px solid rgba(255,255,255,0.06) !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2) !important;
            color: #d0d4e0 !important;
        }
        .card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.3) !important;
        }
        .card-header {
            background-color: #1e2128 !important;
            border-bottom: 1px solid rgba(255,255,255,0.06) !important;
            color: #e0e3eb !important;
        }
        .table th {
            background-color: #15171e !important;
            color: #9ea4b6 !important;
            border-bottom: 2px solid rgba(255,255,255,0.06) !important;
        }
        .table td {
            border-bottom: 1px solid rgba(255,255,255,0.04) !important;
            color: #c4c9d6 !important;
        }
        .form-control, .form-select {
            background-color: #13151a !important;
            border-color: rgba(255,255,255,0.1) !important;
            color: #e0e3eb !important;
        }
        .form-control::placeholder {
            color: #5c6070 !important;
        }
        .crm-sales-card { background: transparent !important; }
        .crm-sales-card .card-header {
            background: #1a1d25 !important;
            border-top: 2px solid var(--primary) !important;
            color: #e0e3eb !important;
        }
        .sales-item {
            background: #1a1d25 !important;
            border: 1px solid rgba(255,255,255,0.06) !important;
            color: #d0d4e0 !important;
        }
        .sales-item .dashboard-link { color: #d0d4e0 !important; }
        .modal-content {
            background-color: #1a1d25 !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
            box-shadow: 0 16px 48px rgba(0,0,0,0.4) !important;
        }
        .modal-header { border-bottom-color: rgba(255,255,255,0.06) !important; }
        .modal-footer { border-top-color: rgba(255,255,255,0.06) !important; }
        .modal-header .btn-close { filter: invert(1) !important; }
        .text-muted { color: #6b7280 !important; }
        .text-dark { color: #d0d4e0 !important; }
        .dash-h-dropdown, .dropdown-menu {
            background: #1a1d25 !important;
            border-color: rgba(255,255,255,0.08) !important;
        }
        .dropdown-item { color: #c4c9d6 !important; }
        .dropdown-item:hover { background: rgba(255,255,255,0.05) !important; }
        .progress { background-color: #252830 !important; }
        @endif
    </style>


</head>



<body class="{{ $themeColor }} {{ $setting['cust_darklayout'] == 'on' ? 'dash-sidebar-dark' : 'dash-sidebar-light' }}">

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    @include('partials.admin.menu')
    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
    @include('partials.admin.header')

    <!-- Modal -->
    <div class="modal notification-modal fade" id="notification-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <h6 class="mt-2">
                        <i data-feather="monitor" class="me-2"></i>Desktop settings
                    </h6>
                    <hr />
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting1" checked />
                        <label class="form-check-label f-w-600 pl-1" for="pcsetting1">Allow desktop notification</label>
                    </div>
                    <p class="text-muted ms-5">
                        you get lettest content at a time when data will updated
                    </p>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting2" />
                        <label class="form-check-label f-w-600 pl-1" for="pcsetting2">Store Cookie</label>
                    </div>
                    <h6 class="mb-0 mt-5">
                        <i data-feather="save" class="me-2"></i>Application settings
                    </h6>
                    <hr />
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting3" />
                        <label class="form-check-label f-w-600 pl-1" for="pcsetting3">Backup Storage</label>
                    </div>
                    <p class="text-muted mb-4 ms-5">
                        Automaticaly take backup as par schedule
                    </p>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting4" />
                        <label class="form-check-label f-w-600 pl-1" for="pcsetting4">Allow guest to print
                            file</label>
                    </div>
                    <h6 class="mb-0 mt-5">
                        <i data-feather="cpu" class="me-2"></i>System settings
                    </h6>
                    <hr />
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting5" checked />
                        <label class="form-check-label f-w-600 pl-1" for="pcsetting5">View other user chat</label>
                    </div>
                    <p class="text-muted ms-5">Allow to show public user message</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger btn-sm" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-light-primary btn-sm">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="dash-container">
        <div class="dash-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <div class="page-header-title">
                                <h4 class="mb-2">@yield('page-title')</h4>
                            </div>
                            <ul class="breadcrumb">
                                @yield('breadcrumb')
                            </ul>
                        </div>
                        <div class="action-btn-col">
                            @yield('action-btn')
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="body">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="commonModalOver" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commonModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
        <div id="liveToast" class="toast text-white fade" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    @include('partials.admin.footer')
    @include('Chatify::layouts.footerLinks')

</body>

</html>
