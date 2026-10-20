<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $customer->name }} &mdash; Client Portal &amp; Project Dashboard | Animazon Tech</title>
    
    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tabler / Feather Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-body: #0b0f19;
            --bg-card: rgba(17, 24, 39, 0.85);
            --bg-card-hover: rgba(24, 33, 53, 0.95);
            --border-glass: rgba(255, 255, 255, 0.08);
            --border-glass-hover: rgba(0, 192, 249, 0.35);
            --primary-cyan: #00c0f9;
            --primary-cyan-glow: rgba(0, 192, 249, 0.25);
            --accent-green: #10b981;
            --accent-amber: #f59e0b;
            --accent-rose: #f43f5e;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-dimmed: #cbd5e1;
        }

        /* High-contrast accessible text overrides against Bootstrap 5.3 light defaults */
        .text-muted, 
        [data-bs-theme="dark"] .text-muted,
        .text-secondary,
        [data-bs-theme="dark"] .text-secondary,
        .text-body-secondary {
            color: #94a3b8 !important;
        }

        /* Essential font size and weight utility fallbacks */
        .text-xs {
            font-size: 0.78rem !important;
        }

        .text-2xs {
            font-size: 0.70rem !important;
        }

        .text-sm {
            font-size: 0.875rem !important;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .font-weight-600 {
            font-weight: 600 !important;
        }

        /* Card and Timeline Body Text Readability */
        .timeline-card p,
        .hero-banner p {
            color: #cbd5e1 !important;
            line-height: 1.6;
        }

        .badge-portal {
            background: rgba(0, 192, 249, 0.12);
            border: 1px solid rgba(0, 192, 249, 0.3);
            color: #38bdf8 !important;
            font-size: 0.75rem;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-live-since {
            background: rgba(0, 192, 249, 0.12);
            border: 1px solid rgba(0, 192, 249, 0.3);
            color: #38bdf8 !important;
            padding: 6px 14px;
            font-size: 0.82rem;
            border-radius: 20px;
        }

        body {
            background-color: var(--bg-body);
            background-image: 
                radial-gradient(at 0% 0%, rgba(0, 192, 249, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.06) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(15, 23, 42, 0.5) 0px, transparent 100%);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            padding-bottom: 60px;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }

        .glass-card {
            background: var(--bg-card);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            border-color: var(--border-glass-hover);
            box-shadow: 0 12px 35px rgba(0, 192, 249, 0.12);
        }

        .status-dot-pulse {
            width: 10px;
            height: 10px;
            background-color: var(--accent-green);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .hero-banner {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.85));
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            padding: 2.2rem;
            position: relative;
            overflow: hidden;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, var(--primary-cyan-glow) 0%, transparent 70%);
            pointer-events: none;
        }

        .stat-card {
            padding: 1.5rem;
            border-radius: 14px;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--border-glass);
        }

        .stat-value {
            font-size: 1.85rem;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .nav-pills .nav-link {
            color: var(--text-muted);
            border-radius: 10px;
            padding: 0.65rem 1.25rem;
            font-weight: 500;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .nav-pills .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-pills .nav-link.active {
            background: var(--primary-cyan);
            color: #0b0f19;
            font-weight: 700;
            box-shadow: 0 4px 15px var(--primary-cyan-glow);
        }

        /* Timeline Styling */
        .timeline-container {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-container::before {
            content: '';
            position: absolute;
            top: 10px;
            bottom: 10px;
            left: 19px;
            width: 2px;
            background: linear-gradient(180deg, var(--primary-cyan) 0%, var(--accent-green) 50%, rgba(255, 255, 255, 0.1) 100%);
        }

        .timeline-step {
            position: relative;
            margin-bottom: 2rem;
        }

        .timeline-icon-box {
            position: absolute;
            left: -2rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #0f172a;
            border: 2px solid var(--primary-cyan);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-cyan);
            font-size: 1.2rem;
            box-shadow: 0 0 12px var(--primary-cyan-glow);
            z-index: 2;
        }

        .timeline-card {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid var(--border-glass);
            border-radius: 12px;
            padding: 1.25rem;
            margin-left: 1.25rem;
            transition: transform 0.2s ease;
        }

        .timeline-card:hover {
            transform: translateX(4px);
            border-color: rgba(0, 192, 249, 0.3);
        }

        /* Table custom styling */
        .table-custom {
            color: var(--text-main);
            vertical-align: middle;
        }

        .table-custom th {
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-glass);
            background: transparent;
            padding: 1rem;
        }

        .table-custom td {
            border-bottom: 1px solid var(--border-glass);
            background: transparent;
            padding: 1rem;
            color: #e2e8f0;
        }

        .badge-due-alert {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(244, 63, 94, 0.15));
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #fbbf24;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-weight: 600;
        }

        .qr-placeholder {
            background: #fff;
            padding: 12px;
            border-radius: 12px;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>

    <!-- Top Navigation / Branding -->
    <header class="border-bottom" style="border-color: var(--border-glass) !important; background: rgba(11, 15, 25, 0.85); backdrop-filter: blur(12px);">
        <div class="container py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a href="https://animazon.in" target="_blank" class="text-decoration-none d-flex align-items-center gap-2">
                    <span style="background: linear-gradient(135deg, #00c0f9, #38bdf8); color: #0b0f19; font-weight: 800; padding: 4px 10px; border-radius: 8px; font-size: 1.1rem; letter-spacing: 0.5px;">A</span>
                    <span class="brand-font fs-5 text-white tracking-wide">ANIMAZON <span style="color: var(--primary-cyan);">TECH</span></span>
                </a>
                <span class="badge badge-portal d-none d-md-inline">
                    <i class="ti ti-shield-check me-1"></i>{{ __('Client Intelligence Portal') }}
                </span>
            </div>

            <div class="d-flex align-items-center gap-2">
                @if(!empty($projectTimeline['website_url']))
                    <a href="{{ $projectTimeline['website_url'] }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3 d-flex align-items-center gap-1">
                        <i class="ti ti-world"></i>
                        <span class="d-none d-sm-inline">{{ __('Visit Live Website') }}</span>
                    </a>
                @endif
                <a href="https://wa.me/{{ $bankDetails['whatsapp_phone'] }}?text={{ urlencode('Hi Animazon Tech, I am contacting you regarding ' . $customer->name . ' account and project.') }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3 d-flex align-items-center gap-1">
                    <i class="ti ti-brand-whatsapp fs-6"></i>
                    <span class="d-none d-sm-inline">{{ __('WhatsApp Support') }}</span>
                </a>
            </div>
        </div>
    </header>

    <main class="container mt-4">

        @if(isset($isAdminPreview) && $isAdminPreview)
            <div class="alert alert-info border-info d-flex justify-content-between align-items-center py-2 px-3 mb-4 rounded-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-eye fs-5"></i>
                    <span><strong>{{ __('Admin Preview Mode') }}:</strong> {{ __('Viewing live portal representation for') }} <strong>{{ $customer->name }}</strong>.</span>
                </div>
                <button type="button" class="btn btn-xs btn-outline-dark" onclick="navigator.clipboard.writeText('{{ $portalUrl }}'); alert('Portal URL copied to clipboard!');">
                    <i class="ti ti-copy"></i> {{ __('Copy Client Portal Link') }}
                </button>
            </div>
        @endif

        <!-- Hero Card -->
        <div class="hero-banner mb-4">
            <div class="row align-items-center position-relative" style="z-index: 1;">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="status-dot-pulse"></span>
                        <span class="text-xs text-uppercase font-weight-bold" style="color: var(--accent-green); letter-spacing: 1px;">
                            {{ $projectTimeline['status'] ?? 'Operational & Active' }}
                        </span>
                        <span class="text-muted text-xs">&bull;</span>
                        <span class="text-muted text-xs">{{ __('Server:') }} {{ $projectTimeline['server_ip'] ?? 'Cloud IP' }}</span>
                    </div>

                    <h1 class="display-6 text-white mb-2">{{ $customer->name }}</h1>
                    <p class="mb-3" style="max-width: 620px; font-size: 0.95rem; color: #cbd5e1; line-height: 1.6;">
                        {{ __('Welcome to your dedicated client portal. Review upcoming payment schedules, invoice statements, website launch timeline, and verified project milestones.') }}
                    </p>

                    <div class="d-flex flex-wrap gap-3 align-items-center text-xs" style="color: #94a3b8;">
                        <div class="d-flex align-items-center gap-1">
                            <i class="ti ti-calendar-event text-primary"></i>
                            <span>{{ __('Website Launched:') }} <strong class="text-white">{{ $projectTimeline['website_launched_date'] ?? 'Live' }}</strong></span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i class="ti ti-shield-check" style="color: var(--accent-green);"></i>
                            <span>{{ __('SSL Security:') }} <strong class="text-white">Active (Let's Encrypt)</strong></span>
                        </div>
                        @if(!empty($customer->email))
                            <div class="d-flex align-items-center gap-1">
                                <i class="ti ti-mail text-info"></i>
                                <span style="color: #cbd5e1;">{{ $customer->email }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0 text-lg-end">
                    <div class="glass-card p-3 d-inline-block text-start w-100" style="max-width: 340px;">
                        <div class="text-xs text-muted mb-1">{{ __('Payment Status') }}</div>
                        @if($totalDue > 0)
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-danger p-2"><i class="ti ti-alert-triangle fs-6"></i></span>
                                <div>
                                    <h4 class="mb-0 text-white font-weight-bold">&#8377;{{ number_format($totalDue, 2) }}</h4>
                                    <div class="text-xs text-warning">{{ __('Outstanding Amount Due') }}</div>
                                </div>
                            </div>
                            @if($nextDueInvoice)
                                <div class="badge-due-alert text-xs d-flex align-items-center justify-content-between mb-2">
                                    <span><i class="ti ti-clock me-1"></i>{{ __('Due Date:') }}</span>
                                    <strong>{{ date('d M Y', strtotime($nextDueInvoice->due_date)) }}</strong>
                                </div>
                                @if($isOverdue)
                                    <div class="text-danger text-xs font-weight-bold mb-2">
                                        <i class="ti ti-alert-circle"></i> {{ __('Overdue by') }} {{ abs($dueDaysRemaining) }} {{ __('days') }}
                                    </div>
                                @else
                                    <div class="text-warning text-xs mb-2">
                                        <i class="ti ti-hourglass-empty"></i> {{ __('Due in') }} {{ $dueDaysRemaining }} {{ __('days') }}
                                    </div>
                                @endif
                            @endif
                            <a href="#payment-section" class="btn btn-sm btn-primary w-100 rounded-pill font-weight-bold">
                                <i class="ti ti-credit-card me-1"></i>{{ __('View Payment Details') }}
                            </a>
                        @else
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-success p-2"><i class="ti ti-circle-check fs-6"></i></span>
                                <div>
                                    <h5 class="mb-0 text-white font-weight-bold">{{ __('All Paid Up!') }}</h5>
                                    <div class="text-xs text-success">{{ __('No pending dues') }}</div>
                                </div>
                            </div>
                            <p class="text-muted text-xs mb-2">{{ __('Your account is completely settled. Thank you for your continued partnership.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-pills gap-2 mb-4" id="portalTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button" role="tab">
                    <i class="ti ti-layout-grid me-1"></i>{{ __('Overview') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="timeline-tab" data-bs-toggle="pill" data-bs-target="#timeline" type="button" role="tab">
                    <i class="ti ti-history me-1"></i>{{ __('Website Launch & What\'s Done') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="invoices-tab" data-bs-toggle="pill" data-bs-target="#invoices" type="button" role="tab">
                    <i class="ti ti-receipt-2 me-1"></i>{{ __('Invoices & When to Pay') }}
                    @if($totalDue > 0)
                        <span class="badge bg-danger ms-1">{{ count($invoices->where('status', '!=', 4)) }}</span>
                    @endif
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="bank-tab" data-bs-toggle="pill" data-bs-target="#bank" type="button" role="tab">
                    <i class="ti ti-building-bank me-1"></i>{{ __('Bank & UPI Transfer') }}
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="portalTabContent">

            <!-- OVERVIEW TAB -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                <div class="row g-4 mb-4">
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card glass-card">
                            <div class="text-xs text-muted mb-1 text-uppercase tracking-wider">{{ __('Total Invoiced') }}</div>
                            <div class="stat-value text-white">&#8377;{{ number_format($totalInvoiced, 2) }}</div>
                            <div class="text-xs text-muted mt-1">{{ count($invoices) }} {{ __('invoices issued') }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card glass-card">
                            <div class="text-xs text-muted mb-1 text-uppercase tracking-wider">{{ __('Total Paid') }}</div>
                            <div class="stat-value text-success">&#8377;{{ number_format($totalPaid, 2) }}</div>
                            <div class="text-xs text-muted mt-1">{{ __('Verified settled payments') }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card glass-card">
                            <div class="text-xs text-muted mb-1 text-uppercase tracking-wider">{{ __('Current Due') }}</div>
                            <div class="stat-value {{ $totalDue > 0 ? 'text-warning' : 'text-white' }}">&#8377;{{ number_format($totalDue, 2) }}</div>
                            <div class="text-xs text-muted mt-1">
                                @if($totalDue > 0)
                                    <span class="text-warning font-weight-bold">{{ __('Payment required') }}</span>
                                @else
                                    <span class="text-success">{{ __('Clear balance') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card glass-card">
                            <div class="text-xs text-muted mb-1 text-uppercase tracking-wider">{{ __('Next Due Date') }}</div>
                            <div class="stat-value text-white" style="font-size: 1.4rem; padding-top: 6px;">
                                @if($nextDueInvoice)
                                    {{ date('d M Y', strtotime($nextDueInvoice->due_date)) }}
                                @else
                                    {{ __('None') }}
                                @endif
                            </div>
                            <div class="text-xs text-muted mt-1">
                                @if($nextDueInvoice)
                                    <span class="{{ $isOverdue ? 'text-danger' : 'text-info' }}">
                                        {{ $isOverdue ? __('Overdue') : __('Upcoming payment') }}
                                    </span>
                                @else
                                    <span class="text-success">{{ __('All cleared') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Launch & Quick Highlights -->
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="glass-card p-4 h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 text-white"><i class="ti ti-rocket text-primary me-2"></i>{{ __('Website Launch & Operations Summary') }}</h5>
                                <span class="badge bg-light-primary text-primary px-3 py-1 rounded-pill">{{ __('Verified Timeline') }}</span>
                            </div>

                            <p class="text-muted text-sm mb-4">
                                {{ __('Summary of live deployment, optical simulation infrastructure, commercial ERP sales records, and cloud host performance.') }}
                            </p>

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-glass);">
                                        <div class="text-xs text-muted">{{ __('Official Storefront Launch') }}</div>
                                        <div class="font-weight-bold text-white fs-6 mt-1">{{ $projectTimeline['website_launched_date'] ?? 'February 28, 2026' }}</div>
                                        <div class="text-2xs text-success mt-1"><i class="ti ti-check"></i> {{ __('Let\'s Encrypt SSL Live') }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-glass);">
                                        <div class="text-xs text-muted">{{ __('ERP & Commercial Sales Live') }}</div>
                                        <div class="font-weight-bold text-white fs-6 mt-1">{{ $projectTimeline['erp_live_date'] ?? 'April 1, 2025' }}</div>
                                        <div class="text-2xs text-info mt-1"><i class="ti ti-building-store"></i> {{ __('69,560+ SKUs & 38,700+ Orders') }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-glass);">
                                        <div class="text-xs text-muted">{{ __('First Web Presence & Domain') }}</div>
                                        <div class="font-weight-bold text-white fs-6 mt-1">{{ $projectTimeline['domain_registered_date'] ?? 'October 11, 2023' }}</div>
                                        <div class="text-2xs text-muted mt-1"><i class="ti ti-archive"></i> {{ __('Web Archive & DNS Verified') }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-glass);">
                                        <div class="text-xs text-muted">{{ __('Cloud Server Infrastructure') }}</div>
                                        <div class="font-weight-bold text-white fs-6 mt-1">{{ $projectTimeline['server_ip'] ?? '45.199.139.25' }}</div>
                                        <div class="text-2xs text-success mt-1"><i class="ti ti-activity"></i> {{ __('LiteSpeed Web Server (HTTP/3)') }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top" style="border-color: var(--border-glass) !important;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-xs text-muted">{{ __('Need the detailed milestone breakdown?') }}</span>
                                    <button class="btn btn-sm btn-outline-info rounded-pill" onclick="document.getElementById('timeline-tab').click();">
                                        {{ __('View Full Timeline & Milestones') }} &rarr;
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="glass-card p-4 h-100" id="payment-section">
                            <h5 class="mb-3 text-white"><i class="ti ti-credit-card text-warning me-2"></i>{{ __('When You Need To Pay') }}</h5>

                            @if($totalDue > 0)
                                <div class="p-3 rounded-3 mb-3" style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.25);">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-xs text-warning text-uppercase font-weight-bold">{{ __('Upcoming Payment Due') }}</span>
                                        @if($isOverdue)
                                            <span class="badge bg-danger">{{ __('Overdue') }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{ __('Pending') }}</span>
                                        @endif
                                    </div>
                                    <div class="fs-4 font-weight-bold text-white mb-1">&#8377;{{ number_format($totalDue, 2) }}</div>
                                    <div class="text-xs text-muted">
                                        @if($nextDueInvoice)
                                            {{ __('Due on:') }} <strong class="text-white">{{ date('d F, Y', strtotime($nextDueInvoice->due_date)) }}</strong>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="p-3 rounded-3 mb-3 text-center" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25);">
                                    <i class="ti ti-circle-check fs-1 text-success mb-2"></i>
                                    <h6 class="text-white mb-1">{{ __('No Outstanding Payments') }}</h6>
                                    <p class="text-muted text-xs mb-0">{{ __('All current invoices have been settled in full.') }}</p>
                                </div>
                            @endif

                            <h6 class="text-white text-xs text-uppercase tracking-wider mb-2 mt-3">{{ __('Quick Bank Transfer Details') }}</h6>
                            <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-glass); font-size: 0.85rem;">
                                <div class="d-flex justify-content-between py-1 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                                    <span class="text-muted">{{ __('Bank:') }}</span>
                                    <strong class="text-white">{{ $bankDetails['bank_name'] }}</strong>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                                    <span class="text-muted">{{ __('Account Holder:') }}</span>
                                    <strong class="text-white">{{ $bankDetails['account_holder'] }}</strong>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                                    <span class="text-muted">{{ __('Account Number:') }}</span>
                                    <span class="font-monospace text-primary font-weight-bold">{{ $bankDetails['account_number'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span class="text-muted">{{ __('IFSC Code:') }}</span>
                                    <span class="font-monospace text-warning font-weight-bold">{{ $bankDetails['ifsc_code'] }}</span>
                                </div>
                            </div>

                            <div class="mt-3 text-center">
                                <button class="btn btn-sm btn-outline-primary rounded-pill w-100" onclick="document.getElementById('bank-tab').click();">
                                    <i class="ti ti-qrcode me-1"></i>{{ __('Open UPI QR Code & Full Bank Details') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TIMELINE & WHAT IS DONE TAB -->
            <div class="tab-pane fade" id="timeline" role="tabpanel">
                <div class="glass-card p-4 mb-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: var(--border-glass) !important;">
                        <div>
                            <h4 class="text-white mb-1"><i class="ti ti-timeline text-primary me-2"></i>{{ __('Project Timeline & What\'s Done') }}</h4>
                            <p class="text-sm mb-0" style="color: #cbd5e1;">
                                {{ __('Complete history of engineering, deployments, operational milestones, and infrastructure delivery for') }} <strong class="text-white">{{ $customer->name }}</strong>.
                            </p>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <span class="badge badge-live-since">
                                <i class="ti ti-calendar me-1"></i>{{ __('Live Since:') }} {{ $projectTimeline['website_launched_date'] ?? 'February 28, 2026' }}
                            </span>
                        </div>
                    </div>

                    <div class="timeline-container mt-4">
                        @foreach($projectTimeline['milestones'] as $milestone)
                            <div class="timeline-step">
                                <div class="timeline-icon-box">
                                    <i class="ti {{ $milestone['icon'] ?? 'ti-check' }}"></i>
                                </div>
                                <div class="timeline-card">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                                        <h6 class="text-white mb-0 font-weight-bold">{{ $milestone['title'] }}</h6>
                                        <div class="d-flex align-items-center gap-2 mt-1 mt-sm-0">
                                            <span class="badge {{ $milestone['badge_class'] ?? 'bg-success' }} px-2 py-1 text-2xs">{{ $milestone['status'] }}</span>
                                            <span class="text-xs" style="color: #94a3b8;"><i class="ti ti-calendar me-1"></i>{{ $milestone['date'] }}</span>
                                        </div>
                                    </div>
                                    <p class="text-sm mb-0" style="color: #cbd5e1; line-height: 1.6;">
                                        {{ $milestone['description'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- INVOICES & PAYMENTS TAB -->
            <div class="tab-pane fade" id="invoices" role="tabpanel">
                <div class="glass-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: var(--border-glass) !important;">
                        <div>
                            <h4 class="text-white mb-1"><i class="ti ti-file-invoice text-primary me-2"></i>{{ __('Invoices & Payment Schedule') }}</h4>
                            <p class="text-muted text-sm mb-0">{{ __('Detailed record of invoices, due dates, payments received, and balance schedules.') }}</p>
                        </div>
                    </div>

                    @if(count($invoices) > 0)
                        <div class="table-responsive">
                            <table class="table table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('Invoice #') }}</th>
                                        <th>{{ __('Issue Date') }}</th>
                                        <th>{{ __('Due Date') }}</th>
                                        <th>{{ __('Total Amount') }}</th>
                                        <th>{{ __('Due Amount') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th class="text-end">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoices as $inv)
                                        @php
                                            $isInvOverdue = ($inv->due_date && $inv->due_date < date('Y-m-d') && $inv->getDue() > 0);
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong class="text-white">#INVO{{ sprintf('%05d', $inv->invoice_id) }}</strong>
                                                @if(!empty($inv->ref_number))
                                                    <div class="text-2xs text-muted">{{ __('Ref:') }} {{ $inv->ref_number }}</div>
                                                @endif
                                            </td>
                                            <td>{{ date('d M Y', strtotime($inv->issue_date)) }}</td>
                                            <td>
                                                <span class="{{ $isInvOverdue ? 'text-danger font-weight-bold' : '' }}">
                                                    {{ date('d M Y', strtotime($inv->due_date)) }}
                                                </span>
                                                @if($isInvOverdue)
                                                    <div class="text-2xs text-danger">{{ __('Overdue') }}</div>
                                                @endif
                                            </td>
                                            <td class="font-weight-bold text-white">&#8377;{{ number_format($inv->getTotal(), 2) }}</td>
                                            <td>
                                                @if($inv->getDue() > 0)
                                                    <span class="text-warning font-weight-bold">&#8377;{{ number_format($inv->getDue(), 2) }}</span>
                                                @else
                                                    <span class="text-success">&#8377;0.00</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($inv->status == 4)
                                                    <span class="badge bg-success px-2 py-1 text-2xs">{{ __('Paid') }}</span>
                                                @elseif($inv->status == 3)
                                                    <span class="badge bg-info px-2 py-1 text-2xs">{{ __('Partially Paid') }}</span>
                                                @elseif($isInvOverdue)
                                                    <span class="badge bg-danger px-2 py-1 text-2xs">{{ __('Overdue') }}</span>
                                                @elseif($inv->status == 1 || $inv->status == 2)
                                                    <span class="badge bg-warning text-dark px-2 py-1 text-2xs">{{ __('Unpaid') }}</span>
                                                @else
                                                    <span class="badge bg-secondary px-2 py-1 text-2xs">{{ __('Draft') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-end gap-2">
                                                    @if(method_exists($inv, 'publicUrl'))
                                                        <a href="{{ $inv->publicUrl() }}" target="_blank" class="btn btn-xs btn-outline-info" title="{{ __('View Online Invoice') }}">
                                                            <i class="ti ti-eye"></i> {{ __('View') }}
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('invoice.pdf', Crypt::encrypt($inv->id)) }}" class="btn btn-xs btn-outline-light" title="{{ __('Download PDF Invoice') }}">
                                                        <i class="ti ti-download"></i> {{ __('PDF') }}
                                                    </a>
                                                    @if($inv->getDue() > 0)
                                                        <button type="button" class="btn btn-xs btn-primary" onclick="document.getElementById('bank-tab').click();">
                                                            <i class="ti ti-credit-card"></i> {{ __('Pay Now') }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ti ti-receipt-off fs-1 text-muted mb-3 d-block"></i>
                            <h6 class="text-white">{{ __('No Invoices Recorded Yet') }}</h6>
                            <p class="text-muted text-sm">{{ __('Invoices generated for your account will appear here with full statements and due dates.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- BANK & UPI TRANSFER TAB -->
            <div class="tab-pane fade" id="bank" role="tabpanel">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="glass-card p-4 h-100">
                            <h4 class="text-white mb-3"><i class="ti ti-building-bank text-primary me-2"></i>{{ __('Direct Bank Transfer (NEFT / RTGS / IMPS)') }}</h4>
                            <p class="text-muted text-sm mb-4">
                                {{ __('Please use the verified official company bank account details below to remit invoice payments.') }}
                            </p>

                            <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-glass);">
                                <div class="mb-3 pb-2 border-bottom" style="border-color: rgba(255,255,255,0.06) !important;">
                                    <div class="text-xs text-muted">{{ __('Bank Name') }}</div>
                                    <div class="fs-5 text-white font-weight-bold">{{ $bankDetails['bank_name'] }}</div>
                                </div>
                                <div class="mb-3 pb-2 border-bottom" style="border-color: rgba(255,255,255,0.06) !important;">
                                    <div class="text-xs text-muted">{{ __('Account Holder Name') }}</div>
                                    <div class="fs-5 text-white font-weight-bold">{{ $bankDetails['account_holder'] }}</div>
                                </div>
                                <div class="mb-3 pb-2 border-bottom" style="border-color: rgba(255,255,255,0.06) !important;">
                                    <div class="text-xs text-muted">{{ __('Account Number') }}</div>
                                    <div class="fs-4 text-primary font-monospace font-weight-bold d-flex align-items-center justify-content-between">
                                        <span>{{ $bankDetails['account_number'] }}</span>
                                        <button class="btn btn-xs btn-outline-secondary" onclick="navigator.clipboard.writeText('{{ $bankDetails['account_number'] }}'); alert('Account Number Copied!');">
                                            <i class="ti ti-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3 pb-2 border-bottom" style="border-color: rgba(255,255,255,0.06) !important;">
                                    <div class="text-xs text-muted">{{ __('IFSC Code') }}</div>
                                    <div class="fs-5 text-warning font-monospace font-weight-bold d-flex align-items-center justify-content-between">
                                        <span>{{ $bankDetails['ifsc_code'] }}</span>
                                        <button class="btn btn-xs btn-outline-secondary" onclick="navigator.clipboard.writeText('{{ $bankDetails['ifsc_code'] }}'); alert('IFSC Code Copied!');">
                                            <i class="ti ti-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-muted">{{ __('Branch Location') }}</div>
                                    <div class="text-white">{{ $bankDetails['branch'] }}</div>
                                </div>
                            </div>

                            <div class="alert alert-dark border-secondary mt-4 text-xs text-muted mb-0">
                                <i class="ti ti-info-circle text-info me-1"></i>
                                {{ __('Please add your Invoice Number (e.g. INVO00149) in the transaction narration for automated reconciliation.') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="glass-card p-4 h-100 text-center">
                            <h4 class="text-white mb-2"><i class="ti ti-qrcode text-info me-2"></i>{{ __('Scan & Pay via UPI') }}</h4>
                            <p class="text-muted text-sm mb-4">
                                {{ __('Supported apps: Google Pay, PhonePe, Paytm, BHIM, Cred, and Any Banking UPI App.') }}
                            </p>

                            <div class="qr-placeholder mb-3">
                                <!-- Dynamic QR code for the UPI payment -->
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($upiUrl) }}" alt="Scan UPI QR Code" width="180" height="180" class="img-fluid">
                            </div>

                            <div class="mb-3">
                                <div class="text-xs text-muted mb-1">{{ __('UPI ID / VPA') }}</div>
                                <span class="badge bg-dark border border-secondary text-primary font-monospace px-3 py-2 fs-6">
                                    {{ $bankDetails['upi_id'] }}
                                </span>
                            </div>

                            @if($totalDue > 0)
                                <div class="text-xs text-muted mb-4">
                                    {{ __('Pre-filled Amount:') }} <strong class="text-white">&#8377;{{ number_format($totalDue, 2) }}</strong>
                                </div>
                            @endif

                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ $upiUrl }}" class="btn btn-sm btn-primary rounded-pill px-4">
                                    <i class="ti ti-external-link me-1"></i>{{ __('Open in UPI App') }}
                                </a>
                                <a href="https://wa.me/{{ $bankDetails['whatsapp_phone'] }}?text={{ urlencode('Payment Confirmation for ' . $customer->name . ': Transferred Rs. ' . number_format($totalDue, 2)) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-4">
                                    <i class="ti ti-brand-whatsapp me-1"></i>{{ __('Notify Payment via WhatsApp') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="mt-5 pt-4 border-top text-center text-muted text-xs" style="border-color: var(--border-glass) !important;">
        <div class="container">
            <p class="mb-1">&copy; {{ date('Y') }} <strong>Animazon Tech</strong> &bull; All Rights Reserved.</p>
            <p class="mb-0 text-muted">
                {{ __('For priority support or project consultations:') }} <a href="mailto:{{ $bankDetails['support_email'] }}" class="text-info text-decoration-none">{{ $bankDetails['support_email'] }}</a> &bull; {{ $bankDetails['contact_phone'] }}
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
