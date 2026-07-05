@extends('layouts.landing')

@section('page_content')
<section class="py-24 bg-animazon-black text-animazon-white min-h-screen relative overflow-hidden">
    <!-- background effect -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-primary/10 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-1/4 left-1/4 w-64 h-64 bg-indigo-500/10 rounded-full blur-[80px] animate-pulse" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10 mt-12 max-w-4xl">
        <div class="animate__animated animate__fadeInUp">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center text-primary hover:text-white transition-colors mb-8 group">
                <i class="ti ti-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Back to Blog
            </a>

            <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-4">For Local Businesses</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                Why Your Local Business Needs a <span class="text-primary italic">Digital Partner</span> Today
            </h1>

            <p class="text-xl text-animazon-muted mb-8 leading-relaxed">
                E-commerce, business websites, 3D product animation, ERP, custom apps — here is why the shops, factories,
                and traders in our own city are quietly becoming our biggest growth stories.
            </p>

            <div class="flex items-center gap-4 text-animazon-muted text-sm mb-12 border-b border-animazon-border/50 pb-8">
                <span><i class="ti ti-calendar mr-1"></i> Jun 26, 2026</span>
                <span><i class="ti ti-clock mr-1"></i> 8 min read</span>
                <span><i class="ti ti-user mr-1"></i> Animazon Tech Team</span>
            </div>

            <div class="aspect-video relative overflow-hidden rounded-2xl bg-animazon-black mb-12 shadow-2xl shadow-primary/10">
                <img src="{{ asset('assets/images/services/cat-website.webp') }}" alt="Local business going digital with Animazon Tech" class="w-full h-full object-cover">
            </div>

            <article class="prose prose-invert prose-lg max-w-none prose-headings:text-white prose-a:text-primary hover:prose-a:text-primary/80">
                <p>
                    Your customers are already online. They search before they walk in. They compare before they call.
                    They trust a clean website and a sharp product video more than the loudest hoarding on the highway.
                    The question is no longer <em>whether</em> your business should go digital — it is <strong>how fast,
                    and with whom.</strong>
                </p>
                <p>
                    At <strong>Animazon Tech</strong>, we are a local team that speaks your language and understands your
                    market. We do not hand you jargon and disappear. We build the digital backbone your business runs on —
                    and we stay close enough to fix, grow, and support it.
                </p>

                <h2>1. E-commerce — Sell While You Sleep</h2>
            </article>

            <div class="grid md:grid-cols-2 gap-6 my-10 not-prose">
                <div class="rounded-2xl overflow-hidden border border-animazon-border/50">
                    <img src="{{ asset('assets/images/pricing/webapp1.jpg') }}" alt="E-commerce storefront" class="w-full h-56 object-cover">
                </div>
                <div class="rounded-2xl overflow-hidden border border-animazon-border/50">
                    <img src="{{ asset('assets/images/pricing/mobileapp.jpg') }}" alt="Mobile shopping experience" class="w-full h-56 object-cover">
                </div>
            </div>

            <article class="prose prose-invert prose-lg max-w-none prose-headings:text-white prose-a:text-primary hover:prose-a:text-primary/80">
                <p>
                    A physical shop earns when its doors are open. An online store earns at 2 AM, on a holiday, from the next
                    city. We build fast, secure storefronts with proper product catalogs, online payments (UPI, cards,
                    wallets), inventory tracking, and order management — so the whole machine runs without you babysitting it.
                </p>
                <ul>
                    <li><strong>Reach beyond your street:</strong> Sell to the whole region, not just the people who pass by.</li>
                    <li><strong>Trusted checkout:</strong> Integrated Razorpay / UPI / card payments your customers already use.</li>
                    <li><strong>Know your numbers:</strong> Real-time stock, sales, and best-seller reports on one dashboard.</li>
                </ul>

                <h2>2. Business Website — Your 24/7 First Impression</h2>
                <p>
                    Most customers judge your business in the first eight seconds of seeing your website. A slow, outdated, or
                    missing site quietly sends them to a competitor. A clean, fast, mobile-first website does the opposite —
                    it builds trust before you even pick up the phone.
                </p>
                <ul>
                    <li><strong>Found on Google:</strong> SEO-ready pages so locals searching your service actually find <em>you</em>.</li>
                    <li><strong>Looks premium everywhere:</strong> Perfect on mobile, tablet, and desktop.</li>
                    <li><strong>Leads, not just visits:</strong> Enquiry forms, WhatsApp click-to-chat, and call buttons that convert.</li>
                </ul>
            </article>

            <div class="rounded-2xl overflow-hidden border border-animazon-border/50 my-10 not-prose shadow-xl shadow-primary/10">
                <img src="{{ asset('assets/images/services/saas-webapp.webp') }}" alt="Modern business website and web application" class="w-full object-cover">
            </div>

            <article class="prose prose-invert prose-lg max-w-none prose-headings:text-white prose-a:text-primary hover:prose-a:text-primary/80">
                <h2>3. 3D Product Animation — Show, Don't Just Tell</h2>
                <p>
                    Whether you make machinery, furniture, jewellery, packaging, or industrial parts, a flat photo can only say
                    so much. A <strong>3D product animation</strong> lets a customer spin your product, see it work, look inside
                    it, and understand its value — without ever holding it. It is the single most persuasive tool for a product
                    that needs explaining.
                </p>
                <ul>
                    <li><strong>Explain complex products instantly:</strong> Show how it assembles, works, or fits together.</li>
                    <li><strong>Look bigger than you are:</strong> Cinematic visuals make small manufacturers look like premium brands.</li>
                    <li><strong>One asset, everywhere:</strong> Use the same animation on your site, ads, WhatsApp, and trade shows.</li>
                </ul>
            </article>

            <div class="grid md:grid-cols-3 gap-6 my-10 not-prose">
                <div class="rounded-2xl overflow-hidden border border-animazon-border/50">
                    <img src="{{ asset('assets/images/services/3d-modeling.webp') }}" alt="3D product modeling" class="w-full h-48 object-cover">
                </div>
                <div class="rounded-2xl overflow-hidden border border-animazon-border/50">
                    <img src="{{ asset('assets/images/services/3d-animation-video.webp') }}" alt="3D product animation render" class="w-full h-48 object-cover">
                </div>
                <div class="rounded-2xl overflow-hidden border border-animazon-border/50">
                    <img src="{{ asset('assets/images/services/cat-3d-animation.webp') }}" alt="3D animation showcase" class="w-full h-48 object-cover">
                </div>
            </div>

            <article class="prose prose-invert prose-lg max-w-none prose-headings:text-white prose-a:text-primary hover:prose-a:text-primary/80">
                <h2>4. ERP — Run the Whole Business From One Screen</h2>
                <p>
                    Spreadsheets break. WhatsApp orders get lost. The accountant, the store, and the sales team each keep their
                    own version of the truth. An <strong>ERP system</strong> built around how <em>your</em> business actually
                    works puts inventory, billing, purchases, staff, and accounts in one place — so nothing falls through the
                    cracks as you grow.
                </p>
                <ul>
                    <li><strong>One source of truth:</strong> Stock, invoices, payments, and ledgers always in sync.</li>
                    <li><strong>Faster decisions:</strong> Live dashboards instead of waiting for month-end reports.</li>
                    <li><strong>Built for you:</strong> We tailor the workflow to your trade — not force you into someone else's template.</li>
                </ul>
            </article>

            <div class="grid md:grid-cols-2 gap-6 my-10 not-prose">
                <div class="rounded-2xl overflow-hidden border border-animazon-border/50 bg-animazon-navy p-4">
                    <img src="{{ asset('assets/images/front/img-crm-dash-1.svg') }}" alt="ERP dashboard overview" class="w-full object-contain">
                </div>
                <div class="rounded-2xl overflow-hidden border border-animazon-border/50 bg-animazon-navy p-4">
                    <img src="{{ asset('assets/images/front/img-crm-dash-3.svg') }}" alt="ERP analytics view" class="w-full object-contain">
                </div>
            </div>

            <article class="prose prose-invert prose-lg max-w-none prose-headings:text-white prose-a:text-primary hover:prose-a:text-primary/80">
                <h2>5. Custom Applications — When Off-the-Shelf Just Won't Fit</h2>
                <p>
                    Every business has that one process no ready-made software handles — a booking flow, a field-team app, a
                    distributor portal, a job-card system. That is where <strong>custom applications</strong> earn their keep.
                    We build exactly what you need, on web and mobile, so technology bends around your business instead of the
                    other way around.
                </p>
                <ul>
                    <li><strong>Solve your exact problem:</strong> Software shaped to your real workflow, not a compromise.</li>
                    <li><strong>Web + mobile:</strong> Your team and customers stay connected from anywhere.</li>
                    <li><strong>Grows with you:</strong> Add features as your business changes — it is your platform.</li>
                </ul>

                <h2>Why Choose a <span class="text-primary">Local</span> Partner?</h2>
                <p>
                    You could hire an agency three time zones away. But when a payment gateway fails on a festival weekend, or a
                    customer can't place an order, you want someone who picks up the phone and understands your market — not a
                    support ticket in a queue. We are that team.
                </p>
                <ul>
                    <li><strong>We meet you in person.</strong> Real conversations, not just emails.</li>
                    <li><strong>We know the local market</strong> — payment habits, customer expectations, language.</li>
                    <li><strong>One partner, every service:</strong> Website, store, 3D, ERP, apps — under one roof, one accountable team.</li>
                    <li><strong>We stay after launch.</strong> Support, updates, and growth — not disappear after the invoice.</li>
                </ul>

                <h2>The Bottom Line</h2>
                <p>
                    Going digital is not an expense — it is the lowest-cost salesperson, showroom, and back-office you will ever
                    hire. The businesses pulling ahead in our region are not always the biggest. They are the ones that showed up
                    online first, looked professional, and made it easy to buy. We help you become one of them.
                </p>

                <div class="mt-12 bg-animazon-navy p-6 sm:p-8 rounded-2xl border border-primary/30 text-center not-prose">
                    <h3 class="text-xl sm:text-2xl font-bold mb-4 mt-0 text-white">Let's Grow Your Business Together</h3>
                    <p class="text-animazon-muted mb-6 text-sm sm:text-base">Free consultation — tell us your goals, we'll show you exactly how digital can pay for itself.</p>
                    <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4 justify-center">
                        <a href="{{ $wa_link }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 bg-[#25D366] text-white font-bold py-3 px-6 sm:px-8 rounded-full hover:bg-[#1ebe57] transition-colors shadow-lg shadow-[#25D366]/20 hover:shadow-[#25D366]/40">
                            <i class="ti ti-brand-whatsapp text-lg"></i> Chat on WhatsApp
                        </a>
                        <a href="{{ route('portfolio.public') }}" class="inline-flex items-center justify-center bg-transparent border border-primary/50 text-primary font-bold py-3 px-6 sm:px-8 rounded-full hover:bg-primary/10 transition-colors">
                            See Our Work
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
@endsection
