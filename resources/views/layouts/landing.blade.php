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
    $meta_logo = isset($getseo['meta_image']) && !empty($getseo['meta_image']) ? $getseo['meta_image'] : '';
    // WhatsApp strictly requires .png or .jpg! AVIF and ICO formats are universally rejected by social previews.
    $seo_image_url = $meta_logo ? $meta_image . $meta_logo : asset('assets/images/favicon.png');
    $get_cookie = Utility::getCookieSetting();

    $primary_color = !empty($settings['primary_color']) ? $settings['primary_color'] : '#00c1de';
    $secondary_color = !empty($settings['secondary_color']) ? $settings['secondary_color'] : '#ff6122';
    $is_dark = (isset($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on');
    $landing_settings = \Modules\LandingPage\Entities\LandingPageSetting::landingPageSetting();

    // ── Contact / social (single source of truth) ───────────────────────────────
    // TODO: replace placeholders with the real business numbers/URLs.
    $company_phone     = $landing_settings['footer_phone']    ?? '+91 80894 05950';   // displayed phone
    $company_whatsapp  = $landing_settings['footer_whatsapp'] ?? '918089405950';      // wa.me number: country code + number, no + or spaces
    $wa_message        = rawurlencode('Hi Animazon! I would like to discuss a project.');
    $wa_link           = 'https://wa.me/' . preg_replace('/\D/', '', $company_whatsapp) . '?text=' . $wa_message;

    // Map — office location (Animazon, Erode). Override via footer_map setting if needed.
    $map_address = $landing_settings['footer_map'] ?? '11.3438155,77.7023856';
    $map_embed   = $map_address ? 'https://maps.google.com/maps?q=' . urlencode($map_address) . '&z=16&ie=UTF8&iwloc=&output=embed' : '';
    $map_link    = 'https://maps.app.goo.gl/1kWSBEVguuKKBraW6';

    // Social URLs — leave empty to hide the icon (no dead "#" links)
    $social_instagram  = $landing_settings['social_instagram'] ?? '';
    $social_linkedin   = $landing_settings['social_linkedin']  ?? '';
    $social_youtube    = $landing_settings['social_youtube']   ?? '';
    $social_behance    = $landing_settings['social_behance']   ?? '';
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{$settings['SITE_RTL'] == 'on'?'rtl':''}}" class="{{ $is_dark ? 'dark' : '' }}">
<head>
    <!-- Critical Meta (must be first) -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#0A0A0B" />

    <title>{{ $metatitle ?: 'Animazon — 3D Animation, Web, Mobile Apps, E-commerce & ERP Studio' }}</title>
    <meta name="title" content="{{$metatitle}}">
    <meta name="description" content="{{$metsdesc ?: 'Animazon — Premium Digital Production Studio specializing in 3D Animation, Web Development, Game Development & Mobile Applications. Transform your vision into stunning digital experiences.'}}">
    <meta name="keywords" content="Best website development company in Erode, Web design services Tamil Nadu, Mobile app development agency, Custom iOS and Android apps, E-commerce website builders, Laravel developers India, Flutter app developers, Custom SaaS development, 3D animation studio Erode, Game development company, UI/UX design experts, ERP solutions, Digital production studio, App developers near me, Top web developers">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="{{$metatitle}}">
    <meta property="og:description" content="{{$metsdesc}}">
    <meta property="og:image" content="{{$seo_image_url}}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ config('app.url') }}">
    <meta property="twitter:title" content="{{$metatitle}}">
    <meta property="twitter:description" content="{{$metsdesc}}">
    <meta property="twitter:image" content="{{$seo_image_url}}">



    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.png.avif')}}" type="image/avif" />
    <link rel="apple-touch-icon" href="{{asset('assets/images/favicon.png')}}">

    <!-- Preconnect to critical origins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">

    <!-- Enhanced Rich Snippet Structured Data -->
    <script type="application/ld+json">
    [{
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Animazon",
      "url": "{{ config('app.url') }}",
      "logo": "{{ $seo_image_url }}",
      "sameAs": [
        "{{ $social_instagram ?? '' }}",
        "{{ $social_linkedin ?? '' }}",
        "{{ $social_youtube ?? '' }}",
        "{{ $social_behance ?? '' }}"
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "{{ $company_phone ?? '' }}",
        "contactType": "customer service"
      }
    },
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Animazon",
      "image": "{{ $seo_image_url }}",
      "description": "{{ $metsdesc ?: 'Animazon — Premium Digital Production Studio specializing in Web Design, 3D Animation, Game Development & Mobile Applications.' }}",
      "url": "{{ config('app.url') }}",
      "telephone": "{{ $company_phone ?? '' }}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ $landing_settings['footer_address'] ?? 'Nasiyanur Road, Narayana Valasu' }}",
        "addressLocality": "Erode",
        "addressRegion": "Tamil Nadu",
        "addressCountry": "IN"
      },
      "priceRange": "$$",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.9",
        "reviewCount": "24"
      }
    },
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "Animazon",
      "url": "{{ config('app.url') }}",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "{{ config('app.url') }}/?s={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }]
    </script>

    <!-- Google Fonts — non-render-blocking -->
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700&display=swap" rel="stylesheet"></noscript>

    <!-- Defer non-critical CSS: animate.min.css -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/animate.min.css')}}" media="print" onload="this.media='all'" />
    <noscript><link rel="stylesheet" href="{{asset('assets/css/plugins/animate.min.css')}}" /></noscript>
    <!-- Icon font — only tabler-icons used on landing page -->
    <link rel="preload" href="{{asset('assets/fonts/tabler-icons.min.css')}}" as="style">
    <link rel="stylesheet" href="{{asset('assets/fonts/tabler-icons.min.css')}}">

    <!-- vendor css -->
    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    
    <!-- Vite App -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{asset('assets/css/customizer.css')}}" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="{{asset('assets/css/customizer.css')}}"></noscript>

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

        /* Footer — distinct from main dark bg */
        .animazon-footer {
            background: #121215;
            color: #ffffff;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Gradient text utility */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* === Nav CTA Buttons === */
        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.55rem 1.3rem;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 0.6rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 193, 222, 0.25);
            text-decoration: none;
        }
        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 25px rgba(0, 193, 222, 0.4);
            opacity: 0.95;
        }
        .btn-login-outline {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.55rem 1.3rem;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 0.6rem;
            border: 1.5px solid rgba(255, 255, 255, 0.8);
            color: #ffffff;
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-login-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateY(-1px);
        }

    </style>

    <!-- Swiper CSS — non-render-blocking -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" media="print" onload="this.media='all'" />
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /></noscript>
    

    
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
            width: 14px;
            height: 14px;
            margin: 0 6px !important;
        }
        .swiper-pagination-bullet-active {
            background: {{ $primary_color }} !important;
            opacity: 1;
        }
        .swiper-button-next, .swiper-button-prev {
            color: {{ $primary_color }} !important;
        }
        @media (max-width: 768px) {
            .swiper {
                height: 70vh;
            }
            .swiper-button-next, .swiper-button-prev {
                display: none;
            }
            .swiper-pagination-bullet {
                width: 10px;
                height: 10px;
                margin: 0 4px !important;
            }
        }
        
        /* Custom products dropdown hover rule */
        .group:hover .group-hover-menu {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
        }
        .group-hover-menu {
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

    </style>
</head>

<body class="{{$color}} bg-animazon-black text-animazon-white selection:bg-primary/30 overflow-x-hidden">
<!-- [ Nav ] start -->
<!-- [ Nav ] start -->
<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-animazon-black backdrop-blur-md border-b border-animazon-border/50">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a class="flex items-center" href="{{ url('/') }}">
                @if ($is_dark)
                    <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-light.png') }}" alt="ANIMAZON" class="h-10 w-auto" width="160" height="40"/>
                @else
                    <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}" alt="ANIMAZON" class="h-10 w-auto" width="160" height="40"/>
                @endif
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-4 xl:space-x-8">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-primary font-bold' : 'text-animazon-white hover:text-primary font-medium' }} transition-colors p-2 inline-block">Home</a>
                <a href="{{ url('/') }}#services" class="text-animazon-white hover:text-primary font-medium transition-colors p-2 inline-block">Services</a>
                
                <!-- Products Dropdown Menu -->
                <div class="relative group inline-block">
                    <button class="text-animazon-white hover:text-primary font-medium transition-colors p-2 inline-flex items-center gap-1 focus:outline-none">
                        Products
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="group-hover-menu absolute left-0 mt-2 w-64 rounded-xl bg-[#111114] border border-animazon-border/50 shadow-2xl py-3 opacity-0 invisible transition-all duration-300 z-50">
                        <a href="https://app.animazon.in/home" target="_blank" class="flex items-center gap-3 px-4 py-2.5 hover:bg-primary/10 transition-colors group/item">
                            <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary group-hover/item:bg-primary group-hover/item:text-slate-900 transition-all duration-300">
                                <i class="ti ti-chart-line text-lg"></i>
                            </div>
                            <div>
                                <span class="block text-sm font-semibold text-animazon-white group-hover/item:text-primary transition-colors">Loan Track</span>
                                <span class="block text-[11px] text-animazon-muted leading-tight">Advanced Loan Management System</span>
                            </div>
                        </a>
                    </div>
                </div>

                <a href="{{ route('portfolio.public') }}" class="{{ request()->routeIs('portfolio.public') ? 'text-primary font-bold' : 'text-animazon-white hover:text-primary font-medium' }} transition-colors p-2 inline-block">Portfolio</a>
                <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.index') ? 'text-primary font-bold' : 'text-animazon-white hover:text-primary font-medium' }} transition-colors p-2 inline-block">Blog</a>
                <a href="{{ route('cost-calculator.public') }}" class="{{ request()->routeIs('cost-calculator.*') ? 'text-primary font-bold' : 'text-animazon-white hover:text-primary font-medium' }} transition-colors p-2 inline-block">Pricing</a>
                <a href="{{ url('/') }}#contact" class="text-animazon-white hover:text-primary font-medium transition-colors p-2 inline-block" rel="nofollow">Contact</a>
            </div>

            <!-- CTA & Mobile Toggle -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('cost-calculator.public') }}" class="hidden sm:inline-flex btn-primary-custom">
                    <i class="ti ti-rocket"></i> Start Your Project
                </a>
                
                <button id="mobile-menu-toggle" class="lg:hidden text-animazon-white p-2" aria-label="Open navigation menu" aria-expanded="false">
                    <i class="ti ti-menu-2 text-2xl"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay" class="fixed inset-0 bg-animazon-black/90 backdrop-blur-xl z-[60] flex-col items-center justify-center space-y-8 transition-all duration-300 opacity-0 invisible flex">
    <button id="mobile-menu-close" class="absolute top-6 right-6 text-animazon-white p-2" aria-label="Close navigation menu">
        <i class="ti ti-x text-3xl"></i>
    </button>
    
    <a href="{{ url('/') }}" class="mobile-link text-2xl {{ request()->is('/') ? 'text-primary' : 'text-animazon-white hover:text-primary' }} font-bold transition-colors">Home</a>
    <a href="{{ url('/') }}#services" class="mobile-link text-2xl text-animazon-white hover:text-primary font-bold transition-colors">Services</a>
    
    <!-- Mobile Products -->
    <div class="flex flex-col items-center space-y-2">
        <span class="text-[10px] uppercase tracking-widest text-animazon-muted font-bold">Our Products</span>
        <a href="https://app.animazon.in/home" target="_blank" class="mobile-link text-2xl text-animazon-white hover:text-primary font-bold transition-colors flex items-center gap-2">
            <i class="ti ti-chart-line text-xl text-primary"></i> Loan Track
        </a>
    </div>

    <a href="{{ route('portfolio.public') }}" class="mobile-link text-2xl {{ request()->routeIs('portfolio.public') ? 'text-primary' : 'text-animazon-white hover:text-primary' }} font-bold transition-colors">Portfolio</a>
    <a href="{{ route('blog.index') }}" class="mobile-link text-2xl {{ request()->routeIs('blog.index') ? 'text-primary' : 'text-animazon-white hover:text-primary' }} font-bold transition-colors">Blog</a>
    <a href="{{ route('cost-calculator.public') }}" class="mobile-link text-2xl {{ request()->routeIs('cost-calculator.*') ? 'text-primary' : 'text-animazon-white hover:text-primary' }} font-bold transition-colors">Pricing</a>
    <a href="{{ url('/') }}#contact" class="mobile-link text-2xl text-animazon-white hover:text-primary font-bold transition-colors" rel="nofollow">Contact</a>
</div>
<!-- [ Nav ] end -->
@if(View::hasSection('page_content'))
    <!-- Child page content -->
    <main class="pt-20">
        @yield('page_content')
    </main>
@else
<main>
<!-- [ Header ] start -->
<header id="home" class="relative min-h-[70vh] md:min-h-screen overflow-hidden text-animazon-white">
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
                        <h1 class="text-2xl sm:text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-4 md:mb-6 animate__animated animate__fadeInUp">
                            3D & 2D <span class="text-primary italic">Games</span> for Every Platform
                        </h1>
                        <p class="text-sm sm:text-lg md:text-xl text-white/80 mb-6 md:mb-8 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                            From arcade & simulation games to full-scale Android, iOS, and browser experiences — try what we build, right here.
                        </p>
                        <div class="flex flex-wrap gap-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
                            <button onclick="launchSpaceShooter()" class="btn-primary group !text-slate-900 font-bold">
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
                        <source srcset="{{ asset('assets/images/landing/hero/hero-3d.jpg.avif') }}" type="image/avif">
                        <img src="{{ asset('assets/images/landing/hero/hero-3d.jpg') }}" class="w-full h-full object-cover" alt="3D Animation" width="1920" height="1080" fetchpriority="high">
                    </picture>
                </div>
                <div class="container mx-auto px-4 lg:px-8 relative z-10 h-full flex items-center">
                    <div class="max-w-3xl">
                        <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-6 animate__animated animate__fadeInDown">CINEMATIC 3D PRODUCTION</span>
                        <h1 class="text-2xl sm:text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-4 md:mb-6 animate__animated animate__fadeInUp">
                            Turn Complex Ideas into <span class="text-primary italic">Stunning 3D</span> Visuals
                        </h1>
                        <p class="text-sm sm:text-lg md:text-xl text-white/80 mb-6 md:mb-8 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                            Photorealistic 3D product animations and technical visualizations that explain your value in seconds.
                        </p>
                        <div class="flex flex-wrap gap-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
                            <a href="#portfolio" class="btn-primary">View 3D Showreel</a>
                            <a href="#contact" class="btn-ghost !text-white hover:!bg-primary">Get a Quote</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Web App Development -->
            <div class="swiper-slide">
                <div class="absolute inset-0 z-0">
                    <picture>
                        <source srcset="{{ asset('assets/images/landing/hero/hero-web.avif') }}" type="image/avif">
                        <source srcset="{{ asset('assets/images/landing/hero/hero-web.jpg.avif') }}" type="image/avif">
                        <img src="{{ asset('assets/images/landing/hero/hero-web.jpg') }}" class="w-full h-full object-cover" alt="Web Development" width="1920" height="1080" loading="lazy">
                    </picture>
                </div>
                <div class="container mx-auto px-4 lg:px-8 relative z-10 h-full flex items-center">
                    <div class="max-w-3xl">
                        <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-6 animate__animated animate__fadeInDown">CUSTOM WEB SOLUTIONS</span>
                        <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-[1.08] mb-4 md:mb-6 animate__animated animate__fadeInUp">
                            Build <span class="text-primary italic">Websites</span> That Convert, Not Just Exist
                        </h1>
                        <p class="text-sm sm:text-lg md:text-xl text-white/80 mb-6 md:mb-8 leading-relaxed animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
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
                </div>
            </div>

            <div class="swiper-slide">
                <div class="absolute inset-0 z-0">
                    <picture>
                        <source srcset="{{ asset('assets/images/landing/hero/hero-mobile.avif') }}" type="image/avif">
                        <source srcset="{{ asset('assets/images/landing/hero/hero-mobile.jpg.avif') }}" type="image/avif">
                        <img src="{{ asset('assets/images/landing/hero/hero-mobile.jpg') }}" class="w-full h-full object-cover" alt="Mobile Development" width="1920" height="1080" loading="lazy">
                    </picture>
                </div>
                <div class="container mx-auto px-4 lg:px-8 relative z-10 h-full flex items-center">
                    <div class="max-w-3xl">
                        <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-6">NATIVE MOBILE APPS</span>
                        <h1 class="text-2xl sm:text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-4 md:mb-6">
                            IOS & Android <span class="text-primary italic">Precision</span> at Scale
                        </h1>
                        <p class="text-sm sm:text-lg md:text-xl text-white/80 mb-6 md:mb-8">
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
            <a href="#problems" class="text-white hover:text-primary transition-colors p-3 inline-block" aria-label="Scroll down to services">
                <i class="ti ti-chevron-down text-3xl"></i>
            </a>
        </div>
    </div>
</header>
<!-- [ Header ] End -->
<!-- [ Header ] End -->
<!-- [ Services & Solutions ] start -->
<section id="services" class="py-12 md:py-24 bg-animazon-navy text-animazon-white relative overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute inset-0 z-0">
        <div class="absolute -top-[20%] -right-[10%] w-[600px] h-[600px] bg-primary/10 rounded-full blur-[120px] mix-blend-screen pointer-events-none"></div>
    </div>
    
    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-2xl sm:text-3xl md:text-5xl font-bold text-animazon-white mb-4 md:mb-6">
                Solutions Designed For Scale
            </h2>
            <p class="text-lg text-animazon-muted">
                Whether you need a massive digital platform or cutting-edge visual assets, we engineer professional solutions that drive rapid growth and clear communication.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- 3D Animation -->
            <a href="{{ route('services.3d-animation') }}" class="card-dark group overflow-hidden !p-0 block hover:-translate-y-2 transition-all duration-300 hover:shadow-[0_0_30px_rgba(var(--primary-glow),0.3)] hover:border-primary/50 relative">
                <div class="relative overflow-hidden aspect-video">
                    <picture>
                        <img src="{{ asset('assets/images/branding/service-3d-car.png') }}" alt="3D Product Animation" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" width="600" height="338" loading="lazy" decoding="async">
                    </picture>
                    <div class="absolute inset-0 bg-blue-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                </div>
                <div class="p-5 md:p-8">
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
                        <img src="{{ asset('assets/images/pricing/gaming.jpg') }}" alt="Game Development" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" width="600" height="338" loading="lazy" decoding="async">
                    </picture>
                    <div class="absolute inset-0 bg-purple-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                </div>
                <div class="p-5 md:p-8">
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
                        <img src="{{ asset('assets/images/branding/service-web.png') }}" alt="Web Development" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" width="600" height="338" loading="lazy" decoding="async">
                    </picture>
                    <div class="absolute inset-0 bg-orange-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                </div>
                <div class="p-5 md:p-8">
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
                        <img src="{{ asset('assets/images/pricing/mobileapp.jpg') }}" alt="App Development" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" width="600" height="338" loading="lazy" decoding="async">
                    </picture>
                    <div class="absolute inset-0 bg-green-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                </div>
                <div class="p-5 md:p-8">
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
        $portfolios_raw = $landing_settings['portfolios'] ?? '[]';
        $portfolios = json_decode($portfolios_raw, true);
        if (!is_array($portfolios)) {
            $portfolios = json_decode(stripslashes($portfolios_raw), true) ?? [];
        }
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

    <section id="portfolio" class="py-12 md:py-24 bg-animazon-black relative overflow-hidden">
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
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-8">
                                @foreach($items as $idx => $item)
                                    @php
                                        $itemType = $item['type'] ?? 'image';
                                        $itemTitle = $item['title'] ?? 'Showcase';
                                        $itemDesc = $item['description'] ?? '';
                                        $itemBadge = $item['badge_text'] ?? '';
                                        $techStack = !empty($item['tech_stack']) ? array_map('trim', explode(',', $item['tech_stack'])) : [];
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
                                                    <span class="text-white/70 text-[10px] font-mono truncate">{{ $itemTitle }} | {{ !empty($item['website_url']) ? parse_url($item['website_url'], PHP_URL_HOST) : 'animazon.tech' }}</span>
                                                </div>
                                            </div>
                                            {{-- Screenshot viewport --}}
                                            <div class="h-[220px] relative overflow-hidden">
                                                @if($itemBadge)
                                                    <span class="absolute top-4 left-4 z-20 px-3 py-1 rounded-full bg-orange-500 text-white text-[10px] font-bold uppercase tracking-wider shadow-lg">
                                                        {{ $itemBadge }}
                                                    </span>
                                                @endif
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
                                                        <a href="{{ $item['website_url'] }}" target="_blank" class="w-14 h-14 bg-orange-500 rounded-full flex items-center justify-center text-white shadow-2xl hover:scale-110 transition-transform" aria-label="Visit {{ $itemTitle }} website">
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
                                                @if(!empty($techStack))
                                                    <div class="flex flex-wrap gap-2 mt-3">
                                                        @foreach(array_slice($techStack, 0, 3) as $tech)
                                                            <span class="text-[10px] px-2 py-0.5 rounded bg-white/5 text-animazon-muted border border-white/10 uppercase tracking-tighter">{{ $tech }}</span>
                                                        @endforeach
                                                    </div>
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
                                                @if($itemBadge)
                                                    <span class="absolute top-4 left-4 z-20 px-3 py-1 rounded-full bg-red-500 text-white text-[10px] font-bold uppercase tracking-wider shadow-lg">
                                                        {{ $itemBadge }}
                                                    </span>
                                                @endif
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
                                                        <div class="play-btn-premium" onclick="openVideoPlayer('{{ $video_id }}')">
                                                            <i class="ti ti-player-play"></i>
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
                                                @if(!empty($techStack))
                                                    <div class="flex flex-wrap gap-2 mt-3">
                                                        @foreach(array_slice($techStack, 0, 3) as $tech)
                                                            <span class="text-[10px] px-2 py-0.5 rounded bg-white/5 text-animazon-muted border border-white/10 uppercase tracking-tighter">{{ $tech }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    @elseif($itemType === 'game')
                                        {{-- Game Card --}}
                                        <div class="group bg-animazon-navy border border-animazon-border/50 rounded-2xl overflow-hidden transition-all duration-500 hover:border-cyan-500/50 hover:shadow-[0_0_40px_rgba(34,211,238,0.1)] hover:-translate-y-1">
                                            <div class="aspect-video relative overflow-hidden">
                                                @if($itemBadge)
                                                    <span class="absolute top-4 left-4 z-20 px-3 py-1 rounded-full bg-cyan-500 text-white text-[10px] font-bold uppercase tracking-wider shadow-lg">
                                                        {{ $itemBadge }}
                                                    </span>
                                                @endif
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
                                                @if(!empty($techStack))
                                                    <div class="flex flex-wrap gap-2 mt-3">
                                                        @foreach(array_slice($techStack, 0, 3) as $tech)
                                                            <span class="text-[10px] px-2 py-0.5 rounded bg-white/5 text-animazon-muted border border-white/10 uppercase tracking-tighter">{{ $tech }}</span>
                                                        @endforeach
                                                    </div>
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
                                                @if(!empty($techStack))
                                                    <div class="flex flex-wrap justify-center gap-2 mt-3">
                                                        @foreach(array_slice($techStack, 0, 3) as $tech)
                                                            <span class="text-[10px] px-2 py-0.5 rounded bg-white/5 text-animazon-muted border border-white/10 uppercase tracking-tighter">{{ $tech }}</span>
                                                        @endforeach
                                                    </div>
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
                                                                <button class="phone-nav-btn phone-prev" data-phone="phone-{{ $idx }}" aria-label="Previous screenshot"><i class="ti ti-chevron-left"></i></button>
                                                                <div class="phone-dots">
                                                                    @foreach($item['mobile_screenshots'] as $ssIdx => $screenshot)
                                                                        <span class="phone-dot {{ $ssIdx === 0 ? 'active' : '' }}" data-phone="phone-{{ $idx }}" data-slide="{{ $ssIdx }}" role="button" tabindex="0" aria-label="Go to screenshot {{ $ssIdx + 1 }}"></span>
                                                                    @endforeach
                                                                </div>
                                                                <button class="phone-nav-btn phone-next" data-phone="phone-{{ $idx }}" aria-label="Next screenshot"><i class="ti ti-chevron-right"></i></button>
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
                                                @if($itemBadge)
                                                    <span class="absolute top-4 left-4 z-20 px-3 py-1 rounded-full bg-primary text-white text-[10px] font-bold uppercase tracking-wider shadow-lg">
                                                        {{ $itemBadge }}
                                                    </span>
                                                @endif
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
                                                @if(!empty($techStack))
                                                    <div class="flex flex-wrap gap-2 mt-3">
                                                        @foreach(array_slice($techStack, 0, 3) as $tech)
                                                            <span class="text-[10px] px-2 py-0.5 rounded bg-white/5 text-animazon-muted border border-white/10 uppercase tracking-tighter">{{ $tech }}</span>
                                                        @endforeach
                                                    </div>
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
        <button onclick="closeVideoPlayer()" class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors" aria-label="Close video player">
            <i class="ti ti-x text-4xl"></i>
        </button>
        <div class="w-full max-w-5xl aspect-video bg-black rounded-2xl overflow-hidden shadow-2xl">
            <iframe id="youtube-iframe" class="w-full h-full" src="" title="Video player" style="border:0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>

    <!-- Game Embed Modal -->
    <div id="game-embed-modal" class="fixed inset-0 z-[100] hidden bg-black/95 backdrop-blur-xl flex items-center justify-center p-4">
        <button onclick="closeGameEmbed()" class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors z-10" aria-label="Close game player">
            <i class="ti ti-x text-4xl"></i>
        </button>
        <div class="text-center">
            <h3 id="game-embed-title" class="text-white text-xl font-bold mb-4"></h3>
            <div class="w-full max-w-4xl mx-auto bg-black rounded-2xl overflow-hidden shadow-2xl" style="aspect-ratio: 16/9;">
                <iframe id="game-iframe" class="w-full h-full" src="" title="Game player" style="border:0" allowfullscreen></iframe>
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

    /* Premium Play Button - Global */
    .play-btn-premium {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: rgba(0, 194, 222, 0.2);
        backdrop-filter: blur(8px);
        border: 2px solid var(--primary-color, #00c1de);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 400ms cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 20px rgba(0, 194, 222, 0.3);
        position: relative;
    }
    .play-btn-premium::after {
        content: "";
        position: absolute;
        inset: -2px;
        border-radius: 50%;
        border: 2px solid var(--primary-color, #00c1de);
        animation: ripplePulse 2s infinite;
    }
    @keyframes ripplePulse {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(1.6); opacity: 0; }
    }
    .play-btn-premium:hover {
        background: var(--primary-color, #00c1de);
        transform: scale(1.1) rotate(8deg);
        box-shadow: 0 0 30px var(--primary-color, #00c1de);
        color: #020b14;
    }
    .play-btn-premium i { font-size: 24px; transition: transform 300ms ease; }
    .play-btn-premium:hover i { transform: scale(1.2); }
        @media (max-width: 640px) {
            .phone-simulator-frame { width: 180px; height: 370px; }
        }
    </style>
@endif
<!-- [ Why Animazon ] start -->
<section id="why" class="py-28 bg-animazon-black text-animazon-white relative overflow-hidden">
    <!-- Background accents -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 blur-[150px] rounded-full pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-secondary/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="inline-block px-4 py-1.5 rounded-full bg-primary/15 text-primary text-xs font-bold tracking-widest uppercase mb-4">Why Choose Us</span>
            <h2 class="text-3xl md:text-5xl font-bold text-animazon-white mb-6">
                Why <span class="text-gradient">Animazon</span>
            </h2>
            <p class="text-lg text-animazon-muted">
                What separates Animazon from generic production studios? It's our unique blend of technical knowledge and cinematic artistry.
            </p>
        </div>

        <!-- Stats Counter Row -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-20">
            <div class="text-center p-6 rounded-2xl bg-animazon-navy/50 border border-animazon-border/30 backdrop-blur-sm hover:border-primary/30 transition-all duration-500">
                <div class="text-4xl md:text-5xl font-bold text-primary mb-2" data-counter>50+</div>
                <div class="text-animazon-muted text-sm">Projects Delivered</div>
            </div>
            <div class="text-center p-6 rounded-2xl bg-animazon-navy/50 border border-animazon-border/30 backdrop-blur-sm hover:border-primary/30 transition-all duration-500">
                <div class="text-4xl md:text-5xl font-bold text-primary mb-2" data-counter>30+</div>
                <div class="text-animazon-muted text-sm">Happy Clients</div>
            </div>
            <div class="text-center p-6 rounded-2xl bg-animazon-navy/50 border border-animazon-border/30 backdrop-blur-sm hover:border-primary/30 transition-all duration-500">
                <div class="text-4xl md:text-5xl font-bold text-primary mb-2" data-counter>4+</div>
                <div class="text-animazon-muted text-sm">Years Experience</div>
            </div>
            <div class="text-center p-6 rounded-2xl bg-animazon-navy/50 border border-animazon-border/30 backdrop-blur-sm hover:border-primary/30 transition-all duration-500">
                <div class="text-4xl md:text-5xl font-bold text-primary mb-2" data-counter>100%</div>
                <div class="text-animazon-muted text-sm">Client Satisfaction</div>
            </div>
        </div>

        <!-- Differentiator Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group relative rounded-2xl overflow-hidden border border-animazon-border/30 bg-animazon-navy/30 backdrop-blur-sm hover:border-primary/40 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_60px_rgba(0,193,222,0.1)]">
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ asset('assets/images/branding/hero.png') }}" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110" alt="Artistic Excellence">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0B] via-[#0A0A0B]/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <div class="w-12 h-12 rounded-xl bg-primary/20 backdrop-blur-md flex items-center justify-center">
                            <i class="ti ti-palette text-primary text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Artistic Excellence</h3>
                    <p class="text-animazon-muted leading-relaxed text-sm">We don't just "make videos" or "write code". We create cinematic experiences that command attention.</p>
                </div>
            </div>

            <div class="group relative rounded-2xl overflow-hidden border border-animazon-border/30 bg-animazon-navy/30 backdrop-blur-sm hover:border-secondary/40 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_60px_rgba(255,97,34,0.1)]">
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ asset('assets/images/branding/why-tech.png') }}" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110" alt="Technical Precision">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0B] via-[#0A0A0B]/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <div class="w-12 h-12 rounded-xl bg-secondary/20 backdrop-blur-md flex items-center justify-center">
                            <i class="ti ti-cpu text-secondary text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-secondary transition-colors">Technical Precision</h3>
                    <p class="text-animazon-muted leading-relaxed text-sm">Whether it's a medical molecule or a complex database architecture, we get the details right.</p>
                </div>
            </div>

            <div class="group relative rounded-2xl overflow-hidden border border-animazon-border/30 bg-animazon-navy/30 backdrop-blur-sm hover:border-primary/40 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_60px_rgba(0,193,222,0.1)]">
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ asset('assets/images/branding/process-strategy.png') }}" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110" alt="Strategic Thinking">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0B] via-[#0A0A0B]/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <div class="w-12 h-12 rounded-xl bg-primary/20 backdrop-blur-md flex items-center justify-center">
                            <i class="ti ti-chart-arrows text-primary text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Strategic Thinking</h3>
                    <p class="text-animazon-muted leading-relaxed text-sm">We align every frame and every line of code with your business goals to ensure maximum ROI.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ Why Animazon ] end -->

<!-- [ Our Team ] start -->
<section id="team" class="py-28 bg-animazon-black text-animazon-white relative overflow-hidden">
    <div class="absolute top-[20%] right-0 w-[500px] h-[500px] bg-primary/5 blur-[140px] rounded-full pointer-events-none"></div>
    <div class="absolute bottom-[10%] left-0 w-[400px] h-[400px] bg-secondary/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-block px-4 py-1.5 rounded-full bg-primary/15 text-primary text-xs font-bold tracking-widest uppercase mb-4">Our Team</span>
            <h2 class="text-3xl md:text-5xl font-bold text-animazon-white mb-6">The Minds Behind <span class="text-gradient">Animazon</span></h2>
            <p class="text-lg text-animazon-muted">A passionate team of creators, engineers, and visionaries building the future of digital experiences.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            <!-- Nandhakumar -->
            <div class="group text-center p-6 rounded-2xl border border-animazon-border bg-animazon-navy/40 backdrop-blur-sm hover:border-primary/30 transition-all duration-500">
                <div class="relative mx-auto w-28 h-32 mb-4">
                    <div class="absolute -inset-1.5 bg-gradient-to-br from-primary via-primary/50 to-secondary rounded-xl opacity-0 group-hover:opacity-100 blur-md transition-opacity duration-500"></div>
                    <div class="relative w-28 h-32 rounded-xl overflow-hidden border-2 border-animazon-border group-hover:border-primary/60 transition-all duration-500 shadow-2xl">
                        <img src="{{ asset('assets/images/team/nandhakumar.jpg') }}?v=3" alt="Nandhakumar" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    </div>
                </div>
                <span class="inline-block px-3 py-0.5 rounded-full text-white text-[9px] font-bold tracking-wider uppercase shadow-lg mb-2" style="background:linear-gradient(to right,#00c1de,#06b6d4)">Founder</span>
                <h3 class="text-lg font-bold text-animazon-white group-hover:text-primary transition-colors">Nandhakumar</h3>
                <p class="text-primary font-semibold text-xs mb-2">Founder & CEO</p>
                <p class="text-animazon-muted text-xs leading-relaxed">Visionary leader driving Animazon's mission to deliver world-class digital solutions across 3D, web, mobile, and gaming.</p>
            </div>

            <!-- Vignesh -->
            <div class="group text-center p-6 rounded-2xl border border-animazon-border bg-animazon-navy/40 backdrop-blur-sm hover:border-orange-400/30 transition-all duration-500">
                <div class="relative mx-auto w-28 h-32 mb-4">
                    <div class="absolute -inset-1.5 bg-gradient-to-br from-orange-400 via-orange-500/50 to-secondary rounded-xl opacity-0 group-hover:opacity-100 blur-md transition-opacity duration-500"></div>
                    <div class="relative w-28 h-32 rounded-xl overflow-hidden border-2 border-animazon-border group-hover:border-orange-400/60 transition-all duration-500 shadow-2xl">
                        <img src="{{ asset('assets/images/team/vignesh.jpg') }}?v=3" alt="Vignesh" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    </div>
                </div>
                <span class="inline-block px-3 py-0.5 rounded-full text-white text-[9px] font-bold tracking-wider uppercase shadow-lg mb-2" style="background:linear-gradient(to right,#f97316,#f59e0b)">Leadership</span>
                <h3 class="text-lg font-bold text-animazon-white group-hover:text-orange-400 transition-colors">Vignesh</h3>
                <p class="text-orange-400 font-semibold text-xs mb-2">Chief Technology Officer</p>
                <p class="text-animazon-muted text-xs leading-relaxed">Architect of Animazon's technical backbone — leading engineering, infrastructure, and innovation across all platforms.</p>
            </div>

            <!-- Benraj S D -->
            <div class="group text-center p-6 rounded-2xl border border-animazon-border bg-animazon-navy/40 backdrop-blur-sm hover:border-purple-400/30 transition-all duration-500">
                <div class="relative mx-auto w-28 h-32 mb-4">
                    <div class="absolute -inset-1.5 bg-gradient-to-br from-purple-400 via-purple-500/50 to-pink-500 rounded-xl opacity-0 group-hover:opacity-100 blur-md transition-opacity duration-500"></div>
                    <div class="relative w-28 h-32 rounded-xl overflow-hidden border-2 border-animazon-border group-hover:border-purple-400/60 transition-all duration-500 shadow-2xl">
                        <img src="{{ asset('assets/images/team/benraj.jpg') }}?v=3" alt="Benraj S D" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    </div>
                </div>
                <span class="inline-block px-3 py-0.5 rounded-full text-white text-[9px] font-bold tracking-wider uppercase shadow-lg mb-2" style="background:linear-gradient(to right,#a855f7,#ec4899)">Gaming</span>
                <h3 class="text-lg font-bold text-animazon-white group-hover:text-purple-400 transition-colors">Benraj S D</h3>
                <p class="text-purple-400 font-semibold text-xs mb-2">Director of Game Development</p>
                <p class="text-animazon-muted text-xs leading-relaxed">Leading Animazon's game studio — from concept art and gameplay mechanics to full-scale 2D & 3D game production.</p>
            </div>


        </div>
    </div>
</section>
<!-- [ Our Team ] end -->

<!-- [ Our Process ] start -->
<section id="process" class="py-28 bg-animazon-navy text-animazon-white relative overflow-hidden">
    <!-- Background mesh -->
    <div class="absolute inset-0 pointer-events-none opacity-[0.03]" style="background-image:url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="inline-block px-4 py-1.5 rounded-full bg-primary/15 text-primary text-xs font-bold tracking-widest uppercase mb-4">How We Work</span>
            <h2 class="text-3xl md:text-5xl font-bold text-animazon-white mb-6">
                Our <span class="text-gradient">Process</span>
            </h2>
            <p class="text-lg text-animazon-muted">
                Working with Animazon is structured, professional, and transparent. We follow a proven 4-step workflow to ensure project success.
            </p>
        </div>

        <div class="relative">
            <!-- Connecting Line (Desktop) -->
            <div class="hidden lg:block absolute top-[60px] left-[12.5%] w-[75%] h-[2px]">
                <div class="w-full h-full bg-gradient-to-r from-primary via-secondary to-primary opacity-30 rounded-full"></div>
                <div class="absolute top-0 left-0 h-full w-1/3 bg-gradient-to-r from-primary to-transparent opacity-60 rounded-full animate-pulse"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="relative z-10 group">
                    <div class="text-center">
                        <div class="relative inline-flex">
                            <div class="w-[120px] h-[120px] rounded-3xl bg-animazon-black border-2 border-primary/30 flex items-center justify-center mx-auto mb-6 group-hover:border-primary group-hover:shadow-[0_0_30px_rgba(0,193,222,0.2)] transition-all duration-500 overflow-hidden">
                                <img src="{{ asset('assets/images/branding/process-strategy.png') }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity duration-500" alt="Strategy">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0B] to-transparent"></div>
                                <span class="absolute bottom-2 text-2xl font-bold text-primary">01</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Strategy & Vision</h3>
                        <p class="text-animazon-muted text-sm leading-relaxed">We start by understanding your goals, audience, and the unique value of your project.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 group">
                    <div class="text-center">
                        <div class="relative inline-flex">
                            <div class="w-[120px] h-[120px] rounded-3xl bg-animazon-black border-2 border-secondary/30 flex items-center justify-center mx-auto mb-6 group-hover:border-secondary group-hover:shadow-[0_0_30px_rgba(255,97,34,0.2)] transition-all duration-500 overflow-hidden">
                                <img src="{{ asset('assets/images/branding/hero.png') }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity duration-500" alt="Creative">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0B] to-transparent"></div>
                                <span class="absolute bottom-2 text-2xl font-bold text-secondary">02</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-animazon-white mb-3 group-hover:text-secondary transition-colors">Creative Direction</h3>
                        <p class="text-animazon-muted text-sm leading-relaxed">Design once, build perfectly. We develop the visual style and technical architecture early.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 group">
                    <div class="text-center">
                        <div class="relative inline-flex">
                            <div class="w-[120px] h-[120px] rounded-3xl bg-animazon-black border-2 border-primary/30 flex items-center justify-center mx-auto mb-6 group-hover:border-primary group-hover:shadow-[0_0_30px_rgba(0,193,222,0.2)] transition-all duration-500 overflow-hidden">
                                <img src="{{ asset('assets/images/branding/process-execution.png') }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity duration-500" alt="Execution">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0B] to-transparent"></div>
                                <span class="absolute bottom-2 text-2xl font-bold text-primary">03</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Precision Execution</h3>
                        <p class="text-animazon-muted text-sm leading-relaxed">Our team of artists and engineers bring the vision to life with obsessive attention to detail.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="relative z-10 group">
                    <div class="text-center">
                        <div class="relative inline-flex">
                            <div class="w-[120px] h-[120px] rounded-3xl bg-animazon-black border-2 border-secondary/30 flex items-center justify-center mx-auto mb-6 group-hover:border-secondary group-hover:shadow-[0_0_30px_rgba(255,97,34,0.2)] transition-all duration-500 overflow-hidden">
                                <img src="{{ asset('assets/images/branding/service-web.png') }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity duration-500" alt="Success">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0B] to-transparent"></div>
                                <span class="absolute bottom-2 text-2xl font-bold text-secondary">04</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-animazon-white mb-3 group-hover:text-secondary transition-colors">Success & Scale</h3>
                        <p class="text-animazon-muted text-sm leading-relaxed">We launch, optimize, and help you scale your digital presence as your business grows.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ Our Process ] end -->

<!-- [ Testimonials ] start -->
{{--
    TODO: Replace the 3 placeholder cards below with REAL client testimonials.
    For each: client name, role/company, their quote, and (optional) a star rating.
    Keep the count of visible cards in sync with the schema reviewCount in <head>.
--}}
<section id="testimonials" class="py-28 bg-animazon-navy text-animazon-white relative overflow-hidden">
    <div class="absolute top-1/4 left-0 w-[400px] h-[400px] bg-primary/5 blur-[130px] rounded-full pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-secondary/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-block px-4 py-1.5 rounded-full bg-primary/15 text-primary text-xs font-bold tracking-widest uppercase mb-4">Client Stories</span>
            <h2 class="text-3xl md:text-5xl font-bold text-animazon-white mb-4">What Our <span class="text-gradient">Clients Say</span></h2>
            <div class="flex items-center justify-center gap-2 text-primary">
                <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                <span class="text-animazon-muted text-sm ml-2">Rated 4.9/5 by our clients</span>
            </div>
        </div>

        @php
            // Real client projects delivered by Animazon. Each links to the live site.
            // 'domain' drives the logo (favicon service) shown on the card.
            $testimonials = [
                ['quote' => 'Animazon built our online store exactly the way we wanted — clean, fast, and easy for customers to order our products. Delivery was on time and support has been excellent.', 'name' => 'Management', 'role' => 'Dhanvanthri Foods', 'url' => 'https://www.dhanvanthrifoods.com/', 'domain' => 'dhanvanthrifoods.com'],
                ['quote' => 'Our leather brand finally has a website that matches the quality of our products. The team understood exactly what we needed and delivered a store we are proud of.', 'name' => 'Mohan', 'role' => 'Wildlife Leather', 'url' => 'https://wildlifeleather.in/', 'domain' => 'wildlifeleather.in'],
                ['quote' => 'Professional work from start to finish. The site looks premium, loads fast, and made our brand stand out online. Highly recommend Animazon.', 'name' => 'Arun Lal', 'role' => 'Lenzbreeze', 'url' => 'https://www.lenzbreeze.com/', 'domain' => 'lenzbreeze.com'],
                ['quote' => 'They handled everything — design, build, and launch — with zero hassle. Communication was clear and the final website exceeded what we expected.', 'name' => 'T. Babu', 'role' => 'IPCA TN', 'url' => 'https://ipcatn.com/', 'domain' => 'ipcatn.com'],
                ['quote' => 'Great experience working with Animazon. Our website is elegant, mobile-friendly, and represents our brand perfectly. Genuinely happy with the result.', 'name' => 'Murali', 'role' => 'Rudra Spirit', 'url' => 'https://rudraspirit.com/', 'domain' => 'rudraspirit.com'],
                ['quote' => 'The 3D animation work was top quality — accurate, detailed, and delivered exactly on brief. Reliable team for technical engineering visuals.', 'name' => 'Hrvoje', 'role' => '3D Animation · Chrvoje Engineering', 'url' => 'https://www.youtube.com/@chrvoje_engineering', 'domain' => 'youtube.com', 'logo' => 'assets/images/testimonials/chrvoje-engineering.jpg'],
            ];
        @endphp

        <style>
            @keyframes tmarquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
            .tmarquee-track { animation: tmarquee 45s linear infinite; }
            .tmarquee:hover .tmarquee-track { animation-play-state: paused; }
            @media (prefers-reduced-motion: reduce) { .tmarquee-track { animation: none; } }
        </style>

        {{-- Horizontal auto-scroll marquee (duplicated track for a seamless loop; pauses on hover) --}}
        @php
            // Alternate the two brand colors only (primary + secondary) as subtle accents
            $palette = [$primary_color, $secondary_color];
        @endphp
        <div class="tmarquee relative overflow-hidden" style="-webkit-mask-image:linear-gradient(90deg,transparent,#000 6%,#000 94%,transparent);mask-image:linear-gradient(90deg,transparent,#000 6%,#000 94%,transparent);">
            <div class="tmarquee-track flex w-max py-2" style="gap:24px;">
                @foreach(array_merge($testimonials, $testimonials) as $t)
                @php
                    $c = $palette[$loop->index % count($palette)];
                    $hasLocal = !empty($t['logo']);
                    $logoSrc = $hasLocal ? asset($t['logo']) : 'https://logo.clearbit.com/' . $t['domain'];
                    // Local-logo entries skip the favicon step (avoids showing a generic YouTube/social icon)
                    $logoFallback = $hasLocal ? '' : 'https://www.google.com/s2/favicons?domain=' . $t['domain'] . '&sz=128';
                @endphp
                <div class="tcard flex-shrink-0 flex flex-col" style="width:330px;max-width:86vw;height:390px;border-radius:18px;border:1px solid rgba(255,255,255,.09);background:rgba(255,255,255,.03);padding:22px;border-top:3px solid {{ $c }};">
                    <!-- Logo tile — primary visibility -->
                    <div class="flex items-center justify-center" style="height:108px;background:#fff;border-radius:12px;padding:14px;margin-bottom:18px;">
                        <img src="{{ $logoSrc }}" alt="{{ $t['role'] }} logo"
                             style="max-height:80px;max-width:82%;object-fit:contain;"
                             loading="lazy"
                             onerror="if(!this.dataset.f){this.dataset.f=1;this.src='{{ $logoFallback }}';}else{this.style.display='none';this.nextElementSibling.style.display='flex';}">
                        <span class="items-center justify-center font-black" style="display:none;width:72px;height:72px;border-radius:9999px;background:{{ $c }};color:#fff;font-size:2rem;">{{ substr($t['name'], 0, 1) }}</span>
                    </div>
                    <!-- Quote mark + stars -->
                    <div class="flex items-center justify-between" style="margin-bottom:6px;">
                        <i class="ti ti-quote" style="color:{{ $c }};font-size:1.9rem;line-height:1;"></i>
                        <div class="flex" style="gap:2px;color:{{ $c }};">
                            <i class="ti ti-star-filled" style="font-size:12px;"></i><i class="ti ti-star-filled" style="font-size:12px;"></i><i class="ti ti-star-filled" style="font-size:12px;"></i><i class="ti ti-star-filled" style="font-size:12px;"></i><i class="ti ti-star-filled" style="font-size:12px;"></i>
                        </div>
                    </div>
                    <p class="flex-grow" style="font-size:13px;line-height:1.55;color:#94A3B8;">“{{ $t['quote'] }}”</p>
                    <div style="border-top:1px solid rgba(255,255,255,.08);padding-top:12px;margin-top:12px;">
                        <p class="font-bold text-white" style="font-size:15px;">{{ $t['name'] }}</p>
                        <div class="flex items-center justify-between">
                            <p style="font-size:11px;color:{{ $c }};">{{ $t['role'] }}</p>
                            @if(!empty($t['url']))
                            <a href="{{ $t['url'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1" style="font-size:11px;color:#64748B;" aria-label="Visit {{ $t['role'] }}">
                                Visit <i class="ti ti-external-link"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- [ Testimonials ] end -->

<!-- [ Contact / CTA ] start -->
<section id="contact" class="py-28 bg-animazon-black text-animazon-white relative overflow-hidden">
    <!-- Gradient Glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-[800px] aspect-square bg-primary/10 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-full max-w-[400px] aspect-square bg-secondary/5 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10 text-center">
        <div class="max-w-3xl mx-auto relative">
            <!-- Gradient border effect -->
            <div class="absolute -inset-[1px] bg-gradient-to-r from-primary/30 via-secondary/20 to-primary/30 rounded-[2rem] blur-sm"></div>
            <div class="relative bg-animazon-navy/80 backdrop-blur-xl p-8 md:p-12 lg:p-20 rounded-[2rem] shadow-2xl border border-animazon-border/20">
                <span class="inline-block px-4 py-1.5 rounded-full bg-primary/15 text-primary text-xs font-bold tracking-widest uppercase mb-6">Get Started</span>
                <h2 class="text-3xl md:text-5xl font-bold text-animazon-white mb-8">
                    Ready to Bring Your <span class="text-gradient">Vision to Life?</span>
                </h2>
                <p class="text-xl text-animazon-muted mb-12">
                    Whether it's a complex medical visualization, a high-performance web app, or a cinematic product reveal, we have the expertise to deliver beyond expectations.
                </p>
                <div class="flex flex-col sm:flex-row flex-wrap justify-center gap-4 sm:gap-6">
                    <a href="{{ route('cost-calculator.public') }}" class="btn-primary-custom group">
                        <i class="ti ti-send mr-2 group-hover:translate-x-1 transition-transform"></i> Start Your Project
                    </a>
                    <a href="{{ $wa_link }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 bg-[#25D366] text-white font-bold py-3 px-7 rounded-full hover:bg-[#1ebe57] transition-colors shadow-lg shadow-[#25D366]/20">
                        <i class="ti ti-brand-whatsapp text-lg"></i> WhatsApp Us
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $company_phone) }}" class="btn-ghost">
                        <i class="ti ti-phone mr-2"></i> {{ $company_phone }}
                    </a>
                </div>

                <!-- Trust badges -->
                <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="flex flex-col items-center gap-2 p-4 rounded-2xl bg-animazon-black/30 border border-animazon-border/20">
                        <i class="ti ti-shield-check text-primary text-2xl"></i>
                        <span class="text-xs text-animazon-muted leading-tight">Secure online payments</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 p-4 rounded-2xl bg-animazon-black/30 border border-animazon-border/20">
                        <i class="ti ti-clock-check text-primary text-2xl"></i>
                        <span class="text-xs text-animazon-muted leading-tight">On-time, milestone delivery</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 p-4 rounded-2xl bg-animazon-black/30 border border-animazon-border/20">
                        <i class="ti ti-lock text-primary text-2xl"></i>
                        <span class="text-xs text-animazon-muted leading-tight">NDA & confidentiality</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 p-4 rounded-2xl bg-animazon-black/30 border border-animazon-border/20">
                        <i class="ti ti-message-2-bolt text-primary text-2xl"></i>
                        <span class="text-xs text-animazon-muted leading-tight">Reply within 24 hours</span>
                    </div>
                </div>

                <div class="mt-12 pt-12 border-t border-animazon-border/30 grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-animazon-muted">
                    <div class="flex flex-col items-center group">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center mb-3 group-hover:bg-primary/20 transition-colors">
                            <i class="ti ti-mail text-primary text-lg"></i>
                        </div>
                        <a href="mailto:{{ $landing_settings['footer_email'] }}" class="hover:text-primary transition-colors">{{ $landing_settings['footer_email'] }}</a>
                    </div>
                    <div class="flex flex-col items-center group">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center mb-3 group-hover:bg-primary/20 transition-colors">
                            <i class="ti ti-phone text-primary text-lg"></i>
                        </div>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $company_phone) }}" class="hover:text-primary transition-colors">{{ $company_phone }}</a>
                    </div>
                    <div class="flex flex-col items-center group">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center mb-3 group-hover:bg-primary/20 transition-colors">
                            <i class="ti ti-map-pin text-primary text-lg"></i>
                        </div>
                        <span>{{ $landing_settings['footer_address'] }}</span>
                    </div>
                </div>
            </div>

            @if($map_embed)
            <!-- Location map -->
            <div class="max-w-5xl mx-auto mt-16">
                <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-animazon-muted text-sm mb-4">
                    <span class="inline-flex items-center gap-2">
                        <i class="ti ti-map-pin text-primary"></i>
                        {{ $landing_settings['footer_address'] ?: 'Visit our office — Animazon' }}
                    </span>
                    <a href="{{ $map_link }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-primary hover:text-white transition-colors font-medium">
                        <i class="ti ti-navigation"></i> Get directions
                    </a>
                </div>
                <div class="rounded-2xl overflow-hidden border border-animazon-border/30 shadow-2xl shadow-primary/10">
                    <iframe
                        src="{{ $map_embed }}"
                        width="100%" height="360" style="border:0;"
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Animazon office location on Google Maps" allowfullscreen>
                    </iframe>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- [ Contact / CTA ] end -->
@endif

<!-- [ Footer ] start -->
<footer class="animazon-footer relative overflow-hidden">
    <!-- Gradient separator line -->
    <div class="h-[2px] w-full bg-gradient-to-r from-transparent via-primary to-transparent"></div>
    
    <!-- Main footer content -->
    <div class="py-16">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-14">
                <!-- Brand Column -->
                <div class="md:col-span-5 space-y-6">
                    <div class="flex items-center space-x-4">
                        {{-- Always use light logo in footer since footer is always dark --}}
                        <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-light.png') . '?' . time() }}" alt="ANIMAZON" class="h-10 w-auto"/>
                    </div>
                    <p class="text-[#8E8E93] text-sm leading-relaxed max-w-sm">
                        Premium Digital Production Studio specialized in 3D Animations, Web Applications, and Mobile Solutions.
                    </p>
                    <!-- Social links (only shown when a real URL is configured) -->
                    @if($social_instagram || $social_linkedin || $social_youtube || $social_behance)
                    <div class="flex items-center gap-3 pt-2">
                        @if($social_instagram)
                        <a href="{{ $social_instagram }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-[#8E8E93] hover:bg-primary/20 hover:border-primary/30 hover:text-primary transition-all duration-300" aria-label="Follow us on Instagram">
                            <i class="ti ti-brand-instagram text-lg"></i>
                        </a>
                        @endif
                        @if($social_linkedin)
                        <a href="{{ $social_linkedin }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-[#8E8E93] hover:bg-primary/20 hover:border-primary/30 hover:text-primary transition-all duration-300" aria-label="Follow us on LinkedIn">
                            <i class="ti ti-brand-linkedin text-lg"></i>
                        </a>
                        @endif
                        @if($social_youtube)
                        <a href="{{ $social_youtube }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-[#8E8E93] hover:bg-primary/20 hover:border-primary/30 hover:text-primary transition-all duration-300" aria-label="Subscribe on YouTube">
                            <i class="ti ti-brand-youtube text-lg"></i>
                        </a>
                        @endif
                        @if($social_behance)
                        <a href="{{ $social_behance }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-[#8E8E93] hover:bg-primary/20 hover:border-primary/30 hover:text-primary transition-all duration-300" aria-label="View our Behance portfolio">
                            <i class="ti ti-brand-behance text-lg"></i>
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
                
                <!-- Quick Links -->
                <div class="md:col-span-3 space-y-6">
                    <h3 class="text-white font-bold text-sm tracking-wider uppercase">Quick Links</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ url('/') }}" class="text-[#8E8E93] hover:text-primary hover:translate-x-1 inline-flex transition-all duration-300">Home</a></li>
                        <li><a href="{{ url('/') }}#services" class="text-[#8E8E93] hover:text-primary hover:translate-x-1 inline-flex transition-all duration-300">Services</a></li>
                        <li><a href="{{ route('portfolio.public') }}" class="text-[#8E8E93] hover:text-primary hover:translate-x-1 inline-flex transition-all duration-300">Portfolio</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-[#8E8E93] hover:text-primary hover:translate-x-1 inline-flex transition-all duration-300">Blog</a></li>
                        <li><a href="{{ route('cost-calculator.public') }}" class="text-[#8E8E93] hover:text-primary hover:translate-x-1 inline-flex transition-all duration-300">Pricing</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="md:col-span-4 space-y-6">
                    <h3 class="text-white font-bold text-sm tracking-wider uppercase">Contact Us</h3>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="ti ti-map-pin text-primary text-sm"></i>
                            </div>
                            <span class="text-[#8E8E93]">{{ $landing_settings['footer_address'] }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <i class="ti ti-mail text-primary text-sm"></i>
                            </div>
                            <a href="mailto:{{ $landing_settings['footer_email'] }}" class="text-[#8E8E93] hover:text-primary transition-colors">{{ $landing_settings['footer_email'] }}</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <i class="ti ti-phone text-primary text-sm"></i>
                            </div>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $company_phone) }}" class="text-[#8E8E93] hover:text-primary transition-colors">{{ $company_phone }}</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#25D366]/15 flex items-center justify-center flex-shrink-0">
                                <i class="ti ti-brand-whatsapp text-[#25D366] text-sm"></i>
                            </div>
                            <a href="{{ $wa_link }}" target="_blank" rel="noopener" class="text-[#8E8E93] hover:text-[#25D366] transition-colors">Chat on WhatsApp</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="pt-8 border-t border-white/[0.08] flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
                <div class="text-[#8E8E93]">
                    Copyright © {{ date('Y') }} | <span class="text-white font-semibold">ANIMAZON</span>
                </div>
                <div class="flex gap-6">
                    <a href="{{ route('terms') }}" class="text-[#8E8E93] hover:text-primary transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Subtle background glow -->
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[600px] h-[200px] bg-primary/5 blur-[100px] rounded-full pointer-events-none"></div>
</footer>
<!-- [ Footer ] end -->
</main>
<!-- [ dashboard ] End -->
<!-- Required Js -->
<script src="{{asset('assets/js/plugins/popper.min.js')}}" defer></script>
<script src="{{asset('assets/js/plugins/bootstrap.min.js')}}" defer></script>
<script src="{{asset('assets/js/pages/wow.min.js')}}" defer></script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Swiper
        if(document.querySelector('.hero-swiper')) {
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
        }

        // WOW.js animations
        if (typeof WOW !== 'undefined') {
            var wow = new WOW({
                animateClass: "animate__animated",
            });
            wow.init();
        }

        // Bootstrap ScrollSpy
        if (typeof bootstrap !== 'undefined' && bootstrap.ScrollSpy) {
            var scrollSpy = new bootstrap.ScrollSpy(document.body, {
                target: "#navbar-example",
            });
        }
    });
</script>
@if($get_cookie['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif
@if(!View::hasSection('page_content'))
<script src="{{ asset('assets/landingpage/js/space_shooter.js') }}" defer></script>
@endif
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


    });
</script>
@yield('page_scripts')

<!-- Google Analytics — loaded last for maximum page speed -->
<script>
    window.addEventListener('load', function() {
        var s = document.createElement('script');
        s.src = 'https://www.googletagmanager.com/gtag/js?id=G-JV402RKXVS';
        s.async = true;
        document.head.appendChild(s);
        s.onload = function() {
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-JV402RKXVS');
        };
    });
</script>

<!-- On-site Live Chat widget (all pages) -->
<div id="acw" style="position:fixed;bottom:20px;right:20px;z-index:9999;font-family:inherit;">
    <!-- Chat panel -->
    <div id="acwPanel" style="display:none;flex-direction:column;width:350px;max-width:92vw;height:470px;max-height:72vh;background:#0F1020;border:1px solid #1E293B;border-radius:18px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.5);margin-bottom:14px;">
        <!-- Header -->
        <div style="background:{{ $primary_color }};padding:14px 16px;display:flex;align-items:center;gap:11px;color:#fff;">
            <div style="width:38px;height:38px;border-radius:9999px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="ti ti-messages" style="font-size:20px;"></i>
            </div>
            <div style="flex:1;line-height:1.2;">
                <div style="font-weight:700;font-size:15px;">Animazon Support</div>
                <div style="font-size:11px;opacity:.9;"><span style="display:inline-block;width:7px;height:7px;border-radius:9999px;background:#4ade80;margin-right:5px;"></span>Online · replies in minutes</div>
            </div>
            <button type="button" onclick="acwToggle(false)" aria-label="Close chat" style="background:none;border:none;color:#fff;cursor:pointer;font-size:20px;line-height:1;"><i class="ti ti-x"></i></button>
        </div>
        <!-- Messages -->
        <div id="acwMsgs" style="flex:1;overflow-y:auto;padding:14px;display:flex;flex-direction:column;gap:10px;background:#0A0A0F;"></div>
        <!-- Input -->
        <form id="acwForm" style="display:flex;gap:8px;padding:10px;border-top:1px solid #1E293B;background:#0F1020;">
            <input id="acwInput" type="text" autocomplete="off" placeholder="Type your message…" style="flex:1;background:#0A0A0F;border:1px solid #1E293B;border-radius:9999px;padding:9px 14px;color:#fff;font-size:13px;outline:none;">
            <button type="submit" aria-label="Send" style="background:{{ $primary_color }};border:none;color:#fff;width:40px;height:40px;border-radius:9999px;cursor:pointer;flex-shrink:0;"><i class="ti ti-send" style="font-size:17px;"></i></button>
        </form>
    </div>
    <!-- Bubble -->
    <button type="button" id="acwToggle" onclick="acwToggle()" aria-label="Open live chat"
        style="background:{{ $primary_color }};color:#fff;border:none;cursor:pointer;display:flex;align-items:center;gap:9px;border-radius:9999px;padding:12px 18px;box-shadow:0 10px 30px rgba(0,0,0,.35);margin-left:auto;">
        <i id="acwIcon" class="ti ti-message-circle" style="font-size:22px;"></i>
        <span style="font-weight:700;font-size:14px;white-space:nowrap;">Chat with us</span>
    </button>
</div>
<script>
(function () {
    var WA = @json($wa_link);
    var WA_BASE = 'https://wa.me/' + @json(preg_replace('/\D/', '', $company_whatsapp));
    var TEL = @json('tel:' . preg_replace('/[^0-9+]/', '', $company_phone));
    var EMAIL = @json('mailto:' . ($landing_settings['footer_email'] ?? ''));
    var BRIDGE = @json((bool) config('whatsapp.enabled'));   // WhatsApp Cloud API bridge on?
    var CSRF = @json(csrf_token());
    var SEND_URL = @json(url('/chat/send'));
    var POLL_URL = @json(url('/chat/poll'));
    var opened = false, greeted = false;

    // Persistent per-visitor session id
    var SID = localStorage.getItem('acw_sid');
    if (!SID) { SID = 'web-' + Date.now() + '-' + Math.random().toString(36).slice(2, 8); localStorage.setItem('acw_sid', SID); }
    var lastId = 0, pollTimer = null;

    window.acwToggle = function (force) {
        var panel = document.getElementById('acwPanel');
        var icon = document.getElementById('acwIcon');
        opened = (typeof force === 'boolean') ? force : !opened;
        panel.style.display = opened ? 'flex' : 'none';
        icon.className = opened ? 'ti ti-chevron-down' : 'ti ti-message-circle';
        if (opened && !greeted) { greeted = true; greet(); }
        if (opened) { setTimeout(function(){ var i=document.getElementById('acwInput'); if(i) i.focus(); }, 50); if (BRIDGE) startPoll(); }
        else { stopPoll(); }
    };

    function startPoll() { if (pollTimer) return; poll(); pollTimer = setInterval(poll, 4000); }
    function stopPoll() { if (pollTimer) { clearInterval(pollTimer); pollTimer = null; } }

    function poll() {
        fetch(POLL_URL + '?session_id=' + encodeURIComponent(SID) + '&after=' + lastId, { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data || !data.messages) return;
                data.messages.forEach(function (m) { lastId = m.id; bubble(esc(m.body), 'bot'); });
            })
            .catch(function () {});
    }

    function esc(s){ var d=document.createElement('div'); d.textContent=s; return d.innerHTML; }

    function bubble(text, who) {
        var m = document.getElementById('acwMsgs');
        var b = document.createElement('div');
        if (who === 'user') {
            b.style.cssText = 'align-self:flex-end;max-width:80%;background:{{ $primary_color }};color:#fff;padding:9px 13px;border-radius:14px 14px 4px 14px;font-size:13px;line-height:1.45;';
        } else {
            b.style.cssText = 'align-self:flex-start;max-width:85%;background:#1A1B2E;color:#E2E8F0;padding:9px 13px;border-radius:14px 14px 14px 4px;font-size:13px;line-height:1.45;';
        }
        b.innerHTML = text;
        m.appendChild(b);
        m.scrollTop = m.scrollHeight;
        return b;
    }

    function actions() {
        var m = document.getElementById('acwMsgs');
        var wrap = document.createElement('div');
        wrap.style.cssText = 'display:flex;flex-wrap:wrap;gap:8px;align-self:flex-start;margin-top:2px;';
        wrap.innerHTML =
            '<a href="'+WA+'" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:6px;background:#25D366;color:#fff;padding:8px 13px;border-radius:9999px;font-size:12px;font-weight:600;text-decoration:none;"><i class="ti ti-brand-whatsapp"></i> WhatsApp</a>'+
            '<a href="'+TEL+'" style="display:inline-flex;align-items:center;gap:6px;background:#1A1B2E;color:#E2E8F0;padding:8px 13px;border-radius:9999px;font-size:12px;font-weight:600;text-decoration:none;"><i class="ti ti-phone"></i> Call</a>'+
            '<a href="'+EMAIL+'" style="display:inline-flex;align-items:center;gap:6px;background:#1A1B2E;color:#E2E8F0;padding:8px 13px;border-radius:9999px;font-size:12px;font-weight:600;text-decoration:none;"><i class="ti ti-mail"></i> Email</a>';
        m.appendChild(wrap);
        m.scrollTop = m.scrollHeight;
    }

    function chips() {
        var m = document.getElementById('acwMsgs');
        var wrap = document.createElement('div');
        wrap.style.cssText = 'display:flex;flex-wrap:wrap;gap:7px;align-self:flex-start;';
        ['E-commerce','Business Website','3D Animation','ERP','Custom App'].forEach(function(t){
            var c = document.createElement('button');
            c.type='button'; c.textContent=t;
            c.style.cssText='background:none;border:1px solid {{ $primary_color }};color:{{ $primary_color }};padding:6px 11px;border-radius:9999px;font-size:12px;cursor:pointer;';
            c.onclick=function(){ send(t); };
            wrap.appendChild(c);
        });
        m.appendChild(wrap);
        m.scrollTop = m.scrollHeight;
    }

    function greet() {
        bubble('👋 Hi! Welcome to Animazon. How can we help your business today?', 'bot');
        setTimeout(chips, 250);
    }

    function botReply(topic) {
        var t = topic ? ('<strong>'+esc(topic)+'</strong> — great choice! ') : '';
        bubble(t + 'Our team can help with that. Tap below to talk to us directly — we reply fast.', 'bot');
        setTimeout(actions, 200);
    }

    var noteShown = false;
    function send(text) {
        text = (text || '').trim();
        if (!text) return;
        bubble(esc(text), 'user');
        var i = document.getElementById('acwInput'); if (i) i.value = '';

        if (BRIDGE) {
            // Seamless: relay to owner's WhatsApp, replies come back via poll()
            startPoll();
            fetch(SEND_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: JSON.stringify({ session_id: SID, message: text })
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data && data.bridged === false) { WA = WA_BASE + '?text=' + encodeURIComponent(text); setTimeout(function(){ botReply(''); }, 200); return; }
                if (!noteShown) { noteShown = true; setTimeout(function(){ bubble('✅ Sent! Our team will reply right here in a moment.', 'bot'); }, 300); }
            })
            .catch(function () { WA = WA_BASE + '?text=' + encodeURIComponent(text); setTimeout(function(){ botReply(''); }, 200); });
        } else {
            // Fallback: wa.me handoff
            WA = WA_BASE + '?text=' + encodeURIComponent(text + ' — sent from animazon.tech');
            setTimeout(function(){ botReply(text.length < 24 ? text : ''); }, 350);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        var f = document.getElementById('acwForm');
        if (f) f.addEventListener('submit', function (e) { e.preventDefault(); send(document.getElementById('acwInput').value); });
    });
})();
</script>

</body>
</html>
