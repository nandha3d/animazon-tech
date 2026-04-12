@extends('layouts.landing')

@section('title', 'Enterprise Web Development | Animazon-Tech')

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
                Web Development
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-extrabold tracking-tight mb-8 text-animazon-white leading-[1.1]">
                Scalable, Secure <br class="hidden md:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Web Experiences</span>
            </h1>
            <p class="text-lg md:text-xl text-animazon-muted max-w-3xl mx-auto mb-12 leading-relaxed">
                From simple business websites to complex SaaS platforms &mdash; we scope, design, and develop the right solution for your stage and goals.
            </p>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto mt-12 bg-animazon-navy/50 backdrop-blur border border-animazon-border p-6 rounded-2xl">
                <div class="text-center">
                    <div class="text-3xl font-bold text-animazon-white mb-1">200+</div>
                    <div class="text-sm font-medium text-animazon-muted uppercase tracking-wider">Deployments</div>
                </div>
                <div class="text-center sm:border-l sm:border-r border-animazon-border">
                    <div class="text-3xl font-bold text-animazon-white mb-1">99.9%</div>
                    <div class="text-sm font-medium text-animazon-muted uppercase tracking-wider">Uptime SLA</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-animazon-white mb-1">10+</div>
                    <div class="text-sm font-medium text-animazon-muted uppercase tracking-wider">Industries served</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Development Types Section -->
    <section id="services" class="py-24 bg-animazon-black border-b border-animazon-border relative z-10">
        <div class="container mx-auto px-6 lg:px-8 max-w-7xl">
            <div class="flex flex-col mb-16 text-center mx-auto max-w-3xl">
                <h4 class="text-primary text-sm font-semibold tracking-widest uppercase mb-3">Our Expertise</h4>
                <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-animazon-white mb-6">Every type of website we build</h2>
                <p class="text-lg text-animazon-muted leading-relaxed mx-auto">
                    We don't just use templates. We write clean, semantic, and highly optimized code utilizing modern stacks to guarantee high uptime and fast speeds.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Corporate & business websites -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-blue-500/10 border border-blue-500/30 rounded-xl flex items-center justify-center mb-6 text-blue-400 group-hover:scale-110 group-hover:bg-blue-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">Business websites</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Corporate & business websites</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        Professional multi-page websites that represent your brand, communicate credibility, and drive enquiries.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Home, about, services, and contact</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Team and leadership profiles</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Case studies and testimonials</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Lead capture forms and CRM integration</li>
                    </ul>
                </div>

                <!-- SaaS & tech products -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-purple-500/10 border border-purple-500/30 rounded-xl flex items-center justify-center mb-6 text-purple-400 group-hover:scale-110 group-hover:bg-purple-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 17l6-6-6-6M12 19h8"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">SaaS & tech products</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">SaaS marketing sites</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        High-converting websites for software products designed to communicate complex value and drive sign-ups.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Product landing pages & feature breakdowns</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Pricing page strategy and design</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Interactive demos and product tours</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Documentation and integration pages</li>
                    </ul>
                </div>

                <!-- E-commerce websites -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center justify-center mb-6 text-green-400 group-hover:scale-110 group-hover:bg-green-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">Online stores</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">E-commerce websites</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        Full-featured online stores optimized for conversion, repeat purchases, and seamless checkout flows.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Custom and headless e-commerce</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Custom product pages and collections</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Inventory and order management</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Abandoned cart and email flow setup</li>
                    </ul>
                </div>

                <!-- Web portals -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-orange-500/10 border border-orange-500/30 rounded-xl flex items-center justify-center mb-6 text-orange-400 group-hover:scale-110 group-hover:bg-orange-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">Portals & platforms</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Web portals & client portals</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        Authenticated web apps for clients or internal teams. Built with role-based access, dashboards, and reporting.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Login, role-based access control</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Client dashboards and reporting</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Document upload and management</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Booking, approvals, and activity feeds</li>
                    </ul>
                </div>

                <!-- Blog, news & content -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-red-500/10 border border-red-500/30 rounded-xl flex items-center justify-center mb-6 text-red-400 group-hover:scale-110 group-hover:bg-red-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">Content & media</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Blog, news & content</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        Content-first websites optimized for SEO, readability, and audience growth with a CMS your editors will love.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Custom blog and article templates</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Category, tag, and author pages</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Newsletter subscription integration</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> RSS feed and content syndication</li>
                    </ul>
                </div>

                <!-- PWAs -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-pink-500/10 border border-pink-500/30 rounded-xl flex items-center justify-center mb-6 text-pink-400 group-hover:scale-110 group-hover:bg-pink-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">Mobile-first</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Progressive web apps (PWA)</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        App-like experiences delivered through the browser. PWAs work offline, load instantly, and can be installed on any device.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Offline-first architecture</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Push notification support</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Home screen installability</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> App-like navigation and transitions</li>
                    </ul>
                </div>

                <!-- Landing Pages -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-lime-500/10 border border-lime-500/30 rounded-xl flex items-center justify-center mb-6 text-lime-400 group-hover:scale-110 group-hover:bg-lime-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">Lead generation</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Landing pages & campaigns</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        Single-purpose pages engineered to convert. Used for paid campaigns, product launches, event registrations.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Above-the-fold headline & CTA strategy</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Social proof and trust signals</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Multi-step forms and lead scoring</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> A/B testing infrastructure</li>
                    </ul>
                </div>

                <!-- Redesign -->
                <div class="group bg-animazon-navy backdrop-blur-sm border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                    <div class="w-12 h-12 bg-cyan-500/10 border border-cyan-500/30 rounded-xl flex items-center justify-center mb-6 text-cyan-400 group-hover:scale-110 group-hover:bg-cyan-500/20 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-primary/70 uppercase tracking-widest mb-2">Redesign & migration</div>
                    <h3 class="text-xl font-bold text-animazon-white mb-3 group-hover:text-primary transition-colors">Redesign & platform migration</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        We audit, redesign, and migrate your outdated or slow website &mdash; preserving SEO and improving performance.
                    </p>
                    <ul class="space-y-2 text-sm text-animazon-muted">
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Full UX and performance audit</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Content migration and restructuring</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> 301 redirect mapping & SEO preservation</li>
                        <li class="flex items-start gap-2"><span class="text-animazon-border mt-1">&mdash;</span> Speed and Core Web Vitals improvement</li>
                    </ul>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Industries Section -->
    <section class="py-24 bg-animazon-black border-b border-animazon-border">
        <div class="container mx-auto px-6 lg:px-8 max-w-7xl">
            <div class="flex flex-col mb-16 text-center mx-auto max-w-3xl">
                <h4 class="text-primary text-sm font-semibold tracking-widest uppercase mb-3">Industries & solutions</h4>
                <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-animazon-white mb-6">What we build for your industry</h2>
                <p class="text-lg text-animazon-muted leading-relaxed mx-auto">
                    We don't deliver generic websites. Every industry has unique goals, compliance needs, and user behaviours. Look at what we solve for your sector.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

                <!-- Professional services -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                        <h3 class="text-xl font-bold text-animazon-white">Professional services</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Law firms, consultancies, accounting, and finance businesses need to convey authority and generate qualified leads online.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Attorney profiles</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Practice area pages</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Client intake forms</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Secure portals</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">GDPR-compliant flows</span>
                    </div>
                </div>

                <!-- E-commerce & retail -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <h3 class="text-xl font-bold text-animazon-white">E-commerce & retail</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        DTC brands, multi-brand retailers, and marketplaces need fast, conversion-optimised stores that work on every device.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Product catalogues</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Custom Shopify themes</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Subscription commerce</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Loyalty integration</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Multi-warehouse inventory</span>
                    </div>
                </div>

                <!-- SaaS & technology -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-indigo-500"></div>
                        <h3 class="text-xl font-bold text-animazon-white">SaaS & technology</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Software companies need marketing sites that explain complex products simply and turn visitors into free-trial users.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Product marketing sites</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Interactive demos</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Pricing pages</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Documentation portals</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Trial sign-up flows</span>
                    </div>
                </div>

                <!-- Healthcare & wellness -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <h3 class="text-xl font-bold text-animazon-white">Healthcare & wellness</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Clinics, practitioners, and health platforms need trustworthy, accessible sites that make it easy to book and find care.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Online booking</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Specialist profiles</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Telehealth pages</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Patient education</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">HIPAA-aware forms</span>
                    </div>
                </div>

                <!-- Real estate & property -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-orange-600"></div>
                        <h3 class="text-xl font-bold text-animazon-white">Real estate & property</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Agencies, developers, and property platforms need listing-rich sites that generate buyer and seller enquiries at scale.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Property portals</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Search & filters</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Virtual tours</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Agent profiles</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Valuation requests</span>
                    </div>
                </div>

                <!-- Education & e-learning -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-lime-500"></div>
                        <h3 class="text-xl font-bold text-animazon-white">Education & e-learning</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Schools, universities, and training providers need sites that enrol students and deliver content reliably.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Course catalogues</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Student portals</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">LMS integrations</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Event/webinar pages</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Certifications</span>
                    </div>
                </div>

                <!-- Hospitality & food -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-pink-600"></div>
                        <h3 class="text-xl font-bold text-animazon-white">Hospitality & food</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Restaurants, hotels, cafes, and event venues need visually rich sites that drive reservations, orders, and direct bookings.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Online reservations</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Digital menus</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Food delivery integration</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Room booking</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Gift vouchers</span>
                    </div>
                </div>

                <!-- Non-profit & NGO -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-rose-800"></div>
                        <h3 class="text-xl font-bold text-animazon-white">Non-profit & NGO</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Charities and foundations need compelling digital presences that communicate impact, build trust, and drive donations.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Donation pages</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Impact reporting</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Volunteer sign-ups</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Fundraiser pages</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Grant portals</span>
                    </div>
                </div>

                <!-- Manufacturing & B2B -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-gray-500"></div>
                        <h3 class="text-xl font-bold text-animazon-white">Manufacturing & B2B</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Industrial businesses need sites that support long sales cycles, showcase capabilities, and generate qualified RFQs.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Product spec pages</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">RFQ forms</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Dealer locators</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Catalogue downloads</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Partner portals</span>
                    </div>
                </div>

                <!-- Startups & new ventures -->
                <div class="bg-animazon-navy/40 border border-animazon-border rounded-2xl p-8 hover:bg-animazon-navy transition-colors">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 rounded-full bg-teal-500"></div>
                        <h3 class="text-xl font-bold text-animazon-white">Startups & new ventures</h3>
                    </div>
                    <p class="text-animazon-muted text-sm mb-6 leading-relaxed">
                        Early-stage companies need launch-ready websites fast — to attract investors, early customers, and talent.
                    </p>
                    <div class="mb-3 text-xs font-bold text-animazon-white/50 uppercase tracking-widest">Solutions we deliver</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">MVP landing pages</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Waitlist systems</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Digital pitch decks</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Product teasers</span>
                        <span class="px-3 py-1.5 bg-animazon-black border border-animazon-border rounded-full text-xs text-animazon-muted hover:border-primary/30 transition-colors">Media kits</span>
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
                <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-animazon-white mb-6">Ready to bring your vision to life?</h2>
                <p class="text-lg text-animazon-muted leading-relaxed mb-10 max-w-2xl">
                    Tell us about your project — our team will respond within one business day with a tailored proposal.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <a href="{{ route('cost-calculator.public') }}?service=web" class="group relative inline-flex items-center justify-center px-8 py-4 text-base font-bold text-animazon-white transition-all duration-200 bg-primary rounded-xl focus:outline-none hover:opacity-90 overflow-hidden shadow-lg shadow-primary/30 w-full sm:w-auto">
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

