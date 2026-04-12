@extends('layouts.landing')

@section('title', 'Mobile App Development | Animazon-Tech')

@section('page_content')
<div class="bg-animazon-black text-animazon-muted font-sans min-h-screen pt-24 pb-12 overflow-x-hidden">
    
    <!-- Hero Section -->
    <section class="relative py-28 overflow-hidden border-b border-animazon-border">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-[800px] h-[400px] bg-primary/20 blur-[150px] mix-blend-screen pointer-events-none rounded-full"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+CjxwYXRoIGQ9Ik0wIDBoNDB2NDBIMHoiIGZpbGw9Im5vbmUiLz4KPHBhdGggZD0iTTAgMGgwLjV2NDBIMHptMCAwaDQwdjAuNUgweiIgZmlsbD0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjA0KSIvPgo8L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)] pointer-events-none opacity-50"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center max-w-5xl">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 text-xs font-semibold tracking-widest uppercase rounded-full text-primary bg-primary/10 border border-primary/30 mb-8 backdrop-blur-md">
                Mobile Applications
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-extrabold tracking-tight mb-8 text-animazon-white leading-[1.1]">
                Apps That Users <br class="hidden md:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Actually Love</span>
            </h1>
            <p class="text-lg md:text-xl text-animazon-muted max-w-3xl mx-auto mb-12 leading-relaxed">
                We build buttery-smooth, natively optimized mobile experiences that keep retention rates high, load times low, and 5-star reviews flowing.
            </p>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto mt-12 bg-animazon-navy/50 backdrop-blur border border-animazon-border p-6 rounded-2xl">
                <div class="text-center">
                    <div class="text-3xl font-bold text-animazon-white mb-1">Native</div>
                    <div class="text-sm font-medium text-animazon-muted uppercase tracking-wider">Swift & Kotlin</div>
                </div>
                <div class="text-center sm:border-l sm:border-r border-animazon-border">
                    <div class="text-3xl font-bold text-animazon-white mb-1">Cross</div>
                    <div class="text-sm font-medium text-animazon-muted uppercase tracking-wider">React Native & Flutter</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-animazon-white mb-1">Top 10</div>
                    <div class="text-sm font-medium text-animazon-muted uppercase tracking-wider">App Store standard</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Development Types Section -->
    <section id="services" class="py-24 bg-animazon-black border-b border-animazon-border relative z-10">
        <div class="container mx-auto px-6 lg:px-8 max-w-7xl">
            <div class="flex flex-col mb-16 text-center mx-auto max-w-3xl">
                <h4 class="text-primary text-sm font-semibold tracking-widest uppercase mb-3">Our Expertise</h4>
                <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-animazon-white mb-6">Every mobile capability</h2>
                <p class="text-lg text-animazon-muted leading-relaxed mx-auto">
                    We select the right engineering approach based on your budget, timeline, and feature requirements. We don't just write code, we engineer scalable mobile products.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Native iOS -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-gray-500/10 border border-gray-500/30 rounded-xl flex items-center justify-center mb-6 text-gray-400 group-hover:scale-110 group-hover:bg-gray-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 20.94c1.5 0 2.75 1.06 4 1.06 3 0 6-8 6-12.22A4.91 4.91 0 0 0 17 5c-2.22 0-4 1.44-5 2-1-.56-2.78-2-5-2a4.9 4.9 0 0 0-5 4.78C2 14 5 22 8 22c1.25 0 2.5-1.06 4-1.06Z"/><path d="M10 2c1 .5 2 2 2 5"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">Apple Ecosystem</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Native iOS</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        Built from the ground up using Swift and SwiftUI to leverage the absolute maximum power of the Apple ecosystem.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> iPhone, iPad, and Apple Watch</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> ARKit & CoreML integration</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Apple Pay & StoreKit IAP</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Hardware accessories (BLE)</li>
                    </ul>
                </div>

                <!-- Native Android -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center justify-center mb-6 text-green-400 group-hover:scale-110 group-hover:bg-green-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="2" width="14" height="20" rx="2"/><circle cx="12" cy="18" r="1"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">Google Ecosystem</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Native Android</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        Optimised for fragmentation. We use Kotlin to build Android architectures that run smoothly on 10,000+ different devices.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Phones, Tablets, Android Auto</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Custom hardware integrations</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Google Pay & Subscriptions</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Background services optimization</li>
                    </ul>
                </div>

                <!-- Cross platform -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-blue-500/10 border border-blue-500/30 rounded-xl flex items-center justify-center mb-6 text-blue-400 group-hover:scale-110 group-hover:bg-blue-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18s-3-3-3-9 3-9 3-9 3 3 3 9-3 9-3 9Z"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">Hybrid approach</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Cross-platform</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        Using React Native or Flutter, we deliver identical iOS and Android logic from a single codebase—speeding up time to market.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Flutter (Dart) engineering</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> React Native development</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> 50% faster MVP launches</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Unified QA and maintenance</li>
                    </ul>
                </div>

                <!-- API & Backend -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-purple-500/10 border border-purple-500/30 rounded-xl flex items-center justify-center mb-6 text-purple-400 group-hover:scale-110 group-hover:bg-purple-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 14.899A7 7 0 1 1 20 14.9"/><path d="M12 21.5v-7.106"/><path d="M16 11.5a4 4 0 1 0-8 0"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">The Brains</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Mobile backends</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        Apps are nothing without data. We build secure, low-latency APIs infrastructure to power your application's logic.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> REST & GraphQL API design</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Real-time WebSockets</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Push notification microservices</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Secure cloud architecture</li>
                    </ul>
                </div>

                <!-- UI/UX Design -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-pink-500/10 border border-pink-500/30 rounded-xl flex items-center justify-center mb-6 text-pink-400 group-hover:scale-110 group-hover:bg-pink-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">Visual Logic</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">UI/UX App Design</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        Before a line of code is written, we map user journeys and create high-fidelity interactive prototypes to test assumptions.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Human Interface Guidelines adherence</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Material Design compliance</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Micro-interactions & animations</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Interactive Figma prototypes</li>
                    </ul>
                </div>

                <!-- App Store Optimization -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-orange-500/10 border border-orange-500/30 rounded-xl flex items-center justify-center mb-6 text-orange-400 group-hover:scale-110 group-hover:bg-orange-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">Growth</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">App Store Publishing</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        We handle the entire maze of App Store and Google Play publishing, ensuring approval on the very first submission.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> App Store Optimization (ASO)</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Fast-track review compliance</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Privacy manifest generation</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Promotional screenshot design</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Industries Section -->
    <section class="py-24 bg-animazon-black border-b border-animazon-border">
        <div class="container mx-auto px-6 lg:px-8 max-w-7xl">
            <div class="flex flex-col mb-16 text-center mx-auto max-w-3xl">
                <h4 class="text-primary text-sm font-semibold tracking-widest uppercase mb-3">Industries & applications</h4>
                <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-animazon-white mb-6">Apps that run operations</h2>
                <p class="text-lg text-animazon-muted leading-relaxed mx-auto">
                    We've built applications for practically every vertical. Here's a snapshot of the complex mobile solutions we architect.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

                <!-- Startups -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-teal-500"></div>
                        <h3 class="text-xl font-bold text-animazon-white">Startup MVPs</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Validating a new business idea? We build core value applications designed to secure pre-seed and seed funding rounds.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Core loop iteration</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Firebase/Supabase architecture</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Onboarding drops analysis</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Pitch-ready UI Polish</span>
                    </div>
                </div>

                <!-- Logistics & Delivery -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <h3 class="text-xl font-bold text-animazon-white">Logistics & on-demand</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Uber-style applications that connect supply, demand, and operations through complex geopolitical tracking algorithms.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">3-App ecosystem (User, Driver, Admin)</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Live map tracking & ETA</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Dynamic dispatch algorithms</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Stripe Connect split payments</span>
                    </div>
                </div>

                <!-- E-Commerce -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <h3 class="text-xl font-bold text-animazon-white">M-Commerce apps</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Turn browsers into buyers. E-commerce applications converting at 3x the rate of mobile-optimized websites.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Headless Shopify/Magento</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">One-tap Apple/Google Pay</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Cart abandonment push notes</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Loyalty & barcode scannning</span>
                    </div>
                </div>

                <!-- Healthcare -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <h3 class="text-xl font-bold text-animazon-white">Healthcare (mHealth)</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Secure, HIPAA-compliant patient portals, doctor booking apps, and IoT integrated fitness tracking algorithms.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Telemedicine video calls</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">EHR / EMR integration</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">HealthKit & Google Fit</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Prescription scanning endpoints</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-24 bg-animazon-black relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[800px] h-[400px] bg-primary/10 blur-[150px] pointer-events-none rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="max-w-4xl mx-auto bg-animazon-navy border border-animazon-border rounded-3xl p-10 md:p-16 backdrop-blur-md flex flex-col items-center">
                <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-animazon-white mb-6">Ready to build your app?</h2>
                <p class="text-lg text-animazon-muted leading-relaxed mb-10 max-w-2xl">
                    Whether you need an MVP or a complex enterprise app, our team will respond within one business day with a tailored estimate.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <a href="{{ route('cost-calculator.public') }}?service=app" class="group relative inline-flex items-center justify-center px-8 py-4 text-base font-bold text-animazon-white transition-all duration-200 bg-primary rounded-xl focus:outline-none hover:opacity-90 overflow-hidden shadow-lg shadow-primary/30 w-full sm:w-auto">
                        <span class="relative z-10 flex items-center gap-2">
                            Calculate Cost
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                    </a>
                    <a href="{{ route('portfolio.public') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-animazon-white transition-all duration-200 bg-transparent border border-animazon-border rounded-xl hover:bg-animazon-border/50 focus:outline-none w-full sm:w-auto">
                        View portfolio &nearr;
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
