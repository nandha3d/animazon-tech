@extends('layouts.landing')

@section('page_content')
<!-- Include Plugin Assets -->
<link rel="stylesheet" href="{{ asset('css/portfolio-showcase.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<section class="py-24 bg-animazon-black text-animazon-white min-h-screen relative overflow-hidden" style="background-color: #0b0f19;">
    <!-- Starfield/Glow background effect -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/10 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-teal-500/10 rounded-full blur-[80px] animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10 mt-12">
        @php
            $settings = \Modules\LandingPage\Entities\LandingPageSetting::settings();
            $portfolios = json_decode($settings['portfolios'] ?? '[]', true) ?? [];
            
            // Bucket the posts by type
            $websites = [];
            $videos = [];
            $apps = [];
            
            foreach ($portfolios as $item) {
                $type = $item['type'] ?? 'website';
                if ($type === 'website') {
                    $websites[] = $item;
                } elseif ($type === 'video' || $type === '3d') {
                    $videos[] = $item;
                } elseif ($type === 'application') {
                    $apps[] = $item;
                }
            }

            // Function to get image URL
            function getPortfolioImage($item) {
                if (!empty($item['image'])) {
                    return \App\Models\Utility::get_file('uploads/landing_page_image/' . $item['image']);
                }
                if (($item['type'] ?? '') === 'video' && !empty($item['video_url'])) {
                    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $item['video_url'], $match)) {
                        return "https://img.youtube.com/vi/{$match[1]}/maxresdefault.jpg";
                    }
                }
                if (($item['type'] ?? '') === 'website' && !empty($item['website_url'])) {
                    return 'https://s0.wordpress.com/mshots/v1/' . urlencode($item['website_url']) . '?w=600';
                }
                return 'https://via.placeholder.com/800x600/1A1F3A/00D4FF?text=' . urlencode($item['title'] ?? 'Showcase');
            }
        @endphp

        <div class="portfolio-showcase-wrapper dark-theme">
            <div class="portfolio-header text-center mb-12">
                <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-4" style="background: rgba(0,212,255,0.2); color: #00D4FF; border-radius: 9999px; padding: 0.25rem 1rem;">OUR WORK</span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-white" style="font-size: 3rem; margin-bottom: 1rem;">
                    Creative <span class="italic" style="color: #00D4FF;">Portfolio</span>
                </h1>
                <p class="text-xl text-gray-400" style="color: #9ca3af; font-size: 1.25rem;">
                    Explore a showcase of our finest 3D animations, web applications, games, and mobile solutions.
                </p>
            </div>

            <!-- WEBSITES SECTION -->
            @if(!empty($websites))
            <div class="portfolio-section">
                <div class="section-header">
                    <h3 class="section-title text-white"><span class="dashicons dashicons-admin-site-alt3"></span> Websites & Web Apps</h3>
                    <div class="section-line"></div>
                </div>
                <div class="portfolio-grid cols-3">
                    @foreach($websites as $item)
                        @php 
                            $display_image = getPortfolioImage($item);
                            $tech_array = !empty($item['tech_stack']) ? array_map('trim', explode(',', $item['tech_stack'])) : [];
                        @endphp
                        <div class="portfolio-card type-website {{ !empty($item['featured']) ? 'featured' : '' }}">
                            <div class="portfolio-image">
                                <img src="{{ $display_image }}" alt="{{ $item['title'] ?? '' }}">
                                @if(!empty($item['badge_text']))
                                    <span class="portfolio-badge">{{ $item['badge_text'] }}</span>
                                @endif
                                <div class="portfolio-overlay">
                                    <div class="overlay-actions">
                                        @if(!empty($item['website_url']))
                                            <a href="{{ $item['website_url'] }}" target="_blank" class="action-btn" title="Visit Site">
                                                <i class="ti ti-external-link"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="portfolio-info">
                                <div class="portfolio-meta">
                                    @if(!empty($item['completion_date']))
                                    <span class="portfolio-meta-item">
                                        <i class="ti ti-calendar"></i> {{ date('M Y', strtotime($item['completion_date'])) }}
                                    </span>
                                    @endif
                                </div>
                                <h3 class="text-white">{{ $item['title'] ?? '' }}</h3>
                                @if(!empty($tech_array))
                                <div class="portfolio-tags">
                                    @foreach(array_slice($tech_array, 0, 3) as $tech)
                                        <span class="portfolio-tag">{{ $tech }}</span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- 3D WORK & ANIMATION SECTION -->
            @if(!empty($videos))
            <div class="portfolio-section">
                <div class="section-header">
                    <h3 class="section-title text-white"><span class="dashicons dashicons-video-alt3"></span> 3D Work & Animation</h3>
                    <div class="section-line"></div>
                </div>
                <div class="portfolio-grid cols-3">
                    @foreach($videos as $item)
                        @php 
                            $display_image = getPortfolioImage($item);
                            $tech_array = !empty($item['tech_stack']) ? array_map('trim', explode(',', $item['tech_stack'])) : [];
                            $has_youtube = !empty($item['video_url']);
                            $type_class = $item['type'] == '3d' ? 'type-3d' : 'type-video';
                        @endphp
                        <div class="portfolio-card {{ $type_class }} {{ !empty($item['featured']) ? 'featured' : '' }}">
                            <div class="portfolio-image">
                                <img src="{{ $display_image }}" alt="{{ $item['title'] ?? '' }}">
                                @if(!empty($item['badge_text']))
                                    <span class="portfolio-badge">{{ $item['badge_text'] }}</span>
                                @endif
                                <div class="portfolio-overlay">
                                    <div class="overlay-actions">
                                        @if($has_youtube)
                                            <button class="action-btn" onclick="openPortfolioModal('{{ addslashes($item['title'] ?? '') }}', '{{ addslashes($item['video_url']) }}', 'video')" title="Watch Video">
                                                <i class="ti ti-player-play"></i>
                                            </button>
                                        @else
                                            <button class="action-btn" onclick="openPortfolioModal('{{ addslashes($item['title'] ?? '') }}', '{{ addslashes($display_image) }}', 'image')" title="View">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="portfolio-info">
                                <div class="portfolio-meta">
                                    @if(!empty($item['completion_date']))
                                    <span class="portfolio-meta-item">
                                        <i class="ti ti-calendar"></i> {{ date('M Y', strtotime($item['completion_date'])) }}
                                    </span>
                                    @endif
                                    @if(!empty($item['video_views']))
                                    <span class="portfolio-meta-item">
                                        <i class="ti ti-eye"></i> {{ $item['video_views'] }}
                                    </span>
                                    @endif
                                </div>
                                <h3 class="text-white">{{ $item['title'] ?? '' }}</h3>
                                @if(!empty($tech_array))
                                <div class="portfolio-tags">
                                    @foreach(array_slice($tech_array, 0, 3) as $tech)
                                        <span class="portfolio-tag">{{ $tech }}</span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- MOBILE APPS SECTION -->
            @if(!empty($apps))
            <div class="portfolio-section portfolio-section-apps">
                <div class="section-header">
                    <h3 class="section-title text-white"><span class="dashicons dashicons-smartphone"></span> Mobile Applications</h3>
                    <div class="section-line"></div>
                    <div class="gallery-nav-arrows">
                        <button class="gallery-arrow gallery-arrow-prev" data-target="apps-gallery" aria-label="Previous">
                            <i class="ti ti-chevron-left"></i>
                        </button>
                        <button class="gallery-arrow gallery-arrow-next" data-target="apps-gallery" aria-label="Next">
                            <i class="ti ti-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="portfolio-gallery-scroll" id="apps-gallery">
                    <div class="portfolio-gallery-track">
                        @foreach($apps as $idx => $item)
                            @php 
                                $tech_array = !empty($item['tech_stack']) ? array_map('trim', explode(',', $item['tech_stack'])) : [];
                                $gallery_array = !empty($item['mobile_screenshots']) ? $item['mobile_screenshots'] : [];
                                $has_gallery = count($gallery_array) > 0;
                            @endphp
                            <div class="portfolio-card type-application {{ !empty($item['featured']) ? 'featured' : '' }} {{ $has_gallery ? 'has-gallery' : '' }}">
                                <div class="portfolio-image">
                                    @if($has_gallery)
                                        <div class="app-gallery-carousel" data-post-id="{{ $idx }}">
                                            <div class="app-gallery-track">
                                                @foreach($gallery_array as $imgIdx => $img)
                                                <div class="app-gallery-slide {{ $imgIdx === 0 ? 'active' : '' }}" data-index="{{ $imgIdx }}">
                                                    <img src="{{ \App\Models\Utility::get_file('uploads/landing_page_image/' . $img) }}" alt="{{ $item['title'] ?? '' }}">
                                                </div>
                                                @endforeach
                                            </div>
                                            @if(count($gallery_array) > 1)
                                            <div class="app-gallery-nav">
                                                <button class="app-gallery-prev"><i class="ti ti-chevron-left"></i></button>
                                                <button class="app-gallery-next"><i class="ti ti-chevron-right"></i></button>
                                            </div>
                                            <div class="app-gallery-dots">
                                                @foreach($gallery_array as $imgIdx => $img)
                                                <span class="app-gallery-dot {{ $imgIdx === 0 ? 'active' : '' }}" data-index="{{ $imgIdx }}"></span>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    @else
                                        <img src="{{ getPortfolioImage($item) }}" alt="{{ $item['title'] ?? '' }}">
                                    @endif
                                    
                                    @if(!empty($item['badge_text']))
                                        <span class="portfolio-badge">{{ $item['badge_text'] }}</span>
                                    @endif
                                    
                                    <div class="portfolio-overlay">
                                        <div class="overlay-actions">
                                            @if(!empty($item['app_store_url']))
                                                <a href="{{ $item['app_store_url'] }}" target="_blank" class="action-btn" title="App Store">
                                                    <i class="ti ti-brand-apple"></i>
                                                </a>
                                            @endif
                                            @if(!empty($item['play_store_url']))
                                                <a href="{{ $item['play_store_url'] }}" target="_blank" class="action-btn" title="Play Store">
                                                    <i class="ti ti-brand-google-play"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="portfolio-info">
                                    <div class="portfolio-meta">
                                        @if(!empty($item['completion_date']))
                                        <span class="portfolio-meta-item">
                                            <i class="ti ti-calendar"></i> {{ date('M Y', strtotime($item['completion_date'])) }}
                                        </span>
                                        @endif
                                    </div>
                                    <h3 class="text-white">{{ $item['title'] ?? '' }}</h3>
                                    @if(!empty($tech_array))
                                    <div class="portfolio-tags">
                                        @foreach(array_slice($tech_array, 0, 3) as $tech)
                                            <span class="portfolio-tag">{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if(empty($websites) && empty($videos) && empty($apps))
                <div class="text-center py-20 text-gray-500">
                    <i class="ti ti-mood-empty text-6xl mb-4 block"></i>
                    <p class="text-xl">Portfolio items coming soon...</p>
                </div>
            @endif

        </div>

    </div>
</section>

<!-- Website/App Preview Modal -->
<div class="portfolio-modal-overlay" id="portfolioModalOverlay"></div>
<div class="portfolio-modal-container" id="portfolioModalContainer">
    <div class="portfolio-modal-header">
        <h3 id="portfolioModalTitle" class="text-white">Project Preview</h3>
        <div class="portfolio-modal-actions">
            <button class="portfolio-modal-close" onclick="closePortfolioModal()">×</button>
        </div>
    </div>
    <div class="portfolio-modal-body" id="portfolioModalBody">
        <div class="portfolio-loading">Loading preview...</div>
    </div>
</div>

<!-- Gallery Modal -->
<div class="portfolio-gallery-modal" id="portfolioGalleryModal" onclick="closeGalleryModal()">
    <div class="gallery-modal-content" onclick="event.stopPropagation()">
        <button class="gallery-close" onclick="closeGalleryModal()">×</button>
        <img id="galleryModalImage" src="" alt="Gallery Image">
        <button class="gallery-nav prev" onclick="prevGalleryImage()">‹</button>
        <button class="gallery-nav next" onclick="nextGalleryImage()">›</button>
        <div id="galleryCounter" style="position: absolute; bottom: -40px; left: 50%; transform: translateX(-50%); color: white; font-weight: 600;"></div>
    </div>
</div>

<script src="{{ asset('js/portfolio-showcase.js') }}"></script>

<style>
    /* Dark theme overrides for the plugin css to match the site */
    .portfolio-showcase-wrapper {
        color: #fff;
    }
    .portfolio-showcase-wrapper .portfolio-card {
        background: #1a1f3a;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .portfolio-showcase-wrapper .portfolio-card:hover {
        border-color: #00D4FF;
        box-shadow: 0 10px 30px rgba(0, 212, 255, 0.2);
    }
    .portfolio-showcase-wrapper .portfolio-info h3 {
        color: #fff;
    }
    .portfolio-showcase-wrapper .portfolio-meta {
        color: #9ca3af;
    }
    .portfolio-showcase-wrapper .portfolio-tag {
        background: rgba(255,255,255,0.1);
        color: #00D4FF;
    }
    .portfolio-modal-container {
        background: #1a1f3a;
        color: #fff;
    }
    .portfolio-modal-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .portfolio-modal-close {
        color: #fff;
    }
</style>
@endsection
