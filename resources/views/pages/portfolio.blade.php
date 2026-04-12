@extends('layouts.landing')

@section('page_content')
<section class="py-24 bg-animazon-black text-animazon-white min-h-screen relative overflow-hidden">
    <!-- Starfield/Glow background effect -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/10 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-teal-500/10 rounded-full blur-[80px] animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10 mt-12">
        <div class="max-w-3xl mx-auto text-center mb-16 animate__animated animate__fadeInUp">
            <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-4">OUR WORK</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                Creative <span class="text-primary italic">Portfolio</span>
            </h1>
            <p class="text-xl text-animazon-muted">
                Explore a showcase of our finest 3D animations, web applications, games, and mobile solutions, crafted with precision and passion.
            </p>
        </div>

        @php
            $settings = \Modules\LandingPage\Entities\LandingPageSetting::settings();
            $portfolios = json_decode($settings['portfolios'] ?? '[]', true) ?? [];
            
            // Group by category
            $grouped = [];
            foreach ($portfolios as $item) {
                $cat = $item['category'] ?? 'Other';
                $grouped[$cat][] = $item;
            }
            
            // Category config: order, icon, accent color, desc
            $catConfig = [
                'Websites' => ['icon' => 'ti-world', 'accent' => 'orange', 'desc' => 'High-performance websites and web applications built for conversion and scale.'],
                '3D Animation' => ['icon' => 'ti-3d-cube-sphere', 'accent' => 'primary', 'desc' => 'Photorealistic 3D visualizations and animations that bring your ideas to life.'],
                'Game Development' => ['icon' => 'ti-device-gamepad-2', 'accent' => 'cyan', 'desc' => 'Immersive gaming experiences for mobile, desktop, and web platforms.'],
                'Mobile Applications' => ['icon' => 'ti-device-mobile', 'accent' => 'emerald', 'desc' => 'Native and cross-platform mobile apps with premium user experience.'],
            ];
            
            // Enforce order for known categories
            $orderedCats = ['Websites', '3D Animation', 'Game Development', 'Mobile Applications'];
            
            // Include any dynamic categories not in the hardcoded list
            $existingCats = array_keys($grouped);
            $otherCats = array_diff($existingCats, $orderedCats);
            $orderedCats = array_merge($orderedCats, $otherCats);
        @endphp

        @if(count($portfolios) > 0)
            @foreach($orderedCats as $catName)
                @if(isset($grouped[$catName]) && count($grouped[$catName]) > 0)
                    @php
                        $cfg = $catConfig[$catName] ?? ['icon' => 'ti-photo', 'accent' => 'primary', 'desc' => ''];
                        $accent = $cfg['accent'];
                        $items = $grouped[$catName];
                    @endphp

                    <!-- {{ $catName }} Section -->
                    <div class="mb-20 last:mb-0 animate__animated animate__fadeInUp">
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
                                                     onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\\'w-full h-full bg-gradient-to-br from-orange-900/30 to-animazon-black flex items-center justify-center\\'><i class=\\'ti ti-world text-5xl text-orange-400/50\\'></i></div>';">
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
                                                    <button class="w-16 h-16 bg-red-500 text-white rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform cursor-pointer" onclick="openVidPlayer('{{ $video_id }}')">
                                                        <i class="ti ti-player-play text-2xl"></i>
                                                    </button>
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
                                                    <button onclick="openGameModal('{{ $item['game_url'] }}', '{{ $itemTitle }}')" class="w-16 h-16 bg-cyan-500 rounded-full flex items-center justify-center text-white shadow-2xl hover:scale-110 transition-transform cursor-pointer">
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
                                        <div class="phone-sim-frame">
                                            <div class="phone-sim-notch"></div>
                                            <div class="phone-sim-screen">
                                                @if(!empty($item['mobile_screenshots']))
                                                    <div class="phone-sim-carousel" data-sim-id="sim-{{ $catName }}-{{ $idx }}">
                                                        @foreach($item['mobile_screenshots'] as $ssIdx => $screenshot)
                                                            <img src="{{ \App\Models\Utility::get_file('uploads/landing_page_image/' . $screenshot) }}"
                                                                 class="phone-sim-slide {{ $ssIdx === 0 ? 'active' : '' }}"
                                                                 alt="App Screen {{ $ssIdx + 1 }}" loading="lazy" decoding="async">
                                                        @endforeach
                                                    </div>
                                                    @if(count($item['mobile_screenshots']) > 1)
                                                        <div class="phone-sim-nav">
                                                            <button class="phone-sim-btn sim-prev" data-sim="sim-{{ $catName }}-{{ $idx }}"><i class="ti ti-chevron-left"></i></button>
                                                            <div class="phone-sim-dots">
                                                                @foreach($item['mobile_screenshots'] as $ssIdx => $screenshot)
                                                                    <span class="phone-sim-dot {{ $ssIdx === 0 ? 'active' : '' }}" data-sim="sim-{{ $catName }}-{{ $idx }}" data-slide="{{ $ssIdx }}"></span>
                                                                @endforeach
                                                            </div>
                                                            <button class="phone-sim-btn sim-next" data-sim="sim-{{ $catName }}-{{ $idx }}"><i class="ti ti-chevron-right"></i></button>
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
                                            <div class="phone-sim-homebar"></div>
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
        @else
            <div class="text-center py-20">
                <i class="ti ti-mood-empty text-6xl text-animazon-muted mb-4 block"></i>
                <p class="text-animazon-muted text-xl">Portfolio items coming soon...</p>
            </div>
        @endif

        <div class="mt-16 text-center animate__animated animate__fadeInUp" style="animation-delay: 0.5s">
            <a href="{{ url('/') }}#contact" class="btn-primary-custom group inline-flex items-center">
                Start Your Project <i class="ti ti-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</section>

<!-- Video Modal -->
<div id="vid-modal" class="fixed inset-0 z-[100] hidden bg-black/95 backdrop-blur-xl flex items-center justify-center p-4">
    <button onclick="closeVidPlayer()" class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors">
        <i class="ti ti-x text-4xl"></i>
    </button>
    <div class="w-full max-w-5xl aspect-video bg-black rounded-2xl overflow-hidden shadow-2xl">
        <iframe id="vid-iframe" class="w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</div>

<!-- Game Embed Modal -->
<div id="game-modal" class="fixed inset-0 z-[100] hidden bg-black/95 backdrop-blur-xl flex items-center justify-center p-4">
    <button onclick="closeGameModal()" class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors z-10">
        <i class="ti ti-x text-4xl"></i>
    </button>
    <div class="text-center w-full max-w-4xl mx-auto">
        <h3 id="game-modal-title" class="text-white text-xl font-bold mb-4"></h3>
        <div class="bg-black rounded-2xl overflow-hidden shadow-2xl" style="aspect-ratio: 16/9;">
            <iframe id="game-modal-iframe" class="w-full h-full" src="" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>

<script>
    // Video
    function openVidPlayer(id) {
        document.getElementById('vid-iframe').src = `https://www.youtube.com/embed/${id}?autoplay=1`;
        document.getElementById('vid-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeVidPlayer() {
        document.getElementById('vid-iframe').src = '';
        document.getElementById('vid-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Game
    function openGameModal(url, title) {
        document.getElementById('game-modal-iframe').src = url;
        document.getElementById('game-modal-title').textContent = title;
        document.getElementById('game-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeGameModal() {
        document.getElementById('game-modal-iframe').src = '';
        document.getElementById('game-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Filters
    document.querySelectorAll('.pf-filter').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.pf-filter').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter;
            document.querySelectorAll('.pf-item').forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.classList.remove('hidden');
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        item.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    item.style.opacity = '0';
                    setTimeout(() => item.classList.add('hidden'), 400);
                }
            });
        });
    });

    // Phone Simulator Navigation
    document.querySelectorAll('.sim-prev').forEach(btn => {
        btn.addEventListener('click', () => navSim(btn.dataset.sim, -1));
    });
    document.querySelectorAll('.sim-next').forEach(btn => {
        btn.addEventListener('click', () => navSim(btn.dataset.sim, 1));
    });
    document.querySelectorAll('.phone-sim-dot').forEach(dot => {
        dot.addEventListener('click', () => goToSim(dot.dataset.sim, parseInt(dot.dataset.slide)));
    });

    function navSim(simId, dir) {
        const carousel = document.querySelector(`[data-sim-id="${simId}"]`);
        if (!carousel) return;
        const slides = carousel.querySelectorAll('.phone-sim-slide');
        let cur = Array.from(slides).findIndex(s => s.classList.contains('active'));
        goToSim(simId, (cur + dir + slides.length) % slides.length);
    }

    function goToSim(simId, idx) {
        const carousel = document.querySelector(`[data-sim-id="${simId}"]`);
        if (!carousel) return;
        carousel.querySelectorAll('.phone-sim-slide').forEach((s, i) => {
            s.classList.toggle('active', i === idx);
            s.style.transform = i === idx ? 'translateX(0)' : (i < idx ? 'translateX(-100%)' : 'translateX(100%)');
        });
        document.querySelectorAll(`.phone-sim-dot[data-sim="${simId}"]`).forEach((d, i) => d.classList.toggle('active', i === idx));
    }

    // Touch swipe
    document.querySelectorAll('.phone-sim-carousel').forEach(c => {
        let sx = 0;
        c.addEventListener('touchstart', e => { sx = e.touches[0].clientX; }, { passive: true });
        c.addEventListener('touchend', e => {
            const diff = sx - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) navSim(c.dataset.simId, diff > 0 ? 1 : -1);
        }, { passive: true });
    });
</script>

<style>
    .pf-filter.active { border-color: rgb(var(--color-primary)); color: white; background: rgba(var(--color-primary), 0.15); }

    /* === Website Browser Preview === */
    .site-browser-bar {
        background: #1e1e24;
        padding: 8px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .site-url-chip {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 5px;
        background: rgba(255,255,255,0.06);
        border-radius: 6px;
        padding: 3px 10px;
        font-size: 10px;
        color: rgba(255,255,255,0.45);
        font-family: 'Inter', monospace;
        min-width: 0;
    }
    .site-preview-viewport {
        height: 220px;
        overflow: hidden;
    }
    .site-preview-img {
        width: 100%;
        display: block;
        object-fit: cover;
        object-position: top;
        transition: transform 4s cubic-bezier(0.25, 0.1, 0.25, 1);
    }
    .group:hover .site-preview-img {
        transform: translateY(calc(-100% + 220px));
    }

    /* === Phone Simulator === */
    .phone-sim-frame {
        width: 220px; height: 450px;
        background: #1a1a2e; border-radius: 32px;
        border: 3px solid #2d2d44; position: relative; overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5), inset 0 0 0 1px rgba(255,255,255,0.05);
    }
    .phone-sim-notch { position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 100px; height: 22px; background: #1a1a2e; border-radius: 0 0 16px 16px; z-index: 10; }
    .phone-sim-notch::before { content: ''; position: absolute; top: 8px; left: 50%; transform: translateX(-50%); width: 8px; height: 8px; background: #2d2d44; border-radius: 50%; }
    .phone-sim-screen { position: absolute; top: 22px; left: 0; right: 0; bottom: 24px; overflow: hidden; background: #000; }
    .phone-sim-homebar { position: absolute; bottom: 6px; left: 50%; transform: translateX(-50%); width: 80px; height: 4px; background: #3d3d55; border-radius: 4px; }
    .phone-sim-carousel { width: 100%; height: 100%; position: relative; }
    .phone-sim-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.35s cubic-bezier(0.4,0,0.2,1); transform: translateX(100%); }
    .phone-sim-slide.active { transform: translateX(0); }
    .phone-sim-nav { position: absolute; bottom: 30px; left: 0; right: 0; display: flex; align-items: center; justify-content: center; gap: 8px; z-index: 20; }
    .phone-sim-btn { width: 28px; height: 28px; border-radius: 50%; border: none; background: rgba(0,0,0,0.6); color: white; font-size: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(8px); transition: background 0.2s; }
    .phone-sim-btn:hover { background: rgba(16,185,129,0.7); }
    .phone-sim-dots { display: flex; gap: 4px; }
    .phone-sim-dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.3); cursor: pointer; transition: all 0.3s; }
    .phone-sim-dot.active { background: #10b981; width: 16px; border-radius: 3px; }

    @media (max-width: 640px) {
        .phone-sim-frame { width: 180px; height: 370px; }
        .site-preview-viewport { height: 180px; }
        .group:hover .site-preview-img {
            transform: translateY(calc(-100% + 180px));
        }
    }
</style>
@endsection
