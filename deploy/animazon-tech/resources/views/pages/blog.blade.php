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
                Our <span class="text-primary italic">Blog</span>
            </h1>
            <p class="text-xl text-animazon-muted">
                Stay updated with the latest trends, technologies, and our process in building premium digital experiences.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Blog Article 1 -->
            <article class="bg-animazon-navy rounded-2xl overflow-hidden border border-animazon-border/50 hover:border-primary/50 transition-colors duration-300 animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                <div class="aspect-video relative overflow-hidden bg-animazon-black">
                    <img src="{{ asset('assets/images/landing/hero/hero-bg.jpg') }}" alt="Blog 1" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4 text-sm">
                        <span class="text-primary font-bold">Tech Insight</span>
                        <span class="text-animazon-muted"><i class="ti ti-calendar mr-1"></i> Oct 24, 2024</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 hover:text-primary transition-colors cursor-pointer">The Future of Web Applications in 2025</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        Explore the upcoming paradigms in frontend development, from server components to edge computing, and how they will shape user experiences.
                    </p>
                    <a href="#" class="text-primary font-medium hover:text-white transition-colors flex items-center group">
                        Read Article <i class="ti ti-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>

            <!-- Blog Article 2 -->
            <article class="bg-animazon-navy rounded-2xl overflow-hidden border border-animazon-border/50 hover:border-primary/50 transition-colors duration-300 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                <div class="aspect-video relative overflow-hidden bg-animazon-black">
                    <img src="{{ asset('assets/images/landing/hero/hero-3d.jpg') }}" alt="Blog 2" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4 text-sm">
                        <span class="text-primary font-bold">3D Design</span>
                        <span class="text-animazon-muted"><i class="ti ti-calendar mr-1"></i> Oct 18, 2024</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 hover:text-primary transition-colors cursor-pointer">Bridging Realism and Performance in WebGL</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        How our creative team optimizes high-fidelity 3D models for seamless integration into modern web and mobile platforms.
                    </p>
                    <a href="#" class="text-primary font-medium hover:text-white transition-colors flex items-center group">
                        Read Article <i class="ti ti-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>

            <!-- Blog Article 3 -->
            <article class="bg-animazon-navy rounded-2xl overflow-hidden border border-animazon-border/50 hover:border-primary/50 transition-colors duration-300 animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
                <div class="aspect-video relative overflow-hidden bg-animazon-black">
                    <img src="{{ asset('assets/images/landing/hero/hero-app.jpg') }}" alt="Blog 3" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4 text-sm">
                        <span class="text-primary font-bold">Engineering</span>
                        <span class="text-animazon-muted"><i class="ti ti-calendar mr-1"></i> Oct 12, 2024</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 hover:text-primary transition-colors cursor-pointer">Microservice Architecture Best Practices</h3>
                    <p class="text-animazon-muted text-sm leading-relaxed mb-6">
                        A deep dive into our backend structuring principles, ensuring systems remain scalable, resilient, and ready for enterprise demands.
                    </p>
                    <a href="#" class="text-primary font-medium hover:text-white transition-colors flex items-center group">
                        Read Article <i class="ti ti-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>
        </div>
    </div>
</section>
@endsection
