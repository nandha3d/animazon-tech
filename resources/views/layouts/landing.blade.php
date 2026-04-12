@php
    use App\Models\Utility;

    $settings = Utility::settings();
    $logo = asset('storage/uploads/logo');

    $company_logo = $settings['company_logo_dark'] ?? 'logo-dark.png';
    $company_logos = $settings['company_logo_light'] ?? 'logo-light.png';

    $color = (!empty($settings['color'])) ? $settings['color'] : 'theme-3';
    $SITE_RTL = $settings['SITE_RTL'] ?? 'off';

    $getseo = App\Models\Utility::getSeoSetting();
    $metatitle = isset($getseo['meta_title']) ? $getseo['meta_title'] : '';
    $metsdesc = isset($getseo['meta_desc']) ? $getseo['meta_desc'] : '';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($getseo['meta_image']) ? $getseo['meta_image'] : '';
    $get_cookie = Utility::getCookieSetting();

    $primary_color = !empty($settings['primary_color']) ? $settings['primary_color'] : '#00c1de';
    $secondary_color = !empty($settings['secondary_color']) ? $settings['secondary_color'] : '#ff6122';
    $is_dark = (isset($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on');
    $landing_settings = \Modules\LandingPage\Entities\LandingPageSetting::landingPageSetting();
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{$settings['SITE_RTL'] == 'on'?'rtl':''}}" class="{{ $is_dark ? 'dark' : '' }}">
<head>

    <title>{{__('ANIMAZON')}}</title>
    <meta name="title" content="{{$metatitle}}">
    <meta name="description" content="{{$metsdesc}}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{$metatitle}}">
    <meta property="og:description" content="{{$metsdesc}}">
    <meta property="og:image" content="{{$meta_image.$meta_logo}}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{$metatitle}}">
    <meta property="twitter:description" content="{{$metsdesc}}">
    <meta property="twitter:image" content="{{$meta_image.$meta_logo}}">


    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"
    />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="WorkDo" />

    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon" />

    <!-- Google Fonts (display=swap for non-blocking) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Defer non-critical CSS: animate.min.css -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/animate.min.css')}}" media="print" onload="this.media='all'" />
    <noscript><link rel="stylesheet" href="{{asset('assets/css/plugins/animate.min.css')}}" /></noscript>
    <!-- font css -->
    <link rel="stylesheet" href="{{asset('assets/fonts/tabler-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/feather.css')}}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome.css')}}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{asset('assets/fonts/material.css')}}" media="print" onload="this.media='all'">

    <!-- vendor css -->
    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    
    <!-- Vite App -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{asset('assets/css/customizer.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('assets/css/landing.css')}}" /> -->

    <style>
        :root {
            --primary-color: {{ $primary_color }};
            --secondary-color: {{ $secondary_color }};
            --animazon-black: #FFFFFF;
            --animazon-navy: #F8F9FA;
            --animazon-white: #0A0A0B;
            --animazon-gray: #6C757D;
            --animazon-muted: #6C757D;
            --animazon-border: rgba(0,0,0,0.1);
        }

        .dark {
            --animazon-black: #0A0A0B;
            --animazon-navy: #111114;
            --animazon-white: #FFFFFF;
            --animazon-gray: #8E8E93;
            --animazon-muted: #A1A1AA;
            --animazon-border: rgba(255,255,255,0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }
    </style>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    

    
    <style>
        .swiper {
            width: 100%;
            height: 100vh;
        }
        .swiper-slide {
            position: relative;
            overflow: hidden;
        }
        .swiper-pagination-bullet {
            background: #FFFFFF !important;
            opacity: 0.5;
        }
        .swiper-pagination-bullet-active {
            background: {{ $primary_color }} !important;
            opacity: 1;
        }
        .swiper-button-next, .swiper-button-prev {
            color: {{ $primary_color }} !important;
        }
        @media (max-width: 768px) {
            .swiper-button-next, .swiper-button-prev {
                display: none;
            }
        }

        /* === Stacked Card Deck (nth-last-child fan) === */
        .ws-carousel {
            position: relative;
            width: 560px;
            height: 440px;
        }
        .ws-card {
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            width: 480px;
            height: 380px;
            border-radius: 20px;
            overflow: hidden;
            background: #1a1a1f;
            box-shadow: 0 5px 10px 0 rgba(0,0,0,.25),
                        0 15px 20px 0 rgba(0,0,0,.125);
            transition: transform 0.6s;
            display: flex;
            flex-direction: column;
            user-select: none;
        }
        /* Stack positions — fan out to the right, front is largest */
        .ws-card:nth-last-child(n + 4) {
            --x: calc(-50% + 70px);
            transform: translate(var(--x), -50%) scale(0.85);
            box-shadow: 0 0 1px 1px rgba(0,0,0,.01);
        }
        .ws-card:nth-last-child(3) {
            --x: calc(-50% + 50px);
            transform: translate(var(--x), -50%) scale(0.9);
            opacity: .55;
        }
        .ws-card:nth-last-child(2) {
            --x: calc(-50% + 25px);
            transform: translate(var(--x), -50%) scale(0.95);
            opacity: .8;
        }
        .ws-card:nth-last-child(1) {
            --x: calc(-50%);
            transform: translate(var(--x), -50%) scale(1);
            opacity: 1;
        }
        /* Glow on front card */
        .ws-card:nth-last-child(1)::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 21px;
            background: linear-gradient(135deg, rgba(0,193,222,.35), transparent 40%, transparent 60%, rgba(0,193,222,.18));
            z-index: -1;
            pointer-events: none;
            box-shadow: 0 0 20px 2px rgba(0,193,222,.15);
        }
        /* Shine overlay */
        .ws-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(255,255,255,.06), transparent 50%);
            pointer-events: none;
            z-index: 5;
        }
        /* Swap animation — swing left, rotate, shrink behind */
        .ws-swap {
            animation: wsSwap 0.8s ease-out forwards;
        }
        @keyframes wsSwap {
            30% {
                transform: translate(calc(var(--x) - 220px), -50%) scale(0.85) rotate(-5deg) rotateY(65deg);
            }
            100% {
                transform: translate(calc(var(--x) - 30px), -50%) scale(0.5);
                z-index: -1;
            }
        }
        /* Browser chrome bar */
        .ws-browser-bar {
            background: #1e1e24;
            height: 32px;
            display: flex;
            align-items: center;
            padding: 0 12px;
            gap: 8px;
            flex-shrink: 0;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .ws-dots { display: flex; gap: 5px; }
        .ws-dots span { width: 8px; height: 8px; border-radius: 50%; }
        .ws-url {
            flex: 1;
            background: rgba(255,255,255,.06);
            border-radius: 8px;
            height: 20px;
            padding: 0 10px;
            font-size: 9px;
            color: rgba(255,255,255,.45);
            display: flex;
            align-items: center;
            gap: 4px;
            font-family: 'Inter', monospace;
        }
        .ws-url-lock { color: #28c840; font-size: 9px; }
        /* Category label */
        .ws-label {
            position: absolute;
            top: 44px; right: 12px;
            background: rgba(0,0,0,.65);
            backdrop-filter: blur(12px);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            color: #00c1de;
            letter-spacing: .4px;
            z-index: 6;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .ws-label-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #00c1de;
            animation: wsDotPulse 2s ease infinite;
        }
        @keyframes wsDotPulse {
            0%,100% { opacity: 1; }
            50% { opacity: .4; }
        }
        /* Carousel indicator dots */
        .ws-nav {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 28px;
        }
        .ws-nav-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,.2);
            border: none;
            cursor: pointer;
            transition: all .3s ease;
            padding: 0;
        }
        .ws-nav-dot.active {
            background: #00c1de;
            box-shadow: 0 0 8px rgba(0,193,222,.4);
            width: 24px;
            border-radius: 4px;
        }
    </style>
</head>

<body class="{{$color}} bg-animazon-black text-animazon-white selection:bg-primary/30">
<!-- [ Nav ] start -->
<!-- [ Nav ] start -->
<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-animazon-black backdrop-blur-md border-b border-animazon-border/50">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a class="flex items-center" href="{{ url('/') }}">
                @if ($is_dark)
                    <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-light.png') . '?' . time() }}" alt="ANIMAZON" class="h-10 w-auto"/>
                @else
                    <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') . '?' . time() }}" alt="ANIMAZON" class="h-10 w-auto"/>
                @endif
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="{{ url('/') }}" class="text-animazon-white hover:text-primary font-medium transition-colors">Home</a>
                <a href="{{ url('/') }}#services" class="text-animazon-white hover:text-primary font-medium transition-colors">Services</a>
                <a href="{{ route('portfolio.public') }}" class="text-animazon-white hover:text-primary font-medium transition-colors">Portfolio</a>
                <a href="{{ route('blog.index') }}" class="text-animazon-white hover:text-primary font-medium transition-colors">Blog</a>
                <a href="{{ route('cost-calculator.public') }}" class="text-animazon-white hover:text-primary font-medium transition-colors">Pricing</a>
                <a href="{{ url('/') }}#contact" class="text-animazon-white hover:text-primary font-medium transition-colors">Contact</a>
            </div>

            <!-- CTA & Mobile Toggle -->
            <div class="flex items-center space-x-4">
                <a href="{{ url('/') }}#contact" class="hidden sm:inline-flex btn-primary-custom !py-2 !px-5 text-sm">
                    Start Your Project
                </a>
                <a href="{{ route('login') }}" class="text-animazon-muted hover:text-animazon-white font-medium text-sm transition-colors hidden lg:block">Login</a>
                
                <button id="mobile-menu-toggle" class="lg:hidden text-animazon-white p-2">
                    <i class="ti ti-menu-2 text-2xl"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay" class="fixed inset-0 bg-animazon-black/90 backdrop-blur-xl z-[60] flex-col items-center justify-center space-y-8 transition-all duration-300 opacity-0 invisible flex">
    <button id="mobile-menu-close" class="absolute top-6 right-6 text-animazon-white p-2">
        <i class="ti ti-x text-3xl"></i>
    </button>
    
    <a href="{{ url('/') }}" class="mobile-link text-2xl text-animazon-white hover:text-primary font-bold transition-colors">Home</a>
    <a href="{{ url('/') }}#services" class="mobile-link text-2xl text-animazon-white hover:text-primary font-bold transition-colors">Services</a>
    <a href="{{ route('portfolio.public') }}" class="mobile-link text-2xl text-animazon-white hover:text-primary font-bold transition-colors">Portfolio</a>
    <a href="{{ route('blog.index') }}" class="mobile-link text-2xl text-animazon-white hover:text-primary font-bold transition-colors">Blog</a>
    <a href="{{ route('cost-calculator.public') }}" class="mobile-link text-2xl text-animazon-white hover:text-primary font-bold transition-colors">Pricing</a>
    <a href="{{ url('/') }}#contact" class="mobile-link text-2xl text-animazon-white hover:text-primary font-bold transition-colors">Contact</a>
    <a href="{{ route('login') }}" class="mobile-link text-xl text-primary font-bold transition-colors mt-8">Login</a>
</div>
<!-- [ Nav ] end -->
@if(View::hasSection('page_content'))
    <!-- Child page content -->
    <main class="pt-20">
        @yield('page_content')
    </main>
@else
<!-- [ Header ] start -->
<header id="home" class="relative min-h-screen overflow-hidden text-animazon-white">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            <!-- Slide 0: Space Shooter Game -->
            <div class="swiper-slide">
                <div class="absolute inset-0 z-0 bg-[#0a0a12]">
                    <canvas id="heroGameCanvas" style="width:100%;height:100%;display:block;"></canvas>
                </div>
                <div id="gameSlideOverlay" class="container mx-auto px-4 lg:px-8 relative z-10 h-full flex items-center transition-opacity duration-500">
                    <div class="max-w-3xl">
                        <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-6 animate__animated animate__fadeInDown">WE BUILD GAMES TOO</span>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6 animate__animated animate__fadeInUp">
                            3D & 2D <span class="text-primary italic">Games</span> for Every Platform
                        </h1>
                        <p class="text-xl text-white/80 mb-8 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                            From arcade & simulation games to full-scale Android, iOS, and browser experiences — try what we build, right here.
                        </p>
                        <div class="flex flex-wrap gap-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
                            <button onclick="launchSpaceShooter()" class="btn-primary group">
                                <i class="ti ti-rocket mr-2 group-hover:animate-bounce"></i> Play Now
                            </button>
                            <a href="#problems" class="btn-ghost !text-white hover:!bg-primary">Explore Services</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 1: 3D Animation -->
            <div class="swiper-slide">
                <div class="absolute inset-0 z-0">
                    <picture>
                        <source srcset="{{ asset('assets/images/landing/hero/hero-3d.avif') }}" type="image/avif">
                        <img src="{{ asset('assets/images/landing/hero/hero-3d.jpg') }}" class="w-full h-full object-cover" alt="3D Animation" width="1920" height="1080" fetchpriority="high">
                    </picture>
                </div>
                <div class="container mx-auto px-4 lg:px-8 relative z-10 h-full flex items-center">
                    <div class="max-w-3xl">
                        <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-6 animate__animated animate__fadeInDown">CINEMATIC 3D PRODUCTION</span>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6 animate__animated animate__fadeInUp">
                            Turn Complex Ideas into <span class="text-primary italic">Stunning 3D</span> Visuals
                        </h1>
                        <p class="text-xl text-white/80 mb-8 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                            Photorealistic 3D product animations and technical visualizations that explain your value in seconds.
                        </p>
                        <div class="flex flex-wrap gap-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
                            <a href="#portfolio" class="btn-primary">View 3D Showreel</a>
                            <a href="#contact" class="btn-ghost !text-white hover:!bg-primary">Get a Quote</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Web App Development — Split Layout with 3D Browser Card -->
            <div class="swiper-slide">
                <div class="absolute inset-0 z-0 bg-[#020b14]">
                    <!-- Ambient glow effects -->
                    <div class="absolute w-[700px] h-[700px] rounded-full top-[-150px] right-[-150px] pointer-events-none" style="background:radial-gradient(circle,rgba(0,193,222,0.12) 0%,transparent 70%);"></div>
                    <div class="absolute w-[500px] h-[500px] rounded-full bottom-[-100px] left-[-100px] pointer-events-none" style="background:radial-gradient(circle,rgba(0,193,222,0.06) 0%,transparent 70%);"></div>
                    <!-- Noise texture -->
                    <div class="absolute inset-0 pointer-events-none opacity-[0.035]" style="background-image:url(&quot;data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E&quot;);"></div>
                </div>
                <div class="container mx-auto px-4 lg:px-8 relative z-10 h-full flex items-center">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center w-full">
                        <!-- Left: Copy -->
                        <div class="max-w-xl">
                            <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-6 animate__animated animate__fadeInDown">CUSTOM WEB SOLUTIONS</span>
                            <h1 class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-[1.08] mb-6 animate__animated animate__fadeInUp">
                                Build <span class="text-primary italic">Websites</span> That Convert, Not Just Exist
                            </h1>
                            <p class="text-lg md:text-xl text-white/70 mb-8 leading-relaxed animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                                Crafting high-performance web experiences that drive growth, engagement, and real results.
                            </p>
                            <div class="flex flex-wrap gap-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
                                <a href="#services" class="btn-primary">Our Capabilities</a>
                                <a href="#contact" class="btn-ghost !text-white hover:!bg-primary">Start Building</a>
                            </div>
                            <!-- Trust bar -->
                            <div class="flex flex-wrap items-center gap-5 mt-10 text-white/40 text-xs uppercase tracking-widest font-medium animate__animated animate__fadeIn" style="animation-delay:0.8s">
                                <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-green-400 inline-block"></span> Laravel</span>
                                <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 inline-block"></span> React</span>
                                <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-cyan-400 inline-block"></span> Next.js</span>
                                <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-yellow-400 inline-block"></span> Vue</span>
                                <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-purple-400 inline-block"></span> Node</span>
                            </div>
                        </div>
                        <!-- Right: Auto-Rotating Website Showcase -->
                        <div class="hidden lg:flex flex-col items-center justify-center">
                            <div class="ws-carousel" id="wsCarousel">

                                <!-- Card 1 — E-Commerce Store -->
                                <div class="ws-card" data-ws="0">
                                    <div class="ws-browser-bar">
                                        <div class="ws-dots"><span style="background:#ff5f57"></span><span style="background:#ffbd2e"></span><span style="background:#28c840"></span></div>
                                        <div class="ws-url"><span class="ws-url-lock">🔒</span> shopwave.io/store</div>
                                    </div>
                                    <div style="flex:1;background:#f8f7f4;display:flex;flex-direction:column;overflow:hidden;">
                                        <!-- Store nav -->
                                        <div style="background:#0a0a0f;padding:8px 16px;display:flex;align-items:center;justify-content:space-between;">
                                            <span style="font-weight:800;font-size:12px;color:#00c1de;font-family:'Montserrat',sans-serif;">ShopWave</span>
                                            <div style="display:flex;gap:14px;"><span style="color:rgba(255,255,255,.5);font-size:9px;font-weight:500;">New</span><span style="color:rgba(255,255,255,.5);font-size:9px;font-weight:500;">Sale</span><span style="color:rgba(255,255,255,.5);font-size:9px;font-weight:500;">Brands</span></div>
                                            <div style="display:flex;align-items:center;gap:6px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.5)" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg><div style="background:#00c1de;color:#020b14;width:16px;height:16px;border-radius:50%;display:grid;place-content:center;font-size:8px;font-weight:700;">3</div></div>
                                        </div>
                                        <!-- Products grid -->
                                        <div style="padding:14px;display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;flex:1;">
                                            <div style="background:white;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.06);">
                                                <div style="height:80px;background:linear-gradient(135deg,#e0f7fa,#b2ebf2);display:flex;align-items:center;justify-content:center;font-size:28px;">👟</div>
                                                <div style="padding:8px;"><div style="font-size:9px;font-weight:600;color:#222;">Air Max Pro</div><div style="font-size:8px;color:#00c1de;font-weight:700;margin-top:3px;">$189.00</div><div style="margin-top:5px;background:#111;color:white;text-align:center;padding:4px;border-radius:6px;font-size:7px;font-weight:600;">Add to Cart</div></div>
                                            </div>
                                            <div style="background:white;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.06);">
                                                <div style="height:80px;background:linear-gradient(135deg,#fff3e0,#ffe0b2);display:flex;align-items:center;justify-content:center;font-size:28px;">⌨️</div>
                                                <div style="padding:8px;"><div style="font-size:9px;font-weight:600;color:#222;">Mech KB</div><div style="font-size:8px;color:#00c1de;font-weight:700;margin-top:3px;">$129.00</div><div style="margin-top:5px;background:#111;color:white;text-align:center;padding:4px;border-radius:6px;font-size:7px;font-weight:600;">Add to Cart</div></div>
                                            </div>
                                            <div style="background:white;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.06);">
                                                <div style="height:80px;background:linear-gradient(135deg,#f3e5f5,#e1bee7);display:flex;align-items:center;justify-content:center;font-size:28px;">🎧</div>
                                                <div style="padding:8px;"><div style="font-size:9px;font-weight:600;color:#222;">Studio Pod</div><div style="font-size:8px;color:#00c1de;font-weight:700;margin-top:3px;">$249.00</div><div style="margin-top:5px;background:#111;color:white;text-align:center;padding:4px;border-radius:6px;font-size:7px;font-weight:600;">Add to Cart</div></div>
                                            </div>
                                        </div>
                                        <!-- Store footer -->
                                        <div style="background:#0a0a0f;padding:6px 16px;display:flex;justify-content:space-between;align-items:center;">
                                            <span style="color:rgba(255,255,255,.35);font-size:8px;">© ShopWave 2025</span>
                                            <div style="display:flex;align-items:center;gap:4px;"><div style="width:5px;height:5px;border-radius:50%;background:#28c840;"></div><span style="color:rgba(255,255,255,.35);font-size:8px;">Secure Checkout</span></div>
                                        </div>
                                    </div>
                                    <div class="ws-label"><div class="ws-label-dot"></div>E-Commerce</div>
                                </div>

                                <!-- Card 2 — SaaS Dashboard -->
                                <div class="ws-card" data-ws="1">
                                    <div class="ws-browser-bar">
                                        <div class="ws-dots"><span style="background:#ff5f57"></span><span style="background:#ffbd2e"></span><span style="background:#28c840"></span></div>
                                        <div class="ws-url"><span class="ws-url-lock">🔒</span> dashboard.saaspro.io</div>
                                    </div>
                                    <div style="flex:1;background:#0d1117;display:flex;overflow:hidden;">
                                        <!-- Sidebar -->
                                        <div style="width:52px;background:#161b22;padding:10px 0;display:flex;flex-direction:column;align-items:center;gap:12px;border-right:1px solid rgba(255,255,255,.06);">
                                            <div style="width:26px;height:26px;border-radius:8px;background:rgba(0,193,222,.15);display:grid;place-content:center;font-size:12px;">🏠</div>
                                            <div style="width:26px;height:26px;border-radius:8px;display:grid;place-content:center;font-size:11px;color:rgba(255,255,255,.35);">📊</div>
                                            <div style="width:26px;height:26px;border-radius:8px;display:grid;place-content:center;font-size:11px;color:rgba(255,255,255,.35);">👥</div>
                                            <div style="width:26px;height:26px;border-radius:8px;display:grid;place-content:center;font-size:11px;color:rgba(255,255,255,.35);">⚙️</div>
                                        </div>
                                        <!-- Main content -->
                                        <div style="flex:1;padding:12px 14px;overflow:hidden;">
                                            <div style="font-size:11px;font-weight:700;color:white;margin-bottom:10px;">Dashboard <span style="color:rgba(255,255,255,.3);font-weight:400;font-size:9px;">/ Overview</span></div>
                                            <!-- Stats row -->
                                            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:10px;">
                                                <div style="background:#161b22;border-radius:10px;padding:8px 10px;border:1px solid rgba(255,255,255,.06);">
                                                    <div style="font-size:7px;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.5px;">Revenue</div>
                                                    <div style="font-size:14px;font-weight:700;color:#00c1de;margin-top:3px;">$48.2K</div>
                                                    <div style="font-size:7px;color:#28c840;margin-top:2px;">▲ 12.5%</div>
                                                </div>
                                                <div style="background:#161b22;border-radius:10px;padding:8px 10px;border:1px solid rgba(255,255,255,.06);">
                                                    <div style="font-size:7px;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.5px;">Users</div>
                                                    <div style="font-size:14px;font-weight:700;color:white;margin-top:3px;">2,847</div>
                                                    <div style="font-size:7px;color:#28c840;margin-top:2px;">▲ 8.3%</div>
                                                </div>
                                                <div style="background:#161b22;border-radius:10px;padding:8px 10px;border:1px solid rgba(255,255,255,.06);">
                                                    <div style="font-size:7px;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.5px;">MRR</div>
                                                    <div style="font-size:14px;font-weight:700;color:white;margin-top:3px;">$12.4K</div>
                                                    <div style="font-size:7px;color:#28c840;margin-top:2px;">▲ 5.1%</div>
                                                </div>
                                            </div>
                                            <!-- Chart -->
                                            <div style="background:#161b22;border-radius:10px;padding:8px 10px;border:1px solid rgba(255,255,255,.06);flex:1;">
                                                <div style="font-size:8px;color:rgba(255,255,255,.4);margin-bottom:8px;">Monthly Traffic</div>
                                                <div style="display:flex;align-items:flex-end;gap:5px;height:60px;">
                                                    <div style="flex:1;background:rgba(0,193,222,.15);border-radius:3px 3px 0 0;height:30%;"></div>
                                                    <div style="flex:1;background:rgba(0,193,222,.2);border-radius:3px 3px 0 0;height:45%;"></div>
                                                    <div style="flex:1;background:rgba(0,193,222,.25);border-radius:3px 3px 0 0;height:35%;"></div>
                                                    <div style="flex:1;background:rgba(0,193,222,.3);border-radius:3px 3px 0 0;height:60%;"></div>
                                                    <div style="flex:1;background:rgba(0,193,222,.4);border-radius:3px 3px 0 0;height:50%;"></div>
                                                    <div style="flex:1;background:rgba(0,193,222,.5);border-radius:3px 3px 0 0;height:72%;"></div>
                                                    <div style="flex:1;background:rgba(0,193,222,.6);border-radius:3px 3px 0 0;height:85%;"></div>
                                                    <div style="flex:1;background:#00c1de;border-radius:3px 3px 0 0;height:95%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ws-label"><div class="ws-label-dot"></div>SaaS Dashboard</div>
                                </div>

                                <!-- Card 3 — CMS / Blog -->
                                <div class="ws-card" data-ws="2">
                                    <div class="ws-browser-bar">
                                        <div class="ws-dots"><span style="background:#ff5f57"></span><span style="background:#ffbd2e"></span><span style="background:#28c840"></span></div>
                                        <div class="ws-url"><span class="ws-url-lock">🔒</span> contentflow.io/blog</div>
                                    </div>
                                    <div style="flex:1;background:#fafafa;display:flex;flex-direction:column;overflow:hidden;">
                                        <!-- Blog nav -->
                                        <div style="background:white;padding:8px 16px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #eee;">
                                            <span style="font-weight:800;font-size:12px;color:#111;font-family:'Montserrat',sans-serif;">Content<span style="color:#00c1de;">Flow</span></span>
                                            <div style="display:flex;gap:14px;"><span style="color:#666;font-size:9px;">Articles</span><span style="color:#666;font-size:9px;">Guides</span><span style="color:#666;font-size:9px;">About</span></div>
                                            <div style="background:#00c1de;color:#020b14;padding:4px 12px;border-radius:14px;font-size:8px;font-weight:600;">Subscribe</div>
                                        </div>
                                        <!-- Featured article -->
                                        <div style="padding:14px 16px 8px;">
                                            <div style="background:linear-gradient(135deg,#0a1a22,#0d2b3a);border-radius:12px;padding:18px;margin-bottom:10px;">
                                                <div style="font-size:7px;color:#00c1de;text-transform:uppercase;letter-spacing:.8px;margin-bottom:4px;font-weight:600;">Featured</div>
                                                <div style="font-size:12px;font-weight:700;color:white;line-height:1.3;margin-bottom:5px;">Building Scalable APIs with Modern Architecture</div>
                                                <div style="font-size:8px;color:rgba(255,255,255,.5);">5 min read · Dec 2025 · By Sarah Chen</div>
                                            </div>
                                        </div>
                                        <!-- Post list -->
                                        <div style="padding:0 16px;display:flex;flex-direction:column;gap:8px;flex:1;">
                                            <div style="display:flex;gap:10px;align-items:center;">
                                                <div style="width:40px;height:32px;border-radius:6px;background:linear-gradient(135deg,#e8eaf6,#c5cae9);flex-shrink:0;display:grid;place-content:center;font-size:14px;">📦</div>
                                                <div><div style="font-size:9px;font-weight:600;color:#222;">Headless CMS Best Practices</div><div style="font-size:7px;color:#999;">3 min · Nov 2025</div></div>
                                            </div>
                                            <div style="display:flex;gap:10px;align-items:center;">
                                                <div style="width:40px;height:32px;border-radius:6px;background:linear-gradient(135deg,#e0f2f1,#b2dfdb);flex-shrink:0;display:grid;place-content:center;font-size:14px;">⚡</div>
                                                <div><div style="font-size:9px;font-weight:600;color:#222;">Performance Optimization Tips</div><div style="font-size:7px;color:#999;">4 min · Oct 2025</div></div>
                                            </div>
                                        </div>
                                        <!-- Blog footer -->
                                        <div style="background:white;padding:6px 16px;display:flex;justify-content:space-between;align-items:center;border-top:1px solid #eee;">
                                            <span style="color:#999;font-size:7px;">© ContentFlow 2025</span>
                                            <span style="color:#00c1de;font-size:8px;font-weight:600;">View all posts →</span>
                                        </div>
                                    </div>
                                    <div class="ws-label"><div class="ws-label-dot"></div>CMS / Blog</div>
                                </div>

                            </div>
                            <!-- Carousel Navigation Dots -->
                            <div class="ws-nav" id="wsNav">
                                <button class="ws-nav-dot active" data-target="0"></button>
                                <button class="ws-nav-dot" data-target="1"></button>
                                <button class="ws-nav-dot" data-target="2"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Mobile App Development -->
            <div class="swiper-slide">
                <div class="absolute inset-0 z-0">
                    <picture>
                        <source srcset="{{ asset('assets/images/landing/hero/hero-mobile.avif') }}" type="image/avif">
                        <img src="{{ asset('assets/images/landing/hero/hero-mobile.jpg') }}" class="w-full h-full object-cover" alt="Mobile Development" width="1920" height="1080" loading="lazy">
                    </picture>
                </div>
                <div class="container mx-auto px-4 lg:px-8 relative z-10 h-full flex items-center">
                    <div class="max-w-3xl">
                        <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-6">NATIVE MOBILE APPS</span>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6">
                            IOS & Android <span class="text-primary italic">Precision</span> at Scale
                        </h1>
                        <p class="text-xl text-white/80 mb-8">
                            Custom mobile experiences that live in your users' pockets. Built for engagement and seamless utility.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="#portfolio" class="btn-primary">View App Projects</a>
                            <a href="#contact" class="btn-ghost !text-white hover:!bg-primary">Consult Our Team</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation Buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        
        <!-- Pagination -->
        <div class="swiper-pagination"></div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce cursor-pointer z-20">
            <a href="#problems" class="text-white hover:text-primary transition-colors">
                <i class="ti ti-chevron-down text-3xl"></i>
            </a>
        </div>
    </div>
</header>
<!-- [ Header ] End -->
<!-- [ Header ] End -->
<!-- [ Services & Solutions ] start -->
<section id="services" class="py-24 bg-animazon-navy text-animazon-white relative overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute inset-0 z-0">
        <div class="absolute -top-[20%] -right-[10%] w-[600px] h-[600px] bg-primary/10 rounded-full blur-[120px] mix-blend-screen pointer-events-none"></div>
    </div>
    
    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-animazon-white mb-6">
                Solutions Designed For Scale
            </h2>
            <p class="text-lg text-animazon-muted">
                Whether you need a massive digital platform or cutting-edge visual assets, we engineer professional solutions that drive rapid growth and clear communication.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- 3D Animation -->
            <a href="{{ route('services.3d-animation') }}" class="card-dark group overflow-hidden !p-0 block hover:-translate-y-2 transition-all duration-300 hover:shadow-[0_0_30px_rgba(var(--primary-glow),0.3)] hover:border-primary/50 relative">
                <div class="relative overflow-hidden aspect-video">
                    <picture>
                        <source srcset="{{ asset('assets/images/branding/service-3d-car.avif') }}" type="image/avif">
                        <img src="{{ asset('assets/images/branding/service-3d-car.png') }}" alt="3D Product Animation" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" width="600" height="338" loading="lazy" decoding="async">
                    </picture>
                    <div class="absolute inset-0 bg-blue-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                </div>
                <div class="p-8">
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">3D Animation</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">High-end photorealistic 3D product animations, exploded views, and technical visualizations that explain complex concepts instantly.</p>
                    <div class="text-primary font-semibold text-sm inline-flex items-center group-hover:translate-x-1 transition-transform">
                        Explore 3D Services <i class="ti ti-arrow-right ms-2 text-lg"></i>
                    </div>
                </div>
            </a>

            <!-- Game Development -->
            <a href="{{ route('services.game-development') }}" class="card-dark group overflow-hidden !p-0 block hover:-translate-y-2 transition-all duration-300 hover:shadow-[0_0_30px_rgba(168,85,247,0.3)] hover:border-purple-500/50 relative">
                <div class="relative overflow-hidden aspect-video">
                    <picture>
                        <source srcset="{{ asset('assets/images/branding/service-medical.avif') }}" type="image/avif">
                        <img src="{{ asset('assets/images/branding/service-medical.png') }}" alt="Game Development" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" width="600" height="338" loading="lazy" decoding="async">
                    </picture>
                    <div class="absolute inset-0 bg-purple-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                </div>
                <div class="p-8">
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-purple-400 transition-colors">Game Development</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">Full-scale 3D & 2D game development for PC, Mobile, and Web platforms using industry-standard game engines and bespoke physics.</p>
                    <div class="text-purple-400 font-semibold text-sm inline-flex items-center group-hover:translate-x-1 transition-transform">
                        Explore Games <i class="ti ti-arrow-right ms-2 text-lg"></i>
                    </div>
                </div>
            </a>

            <!-- Web Development -->
            <a href="{{ route('services.web-development') }}" class="card-dark group overflow-hidden !p-0 block hover:-translate-y-2 transition-all duration-300 hover:shadow-[0_0_30px_rgba(234,88,12,0.3)] hover:border-orange-500/50 relative">
                <div class="relative overflow-hidden aspect-video">
                    <picture>
                        <source srcset="{{ asset('assets/images/branding/service-web.avif') }}" type="image/avif">
                        <img src="{{ asset('assets/images/branding/service-web.png') }}" alt="Web Development" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" width="600" height="338" loading="lazy" decoding="async">
                    </picture>
                    <div class="absolute inset-0 bg-orange-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                </div>
                <div class="p-8">
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-orange-400 transition-colors">Web Development</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">Custom SaaS platforms, robust e-commerce solutions, and lightning-fast corporate websites engineered for conversion.</p>
                    <div class="text-orange-400 font-semibold text-sm inline-flex items-center group-hover:translate-x-1 transition-transform">
                        Explore Web Dev <i class="ti ti-arrow-right ms-2 text-lg"></i>
                    </div>
                </div>
            </a>

            <!-- App Development -->
            <a href="{{ route('services.mobile-applications') }}" class="card-dark group overflow-hidden !p-0 block hover:-translate-y-2 transition-all duration-300 hover:shadow-[0_0_30px_rgba(22,163,74,0.3)] hover:border-green-500/50 relative">
                <div class="relative overflow-hidden aspect-video">
                    <picture>
                        <source srcset="{{ asset('assets/images/branding/service-mobile.avif') }}" type="image/avif">
                        <img src="{{ asset('assets/images/branding/service-mobile.png') }}" alt="App Development" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" width="600" height="338" loading="lazy" decoding="async">
                    </picture>
                    <div class="absolute inset-0 bg-green-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                </div>
                <div class="p-8">
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-green-400 transition-colors">Mobile Applications</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">Native iOS, Android, and cross-platform applications built to deliver a buttery-smooth, premium user experience.</p>
                    <div class="text-green-400 font-semibold text-sm inline-flex items-center group-hover:translate-x-1 transition-transform">
                        Explore Mobile Apps <i class="ti ti-arrow-right ms-2 text-lg"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
<!-- [ Services & Solutions ] end -->
@if ($landing_settings['portfolio_status'] == 'on')
    @php
        $portfolios = json_decode($landing_settings['portfolios'], true) ?? [];
        // Group by category
        $grouped = [];
        foreach ($portfolios as $item) {
            $cat = $item['category'] ?? 'Other';
            $grouped[$cat][] = $item;
        }
        // Category config: order, icon, accent color, bg
        $catConfig = [
            'Websites' => ['icon' => 'ti-world', 'accent' => 'orange', 'desc' => 'High-performance websites and web applications built for conversion and scale.'],
            '3D Animation' => ['icon' => 'ti-3d-cube-sphere', 'accent' => 'primary', 'desc' => 'Photorealistic 3D visualizations and animations that bring your ideas to life.'],
            'Game Development' => ['icon' => 'ti-device-gamepad-2', 'accent' => 'cyan', 'desc' => 'Immersive gaming experiences for mobile, desktop, and web platforms.'],
            'Mobile Applications' => ['icon' => 'ti-device-mobile', 'accent' => 'emerald', 'desc' => 'Native and cross-platform mobile apps with premium user experience.'],
        ];
        // Enforce order
        $orderedCats = ['Websites', '3D Animation', 'Game Development', 'Mobile Applications'];
    @endphp

    <section id="portfolio" class="py-24 bg-animazon-black relative overflow-hidden">
        <!-- Background glow -->
        <div class="absolute top-0 left-1/3 w-[600px] h-[600px] bg-primary/5 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-teal-500/5 blur-[100px] rounded-full pointer-events-none"></div>

        <div class="container mx-auto px-4 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="inline-block px-4 py-1.5 rounded-full bg-primary/15 text-primary text-xs font-bold tracking-widest uppercase mb-4">Portfolio</span>
                <h2 class="text-3xl md:text-5xl font-bold text-animazon-white mb-6">
                    {{ $landing_settings['portfolio_heading'] }}
                </h2>
                <p class="text-lg text-animazon-muted">
                    {{ $landing_settings['portfolio_description'] }}
                </p>
            </div>


            @if (count($portfolios) > 0)
                @foreach($orderedCats as $catName)
                    @if(isset($grouped[$catName]) && count($grouped[$catName]) > 0)
                        @php
                            $cfg = $catConfig[$catName] ?? ['icon' => 'ti-photo', 'accent' => 'primary', 'desc' => ''];
                            $accent = $cfg['accent'];
                            $items = $grouped[$catName];
                        @endphp

                        <!-- {{ $catName }} Section -->
                        <div class="mb-20 last:mb-0">
                            <!-- Category Header -->
                            <div class="flex items-center gap-4 mb-10">
                                <div class="w-12 h-12 rounded-xl bg-{{ $accent }}-500/15 flex items-center justify-center flex-shrink-0">
                                    <i class="ti {{ $cfg['icon'] }} text-{{ $accent }}-400 text-xl"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h3 class="text-2xl font-bold text-animazon-white">{{ $catName }}</h3>
                                        <span class="px-2.5 py-0.5 rounded-full bg-{{ $accent }}-500/15 text-{{ $accent }}-400 text-xs font-bold">{{ count($items) }}</span>
                                    </div>
                                    <p class="text-animazon-muted text-sm mt-1">{{ $cfg['desc'] }}</p>
                                </div>
                            </div>

                            <!-- Items Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach($items as $idx => $item)
                                    @php
                                        $itemType = $item['type'] ?? 'image';
                                        $itemTitle = $item['title'] ?? 'Showcase';
                                        $itemDesc = $item['description'] ?? '';
                                    @endphp

                                    @if($itemType === 'website')
                                        {{-- Website Card with Browser Chrome --}}
                                        <div class="group bg-animazon-navy border border-animazon-border/50 rounded-2xl overflow-hidden transition-all duration-500 hover:border-orange-500/50 hover:shadow-[0_0_40px_rgba(249,115,22,0.1)] hover:-translate-y-1">
                                            {{-- Browser bar --}}
                                            <div class="bg-[#1e1e24] px-3.5 py-2 flex items-center gap-2.5 border-b border-white/[0.06]">
                                                <div class="flex gap-1.5">
                                                    <span class="w-2.5 h-2.5 rounded-full bg-[#ff5f57]"></span>
                                                    <span class="w-2.5 h-2.5 rounded-full bg-[#ffbd2e]"></span>
                                                    <span class="w-2.5 h-2.5 rounded-full bg-[#28c840]"></span>
                                                </div>
                                                <div class="flex-1 flex items-center gap-1.5 bg-white/[0.06] rounded-md px-2.5 py-1 min-w-0">
                                                    <i class="ti ti-lock text-green-500 text-[9px]"></i>
                                                    <span class="text-white/40 text-[10px] font-mono truncate">{{ $itemTitle }} | {{ !empty($item['website_url']) ? parse_url($item['website_url'], PHP_URL_HOST) : 'animazon.tech' }}</span>
                                                </div>
                                            </div>
                                            {{-- Screenshot viewport --}}
                                            <div class="h-[220px] relative overflow-hidden">
                                                @if(!empty($item['image']))
                                                    <img src="{{ \App\Models\Utility::get_file('uploads/landing_page_image/' . $item['image']) }}"
                                                         class="w-full block object-cover object-top transition-transform duration-[4s] ease-[cubic-bezier(0.25,0.1,0.25,1)] group-hover:translate-y-[calc(-100%+220px)]"
                                                         alt="{{ $itemTitle }}" width="600" height="1200" loading="lazy" decoding="async">
                                                @elseif(!empty($item['website_url']))
                                                    <img src="https://s0.wordpress.com/mshots/v1/{{ urlencode($item['website_url']) }}?w=600"
                                                         class="w-full h-full object-cover object-top transition-transform duration-[4s] ease-[cubic-bezier(0.25,0.1,0.25,1)] group-hover:scale-105"
                                                         alt="{{ $itemTitle }}" width="600" height="400" loading="lazy" decoding="async"
                                                         onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-orange-900/30 to-animazon-black flex items-center justify-center\'><i class=\'ti ti-world text-5xl text-orange-400/50\'></i></div>';">
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-orange-900/30 to-animazon-black flex items-center justify-center">
                                                        <i class="ti ti-world text-5xl text-orange-400/50"></i>
                                                    </div>
                                                @endif
                                                @if(!empty($item['website_url']))
                                                    <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                                        <a href="{{ $item['website_url'] }}" target="_blank" class="w-14 h-14 bg-orange-500 rounded-full flex items-center justify-center text-white shadow-2xl hover:scale-110 transition-transform">
                                                            <i class="ti ti-external-link text-xl"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                            {{-- Info --}}
                                            <div class="p-5">
                                                <span class="text-xs font-bold text-orange-400 tracking-widest uppercase mb-1 block">{{ $item['category'] }}</span>
                                                <h4 class="text-lg font-bold text-animazon-white mb-1">{{ $itemTitle }}</h4>
                                                @if($itemDesc)
                                                    <p class="text-animazon-muted text-sm">{{ Str::limit($itemDesc, 80) }}</p>
                                                @endif
                                            </div>
                                        </div>

                                    @elseif($itemType === 'video')
                                        {{-- Video Card --}}
                                        @php
                                            $video_id = '';
                                            if (!empty($item['video_url']) && preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $item['video_url'], $match)) {
                                                $video_id = $match[1];
                                            }
                                        @endphp
                                        <div class="group bg-animazon-navy border border-animazon-border/50 rounded-2xl overflow-hidden transition-all duration-500 hover:border-red-500/50 hover:shadow-[0_0_40px_rgba(239,68,68,0.1)] hover:-translate-y-1">
                                            <div class="aspect-video relative overflow-hidden">
                                                @if(!empty($item['image']))
                                                    <img src="{{ \App\Models\Utility::get_file('uploads/landing_page_image/' . $item['image']) }}"
                                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                                         alt="{{ $itemTitle }}" width="600" height="338" loading="lazy" decoding="async">
                                                @elseif($video_id)
                                                    <img src="https://img.youtube.com/vi/{{ $video_id }}/hqdefault.jpg"
                                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                                         alt="{{ $itemTitle }}" width="480" height="360" loading="lazy" decoding="async"
                                                         onerror="this.onerror=null;this.src='https://img.youtube.com/vi/{{ $video_id }}/mqdefault.jpg';">
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-red-900/30 to-animazon-black flex items-center justify-center">
                                                        <i class="ti ti-player-play text-5xl text-red-400/50"></i>
                                                    </div>
                                                @endif
                                                @if($video_id)
                                                    <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/10 transition-all">
                                                        <div class="w-16 h-16 bg-red-500 text-white rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform cursor-pointer" onclick="openVideoPlayer('{{ $video_id }}')">
                                                            <i class="ti ti-player-play text-2xl"></i>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="p-6">
                                                <span class="text-xs font-bold text-red-400 tracking-widest uppercase mb-1 block">{{ $item['category'] }}</span>
                                                <h4 class="text-lg font-bold text-animazon-white mb-1">{{ $itemTitle }}</h4>
                                                @if($itemDesc)
                                                    <p class="text-animazon-muted text-sm">{{ Str::limit($itemDesc, 80) }}</p>
                                                @endif
                                            </div>
                                        </div>

                                    @elseif($itemType === 'game')
                                        {{-- Game Card --}}
                                        <div class="group bg-animazon-navy border border-animazon-border/50 rounded-2xl overflow-hidden transition-all duration-500 hover:border-cyan-500/50 hover:shadow-[0_0_40px_rgba(34,211,238,0.1)] hover:-translate-y-1">
                                            <div class="aspect-video relative overflow-hidden">
                                                @if(!empty($item['image']))
                                                    <img src="{{ \App\Models\Utility::get_file('uploads/landing_page_image/' . $item['image']) }}"
                                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                                         alt="{{ $itemTitle }}" width="600" height="338" loading="lazy" decoding="async">
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-cyan-900/30 to-animazon-black flex items-center justify-center">
                                                        <i class="ti ti-device-gamepad-2 text-5xl text-cyan-400/50"></i>
                                                    </div>
                                                @endif
                                                @if(!empty($item['game_url']))
                                                    <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <button onclick="openGameEmbed('{{ $item['game_url'] }}', '{{ $itemTitle }}')" class="w-16 h-16 bg-cyan-500 rounded-full flex items-center justify-center text-white shadow-2xl hover:scale-110 transition-transform cursor-pointer">
                                                            <i class="ti ti-device-gamepad-2 text-2xl"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="p-6">
                                                <span class="text-xs font-bold text-cyan-400 tracking-widest uppercase mb-1 block">{{ $item['category'] }}</span>
                                                <h4 class="text-lg font-bold text-animazon-white mb-1">{{ $itemTitle }}</h4>
                                                @if($itemDesc)
                                                    <p class="text-animazon-muted text-sm">{{ Str::limit($itemDesc, 80) }}</p>
                                                @endif
                                            </div>
                                        </div>

                                    @elseif($itemType === 'mobile_app')
                                        {{-- Mobile App Phone Simulator --}}
                                        <div class="bg-animazon-navy border border-animazon-border/50 rounded-2xl p-6 flex flex-col items-center transition-all duration-500 hover:border-emerald-500/50 hover:shadow-[0_0_40px_rgba(16,185,129,0.1)]">
                                            <div class="text-center mb-4 w-full">
                                                <span class="text-xs font-bold text-emerald-400 tracking-widest uppercase block mb-1">{{ $item['category'] }}</span>
                                                <h4 class="text-lg font-bold text-animazon-white">{{ $itemTitle }}</h4>
                                                @if($itemDesc)
                                                    <p class="text-animazon-muted text-sm mt-1">{{ Str::limit($itemDesc, 60) }}</p>
                                                @endif
                                            </div>
                                            <div class="phone-simulator-frame">
                                                <div class="phone-notch"></div>
                                                <div class="phone-screen">
                                                    @if(!empty($item['mobile_screenshots']))
                                                        <div class="phone-carousel" data-phone-id="phone-{{ $idx }}">
                                                            @foreach($item['mobile_screenshots'] as $ssIdx => $screenshot)
                                                                <img src="{{ \App\Models\Utility::get_file('uploads/landing_page_image/' . $screenshot) }}"
                                                                     class="phone-slide {{ $ssIdx === 0 ? 'active' : '' }}"
                                                                     alt="App Screen {{ $ssIdx + 1 }}" loading="lazy" decoding="async">
                                                            @endforeach
                                                        </div>
                                                        @if(count($item['mobile_screenshots']) > 1)
                                                            <div class="phone-nav">
                                                                <button class="phone-nav-btn phone-prev" data-phone="phone-{{ $idx }}"><i class="ti ti-chevron-left"></i></button>
                                                                <div class="phone-dots">
                                                                    @foreach($item['mobile_screenshots'] as $ssIdx => $screenshot)
                                                                        <span class="phone-dot {{ $ssIdx === 0 ? 'active' : '' }}" data-phone="phone-{{ $idx }}" data-slide="{{ $ssIdx }}"></span>
                                                                    @endforeach
                                                                </div>
                                                                <button class="phone-nav-btn phone-next" data-phone="phone-{{ $idx }}"><i class="ti ti-chevron-right"></i></button>
                                                            </div>
                                                        @endif
                                                    @elseif(!empty($item['image']))
                                                        <img src="{{ \App\Models\Utility::get_file('uploads/landing_page_image/' . $item['image']) }}"
                                                             class="w-full h-full object-cover" alt="{{ $itemTitle }}" loading="lazy" decoding="async">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center bg-animazon-black text-animazon-muted">
                                                            <i class="ti ti-device-mobile text-4xl"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="phone-home-bar"></div>
                                            </div>
                                            @if(!empty($item['mobile_app_url']))
                                                <a href="{{ $item['mobile_app_url'] }}" target="_blank" class="mt-4 inline-flex items-center text-sm text-emerald-400 hover:text-emerald-300 transition-colors">
                                                    <i class="ti ti-download me-1"></i> Get the App
                                                </a>
                                            @endif
                                        </div>

                                    @else
                                        {{-- Default Image Card --}}
                                        <div class="group bg-animazon-navy border border-animazon-border/50 rounded-2xl overflow-hidden transition-all duration-500 hover:border-primary/50 hover:shadow-[0_0_40px_rgba(0,193,222,0.1)] hover:-translate-y-1">
                                            <div class="aspect-[4/3] relative overflow-hidden">
                                                @if(!empty($item['image']))
                                                    <img src="{{ \App\Models\Utility::get_file('uploads/landing_page_image/' . $item['image']) }}"
                                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                                         alt="{{ $itemTitle }}" width="600" height="450" loading="lazy" decoding="async">
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-primary/20 to-animazon-black flex items-center justify-center">
                                                        <i class="ti ti-photo text-5xl text-primary/50"></i>
                                                    </div>
                                                @endif
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                                            </div>
                                            <div class="p-6">
                                                <span class="text-xs font-bold text-primary tracking-widest uppercase mb-1 block">{{ $item['category'] }}</span>
                                                <h4 class="text-lg font-bold text-animazon-white mb-1">{{ $itemTitle }}</h4>
                                                @if($itemDesc)
                                                    <p class="text-animazon-muted text-sm">{{ Str::limit($itemDesc, 80) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                <!-- View All CTA -->
                <div class="text-center mt-16">
                    <a href="{{ route('portfolio.public') }}" class="btn-primary group inline-flex items-center">
                        View Full Portfolio <i class="ti ti-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Video Modal Player -->
    <div id="video-player-modal" class="fixed inset-0 z-[100] hidden bg-black/95 backdrop-blur-xl flex items-center justify-center p-4">
        <button onclick="closeVideoPlayer()" class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors">
            <i class="ti ti-x text-4xl"></i>
        </button>
        <div class="w-full max-w-5xl aspect-video bg-black rounded-2xl overflow-hidden shadow-2xl">
            <iframe id="youtube-iframe" class="w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>

    <!-- Game Embed Modal -->
    <div id="game-embed-modal" class="fixed inset-0 z-[100] hidden bg-black/95 backdrop-blur-xl flex items-center justify-center p-4">
        <button onclick="closeGameEmbed()" class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors z-10">
            <i class="ti ti-x text-4xl"></i>
        </button>
        <div class="text-center">
            <h3 id="game-embed-title" class="text-white text-xl font-bold mb-4"></h3>
            <div class="w-full max-w-4xl mx-auto bg-black rounded-2xl overflow-hidden shadow-2xl" style="aspect-ratio: 16/9;">
                <iframe id="game-iframe" class="w-full h-full" src="" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <script>
        // Video Player
        function openVideoPlayer(id) {
            document.getElementById('youtube-iframe').src = `https://www.youtube.com/embed/${id}?autoplay=1`;
            document.getElementById('video-player-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeVideoPlayer() {
            document.getElementById('youtube-iframe').src = '';
            document.getElementById('video-player-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Game Embed
        function openGameEmbed(url, title) {
            document.getElementById('game-iframe').src = url;
            document.getElementById('game-embed-title').textContent = title;
            document.getElementById('game-embed-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeGameEmbed() {
            document.getElementById('game-iframe').src = '';
            document.getElementById('game-embed-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Phone Simulator Carousel
        document.querySelectorAll('.phone-prev').forEach(btn => {
            btn.addEventListener('click', () => navigatePhone(btn.dataset.phone, -1));
        });
        document.querySelectorAll('.phone-next').forEach(btn => {
            btn.addEventListener('click', () => navigatePhone(btn.dataset.phone, 1));
        });
        document.querySelectorAll('.phone-dot').forEach(dot => {
            dot.addEventListener('click', () => {
                goToPhoneSlide(dot.dataset.phone, parseInt(dot.dataset.slide));
            });
        });

        function navigatePhone(phoneId, direction) {
            const carousel = document.querySelector(`[data-phone-id="${phoneId}"]`);
            if (!carousel) return;
            const slides = carousel.querySelectorAll('.phone-slide');
            let current = Array.from(slides).findIndex(s => s.classList.contains('active'));
            let next = (current + direction + slides.length) % slides.length;
            goToPhoneSlide(phoneId, next);
        }

        function goToPhoneSlide(phoneId, index) {
            const carousel = document.querySelector(`[data-phone-id="${phoneId}"]`);
            if (!carousel) return;
            const slides = carousel.querySelectorAll('.phone-slide');
            const dots = document.querySelectorAll(`.phone-dot[data-phone="${phoneId}"]`);
            slides.forEach((s, i) => {
                s.classList.toggle('active', i === index);
                s.style.transform = i === index ? 'translateX(0)' : (i < index ? 'translateX(-100%)' : 'translateX(100%)');
            });
            dots.forEach((d, i) => d.classList.toggle('active', i === index));
        }

        // Touch/swipe support for phone simulator
        document.querySelectorAll('.phone-carousel').forEach(carousel => {
            let startX = 0;
            carousel.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
            carousel.addEventListener('touchend', e => {
                const diff = startX - e.changedTouches[0].clientX;
                const phoneId = carousel.dataset.phoneId;
                if (Math.abs(diff) > 50) {
                    navigatePhone(phoneId, diff > 0 ? 1 : -1);
                }
            }, { passive: true });
        });
    </script>

    <style>
        /* Phone Simulator Frame */
        .phone-simulator-frame {
            width: 220px;
            height: 450px;
            background: #1a1a2e;
            border-radius: 32px;
            border: 3px solid #2d2d44;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5), inset 0 0 0 1px rgba(255,255,255,0.05);
        }
        .phone-notch {
            position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 100px; height: 22px; background: #1a1a2e;
            border-radius: 0 0 16px 16px; z-index: 10;
        }
        .phone-notch::before {
            content: ''; position: absolute; top: 8px; left: 50%; transform: translateX(-50%);
            width: 8px; height: 8px; background: #2d2d44; border-radius: 50%;
        }
        .phone-screen { position: absolute; top: 22px; left: 0; right: 0; bottom: 24px; overflow: hidden; background: #000; }
        .phone-home-bar { position: absolute; bottom: 6px; left: 50%; transform: translateX(-50%); width: 80px; height: 4px; background: #3d3d55; border-radius: 4px; }
        .phone-carousel { width: 100%; height: 100%; position: relative; }
        .phone-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(100%); }
        .phone-slide.active { transform: translateX(0); }
        .phone-nav { position: absolute; bottom: 30px; left: 0; right: 0; display: flex; align-items: center; justify-content: center; gap: 8px; z-index: 20; }
        .phone-nav-btn { width: 28px; height: 28px; border-radius: 50%; border: none; background: rgba(0,0,0,0.6); color: white; font-size: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(8px); transition: background 0.2s; }
        .phone-nav-btn:hover { background: rgba(16,185,129,0.7); }
        .phone-dots { display: flex; gap: 4px; }
        .phone-dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.3); cursor: pointer; transition: all 0.3s; }
        .phone-dot.active { background: #10b981; width: 16px; border-radius: 3px; }
        @media (max-width: 640px) {
            .phone-simulator-frame { width: 180px; height: 370px; }
        }
    </style>
@endif
<!-- [ Why Animazon ] start -->
<section id="why" class="py-24 bg-animazon-black text-animazon-white relative overflow-hidden">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-animazon-white mb-6">
                Why Animazon
            </h2>
            <p class="text-lg text-animazon-muted">
                What separates Animazon from generic production studios? It's our unique blend of technical knowledge and cinematic artistry.
            </p>
        </div>

        <div class="space-y-16">
            <!-- Differentiators -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="flex flex-col space-y-4">
                    <div class="w-full h-48 overflow-hidden rounded-xl bg-animazon-navy border border-animazon-border/50">
                        <img src="{{ asset('assets/images/branding/hero.png') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500" alt="Artistic Excellence">
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-animazon-white mb-3">Artistic Excellence</h3>
                        <p class="text-animazon-muted leading-relaxed text-sm">We don't just "make videos" or "write code". We create cinematic experiences that command attention.</p>
                    </div>
                </div>
                <div class="flex flex-col space-y-4">
                    <div class="w-full h-48 overflow-hidden rounded-xl bg-animazon-navy border border-animazon-border/50">
                        <img src="{{ asset('assets/images/branding/why-tech.png') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500" alt="Technical Precision">
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-animazon-white mb-3">Technical Precision</h3>
                        <p class="text-animazon-muted leading-relaxed text-sm">Whether it's a medical molecule or a complex database architecture, we get the details right.</p>
                    </div>
                </div>
                <div class="flex flex-col space-y-4">
                    <div class="w-full h-48 overflow-hidden rounded-xl bg-animazon-navy border border-animazon-border/50">
                        <img src="{{ asset('assets/images/branding/process-strategy.png') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500" alt="Strategic Thinking">
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-animazon-white mb-3">Strategic Thinking</h3>
                        <p class="text-animazon-muted leading-relaxed text-sm">We align every frame and every line of code with your business goals to ensure maximum ROI.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ Why Animazon ] end -->
<!-- [ Our Process ] start -->
<section id="process" class="py-24 bg-animazon-navy text-animazon-white relative overflow-hidden">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <h2 class="text-3xl md:text-5xl font-bold text-animazon-white mb-6">
                Our Process
            </h2>
            <p class="text-lg text-animazon-muted">
                Working with Animazon is structured, professional, and transparent. We follow a proven 4-step workflow to ensure project success.
            </p>
        </div>

        <div class="relative">
            <!-- Connecting Line (Desktop) -->
            <div class="hidden lg:block absolute top-1/2 left-0 w-full h-0.5 bg-gradient-to-r from-animazon-blue via-secondary to-animazon-blue transform -translate-y-1/2 opacity-20"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="relative z-10 text-center group">
                    <div class="w-16 h-16 bg-animazon-black border-2 border-primary rounded-full flex items-center justify-center text-animazon-white font-bold text-xl mx-auto mb-6 group-hover:bg-primary group-hover:scale-110 transition-all">1</div>
                    <img src="{{ asset('assets/images/branding/process-strategy.png') }}" class="w-full h-32 object-cover rounded-lg mb-4 opacity-70 group-hover:opacity-100 transition-opacity" alt="Strategy">
                    <h3 class="text-lg font-bold text-animazon-white mb-4">Strategy & Vision</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed">We start by understanding your goals, audience, and the unique value of your project.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 text-center group">
                    <div class="w-16 h-16 bg-animazon-black border-2 border-secondary rounded-full flex items-center justify-center text-animazon-white font-bold text-xl mx-auto mb-6 group-hover:bg-secondary group-hover:scale-110 transition-all">2</div>
                    <img src="{{ asset('assets/images/branding/hero.png') }}" class="w-full h-32 object-cover rounded-lg mb-4 opacity-70 group-hover:opacity-100 transition-opacity" alt="Creative">
                    <h3 class="text-lg font-bold text-animazon-white mb-4">Creative Direction</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed">Design once, build perfectly. We develop the visual style and technical architecture early.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 text-center group">
                    <div class="w-16 h-16 bg-animazon-black border-2 border-primary rounded-full flex items-center justify-center text-animazon-white font-bold text-xl mx-auto mb-6 group-hover:bg-primary group-hover:scale-110 transition-all">3</div>
                    <img src="{{ asset('assets/images/branding/process-execution.png') }}" class="w-full h-32 object-cover rounded-lg mb-4 opacity-70 group-hover:opacity-100 transition-opacity" alt="Execution">
                    <h3 class="text-lg font-bold text-animazon-white mb-4">Precision Execution</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed">Our team of artists and engineers bring the vision to life with obsessive attention to detail.</p>
                </div>

                <!-- Step 4 -->
                <div class="relative z-10 text-center group">
                    <div class="w-16 h-16 bg-animazon-black border-2 border-secondary rounded-full flex items-center justify-center text-animazon-white font-bold text-xl mx-auto mb-6 group-hover:bg-secondary group-hover:scale-110 transition-all">4</div>
                    <img src="{{ asset('assets/images/branding/service-web.png') }}" class="w-full h-32 object-cover rounded-lg mb-4 opacity-70 group-hover:opacity-100 transition-opacity" alt="Success">
                    <h3 class="text-lg font-bold text-animazon-white mb-4">Success & Scale</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed">We launch, optimize, and help you scale your digital presence as your business grows.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ Our Process ] end -->
<!-- [ faq ] End -->
<!-- [ Contact / CTA ] start -->
<section id="contact" class="py-24 bg-animazon-black text-animazon-white relative overflow-hidden">
    <!-- Gradient Glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary/10 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10 text-center">
        <div class="max-w-3xl mx-auto border border-animazon-border/50 bg-animazon-navy/50 backdrop-blur-xl p-12 md:p-20 rounded-[2rem] shadow-2xl">
            <h2 class="text-3xl md:text-5xl font-bold text-animazon-white mb-8">
                Ready to Bring Your <span class="text-gradient">Vision to Life?</span>
            </h2>
            <p class="text-xl text-animazon-muted mb-12">
                Whether it's a complex medical visualization, a high-performance web app, or a cinematic product reveal, we have the expertise to deliver beyond expectations.
            </p>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="#contact-modal" class="btn-primary">
                    Book a Free Consultation
                </a>
                <a href="#portfolio" class="btn-ghost">
                    See Our Recent Work
                </a>
            </div>
            
            <div class="mt-12 pt-12 border-t border-animazon-border/30 grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-animazon-muted">
                <div class="flex flex-col items-center">
                    <i class="ti ti-mail text-primary text-xl mb-2"></i>
                    <span>{{ $landing_settings['footer_email'] }}</span>
                </div>
                <div class="flex flex-col items-center">
                    <i class="ti ti-map-pin text-primary text-xl mb-2"></i>
                    <span>{{ $landing_settings['footer_address'] }}</span>
                </div>
                <div class="flex flex-col items-center">
                    <i class="ti ti-device-laptop text-primary text-xl mb-2"></i>
                    <span>Global Remote Studio</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ Contact / CTA ] end -->

<!-- [ Footer ] start -->
<footer class="py-12 bg-animazon-black text-animazon-white border-t border-animazon-border/30">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <div class="space-y-6">
                <div class="flex items-center space-x-4">
                    @if ($is_dark)
                        <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-light.png') . '?' . time() }}" alt="ANIMAZON" class="h-10 w-auto"/>
                    @else
                        <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') . '?' . time() }}" alt="ANIMAZON" class="h-10 w-auto"/>
                    @endif
                </div>
                <p class="text-animazon-muted text-sm leading-relaxed">
                    Premium Digital Production Studio specialized in 3D Animations, Web Applications, and Mobile Solutions.
                </p>
            </div>
            
            <div class="space-y-6">
                <h4 class="text-animazon-white font-bold">Quick Links</h4>
                <ul class="space-y-4 text-sm text-animazon-muted">
                    <li><a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a></li>
                    <li><a href="{{ url('/') }}#services" class="hover:text-primary transition-colors">Services</a></li>
                    <li><a href="{{ route('portfolio.public') }}" class="hover:text-primary transition-colors">Portfolio</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-primary transition-colors">Blog</a></li>
                </ul>
            </div>

            <div class="space-y-6">
                <h4 class="text-animazon-white font-bold">Contact Us</h4>
                <ul class="space-y-4 text-sm text-animazon-muted">
                    <li class="flex items-start space-x-3">
                        <i class="ti ti-map-pin text-primary mt-1"></i>
                        <span>{{ $landing_settings['footer_address'] }}</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="ti ti-mail text-primary"></i>
                        <span>{{ $landing_settings['footer_email'] }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-animazon-border/30 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-animazon-muted">
            <div class="text-animazon-muted text-sm">
                Copyright © {{ date('Y') }} | <span class="text-animazon-white font-semibold">ANIMAZON</span>
            </div>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-primary transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-primary transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
<!-- [ Footer ] end -->
<!-- [ dashboard ] End -->
<!-- Required Js -->
<script src="{{asset('assets/js/plugins/popper.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/pages/wow.min.js')}}"></script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Initialize Swiper
    const swiper = new Swiper('.hero-swiper', {
        loop: true,
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
    window.heroSwiper = swiper;

    // Start [ Menu hide/show on scroll ]
    let ost = 0;
    document.addEventListener("scroll", function () {
        let cOst = document.documentElement.scrollTop;
        if (cOst == 0) {
            document.querySelector(".navbar").classList.add("top-nav-collapse");
        } else if (cOst > ost) {
            document.querySelector(".navbar").classList.add("top-nav-collapse");
            document.querySelector(".navbar").classList.remove("default");
        } else {
            document.querySelector(".navbar").classList.add("default");
            document
                .querySelector(".navbar")
                .classList.remove("top-nav-collapse");
        }
        ost = cOst;
    });
    // End [ Menu hide/show on scroll ]
    var wow = new WOW({
        animateClass: "animate__animated", // animation css class (default is animated)
    });
    wow.init();
    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
        target: "#navbar-example",
    });
</script>
@if($get_cookie['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif
<script src="{{ asset('assets/landingpage/js/space_shooter.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const mobileClose = document.getElementById('mobile-menu-close');
        const mobileOverlay = document.getElementById('mobile-menu-overlay');
        const mobileLinks = document.querySelectorAll('.mobile-link');

        function openMobileMenu() {
            mobileOverlay.classList.remove('opacity-0', 'invisible');
            mobileOverlay.classList.add('opacity-100', 'visible');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            mobileOverlay.classList.add('opacity-0', 'invisible');
            mobileOverlay.classList.remove('opacity-100', 'visible');
            document.body.style.overflow = '';
        }

        if(mobileToggle) mobileToggle.addEventListener('click', openMobileMenu);
        if(mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
        
        mobileLinks.forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });

        // === Stacked Card Deck — DOM Reorder ===
        (function() {
            const stack = document.getElementById('wsCarousel');
            if (!stack) return;

            // Reverse DOM order so nth-last-child(1) = front card
            const cards = Array.from(stack.children)
                .reverse()
                .filter(el => el.classList.contains('ws-card'));
            cards.forEach(card => stack.appendChild(card));

            function moveCard() {
                const lastCard = stack.lastElementChild;
                if (lastCard && lastCard.classList.contains('ws-card')) {
                    lastCard.classList.add('ws-swap');

                    setTimeout(() => {
                        lastCard.classList.remove('ws-swap');
                        stack.insertBefore(lastCard, stack.firstElementChild);
                        updateDots();
                    }, 750);
                }
            }

            // Update nav dots to reflect current front card
            const dots = document.querySelectorAll('#wsNav .ws-nav-dot');
            function updateDots() {
                const front = stack.lastElementChild;
                if (!front) return;
                const wsIdx = front.dataset.ws;
                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', String(i) === wsIdx);
                });
            }

            let autoTimer = setInterval(moveCard, 3000);

            // Click front card to manually rotate
            stack.addEventListener('click', function(e) {
                const card = e.target.closest('.ws-card');
                if (card && card === stack.lastElementChild) {
                    clearInterval(autoTimer);
                    card.classList.add('ws-swap');
                    setTimeout(() => {
                        card.classList.remove('ws-swap');
                        stack.insertBefore(card, stack.firstElementChild);
                        updateDots();
                        autoTimer = setInterval(moveCard, 3000);
                    }, 750);
                }
            });

            // Dot clicks
            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    const target = dot.dataset.target;
                    const front = stack.lastElementChild;
                    if (front && front.dataset.ws === target) return;
                    // Rotate until the target is at front
                    clearInterval(autoTimer);
                    const rotateToTarget = () => {
                        const current = stack.lastElementChild;
                        if (current.dataset.ws === target) {
                            updateDots();
                            autoTimer = setInterval(moveCard, 3000);
                            return;
                        }
                        stack.insertBefore(current, stack.firstElementChild);
                        setTimeout(rotateToTarget, 80);
                    };
                    rotateToTarget();
                });
            });

            // Pause on hover
            stack.addEventListener('mouseenter', () => clearInterval(autoTimer));
            stack.addEventListener('mouseleave', () => { autoTimer = setInterval(moveCard, 3000); });

            updateDots();
        })();
    });
</script>
@yield('page_scripts')
@endif
</body>
</html>
