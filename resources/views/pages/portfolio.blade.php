@extends('layouts.landing')

@section('page_content')
<!-- Include Plugin Assets -->
<style>
/* ===================================
   PORTFOLIO SHOWCASE - COMPACT MODERN
   Color Theme: Cyan Blue (#00c2de)
   Version: 4.1 - Icons on Hover
   =================================== */

:root {
    /* Primary Colors - Cyan Theme */
    --primary: #00c2de;
    --primary-dark: #00a8c4;
    --primary-light: #1fd4ed;
    --primary-subtle: rgba(0, 194, 222, 0.1);

    /* Accent Colors */
    --accent: #4ECDC4;
    --accent-dark: #3DBDB4;

    /* Neutral Colors */
    --dark: #1A1E2E;
    --dark-light: #2D3748;
    --dark-bg: #141d24;
    --card-bg: #1a2632;
    --gray-900: #1F2937;
    --gray-800: #374151;
    --gray-700: #4B5563;
    --gray-600: #6B7280;
    --gray-500: #9CA3AF;
    --gray-400: #D1D5DB;
    --gray-300: #E5E7EB;
    --gray-200: #F3F4F6;
    --gray-100: #F9FAFB;
    --white: #FFFFFF;

    /* Gradients */
    --gradient-primary: linear-gradient(135deg, #00c2de 0%, #00a8c4 100%);
    --gradient-overlay: linear-gradient(0deg, rgba(26, 30, 46, 0.95) 0%, rgba(26, 30, 46, 0.8) 50%, rgba(26, 30, 46, 0.4) 100%);

    /* Shadows */
    --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
    --shadow-primary: 0 8px 24px -8px rgba(0, 194, 222, 0.5);

    /* Spacing */
    --spacing-xs: 0.5rem;
    --spacing-sm: 0.75rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;

    /* Border Radius */
    --radius-sm: 0.375rem;
    --radius-md: 0.5rem;
    --radius-lg: 0.75rem;
    --radius-xl: 1rem;
    --radius-full: 9999px;

    /* Transitions */
    --transition-base: 250ms cubic-bezier(0.4, 0, 0.2, 1);
    --transition-smooth: 400ms cubic-bezier(0.4, 0, 0.1, 1);
}

/* ===================================
   GLOBAL WRAPPER
   =================================== */

.portfolio-showcase-wrapper {
    margin: var(--spacing-xl) 0;
    padding: 0 var(--spacing-md);
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    max-width: 1400px;
    margin-left: auto;
    margin-right: auto;
    background: var(--dark-bg);
}

/* ===================================
   HEADER SECTION
   =================================== */

.portfolio-header {
    text-align: center;
    margin-bottom: var(--spacing-xl);
    position: relative;
}

.portfolio-header::before {
    content: "";
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background: var(--gradient-primary);
    border-radius: var(--radius-full);
}

.portfolio-header h2 {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    font-weight: 800;
    color: var(--white);
    margin: var(--spacing-sm) 0;
    line-height: 1.2;
}

.portfolio-header h2 span {
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.portfolio-header p {
    font-size: clamp(0.9rem, 2vw, 1.1rem);
    color: var(--gray-400);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.5;
}

/* ===================================
   FILTERS
   =================================== */

.portfolio-filters {
    display: flex;
    gap: var(--spacing-sm);
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    margin-bottom: var(--spacing-lg);
    padding: var(--spacing-sm);
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
}

.filter-section {
    display: inline-flex;
    gap: 0.5rem;
    align-items: center;
}

.filter-label {
    font-weight: 700;
    font-size: 0.75rem;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-right: 0.25rem;
}

.filter-btn {
    padding: 0.5rem 1.25rem;
    border: 2px solid transparent;
    background: #0f1923;
    color: var(--gray-400);
    border-radius: var(--radius-full);
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all var(--transition-base);
    position: relative;
    overflow: hidden;
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--gradient-primary);
    color: var(--white);
    border-color: var(--primary);
    box-shadow: var(--shadow-primary);
    transform: translateY(-2px);
}

/* ===================================
   GRID LAYOUT
   =================================== */

.portfolio-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    /* Default 4 columns */
    gap: var(--spacing-lg);
    margin-bottom: var(--spacing-xl);
    align-items: stretch;
}

/* Column variants */
.portfolio-grid.cols-2 {
    grid-template-columns: repeat(2, 1fr);
}

.portfolio-grid.cols-3 {
    grid-template-columns: repeat(3, 1fr);
}

.portfolio-grid.cols-4 {
    grid-template-columns: repeat(4, 1fr);
}

/* Responsive: cols-4 */
@media (max-width: 1200px) {
    .portfolio-grid.cols-4 {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 900px) {
    .portfolio-grid.cols-4 {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .portfolio-grid.cols-4 {
        grid-template-columns: 1fr;
    }
}

/* Responsive: cols-3 */
@media (max-width: 900px) {
    .portfolio-grid.cols-3 {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .portfolio-grid.cols-3 {
        grid-template-columns: 1fr;
    }
}

/* Responsive: cols-2 */
@media (max-width: 600px) {
    .portfolio-grid.cols-2 {
        grid-template-columns: 1fr;
    }
}

/* ===================================
   CARD STYLES
   =================================== */

.portfolio-card {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all var(--transition-smooth);
    cursor: pointer;
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
    /* Stretch to fill grid cell */
}

.portfolio-card:hover {
    box-shadow: 0 0 30px rgba(0, 194, 222, 0.4), var(--shadow-xl);
    transform: translateY(-5px);
}

/* Card Glow Border */
.portfolio-card::before {
    content: "";
    position: absolute;
    inset: -2px;
    border-radius: var(--radius-xl);
    padding: 2px;
    background: linear-gradient(45deg, #ff6122, #00c2de);
    background-size: 200% 200%;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity var(--transition-base);
}

.portfolio-card:hover::before {
    opacity: 1;
}

/* ===================================
   IMAGE AREA & OVERLAY
   =================================== */

.portfolio-image {
    position: relative;
    padding-top: 60%;
    /* 60% aspect ratio container */
    overflow: hidden;
    background: var(--dark);
    flex-shrink: 0;
    /* Prevent image area from shrinking */
}

/* Vertical 9:16 aspect ratio for application cards (phone-like) */
.portfolio-card.type-application .portfolio-image {
    padding-top: 177.78%;
    /* 9:16 aspect ratio (16/9 * 100) */
}

/* Auto-scroll animation for app screenshots (only when no gallery) */
.portfolio-card.type-application:not(.has-gallery) .portfolio-image img {
    animation: scrollGallery 8s ease-in-out infinite;
    object-position: top center;
}

@keyframes scrollGallery {

    0%,
    15% {
        object-position: top center;
    }

    35%,
    65% {
        object-position: center center;
    }

    85%,
    100% {
        object-position: bottom center;
    }
}

/* ===================================
   IN-CARD APP GALLERY CAROUSEL
   =================================== */
.app-gallery-carousel {
    position: absolute;
    inset: 0;
    overflow: hidden;
}

.app-gallery-track {
    display: flex;
    height: 100%;
    transition: transform 0.4s ease-in-out;
}

.app-gallery-slide {
    flex: 0 0 100%;
    width: 100%;
    height: 100%;
    position: relative;
    opacity: 0;
    position: absolute;
    inset: 0;
    transition: opacity 0.4s ease-in-out;
}

.app-gallery-slide.active {
    opacity: 1;
    position: relative;
}

.app-gallery-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
}

/* Gallery Navigation Arrows */
.app-gallery-nav {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    padding: 0 8px;
    pointer-events: none;
    opacity: 0;
    transition: opacity var(--transition-base);
    z-index: 25;
}

.portfolio-card:hover .app-gallery-nav {
    opacity: 1;
}

.app-gallery-prev,
.app-gallery-next {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    pointer-events: auto;
    transition: all var(--transition-base);
    padding: 0;
}

.app-gallery-prev:hover,
.app-gallery-next:hover {
    background: var(--primary);
    border-color: var(--primary);
    transform: scale(1.1);
}

.app-gallery-prev .dashicons,
.app-gallery-next .dashicons {
    font-size: 18px;
    width: 18px;
    height: 18px;
    line-height: 1;
}

/* Gallery Dots Indicator */
.app-gallery-dots {
    position: absolute;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 6px;
    z-index: 25;
    padding: 6px 10px;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 20px;
}

.app-gallery-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    cursor: pointer;
    transition: all var(--transition-base);
}

.app-gallery-dot:hover {
    background: rgba(255, 255, 255, 0.7);
}

.app-gallery-dot.active {
    background: var(--primary);
    transform: scale(1.2);
}

/* Disable zoom effect on gallery cards */
.portfolio-card.has-gallery:hover .portfolio-image img {
    transform: none;
}

.portfolio-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-smooth);
}

.portfolio-card:hover .portfolio-image img {
    transform: scale(1.1);
}

/* OVERLAY */
.portfolio-overlay {
    position: absolute;
    inset: 0;
    background: var(--gradient-overlay);
    opacity: 0;
    display: flex;
    align-items: center;
    /* Vertical Center */
    justify-content: center;
    /* Horizontal Center */
    transition: all var(--transition-base);
    backdrop-filter: blur(2px);
    z-index: 20;
}

.portfolio-card:hover .portfolio-overlay {
    opacity: 1;
}

.overlay-actions {
    display: flex;
    gap: 1.5rem;
    /* More space between icons */
    transform: translateY(20px);
    transition: transform var(--transition-smooth);
    align-items: center;
    justify-content: center;
}

.portfolio-card:hover .overlay-actions {
    transform: translateY(0);
}

/* ICON ACTIONS - PREMIUM REDESIGN */
.action-btn {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: rgba(0, 194, 222, 0.15);
    backdrop-filter: blur(8px);
    border: 2px solid var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    text-decoration: none;
    cursor: pointer;
    transition: all 400ms cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 0 20px rgba(0, 194, 222, 0.3);
    position: relative;
    z-index: 5;
}

/* Pulsing Ripple Effect */
.action-btn::after {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 2px solid var(--primary);
    animation: ripplePulse 2s infinite;
    z-index: -1;
}

@keyframes ripplePulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    100% {
        transform: scale(1.6);
        opacity: 0;
    }
}

.action-btn:hover {
    background: var(--primary);
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 0 30px var(--primary);
    color: var(--dark-bg);
}

.action-btn i {
    font-size: 28px;
    transition: transform 300ms ease;
}

.action-btn:hover i {
    transform: scale(1.2);
}


/* Type Icon (Top Right) */
.portfolio-type-icon {
    display: none;
    /* remove type icon for cleaner look inside image */
}

/* ===================================
   SECTIONS
   =================================== */
.portfolio-section {
    margin-bottom: var(--spacing-xl);
}

.section-header {
    margin-bottom: var(--spacing-lg);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.section-title {
    font-size: 1.5rem;
    color: var(--white);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
}

.section-title .dashicons {
    font-size: 1.5rem;
    width: 1.5rem;
    height: 1.5rem;
    color: var(--primary);
}

.section-line {
    height: 1px;
    background: linear-gradient(90deg, var(--primary) 0%, transparent 100%);
    flex: 1;
    opacity: 0.3;
}

/* ===================================
   HORIZONTAL SCROLL GALLERY (Apps Section)
   =================================== */
.gallery-nav-arrows {
    display: flex;
    gap: 0.5rem;
    margin-left: 1rem;
}

.gallery-arrow {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--card-bg);
    border: 1px solid rgba(0, 194, 222, 0.3);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all var(--transition-base);
}

.gallery-arrow:hover {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
    box-shadow: 0 0 15px rgba(0, 194, 222, 0.4);
}

.gallery-arrow:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.gallery-arrow .dashicons {
    font-size: 20px;
    width: 20px;
    height: 20px;
    line-height: 1;
}

.portfolio-gallery-scroll {
    overflow-x: auto;
    overflow-y: hidden;
    scroll-behavior: smooth;
    scrollbar-width: thin;
    scrollbar-color: var(--primary) var(--dark);
    padding: 10px 0;
    margin: 0 -10px;
    padding-left: 10px;
    padding-right: 10px;
}

.portfolio-gallery-scroll::-webkit-scrollbar {
    height: 6px;
}

.portfolio-gallery-scroll::-webkit-scrollbar-track {
    background: var(--dark);
    border-radius: 3px;
}

.portfolio-gallery-scroll::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 3px;
}

.portfolio-gallery-scroll::-webkit-scrollbar-thumb:hover {
    background: var(--primary-light);
}

.portfolio-gallery-track {
    display: flex;
    gap: var(--spacing-lg);
    padding-bottom: 10px;
}

.portfolio-gallery-track .portfolio-card {
    flex: 0 0 280px;
    min-width: 280px;
    max-width: 280px;
}

.portfolio-gallery-track .portfolio-card.type-application .portfolio-image {
    padding-top: 160%;
    /* Slightly shorter for gallery view */
}

/* Responsive adjustments for gallery */
@media (max-width: 768px) {
    .gallery-nav-arrows {
        display: none;
        /* Hide arrows on mobile, use swipe */
    }

    .portfolio-gallery-track .portfolio-card {
        flex: 0 0 250px;
        min-width: 250px;
        max-width: 250px;
    }

    .section-header {
        flex-wrap: wrap;
    }
}

/* ===================================
   CONTENT AREA
   =================================== */

.portfolio-info {
    padding: var(--spacing-md);
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    z-index: 2;
    /* Above border */
}

.portfolio-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: var(--gray-500);
}

.portfolio-meta-item {
    background: rgba(0, 194, 222, 0.08);
    color: var(--primary);
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    font-weight: 600;
}

.portfolio-info h3 {
    color: var(--white);
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.portfolio-info p {
    color: var(--gray-400);
    font-size: 0.85rem;
    margin: 0;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Stats */
.portfolio-stats {
    display: flex;
    gap: 1rem;
    padding-top: 0.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    margin-top: auto;
}

.stat-item {
    font-size: 0.75rem;
    color: var(--gray-500);
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.stat-value {
    color: var(--white);
    font-weight: 700;
}

/* Tags */
.portfolio-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.3rem;
    margin-top: 0.5rem;
}

.portfolio-tag {
    font-size: 0.65rem;
    background: rgba(255, 255, 255, 0.05);
    color: var(--gray-400);
    padding: 0.15rem 0.4rem;
    border-radius: 4px;
}

/* ===================================
   MODAL (Unchanged mostly)
   =================================== */
.portfolio-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.85);
    z-index: 9999;
}

.portfolio-modal-overlay.active {
    display: block;
}

.portfolio-modal-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
    height: 90%;
    background: #000;
    z-index: 10000;
    display: none;
    flex-direction: column;
}

.portfolio-modal-container.active {
    display: flex;
}

.portfolio-modal-header {
    padding: 1rem;
    background: #111;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
}

.portfolio-modal-close {
    background: none;
    border: none;
    color: white;
    font-size: 2rem;
    cursor: pointer;
}

.portfolio-modal-body {
    flex: 1;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    overflow: hidden;
}

.video-container {
    width: 100%;
    max-width: 1200px;
    aspect-ratio: 16/9;
    position: relative;
    background: #000;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
}

.video-container.type-web {
    aspect-ratio: auto;
    height: 100%;
}

.video-container iframe {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
}


/* ===================================
   GALLERY MODAL
   =================================== */
.portfolio-gallery-modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.95);
    z-index: 10002;
    /* Higher than preview modal */
    display: none;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
}

.portfolio-gallery-modal.active {
    display: flex;
}

.gallery-modal-content {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
}

.gallery-modal-content img {
    max-width: 100%;
    max-height: 90vh;
    border-radius: 4px;
    box-shadow: 0 0 50px rgba(0, 0, 0, 0.5);
}

.gallery-close,
.gallery-nav {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    border-radius: 50%;
    z-index: 10;
}

.gallery-close {
    top: -50px;
    right: 0;
    width: 40px;
    height: 40px;
    font-size: 24px;
    line-height: 1;
}

.gallery-nav {
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    font-size: 30px;
    line-height: 1;
    padding-bottom: 4px;
    /* Center alignment adjustment for char */
}

.gallery-nav.prev {
    left: -70px;
}

.gallery-nav.next {
    right: -70px;
}

.gallery-close:hover,
.gallery-nav:hover {
    background: var(--primary);
    border-color: var(--primary);
    transform: scale(1.1);
}

.gallery-nav.prev:hover {
    transform: translateY(-50%) scale(1.1);
}

.gallery-nav.next:hover {
    transform: translateY(-50%) scale(1.1);
}

@media (max-width: 768px) {
    .gallery-nav.prev {
        left: 10px;
    }

    .gallery-nav.next {
        right: 10px;
    }

    .gallery-close {
        top: 10px;
        right: 10px;
    }
}
</style>
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
            $portfolios_raw = $settings['portfolios'] ?? '[]';
            $portfolios = json_decode($portfolios_raw, true);
            if (!is_array($portfolios)) {
                $portfolios = json_decode(stripslashes($portfolios_raw), true) ?? [];
            }
            
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

<script>
(function ($) {
    'use strict';

    // Global gallery array for image viewing
    let currentGallery = [];
    let currentGalleryIndex = 0;

    // Modal functions for website/app preview
    window.openPortfolioModal = function (title, url, type) {
        const modal = $('#portfolioModalContainer');
        const overlay = $('#portfolioModalOverlay');
        const modalTitle = $('#portfolioModalTitle');
        const modalBody = $('#portfolioModalBody');
        const externalLink = $('#portfolioExternalLink');

        modalTitle.text(title);
        externalLink.attr('href', url);

        if (type === 'video') {
            // Extract YouTube video ID
            const videoId = extractYouTubeID(url);
            if (videoId) {
                modalBody.html(`
                    <div class="video-container">
                        <iframe 
                            src="https://www.youtube.com/embed/${videoId}?autoplay=1" 
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            title="${title}">
                        </iframe>
                    </div>
                `);
            }
        } else {
            modalBody.html(`
                <div class="video-container type-web">
                    <iframe 
                        src="${url}" 
                        frameborder="0"
                        loading="lazy"
                        sandbox="allow-scripts allow-same-origin allow-forms allow-popups allow-popups-to-escape-sandbox"
                        title="${title}">
                    </iframe>
                </div>
            `);
        }

        modal.addClass('active');
        overlay.addClass('active');
        $('body').css('overflow', 'hidden');
    };

    window.closePortfolioModal = function () {
        const modal = $('#portfolioModalContainer');
        const overlay = $('#portfolioModalOverlay');
        const modalBody = $('#portfolioModalBody');

        modal.removeClass('active');
        overlay.removeClass('active');
        $('body').css('overflow', '');

        setTimeout(function () {
            modalBody.html('<div class="portfolio-loading">Loading preview...</div>');
        }, 300);
    };

    // Open Gallery Modal
    window.openGalleryModal = function (images, startIndex) {
        currentGallery = images;
        currentGalleryIndex = startIndex;

        const galleryModal = $('#portfolioGalleryModal');
        galleryModal.addClass('active');
        $('body').css('overflow', 'hidden');

        showGalleryImage(currentGalleryIndex);
    };

    window.closeGalleryModal = function () {
        $('#portfolioGalleryModal').removeClass('active');
        $('body').css('overflow', '');
        currentGallery = [];
        currentGalleryIndex = 0;
    };

    window.nextGalleryImage = function () {
        currentGalleryIndex = (currentGalleryIndex + 1) % currentGallery.length;
        showGalleryImage(currentGalleryIndex);
    };

    window.prevGalleryImage = function () {
        currentGalleryIndex = (currentGalleryIndex - 1 + currentGallery.length) % currentGallery.length;
        showGalleryImage(currentGalleryIndex);
    };

    function showGalleryImage(index) {
        const img = currentGallery[index];
        $('#galleryModalImage').attr('src', img);
        $('#galleryCounter').text(`${index + 1} / ${currentGallery.length}`);
    }

    // Extract YouTube Video ID
    function extractYouTubeID(url) {
        const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[7].length == 11) ? match[7] : false;
    }

    $(document).ready(function () {
        // Category filter
        $('.filter-btn').on('click', function () {
            const filter = $(this).data('filter');
            const filterType = $(this).data('filter-type');

            // Update active state for this filter group
            if (filterType) {
                $(`.filter-btn[data-filter-type="${filterType}"]`).removeClass('active');
            } else {
                $('.filter-btn:not([data-filter-type])').removeClass('active');
            }
            $(this).addClass('active');

            // Get active filters
            const categoryFilter = $('.filter-btn[data-filter-type="category"].active').data('filter') || 'all';
            const typeFilter = $('.filter-btn[data-filter-type="type"].active').data('filter') || 'all';

            // Apply filters
            $('.portfolio-card').each(function () {
                const card = $(this);
                const cardCategories = card.data('category') ? card.data('category').toString().split(' ') : [];
                const cardType = card.data('type');

                let showCard = true;

                // Check category filter
                if (categoryFilter !== 'all') {
                    showCard = cardCategories.includes(categoryFilter);
                }

                // Check type filter
                if (showCard && typeFilter !== 'all') {
                    showCard = (cardType === typeFilter);
                }

                if (showCard) {
                    card.fadeIn(300);
                } else {
                    card.fadeOut(300);
                }
            });
        });

        // Close modal on overlay click
        $('#portfolioModalOverlay').on('click', function () {
            closePortfolioModal();
        });

        // Close modal on Escape key
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') {
                closePortfolioModal();
                closeGalleryModal();
            }

            // Gallery navigation with arrow keys
            if ($('#portfolioGalleryModal').hasClass('active')) {
                if (e.key === 'ArrowRight') {
                    nextGalleryImage();
                } else if (e.key === 'ArrowLeft') {
                    prevGalleryImage();
                }
            }
        });

        // Prevent modal close when clicking inside
        $('#portfolioModalContainer').on('click', function (e) {
            e.stopPropagation();
        });

        // Gallery item click handler
        $('.portfolio-gallery-grid').on('click', '.gallery-thumb', function () {
            const images = [];
            const clickedIndex = $(this).data('index');

            $(this).closest('.portfolio-gallery-grid').find('.gallery-thumb').each(function () {
                images.push($(this).data('full-url'));
            });

            openGalleryModal(images, clickedIndex);
        });

        // View more gallery button
        $('.view-gallery-btn').on('click', function (e) {
            e.preventDefault();
            const images = $(this).data('images');
            if (images && images.length > 0) {
                openGalleryModal(images, 0);
            }
        });

        // Video gallery carousel (if implemented)
        $('.video-carousel-btn').on('click', function () {
            const videos = $(this).closest('.portfolio-info').data('videos');
            const videoIndex = $(this).data('video-index') || 0;

            if (videos && videos[videoIndex]) {
                const video = videos[videoIndex];
                openPortfolioModal(video.title || 'Video Preview', video.url, 'video');
            }
        });

        // Smooth scroll animation for portfolio cards
        $('.portfolio-card').each(function (index) {
            $(this).css({
                'opacity': '0',
                'transform': 'translateY(30px)'
            });

            setTimeout(() => {
                $(this).css({
                    'transition': 'opacity 0.5s ease, transform 0.5s ease',
                    'opacity': '1',
                    'transform': 'translateY(0)'
                });
            }, index * 50);
        });

        // Horizontal Gallery Scroll Navigation
        $('.gallery-arrow').on('click', function () {
            const targetId = $(this).data('target');
            const $gallery = $('#' + targetId);
            const $track = $gallery.find('.portfolio-gallery-track');

            if (!$gallery.length) return;

            const scrollAmount = 300; // Scroll by card width + gap
            const currentScroll = $gallery.scrollLeft();
            const isNext = $(this).hasClass('gallery-arrow-next');

            const newScroll = isNext
                ? currentScroll + scrollAmount
                : currentScroll - scrollAmount;

            $gallery.animate({
                scrollLeft: newScroll
            }, 300);
        });

        // Update arrow states on scroll
        $('.portfolio-gallery-scroll').on('scroll', function () {
            const $this = $(this);
            const scrollLeft = $this.scrollLeft();
            const maxScroll = $this[0].scrollWidth - $this[0].clientWidth;
            const galleryId = $this.attr('id');

            const $prevBtn = $(`.gallery-arrow-prev[data-target="${galleryId}"]`);
            const $nextBtn = $(`.gallery-arrow-next[data-target="${galleryId}"]`);

            $prevBtn.prop('disabled', scrollLeft <= 0);
            $nextBtn.prop('disabled', scrollLeft >= maxScroll - 5);
        });

        // Initialize arrow states
        $('.portfolio-gallery-scroll').trigger('scroll');

        // ===================================
        // IN-CARD APP GALLERY CAROUSEL
        // ===================================

        // Navigate to specific slide
        function goToSlide($carousel, index) {
            const $slides = $carousel.find('.app-gallery-slide');
            const $dots = $carousel.find('.app-gallery-dot');
            const totalSlides = $slides.length;

            // Wrap around
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;

            $slides.removeClass('active');
            $dots.removeClass('active');

            $slides.eq(index).addClass('active');
            $dots.eq(index).addClass('active');

            $carousel.data('current-index', index);
        }

        // Previous button click
        $(document).on('click', '.app-gallery-prev', function (e) {
            e.stopPropagation();
            const $carousel = $(this).closest('.app-gallery-carousel');
            const currentIndex = $carousel.data('current-index') || 0;
            goToSlide($carousel, currentIndex - 1);
        });

        // Next button click
        $(document).on('click', '.app-gallery-next', function (e) {
            e.stopPropagation();
            const $carousel = $(this).closest('.app-gallery-carousel');
            const currentIndex = $carousel.data('current-index') || 0;
            goToSlide($carousel, currentIndex + 1);
        });

        // Dot click
        $(document).on('click', '.app-gallery-dot', function (e) {
            e.stopPropagation();
            const $carousel = $(this).closest('.app-gallery-carousel');
            const index = $(this).data('index');
            goToSlide($carousel, index);
        });

        // Initialize carousels
        $('.app-gallery-carousel').each(function () {
            $(this).data('current-index', 0);
        });

        // Auto-play always active (continuous slideshow)
        let autoPlayIntervals = {};

        function startAutoPlay($carousel) {
            const postId = $carousel.data('post-id');
            const $slides = $carousel.find('.app-gallery-slide');

            if ($slides.length > 1 && !autoPlayIntervals[postId]) {
                autoPlayIntervals[postId] = setInterval(function () {
                    const currentIndex = $carousel.data('current-index') || 0;
                    goToSlide($carousel, currentIndex + 1);
                }, 3000);
            }
        }

        function stopAutoPlay($carousel) {
            const postId = $carousel.data('post-id');
            if (autoPlayIntervals[postId]) {
                clearInterval(autoPlayIntervals[postId]);
                delete autoPlayIntervals[postId];
            }
        }

        // Start auto-play for all carousels on page load
        $('.app-gallery-carousel').each(function () {
            startAutoPlay($(this));
        });

        // Pause auto-play on hover (for manual navigation), resume on leave
        $('.portfolio-card.has-gallery').on('mouseenter', function () {
            const $carousel = $(this).find('.app-gallery-carousel');
            stopAutoPlay($carousel);
        }).on('mouseleave', function () {
            const $carousel = $(this).find('.app-gallery-carousel');
            startAutoPlay($carousel);
        });

        // Touch swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        $(document).on('touchstart', '.app-gallery-carousel', function (e) {
            touchStartX = e.originalEvent.touches[0].clientX;
        });

        $(document).on('touchend', '.app-gallery-carousel', function (e) {
            touchEndX = e.originalEvent.changedTouches[0].clientX;
            const $carousel = $(this);
            const swipeDistance = touchStartX - touchEndX;

            if (Math.abs(swipeDistance) > 50) {
                const currentIndex = $carousel.data('current-index') || 0;
                if (swipeDistance > 0) {
                    // Swipe left - next
                    goToSlide($carousel, currentIndex + 1);
                } else {
                    // Swipe right - prev
                    goToSlide($carousel, currentIndex - 1);
                }
            }
        });

        // Lazy load images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const src = img.dataset.src;

                        if (src) {
                            img.src = src;
                            img.removeAttribute('data-src');
                            observer.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Stats counter animation
        $('.stat-value[data-count]').each(function () {
            const $this = $(this);
            const countTo = parseInt($this.data('count'));

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter($this, countTo);
                        observer.unobserve(entry.target);
                    }
                });
            });

            observer.observe(this);
        });

        function animateCounter($element, countTo) {
            $({ countNum: 0 }).animate({
                countNum: countTo
            }, {
                duration: 2000,
                easing: 'swing',
                step: function () {
                    $element.text(Math.floor(this.countNum).toLocaleString());
                },
                complete: function () {
                    $element.text(countTo.toLocaleString());
                }
            });
        }

        // Search functionality (if search input exists)
        $('#portfolio-search').on('keyup', function () {
            const searchTerm = $(this).val().toLowerCase();

            $('.portfolio-card').each(function () {
                const card = $(this);
                const title = card.find('h3').text().toLowerCase();
                const description = card.find('p').text().toLowerCase();
                const tags = card.find('.portfolio-tag').map(function () {
                    return $(this).text().toLowerCase();
                }).get().join(' ');

                const searchContent = title + ' ' + description + ' ' + tags;

                if (searchContent.indexOf(searchTerm) > -1) {
                    card.fadeIn(300);
                } else {
                    card.fadeOut(300);
                }
            });
        });

        // Sort functionality
        $('#portfolio-sort').on('change', function () {
            const sortBy = $(this).val();
            const $grid = $('.portfolio-grid');
            const $cards = $grid.find('.portfolio-card').get();

            $cards.sort(function (a, b) {
                let aVal, bVal;

                switch (sortBy) {
                    case 'title':
                        aVal = $(a).find('h3').text();
                        bVal = $(b).find('h3').text();
                        return aVal.localeCompare(bVal);

                    case 'date':
                        aVal = $(a).data('date') || '';
                        bVal = $(b).data('date') || '';
                        return bVal.localeCompare(aVal);

                    case 'price':
                        aVal = parseInt($(a).data('price')) || 0;
                        bVal = parseInt($(b).data('price')) || 0;
                        return bVal - aVal;

                    case 'views':
                        aVal = parseInt($(a).data('views')) || 0;
                        bVal = parseInt($(b).data('views')) || 0;
                        return bVal - aVal;

                    default:
                        return 0;
                }
            });

            $.each($cards, function (index, card) {
                $grid.append(card);
            });
        });

        // Add hover sound effect (optional)
        $('.portfolio-card').on('mouseenter', function () {
            // Optional: Add subtle sound effect
            // new Audio('hover-sound.mp3').play();
        });

        // Track analytics (if needed)
        $('.portfolio-btn, .overlay-btn').on('click', function () {
            const action = $(this).text().trim();
            const projectTitle = $(this).closest('.portfolio-card, .portfolio-modal-container').find('h3').text();

            // Send analytics event
            if (typeof gtag !== 'undefined') {
                gtag('event', 'portfolio_interaction', {
                    'event_category': 'Portfolio',
                    'event_label': projectTitle,
                    'event_action': action
                });
            }
        });

        // Parallax effect on scroll (subtle)
        let lastScrollTop = 0;
        $(window).on('scroll', function () {
            const scrollTop = $(this).scrollTop();
            const scrollDiff = scrollTop - lastScrollTop;

            $('.portfolio-card').each(function () {
                const $card = $(this);
                const offset = $card.offset().top - scrollTop;

                if (offset < window.innerHeight && offset > -$card.height()) {
                    const parallax = scrollDiff * 0.1;
                    $card.css('transform', `translateY(${parallax}px)`);
                }
            });

            lastScrollTop = scrollTop;
        });

        // Copy link functionality
        $('.copy-link-btn').on('click', function (e) {
            e.preventDefault();
            const url = $(this).data('url');

            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(() => {
                    showNotification('Link copied to clipboard!');
                });
            } else {
                // Fallback for older browsers
                const temp = $('<input>');
                $('body').append(temp);
                temp.val(url).select();
                document.execCommand('copy');
                temp.remove();
                showNotification('Link copied to clipboard!');
            }
        });

        // Show notification
        function showNotification(message) {
            const notification = $('<div class="portfolio-notification"></div>')
                .text(message)
                .css({
                    position: 'fixed',
                    bottom: '20px',
                    right: '20px',
                    background: '#00D4FF',
                    color: '#0A0E27',
                    padding: '15px 25px',
                    borderRadius: '8px',
                    fontWeight: '600',
                    zIndex: '100001',
                    boxShadow: '0 4px 12px rgba(0,0,0,0.2)',
                    animation: 'slideInUp 0.3s ease'
                });

            $('body').append(notification);

            setTimeout(() => {
                notification.fadeOut(300, function () {
                    $(this).remove();
                });
            }, 3000);
        }

        // Initialize tooltips (if using a tooltip library)
        if (typeof tippy !== 'undefined') {
            tippy('[data-tippy-content]', {
                arrow: true,
                animation: 'scale',
                theme: 'portfolio'
            });
        }

        // Load more functionality (infinite scroll or button)
        let page = 1;
        let loading = false;

        $('#load-more-portfolio').on('click', function () {
            if (loading) return;

            loading = true;
            const btn = $(this);
            btn.text('Loading...').prop('disabled', true);

            // AJAX call to load more items
            $.ajax({
                url: portfolioAjax.ajaxurl, // Define this in your PHP
                type: 'POST',
                data: {
                    action: 'load_more_portfolio',
                    page: ++page,
                    category: $('.filter-btn.active').data('filter'),
                    type: $('.filter-btn[data-filter-type="type"].active').data('filter')
                },
                success: function (response) {
                    if (response.success && response.data.html) {
                        $('.portfolio-grid').append(response.data.html);

                        // Reinitialize animations for new items
                        $('.portfolio-grid .portfolio-card:hidden').each(function (index) {
                            const $card = $(this);
                            setTimeout(() => {
                                $card.fadeIn(300);
                            }, index * 50);
                        });

                        if (!response.data.has_more) {
                            btn.text('No more items').prop('disabled', true);
                        } else {
                            btn.text('Load More').prop('disabled', false);
                        }
                    } else {
                        btn.text('No more items').prop('disabled', true);
                    }
                    loading = false;
                },
                error: function () {
                    btn.text('Load More').prop('disabled', false);
                    loading = false;
                    showNotification('Error loading more items');
                }
            });
        });

        // Infinite scroll (alternative to load more button)
        if ($('.portfolio-grid').data('infinite-scroll') === true) {
            $(window).on('scroll', function () {
                if (loading) return;

                const scrollTop = $(window).scrollTop();
                const windowHeight = $(window).height();
                const documentHeight = $(document).height();

                if (scrollTop + windowHeight > documentHeight - 500) {
                    $('#load-more-portfolio').trigger('click');
                }
            });
        }

        // Masonry layout (if needed for varied heights)
        if (typeof Masonry !== 'undefined') {
            const grid = document.querySelector('.portfolio-grid');
            if (grid && grid.classList.contains('masonry')) {
                new Masonry(grid, {
                    itemSelector: '.portfolio-card',
                    columnWidth: '.portfolio-card',
                    percentPosition: true,
                    gutter: 30
                });
            }
        }

        // Share functionality
        $('.share-btn').on('click', function (e) {
            e.preventDefault();
            const title = $(this).data('title');
            const url = $(this).data('url');

            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                }).catch(err => console.log('Error sharing:', err));
            } else {
                showNotification('Sharing not supported on this browser');
            }
        });
    });

})(jQuery);
</script></script>

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

