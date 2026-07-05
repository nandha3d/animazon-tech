@extends('layouts.landing')

@section('page_content')
<section class="py-24 bg-animazon-black text-animazon-white min-h-screen relative overflow-hidden">
    <!-- background effect -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-primary/10 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-1/4 left-1/4 w-64 h-64 bg-indigo-500/10 rounded-full blur-[80px] animate-pulse" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10 mt-12">
        <div class="max-w-3xl mx-auto text-center mb-16 animate__animated animate__fadeInUp">
            <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-4">INSIGHTS & NEWS</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                Our <span class="text-primary italic">Services Blog</span>
            </h1>
            <p class="text-xl text-animazon-muted">
                Real talk for local businesses on going digital — e-commerce, websites, 3D product animation, ERP, and custom apps that actually grow your sales.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
            <!-- Blog Article: Why Local Business Needs Digital -->
            <article class="bg-animazon-navy rounded-2xl overflow-hidden border border-animazon-border/50 hover:border-primary/50 transition-colors duration-300 animate__animated animate__fadeInUp md:col-span-2" style="animation-delay: 0.1s">
                <a href="{{ route('blog.local-business-growth') }}" class="block aspect-video relative overflow-hidden bg-animazon-black group">
                    <img src="{{ asset('assets/images/services/cat-website.webp') }}" alt="Why local businesses need a digital partner" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                </a>
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-4 mb-4 text-sm">
                        <span class="text-primary font-bold">For Local Businesses</span>
                        <span class="text-animazon-muted"><i class="ti ti-clock mr-1"></i> 8 min read</span>
                    </div>
                    <a href="{{ route('blog.local-business-growth') }}" class="block">
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-3 hover:text-primary transition-colors cursor-pointer">Why Your Local Business Needs a Digital Partner Today</h3>
                    </a>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        E-commerce, business websites, 3D product animation, ERP, and custom apps — here is exactly why the shops, factories, and traders in our city are quietly becoming our biggest growth stories.
                    </p>
                    <a href="{{ route('blog.local-business-growth') }}" class="text-primary font-medium hover:text-white transition-colors flex items-center group">
                        Read Article <i class="ti ti-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>
        </div>
    </div>
</section>
@endsection
