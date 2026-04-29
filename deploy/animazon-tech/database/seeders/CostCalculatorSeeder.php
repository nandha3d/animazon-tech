<?php

namespace Database\Seeders;

use App\Models\ProjectType;
use App\Models\CostCalculatorQuestion;
use App\Models\CostCalculatorAnswer;
use Illuminate\Database\Seeder;

class CostCalculatorSeeder extends Seeder
{
    public function run(): void
    {
        // Clear old data
        CostCalculatorAnswer::query()->delete();
        CostCalculatorQuestion::query()->delete();
        ProjectType::query()->delete();

        // ═══════════════════════════════════════════════════════════════
        //  CATEGORY 1: 3D ANIMATION & VISUALIZATION
        // ═══════════════════════════════════════════════════════════════
        $animation = ProjectType::create([
            'name' => '3D Animation & Visualization',
            'description' => 'Cinematic 3D animations, product renders, and architectural visualization for marketing & presentations.',
            'icon' => 'ti ti-3d-cube-sphere',
            'image_path' => 'assets/images/services/cat-3d-animation.webp',
            'base_cost' => 0,
            'active' => true,
        ]);

        // ── 3D Sub-services ──────────────────────────────────────────

        $animVideo = ProjectType::create([
            'parent_id' => $animation->id,
            'name' => '3D Animation Video',
            'description' => 'Cinematic 3D animation for marketing, products, explainers, or storytelling. Includes modeling, texturing, animation, and rendering.',
            'icon' => 'ti ti-video',
            'image_path' => 'assets/images/services/3d-animation-video.webp',
            'base_cost' => 1500,
            'active' => true,
        ]);
        $this->seed3dAnimVideoQuestions($animVideo->id);

        $modeling = ProjectType::create([
            'parent_id' => $animation->id,
            'name' => '3D Modeling & Assets',
            'description' => 'High-quality 3D models for games, printing, AR/VR, or rendering. Priced per model based on complexity.',
            'icon' => 'ti ti-box',
            'image_path' => 'assets/images/services/3d-modeling.webp',
            'base_cost' => 800,
            'active' => true,
        ]);
        $this->seed3dModelingQuestions($modeling->id);

        ProjectType::create([
            'parent_id' => $animation->id,
            'name' => 'Custom 3D Project',
            'description' => 'Have something unique in mind? Describe your project and we\'ll craft a tailored proposal.',
            'icon' => 'ti ti-brush',
            'image_path' => 'assets/images/services/3d-custom.webp',
            'base_cost' => 0,
            'active' => true,
        ]);

        // ═══════════════════════════════════════════════════════════════
        //  CATEGORY 2: WEBSITE DEVELOPMENT
        // ═══════════════════════════════════════════════════════════════
        $website = ProjectType::create([
            'name' => 'Website Development',
            'description' => 'High-performance websites — from landing pages to full e-commerce stores and enterprise SaaS platforms.',
            'icon' => 'ti ti-world',
            'image_path' => 'assets/images/services/cat-website.webp',
            'base_cost' => 0,
            'active' => true,
        ]);

        $businessSite = ProjectType::create([
            'parent_id' => $website->id,
            'name' => 'Business / Corporate Website',
            'description' => 'Professional multi-page website with responsive design, SEO, and content management. 5 pages included in the base.',
            'icon' => 'ti ti-building',
            'image_path' => 'assets/images/services/business-website.webp',
            'base_cost' => 120, // Reduced base cost
            'active' => true,
        ]);
        $this->seedBusinessWebsiteQuestions($businessSite->id);

        $ecommerce = ProjectType::create([
            'parent_id' => $website->id,
            'name' => 'E-Commerce Store',
            'description' => 'Full-featured online store with product management, cart, checkout, payment gateway, and admin dashboard.',
            'icon' => 'ti ti-shopping-cart',
            'image_path' => 'assets/images/services/ecommerce-store.webp',
            'base_cost' => 180, // Reduced to match roughly ₹15,000 for standard tier
            'active' => true,
        ]);
        $this->seedEcommerceQuestions($ecommerce->id);

        $saasApp = ProjectType::create([
            'parent_id' => $website->id,
            'name' => 'Web Application (SaaS)',
            'description' => 'Custom web applications, dashboards, SaaS platforms, and enterprise tools with user management and API integrations.',
            'icon' => 'ti ti-app-window',
            'image_path' => 'assets/images/services/saas-webapp.webp',
            'base_cost' => 3000,
            'active' => true,
        ]);
        $this->seedSaasQuestions($saasApp->id);

        $landingPage = ProjectType::create([
            'parent_id' => $website->id,
            'name' => 'Landing Page',
            'description' => 'Single-page, high-converting landing page designed for lead generation, product launches, and marketing campaigns.',
            'icon' => 'ti ti-rocket',
            'image_path' => 'assets/images/services/landing-page.webp',
            'base_cost' => 300,
            'active' => true,
        ]);
        $this->seedLandingPageQuestions($landingPage->id);

        ProjectType::create([
            'parent_id' => $website->id,
            'name' => 'Custom Website',
            'description' => 'Don\'t see what you need? Tell us about your project and we\'ll create a tailored proposal.',
            'icon' => 'ti ti-code',
            'image_path' => 'assets/images/services/custom-website.webp',
            'base_cost' => 0,
            'active' => true,
        ]);

        // ═══════════════════════════════════════════════════════════════
        //  CATEGORY 3: APP DEVELOPMENT
        // ═══════════════════════════════════════════════════════════════
        $app = ProjectType::create([
            'name' => 'App Development',
            'description' => 'Native and cross-platform mobile applications for iOS, Android, and beyond.',
            'icon' => 'ti ti-device-mobile',
            'image_path' => 'assets/images/services/cat-app-dev.webp',
            'base_cost' => 0,
            'active' => true,
        ]);

        $mobileApp = ProjectType::create([
            'parent_id' => $app->id,
            'name' => 'Mobile App (iOS & Android)',
            'description' => 'Cross-platform or native mobile app with backend API, push notifications, and app store submission.',
            'icon' => 'ti ti-device-mobile',
            'image_path' => 'assets/images/services/mobile-app.webp',
            'base_cost' => 3500,
            'active' => true,
        ]);
        $this->seedMobileAppQuestions($mobileApp->id);

        $tabletApp = ProjectType::create([
            'parent_id' => $app->id,
            'name' => 'Tablet / iPad App',
            'description' => 'Purpose-built tablet applications for business, education, POS, or consumer use with optimized layouts.',
            'icon' => 'ti ti-device-tablet',
            'image_path' => 'assets/images/services/tablet-app.webp',
            'base_cost' => 2000,
            'active' => true,
        ]);
        $this->seedTabletAppQuestions($tabletApp->id);

        ProjectType::create([
            'parent_id' => $app->id,
            'name' => 'Custom App Project',
            'description' => 'Something different? Wearables, TV, or IoT apps — let\'s discuss.',
            'icon' => 'ti ti-apps',
            'image_path' => 'assets/images/services/custom-app.webp',
            'base_cost' => 0,
            'active' => true,
        ]);

        // ═══════════════════════════════════════════════════════════════
        //  CATEGORY 4: GAME DEVELOPMENT
        // ═══════════════════════════════════════════════════════════════
        $game = ProjectType::create([
            'name' => 'Game Development',
            'description' => '2D & 3D games for mobile, web, PC, and console platforms using Unity, Unreal, or Godot.',
            'icon' => 'ti ti-device-gamepad-2',
            'image_path' => 'assets/images/services/cat-game-dev.webp',
            'base_cost' => 0,
            'active' => true,
        ]);

        $casualGame = ProjectType::create([
            'parent_id' => $game->id,
            'name' => '2D Casual / Puzzle Game',
            'description' => 'Casual, puzzle, and hyper-casual mobile games optimized for quick engagement and ad/IAP monetization.',
            'icon' => 'ti ti-puzzle',
            'image_path' => 'assets/images/services/casual-game.webp',
            'base_cost' => 2000,
            'active' => true,
        ]);
        $this->seedCasualGameQuestions($casualGame->id);

        $game3d = ProjectType::create([
            'parent_id' => $game->id,
            'name' => '3D Game',
            'description' => 'Full 3D games — action, adventure, simulation, or open-world for any platform.',
            'icon' => 'ti ti-3d-cube-sphere',
            'image_path' => 'assets/images/services/3d-game.webp',
            'base_cost' => 8000,
            'active' => true,
        ]);
        $this->seed3dGameQuestions($game3d->id);

        $arvrGame = ProjectType::create([
            'parent_id' => $game->id,
            'name' => 'AR / VR Experience',
            'description' => 'Augmented reality and virtual reality experiences for training, marketing, real estate, or entertainment.',
            'icon' => 'ti ti-cardboards',
            'image_path' => 'assets/images/services/arvr-experience.webp',
            'base_cost' => 5000,
            'active' => true,
        ]);
        $this->seedArvrQuestions($arvrGame->id);

        ProjectType::create([
            'parent_id' => $game->id,
            'name' => 'Custom Game Project',
            'description' => 'Have a unique game concept? Let\'s make it happen. Contact us for a tailored quote.',
            'icon' => 'ti ti-wand',
            'image_path' => 'assets/images/services/custom-game.webp',
            'base_cost' => 0,
            'active' => true,
        ]);
    }


    // ═══════════════════════════════════════════════════════════════
    //  3D ANIMATION QUESTIONS
    // ═══════════════════════════════════════════════════════════════

    private function seed3dAnimVideoQuestions($id)
    {
        // Q1: Duration — base $1500 for 15s
        $this->q($id, 1, 'scope', 'single_select',
            'Video Duration', 'Base package covers up to 15 seconds of rendered animation.', [
                ['Up to 15 seconds', 1.0, 0, 'Perfect for social media teasers & ads', '💡 A 15-second Instagram/TikTok ad typically has 2-3 scenes with transitions.'],
                ['30 seconds', 1.8, 0, 'Standard TV/YouTube commercial length', '💡 A 30s commercial is the standard TV ad slot. YouTube pre-roll ads are 15–30s.'],
                ['60 seconds (1 Minute)', 3.0, 0, 'Detailed product showcase or explainer', '💡 1-minute explainer videos have a 77% viewer retention rate. Ideal for landing pages.'],
                ['90+ seconds', 4.5, 0, 'In-depth presentation or cinematic trailer', '💡 Cinematic trailers typically run 90s–2min. Each second adds ~$25–40 in render costs.'],
            ]);

        // Q2: Complexity
        $this->q($id, 2, 'scope', 'single_select',
            'Animation Complexity', 'What type of objects or characters will be animated?', [
                ['Simple Products / Machinery (Rigid)', 1.0, 0, 'Basic rotations, exploded views, hard-surface objects', '💡 Rigid body animation includes product turntables, mechanical assembly, and simple motion paths.'],
                ['Organic / Soft Bodies / Fluids', 1.4, 0, 'Cloth simulation, liquid splashes, organic motion', '💡 Fluid simulations (water, smoke) require specialized solvers like Mantaflow or RealFlow, adding 30–40% render time.'],
                ['Character Animation (Rigging + Motion)', 1.8, 0, 'Fully rigged characters with walk cycles and actions', '💡 Character rigging alone takes 15–30 hours. Motion capture can speed this up but requires specialized equipment.'],
                ['Medical / Scientific Accuracy', 1.5, 0, 'Internal body, cellular, or molecular visualizations', '💡 Medical animations require scientific review and typically involve 50+ reference images for accuracy.'],
            ]);

        // Q3: Assets
        $this->q($id, 3, 'assets', 'single_select',
            'Do you have 3D models ready?', 'If you already have production-ready models, we can skip asset creation.', [
                ['Yes — fully textured and rigged', 1.0, 0, 'Ready to animate, just needs scene setup', null],
                ['Partially ready — needs cleanup/texturing', 1.0, 200, 'We\'ll fix geometry, add materials, and optimize', '💡 Mesh cleanup typically takes 4–8 hours depending on polygon density and topology issues.'],
                ['No — everything from scratch', 1.0, 600, 'We\'ll create all 3D assets based on your references', '💡 Creating a detailed product model from scratch takes 8–20 hours. We require photo/video references or CAD files.'],
            ]);

        // Q4: Render Quality
        $this->q($id, 4, 'quality', 'single_select',
            'Render Resolution & Quality', 'Higher resolution increases render time significantly.', [
                ['1080p Full HD', 1.0, 0, 'Standard web/social quality', '💡 1080p is the standard for YouTube, Instagram, and most web platforms. Renders in ~2–5 min/frame.'],
                ['2K (2560×1440)', 1.15, 0, 'Higher clarity for presentations', '💡 2K adds 50% more pixels vs 1080p. Good for projector/conference presentations.'],
                ['4K Ultra HD (3840×2160)', 1.3, 100, '4× pixel count — cinematic quality', '💡 4K renders take 3–6× longer per frame. A 30s video at 30fps = 900 frames to render.'],
            ]);

        // Q5: Add-ons
        $this->q($id, 5, 'extras', 'multi_select',
            'Add-ons & Deliverables', 'Select all extras you need.', [
                ['Professional Voiceover', 1.0, 150, 'Script timing + narration', '💡 Pro voiceover artists charge $100–500 for 60s. We include script direction and timing sync.'],
                ['Background Music & SFX', 1.0, 80, 'Licensed royalty-free audio', '💡 Licensed music from Epidemic Sound/Artlist costs $15–50/track. We handle licensing.'],
                ['Raw Project Files Handover', 1.0, 500, '.blend, .ma, or .c4d project files', '💡 Project files let you modify scenes in-house later. Includes all textures, rigs, and scene setups.'],
                ['Storyboard & Pre-visualization', 1.0, 200, 'Scene-by-scene visual blueprint', '💡 Storyboards reduce revision cycles by 40%. Includes camera angles, timing, and transition notes.'],
                ['2 Revision Rounds (Extra)', 1.0, 150, 'Beyond the 1 included revision', '💡 Each revision round typically involves re-rendering 30–50% of frames.'],
            ]);
    }

    private function seed3dModelingQuestions($id)
    {
        // Q1: Detail level
        $this->q($id, 1, 'scope', 'single_select',
            'Detail Level / Poly Count', 'Higher detail = more polygons = more time.', [
                ['Low Poly (< 5K faces)', 0.6, 0, 'Optimized for mobile games or web 3D viewers', '💡 Low-poly models load in < 1s on mobile. Ideal for Three.js, React Three Fiber, or Sketchfab embeds.'],
                ['Medium Poly (~10K–50K faces)', 1.0, 0, 'Standard game-ready or product visualization', '💡 Most AAA game props are 5K–30K polys. Good balance of detail and performance.'],
                ['High Poly (~50K–200K faces)', 1.8, 0, 'Hero objects, close-ups, VR-ready', '💡 High-poly assets are used for close-up shots, VR, or ultra-realistic product renders.'],
                ['Ultra High / ZBrush Sculpt (200K+)', 3.0, 0, 'Photorealistic, cinematic-grade assets', '💡 Ultra-high models are sculpted in ZBrush then retopologized. Often used in film VFX.'],
            ]);

        // Q2: Quantity
        $this->q($id, 2, 'scope', 'input',
            'Number of Models', 'How many models do you need at this detail level?', [
                ['models', 1.0, 0, 'Total cost = base × quantity', '💡 Bulk orders (5+ models) benefit from shared textures and materials, reducing per-unit cost.'],
            ]);

        // Q3: Materials
        $this->q($id, 3, 'features', 'single_select',
            'Material & Texturing', 'What level of surface detail do you need?', [
                ['Untextured / Solid Colors', 0.8, 0, 'Geometry only — for prototyping or 3D printing', '💡 Unshaded models are ideal for technical review, mechanism demos, or SLA/FDM 3D printing.'],
                ['Standard PBR Materials (2K)', 1.0, 0, 'Albedo, Roughness, Normal maps — game-ready', '💡 PBR (Physically Based Rendering) is the industry standard used in Unity, Unreal, and Blender.'],
                ['Custom Hand-painted Textures (4K)', 1.3, 100, 'Stylized or artisan-quality surfaces', '💡 Hand-painted textures are used in games like Fortnite and LoL for a stylized art direction.'],
                ['Ultra-Realistic Scanned Textures (8K)', 1.5, 200, 'Photogrammetry or scanned material maps', '💡 8K texture maps produce near-photographic surface quality. Often used in automotive and architectural visualization.'],
            ]);

        // Q4: Extra services
        $this->q($id, 4, 'extras', 'multi_select',
            'Additional Services', 'Select any extras needed.', [
                ['Character / Object Rigging', 1.0, 250, 'Skeleton/bones for animation readiness', '💡 A basic humanoid rig takes 8–15 hours. Includes IK/FK setup, weight painting, and basic controls.'],
                ['UV Unwrapping & Bake Ready', 1.0, 100, 'Clean UVs for external texturing', '💡 Proper UV unwrapping ensures textures don\'t stretch or distort. Essential for game engines.'],
                ['Optimization for 3D Printing (.STL)', 1.0, 100, 'Water-tight mesh + support structure', '💡 3D printing requires manifold geometry with no holes, overlaps, or inverted normals.'],
                ['Turntable Render Video', 1.0, 80, '360° showcase animation (10–15s)', '💡 We render a smooth 360° rotation video — perfect for portfolios, product pages, or investor decks.'],
            ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  WEBSITE QUESTIONS
    // ═══════════════════════════════════════════════════════════════

    private function seedBusinessWebsiteQuestions($id)
    {
        // Q1: Page count — base 120 for 5 pages
        $this->q($id, 1, 'scope', 'single_select',
            'How many pages do you need?', 'Base includes 5 pages: Home, About, Services, Contact, and one more of your choice.', [
                ['Up to 5 pages (base)', 1.0, 0, 'Home, About, Services, Contact + 1 more', '💡 5 pages cover 80% of business sites. Most visitors only view 3 pages per session.'],
                ['6–10 pages', 1.0, 50, 'Additional pages like Team, FAQ, Portfolio', '💡 Each page includes responsive layout, content placement, and SEO meta tags.'],
                ['11–20 pages', 1.0, 100, 'Comprehensive corporate site', '💡 Sites with 11–20 pages typically include blogs, case studies, and sub-service pages.'],
                ['20+ pages', 1.0, 200, 'Enterprise-grade multi-section site', '💡 Large sites benefit from a CMS. We recommend WordPress or a headless CMS for easy updates.'],
            ]);

        // Q2: Design level
        $this->q($id, 2, 'design', 'single_select',
            'Design Quality', 'How polished should the visual design be?', [
                ['Clean & Professional (Template-based)', 1.0, 0, 'Fast — we customize a premium theme for your brand', '💡 Template-based design takes 3–5 days vs 10–15 days for custom. Still looks professional.'],
                ['Custom Branded Design', 1.2, 80, 'Unique mockup → pixel-perfect dev', '💡 Includes brand color system, typography, custom layouts.'],
                ['Premium with Animations', 1.4, 150, 'Micro-animations, wow-factor', '💡 Interactive sites have 40% higher engagement. Uses gentle custom CSS animations.'],
            ]);

        // Q3: CMS / Tech stack
        $this->q($id, 3, 'stack', 'single_select',
            'Technology / CMS Preference', 'How do you want to manage your content?', [
                ['WordPress / CMS', 1.0, 0, 'Easy content management, huge plugin ecosystem', '💡 WordPress powers 43% of all websites. Plugins like Yoast SEO, WooCommerce, and Elementor extend its capabilities.'],
                ['Custom PHP / Laravel', 1.2, 100, 'Full control, faster performance, custom features', '💡 Laravel is the #1 PHP framework. Better security and performance than WordPress for custom needs.'],
                ['React / Next.js (Static + API)', 1.4, 150, 'Ultra-fast, modern JAMstack architecture', '💡 Next.js sites score 95+ on PageSpeed. Ideal for SEO-critical businesses. Uses serverless APIs.'],
                ['No Preference (You Decide)', 1.0, 0, 'We\'ll recommend the best fit for your project', null],
            ]);

        // Q4: Hosting
        $this->q($id, 4, 'hosting', 'single_select',
            'Hosting & Server Setup', 'Where should we deploy your website? (Annual hosting costs)', [
                ['No hosting — code handover only', 1.0, 0, 'We deliver the code, you handle deployment', null],
                ['Shared Hosting Setup', 1.0, 40, 'We deploy on a shared host you provide', '💡 Shared hosting costs $3–10/month (Hostinger, Bluehost). Suitable for <5K monthly visitors.'],
                ['VPS Setup (DigitalOcean / Linode)', 1.0, 100, 'Dedicated server with SSL, backups, caching', '💡 VPS costs $5–20/month. 10× faster than shared. We setup Nginx, PHP, MySQL, and SSL.'],
                ['Cloud (AWS / GCP / Azure)', 1.0, 200, 'Auto-scaling, CDN, enterprise uptime', '💡 Cloud hosting costs $20–100/month depending on traffic. Includes load balancing and auto-scaling.'],
            ]);

        // Q5: Features
        $this->q($id, 5, 'features', 'multi_select',
            'Integrations & Features', 'Select everything you need. Contact form is included free.', [
                ['Contact Form', 1.0, 0, 'Included free', null, true],
                ['Blog / News Section', 1.0, 50, 'CMS-powered blog with categories, tags, and search', '💡 Businesses with blogs get 67% more leads. Includes RSS feed and social sharing.'],
                ['WhatsApp Chat Integration', 1.0, 20, 'Floating WhatsApp button to talk to your team', '💡 This embeds a click-to-chat button.'],
                ['Live Chat Widget (Tawk.to / Crisp)', 1.0, 30, 'Real-time visitor chat with operator dashboard', '💡 Tawk.to is free forever.'],
                ['Advanced SEO Setup', 1.0, 50, 'Sitemap, Schema.org, Open Graph, robots.txt', '💡 Proper SEO setup can increase organic traffic.'],
                ['Google Analytics & Tag Manager', 1.0, 30, 'Track visitors, conversions, and user behavior', '💡 GA4 is free. We set up basic tracking.'],
            ]);

        // Q6: Timeline
        $this->q($id, 6, 'timeline', 'single_select',
            'Delivery Timeline', 'When do you need the site ready?', [
                ['Standard (2–3 weeks)', 1.0, 0, 'Recommended — includes proper QA and testing', null],
                ['Priority (1–2 weeks)', 1.2, 0, 'Accelerated with dedicated team', '💡 Priority delivery assigns more resources.'],
                ['Urgent (under 1 week)', 1.5, 100, 'Rush delivery with overtime team', '💡 Rush projects require overtime work.'],
            ]);

        // Q7: Maintenance / AMC
        $this->q($id, 7, 'extras', 'single_select',
            'Annual Maintenance Contract (AMC)', 'Do you need ongoing support and updates after launch?', [
                ['No AMC (Handover only)', 1.0, 0, 'We deliver, you maintain independently', null],
                ['Basic AMC (Bug fixes + Security)', 1.0, 80, 'Monthly security patches and bug fixes', '💡 Ideal for static sites to ensure they remain secure.'],
                ['Standard AMC (+ Content Updates)', 1.0, 150, 'Bug fixes + minor content/image changes', '💡 Includes up to 5 hours of updates per month. Great for active businesses.'],
                ['Premium AMC (Full Support)', 1.0, 300, 'Full maintenance, feature enhancements, priority', '💡 Dedicated support channel, plugin updates, caching tuning, and regular backups.'],
            ]);
    }

    private function seedEcommerceQuestions($id)
    {
        // Q1: Product scale — Base is $180 (Starter)
        $this->q($id, 1, 'scope', 'single_select',
            'Store Size & Scale (Product Limit)', 'How many products will your store support?', [
                ['Starter (Up to 10 products)', 1.0, 0, 'Basic store features', '💡 Ideal for new merchants starting a niche online store.', true],
                ['Starter Plus (Up to 15 products)', 1.0, 60, 'Added variants and guest checkout', '💡 A slight bump to allow some basic size/color product variants.'],
                ['Pro (Up to 25 products)', 1.0, 120, 'Wishlists, bulk upload, User accounts', '💡 Pro gives you basic user dashboards and order history.'],
                ['Pro Plus (Up to 50 products)', 1.0, 240, 'Product compare, advanced shipping, Abandoned cart', '💡 Unlocks advanced marketing, Google Analytics, coupons.'],
                ['Enterprise (100+ products)', 1.0, 0, 'Full enterprise custom requirements', '💡 Handled as a custom project scope.', false, true],
            ]);

        // Q2: Platform
        $this->q($id, 2, 'stack', 'single_select',
            'E-Commerce Platform', 'Which platform should we build on?', [
                ['WooCommerce (WordPress)', 1.0, 0, 'Most popular, easy to manage, huge plugin ecosystem', '💡 WooCommerce is free and handles 28% of all online stores.'],
                ['Shopify (Custom Theme)', 1.0, 80, 'Hosted solution — lower maintenance, app marketplace', '💡 Shopify costs $39–399/month subscription.'],
                ['Custom Laravel + Vue/React', 1.4, 200, 'Fully custom — total control over every feature', '💡 Custom builds have zero recurring platform fees. Best for unique logic.'],
                ['No Preference', 1.0, 0, 'We\'ll recommend based on your needs', null],
            ]);

        // Q3: Payment
        $this->q($id, 3, 'features', 'multi_select',
            'Payment Options', 'Select all payment methods you need.', [
                ['Cash on Delivery (COD)', 1.0, 0, 'Included — standard', null, true],
                ['Razorpay Integration', 1.0, 20, 'UPI, Cards, EMI, Wallets', '💡 Razorpay charges ~2% per transaction.'],
                ['Stripe Integration', 1.0, 30, 'Cards, Apple Pay, Google Pay', '💡 Stripe supports international payments easily.'],
                ['PayPal Integration', 1.0, 20, 'International buyer protection', '💡 Popular for cross-border sales.'],
                ['PDF Invoice Generation', 1.0, 15, 'Auto-generated PDF invoices', '💡 Included in Pro tier features.'],
            ]);

        // Q4: Hosting & AMC
        $this->q($id, 4, 'hosting', 'single_select',
            'Hosting & AMC Support', 'Where should we deploy and maintain it?', [
                ['No Hosting (Handover code)', 1.0, 0, 'You handle hosting yourself', null],
                ['Shared / VPS Hosting Setup', 1.0, 50, 'We deploy on standard servers', '💡 Standard setup for small to medium traffic.'],
                ['Cloud & AMC Standard (Bug Fixes)', 1.0, 120, 'Cloud setup + basic AMC maintenance', '💡 Best value for keeping your store secure.'],
                ['Enterprise AMC (Full Support)', 1.0, 250, 'Priority updates and feature additions', '💡 Gives you a dedicated developer for 10 hours a month.'],
            ]);

        // Q5: Timeline
        $this->q($id, 5, 'timeline', 'single_select',
            'Delivery Timeline', 'When do you need the store live?', [
                ['Standard (4–6 weeks)', 1.0, 0, 'Recommended — includes proper testing and QA', null],
                ['Priority (2–3 weeks)', 1.2, 0, 'Accelerated with dedicated team', '💡 Priority runs parallel frontend and backend.'],
                ['Urgent (under 2 weeks)', 1.5, 100, 'Rush delivery — overtime team', '💡 Requires rapid decision making from client.'],
            ]);
    }

    private function seedSaasQuestions($id)
    {
        // Q1: Type — base $3000
        $this->q($id, 1, 'scope', 'single_select',
            'Application Type', 'What kind of web application are you building?', [
                ['Internal Tool / Admin Dashboard', 1.0, 0, 'Employee-facing business tool', '💡 Internal tools typically need auth, CRUD operations, and data visualization. Often built with Laravel + Vue.'],
                ['Customer-facing SaaS Platform', 1.4, 0, 'Multi-tenant subscription product', '💡 SaaS requires tenant isolation, billing integration (Stripe), onboarding flows, and usage analytics.'],
                ['Marketplace / Multi-vendor', 1.8, 0, 'Two-sided platform with buyers & sellers', '💡 Marketplaces need seller dashboards, commission management, escrow payments, and dispute resolution.'],
                ['Enterprise ERP / CRM', 2.2, 0, 'Large-scale business management system', '💡 ERP/CRM systems involve 50+ modules (invoicing, HR, inventory, support tickets). Typical budget: $15K–50K+.'],
            ]);

        // Q2: User roles
        $this->q($id, 2, 'scope', 'single_select',
            'User Roles & Permissions', 'How many distinct user roles do you need?', [
                ['1–2 roles (Admin + User)', 1.0, 0, 'Basic access control', '💡 Simple role system: Users see their data, Admins see everything. Takes ~4 hours to implement.'],
                ['3–5 roles with permissions', 1.3, 150, 'Manager, Editor, Viewer, etc.', '💡 Permission-based access takes 15–20 hours. Uses policies: "Can edit posts?", "Can export data?"'],
                ['6+ roles with granular RBAC', 1.5, 300, 'Full role-based access control matrix', '💡 Granular RBAC needs a permissions table and admin UI to create/edit roles dynamically. ~30+ hours.'],
            ]);

        // Q3: Core features
        $this->q($id, 3, 'features', 'multi_select',
            'Core Features', 'Select all the features your application needs.', [
                ['User Auth & Profiles', 1.0, 0, 'Included — login, register, password reset', null, true],
                ['Real-time Notifications', 1.0, 100, 'In-app + email alerts for key events', '💡 Uses WebSockets (Pusher/Ably) for instant updates. Pusher free tier: 200K messages/day.'],
                ['File Upload & Management', 1.0, 80, 'Document/image uploads with cloud storage', '💡 Files stored on AWS S3 ($0.023/GB/month) or DigitalOcean Spaces ($5/month for 250GB). Storage costs are separate.'],
                ['Reporting & Analytics Dashboard', 1.0, 200, 'Charts, graphs, KPIs with date filtering', '💡 Uses Chart.js or ApexCharts. Includes exportable reports in PDF and Excel formats.'],
                ['Third-party API Integration', 1.0, 150, 'Connect to external services (per API)', '💡 Common APIs: Google Maps, Twilio, SendGrid, Slack, Zapier. Each API has its own pricing.'],
                ['Payment & Subscription Billing', 1.0, 250, 'Stripe/Razorpay with plans and recurring charges', '💡 Stripe Billing handles trials, upgrades, proration, and invoicing. Processing fees: 2.9% + $0.30/txn.'],
                ['Chat / Messaging System', 1.0, 400, 'In-app messaging between users', '💡 Real-time chat requires WebSocket connections, message storage, and typing indicators. ~40+ hours of development.'],
                ['Scheduling & Calendar', 1.0, 200, 'Appointment booking or task scheduling', '💡 Calendar integrates with Google Calendar API (free). Includes timezone handling and recurrence rules.'],
                ['Export (PDF / Excel / CSV)', 1.0, 100, 'Export data in multiple formats', '💡 Uses DomPDF for PDF and Maatwebsite/Excel for spreadsheets. Handles 10K+ rows efficiently.'],
                ['Email & SMS Engine', 1.0, 120, 'Automated transactional messages', '💡 SendGrid: 100 emails/day free. Twilio SMS: $0.0079/msg (US). We build the templates and triggers.'],
                ['Multi-tenant Architecture', 1.0, 0, 'Database-per-tenant or schema isolation', '💡 Multi-tenancy is essential for SaaS. Options: shared DB with tenant_id, or database-per-tenant for enterprise.', false, true],
            ]);

        // Q4: Design
        $this->q($id, 4, 'design', 'single_select',
            'UI/UX Design Level', 'How polished should the interface be?', [
                ['Functional (Clean UI framework)', 1.0, 0, 'Uses Tailwind/Bootstrap — professional but standard', '💡 Framework-based UI ships 2–3× faster. We customize colors, typography, and layout to your brand.'],
                ['Custom Designed UI', 1.3, 200, 'Unique design with Figma mockups', '💡 Custom UI includes wireframes → visual design → prototype. Adds 2–3 weeks. You get Figma files.'],
                ['Premium UX with Prototyping', 1.5, 400, 'Research-driven UX + interactive prototype', '💡 Includes user flow mapping, interactive Figma prototype for stakeholder review, and usability recommendations.'],
            ]);

        // Q5: Infra
        $this->q($id, 5, 'hosting', 'single_select',
            'Deployment Infrastructure', 'Where should the application run?', [
                ['Code Handover Only', 1.0, 0, 'We deliver the code, you deploy', null],
                ['VPS Deployment (DigitalOcean)', 1.0, 150, 'Deployed on a VPS with CI/CD', '💡 DigitalOcean: $6–24/month. We setup Docker, Nginx, SSL, and GitHub Actions for auto-deploy.'],
                ['AWS / GCP Cloud Setup', 1.0, 400, 'Production-grade cloud architecture', '💡 Includes EC2/Cloud Run + RDS + S3 + CloudFront. Monthly cost depends on traffic ($20–200/month).'],
            ]);
    }

    private function seedLandingPageQuestions($id)
    {
        // Q1: Purpose — base $300
        $this->q($id, 1, 'scope', 'single_select',
            'Landing Page Purpose', 'What is the primary goal of this page?', [
                ['Lead Generation / Signup', 1.0, 0, 'Collect emails, phone numbers, inquiries', '💡 Lead gen pages convert at 2–5% on average. A good page with social proof can hit 10–15%.'],
                ['Product Launch', 1.2, 0, 'Pre-launch buzz with countdown timer', '💡 Product launch pages typically include hero video, feature highlights, pricing, and early bird CTA.'],
                ['Event / Webinar Registration', 1.1, 0, 'Promote and capture registrations', '💡 Webinar registration pages need countdown, speaker bios, agenda, and calendar integration.'],
                ['App Download Page', 1.0, 0, 'Showcase mobile app with store links', '💡 App landing pages increase downloads by 30–40% vs direct store links. Include screenshots and reviews.'],
                ['Portfolio / Personal Brand', 1.0, 50, 'Showcase your work and services', '💡 Portfolio pages with case studies and testimonials generate 3× more inquiries than simple bio pages.'],
            ]);

        // Q2: Design
        $this->q($id, 2, 'design', 'single_select',
            'Design Approach', 'How should the page look and feel?', [
                ['Clean & Minimal (Template)', 1.0, 0, 'Professional, fast delivery', '💡 Template-based landing pages ship in 3–5 days. We customize for your brand colors and content.'],
                ['Custom Design with Brand Guide', 1.4, 100, 'Unique design from your brand identity', '💡 Custom design takes 7–10 days. Includes desktop + mobile Figma mockups for approval before dev.'],
                ['Premium with Animations & Video', 1.8, 200, 'Scroll-triggered animations, hero video, parallax', '💡 Animated pages have 20% higher engagement. Uses GSAP, Lottie, or CSS animations. Includes video embed.'],
            ]);

        // Q3: Features
        $this->q($id, 3, 'features', 'multi_select',
            'Features & Integrations', 'Select everything you need.', [
                ['Contact / Lead Form', 1.0, 0, 'Included — with email notification', null, true],
                ['Email Marketing (Mailchimp / ConvertKit)', 1.0, 50, 'Auto-subscribe leads to your email list', '💡 Mailchimp: free up to 500 contacts. ConvertKit: free up to 1000. We connect the signup form.'],
                ['Analytics & Conversion Tracking', 1.0, 30, 'GA4 + Facebook Pixel + UTM tracking', '💡 GA4 is free. Facebook Pixel tracks ad conversions ($0 — you pay for ads separately).'],
                ['Chat Widget (WhatsApp / Tawk.to)', 1.0, 30, 'Let visitors message you instantly', '💡 WhatsApp Business is free. Tawk.to live chat is free. We style and position the widget.'],
                ['Video Background / Hero Video', 1.0, 50, 'Auto-playing video in hero section', '💡 Hero videos should be under 10MB for fast loading. We optimize and compress your video file.'],
                ['Custom Illustrations / Graphics', 1.0, 100, 'Unique vector illustrations for your page', '💡 Custom illustrations make your page stand out. Includes 3–5 spot illustrations.'],
                ['Countdown Timer', 1.0, 30, 'Live countdown to launch/event date', '💡 Countdown timers create urgency. Studies show they boost conversions by 8–14%.'],
                ['A/B Testing Setup', 1.0, 50, 'Two versions to test which converts better', '💡 A/B testing helps you optimize. We set up Google Optimize (free) or VWO ($49/month) for testing.'],
            ]);

        // Q4: Speed
        $this->q($id, 4, 'timeline', 'single_select',
            'Delivery Speed', 'When do you need this page live?', [
                ['Standard (1–2 weeks)', 1.0, 0, 'Includes design review + revision', null],
                ['Priority (5–7 days)', 1.2, 0, 'Accelerated delivery', '💡 Priority delivery means your project is at the top of our queue with dedicated focus.'],
                ['Urgent (under 5 days)', 1.5, 100, 'Express delivery with rush fee', '💡 We can deliver a polished landing page in 3 days for time-critical campaigns.'],
            ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  APP DEVELOPMENT QUESTIONS
    // ═══════════════════════════════════════════════════════════════

    private function seedMobileAppQuestions($id)
    {
        // Q1: Platform — base $3500
        $this->q($id, 1, 'scope', 'single_select',
            'Target Platforms', 'Which mobile platforms do you need?', [
                ['Android Only', 1.0, 0, 'Single platform — Kotlin or Flutter', '💡 Android has 72% global market share. Flutter compiles to native ARM code for near-native performance.'],
                ['iOS Only', 1.0, 0, 'Single platform — Swift or Flutter', '💡 iOS users spend 2.5× more on in-app purchases. Requires Apple Developer account ($99/year — paid by you).'],
                ['Both (Flutter / React Native)', 1.4, 0, 'Cross-platform — one codebase, two apps', '💡 Flutter reduces dev time by 40% vs building two native apps. 90% code shared between platforms.'],
                ['Both (Native: Swift + Kotlin)', 1.9, 0, 'Separate native apps for maximum performance', '💡 Native development is ideal for GPU-intensive apps, AR features, or platform-specific APIs. It\'s 2× the work.'],
            ]);

        // Q2: Complexity
        $this->q($id, 2, 'scope', 'single_select',
            'App Complexity', 'How many screens and flow complexity?', [
                ['Simple (5–10 screens)', 1.0, 0, 'Basic app with straightforward navigation', '💡 Typical screens: splash, login, home, profile, settings, 2–3 feature screens. ~80–120 dev hours.'],
                ['Medium (10–20 screens)', 1.4, 0, 'Multi-feature app with navigation flows', '💡 Medium apps include search, filters, detail views, checkout flows, and notification screens. ~150–250 hours.'],
                ['Complex (20–40 screens)', 1.8, 0, 'Feature-rich app with multiple user flows', '💡 Complex apps approach "super app" territory. Think food delivery, ride-sharing, or social networks.'],
                ['Enterprise (40+ screens)', 2.5, 0, 'Large-scale with deep integrations', '💡 Enterprise apps require modular architecture. Often built in phases across 4–8 months.'],
            ]);

        // Q3: Features
        $this->q($id, 3, 'features', 'multi_select',
            'App Features', 'Select all features you need.', [
                ['User Auth (Email/Social Login)', 1.0, 0, 'Included — login, register, password reset', null, true],
                ['Push Notifications', 1.0, 100, 'Send alerts and updates to users', '💡 Firebase Cloud Messaging is free for unlimited pushes. Apple APNs is also free. We handle both.'],
                ['In-app Payments / Subscriptions', 1.0, 300, 'Buy items or subscribe within the app', '💡 Apple takes 30% commission on in-app purchases. Google takes 15% on first $1M. Stripe/Razorpay for direct payments.'],
                ['Camera / Image Capture', 1.0, 100, 'Take photos, scan documents, or QR codes', '💡 Includes camera permission handling, image cropping, gallery access, and optional QR/barcode scanning.'],
                ['GPS / Location Services', 1.0, 150, 'Map views, location tracking, geofencing', '💡 Google Maps API: $7/1000 map loads (free $200/month credit). We integrate maps, directions, and location pins.'],
                ['Offline Mode & Data Sync', 1.0, 250, 'Works without internet, syncs when connected', '💡 Offline mode uses local SQLite/Hive DB. Auto-syncs when connectivity returns. Adds 20–30% complexity.'],
                ['Chat / Messaging', 1.0, 400, 'In-app real-time messaging between users', '💡 Chat systems require WebSocket servers. Firebase Realtime DB is free up to 1GB data / 10K connections.'],
                ['Admin Panel (Web Dashboard)', 1.0, 500, 'Web-based admin to manage app data', '💡 Admin panel includes user management, content management, analytics, and push notification sender.'],
                ['API Integration (per service)', 1.0, 150, 'Connect to external APIs', '💡 Common: Google Maps, Stripe, Twilio, social media APIs. Each has its own pricing, separate from dev.'],
                ['Biometric Auth (Fingerprint/Face)', 1.0, 80, 'Secure login with device biometrics', '💡 Modern phones support fingerprint and face unlock. Adds security without password friction.'],
            ]);

        // Q4: Design
        $this->q($id, 4, 'design', 'single_select',
            'Design Level', 'How polished should the UI be?', [
                ['Standard (Material/Cupertino)', 1.0, 0, 'Platform-native design patterns', '💡 Material Design (Android) and Cupertino (iOS) look professional and feel native to each platform.'],
                ['Custom Branded Design', 1.3, 200, 'Unique design with brand identity', '💡 Custom design includes Figma mockups for all screens. You approve before development starts.'],
                ['Premium UX with Prototyping', 1.5, 400, 'User research + interactive prototype', '💡 Includes user flow mapping, clickable prototype, and usability testing. Best for investor-facing apps.'],
            ]);

        // Q5: Publishing
        $this->q($id, 5, 'publishing', 'single_select',
            'App Store Submission', 'Should we handle publishing to app stores?', [
                ['No — I\'ll handle publishing', 1.0, 0, 'We deliver the build files', null],
                ['Yes — both Play Store + App Store', 1.0, 100, 'We submit with screenshots, descriptions, and assets', '💡 Google Play: $25 one-time fee. Apple App Store: $99/year. Store fees are paid by you directly.'],
            ]);

        // Q6: Backend
        $this->q($id, 6, 'hosting', 'single_select',
            'Backend & API', 'Does the app need a server-side backend?', [
                ['Firebase (Serverless)', 1.0, 0, 'Fast setup — auth, DB, storage, hosting', '💡 Firebase free tier: 1GB storage, 50K reads/day, 10K auth accounts/month. Scales automatically.'],
                ['Custom Backend (Laravel / Node.js)', 1.0, 400, 'Full control with REST or GraphQL API', '💡 Custom backend gives full data control. Needed for complex business logic, multi-tenancy, or compliance.'],
                ['Already have a backend / API', 1.0, 0, 'We\'ll connect the app to your existing API', null],
            ]);
    }

    private function seedTabletAppQuestions($id)
    {
        // Q1: Platform — base $2000
        $this->q($id, 1, 'scope', 'single_select',
            'Target Platform', 'Which tablet ecosystem?', [
                ['iPad Only', 1.0, 0, 'iOS — SwiftUI or Flutter', '💡 iPads dominate the enterprise tablet market at 32% share. App Store submission requires $99/year developer fee.'],
                ['Android Tablet Only', 1.0, 0, 'Android — Kotlin or Flutter', '💡 Android tablets are common in restaurants, warehouses, and POS systems. Samsung Tab leads the market.'],
                ['Both Platforms', 1.5, 0, 'Cross-platform with Flutter', '💡 Flutter handles tablet-specific layouts with responsive breakpoints. One codebase, two platform builds.'],
            ]);

        // Q2: Complexity
        $this->q($id, 2, 'scope', 'single_select',
            'App Complexity', 'How many screens and features?', [
                ['Simple (3–8 screens)', 1.0, 0, 'Straightforward business tool', '💡 Simple tablet apps: POS, check-in kiosk, inventory scanner. Typically built in 4–6 weeks.'],
                ['Medium (8–15 screens)', 1.3, 0, 'Multiple modules and user flows', '💡 Medium apps need navigation drawers, settings, data management, and offline sync.'],
                ['Complex (15+ screens)', 1.7, 0, 'Full enterprise application', '💡 Complex tablet apps rival desktop software. Think: hospital EMR, warehouse management, vehicle diagnostics.'],
            ]);

        // Q3: Features
        $this->q($id, 3, 'features', 'multi_select',
            'Tablet-Specific Features', 'Select all features you need.', [
                ['Stylus / Pen Input Support', 1.0, 120, 'Drawing, signature capture, annotation', '💡 Uses Apple Pencil (iPad) or S-Pen (Samsung). Includes pressure sensitivity and palm rejection.'],
                ['Offline Data Storage', 1.0, 150, 'Works fully offline with local database', '💡 Essential for field workers, warehouses, or areas with poor connectivity. Uses SQLite or Hive.'],
                ['Barcode / QR Code Scanning', 1.0, 80, 'Scan products, assets, or tickets', '💡 Uses device camera. ML Kit provides barcode scanning in 10+ formats including UPC, EAN, and QR.'],
                ['Bluetooth Device Connection', 1.0, 150, 'Connect to printers, scanners, or IoT sensors', '💡 BLE integration for receipt printers (Star, Epson), barcode scanners, or custom hardware devices.'],
                ['PDF Report Generation', 1.0, 100, 'Generate and share reports from app data', '💡 On-device PDF generation with your branding. Includes tables, charts, and digital signature fields.'],
                ['Backend Admin Panel (Web)', 1.0, 500, 'Web dashboard to manage tablet app data', '💡 Admin panel lets you manage users, view analytics, export data, and push content updates.'],
            ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  GAME DEVELOPMENT QUESTIONS
    // ═══════════════════════════════════════════════════════════════

    private function seedCasualGameQuestions($id)
    {
        // Q1: Genre — base $2000
        $this->q($id, 1, 'scope', 'single_select',
            'Game Genre', 'What type of casual game?', [
                ['Hyper-casual (Tap/Swipe)', 0.8, 0, 'Simple mechanic, instant fun', '💡 Hyper-casual games average 50M+ downloads but rely on ad revenue ($0.02–0.05 per ad view).'],
                ['Puzzle / Match-3', 1.0, 0, 'Logic-based gameplay with progression', '💡 Puzzle games have the highest retention: 40% Day-1 and 15% Day-7 on average.'],
                ['Platformer / Runner', 1.2, 0, 'Side-scrolling or endless runner', '💡 Runner games need procedural generation for infinite levels. ~200 art assets typically needed.'],
                ['Card / Board Game', 1.1, 0, 'Strategy card battles or digital board game', '💡 Card games need deck management, turn logic, and AI opponents. Multiplayer adds 40% scope.'],
                ['Quiz / Trivia', 0.9, 0, 'Question-based game with scoring', '💡 Quiz games need a question bank (500+ questions minimum). We can integrate AI question generation.'],
            ]);

        // Q2: Platform
        $this->q($id, 2, 'scope', 'single_select',
            'Target Platform', 'Where should the game run?', [
                ['Web Browser (HTML5)', 0.8, 0, 'Play instantly, no install needed', '💡 HTML5 games work on Poki, CrazyGames, and can be embedded anywhere. Built with Phaser or PixiJS.'],
                ['Mobile (Android + iOS)', 1.0, 0, 'App store distribution', '💡 Mobile games need Play Store ($25 one-time) and App Store ($99/year) developer accounts.'],
                ['Web + Mobile', 1.4, 0, 'Maximum reach across all devices', '💡 Cross-platform game code can be 70% shared. UI and controls need per-platform tuning.'],
            ]);

        // Q3: Level count
        $this->q($id, 3, 'scope', 'single_select',
            'Number of Levels', 'How much content should the game have?', [
                ['1–20 levels (MVP / Prototype)', 1.0, 0, 'Enough to test market fit', '💡 20 levels = ~1 hour of gameplay. Ideal for soft-launching and testing retention metrics.'],
                ['20–50 levels', 1.3, 0, 'Full casual game experience', '💡 50 levels = 3–5 hours of gameplay. Sweet spot for ad-supported casual games.'],
                ['50–100 levels', 1.6, 0, 'Content-heavy game with long-term engagement', '💡 Games with 100+ levels need difficulty curves and reward systems to maintain engagement.'],
                ['Procedural / Infinite', 2.0, 0, 'Algorithm-generated endless gameplay', '💡 Procedural generation creates infinite replayability. Requires tuned randomization algorithms.'],
            ]);

        // Q4: Features
        $this->q($id, 4, 'features', 'multi_select',
            'Game Features', 'Select additional features.', [
                ['Leaderboard', 1.0, 80, 'Global and friends scoreboards', '💡 Google Play Games and Apple Game Center leaderboards are free. Custom servers cost ~$5/month.'],
                ['In-App Purchases (IAP)', 1.0, 200, 'Sell coins, power-ups, or premium content', '💡 Apple takes 30% (15% under Small Business Program). Google takes 15% on first $1M revenue.'],
                ['Ad Monetization (AdMob)', 1.0, 50, 'Banner, interstitial, and rewarded ads', '💡 AdMob eCPM: $1–5 (US), $0.20–1 (India). Rewarded ads pay 3–5× more than banners.'],
                ['Social Sharing', 1.0, 50, 'Share scores/screenshots on social media', '💡 Social sharing is free to implement. Can increase organic installs by 15–25%.'],
                ['Cloud Save / Progress Sync', 1.0, 80, 'Save progress across devices', '💡 Firebase free tier handles 50K users. Google Play Games auto-saves progress for Android.'],
                ['Tutorial System', 1.0, 60, 'Interactive onboarding for new players', '💡 Games with tutorials have 30% higher Day-1 retention. Step-by-step guided first-time experience.'],
                ['Custom Music & SFX', 1.0, 200, 'Original soundtrack and sound effects', '💡 Royalty-free game music packs cost $20–100. Custom composition by studio costs $200–500.'],
                ['Daily Challenges / Rewards', 1.0, 100, 'Keep players coming back every day', '💡 Daily rewards increase Day-7 retention by 25–40%. Creates habitual engagement patterns.'],
            ]);

        // Q5: Art style
        $this->q($id, 5, 'design', 'single_select',
            'Art Style', 'What visual look do you want?', [
                ['Pixel Art / Retro', 1.0, 0, 'Classic pixel aesthetic', '💡 Pixel art is cost-effective and trendy. Games like Crossy Road and Stardew Valley are pixel-art hits.'],
                ['Flat / Vector Design', 1.0, 0, 'Clean, modern 2D look', '💡 Flat design is scalable to any resolution and loads fast. Popular in hyper-casual games.'],
                ['Illustrated / Hand-drawn', 1.3, 100, 'Unique artistic style', '💡 Hand-drawn art gives your game a unique identity. Requires 20–40 hours of illustration work.'],
                ['Semi-realistic 2D', 1.4, 150, 'Detailed, high-quality 2D art', '💡 Semi-realistic art requires skilled digital painters. Think Hollow Knight or Ori art quality.'],
            ]);
    }

    private function seed3dGameQuestions($id)
    {
        // Q1: Genre — base $8000
        $this->q($id, 1, 'scope', 'single_select',
            'Game Genre', 'What type of 3D game?', [
                ['Action / Shooter', 1.0, 0, 'Fast-paced combat with weapons and AI', '💡 Shooters need weapon systems, hit detection, particle effects, and AI pathfinding. Core mechanics: ~200 hours.'],
                ['Adventure / Exploration', 1.1, 0, 'Story-driven with environmental puzzles', '💡 Adventure games need quest systems, dialogue trees, inventory, and large environments. ~250+ hours.'],
                ['Racing / Sports', 1.2, 0, 'Vehicle physics or sports simulation', '💡 Racing games require physics engines (tire grip, drift), track design, and AI opponents. ~220 hours.'],
                ['Simulation / Strategy', 1.3, 0, 'City builders, tycoons, or turn-based strategy', '💡 Simulation games have complex economies and AI. Think Cities:Skylines complexity. ~300+ hours.'],
                ['Open World / RPG', 2.0, 0, 'Large persistent world with quests and leveling', '💡 Open-world RPGs are the most complex game type. Minimum viable: 6–12 months. Budget: $30K–100K+.'],
            ]);

        // Q2: Platform
        $this->q($id, 2, 'scope', 'single_select',
            'Target Platform', 'Where will the game run?', [
                ['Mobile (Android/iOS)', 1.0, 0, 'Optimized for phones and tablets', '💡 Mobile 3D games must run on devices with limited GPUs. LOD optimization and texture atlasing are essential.'],
                ['PC / Desktop', 1.2, 0, 'Distribute via Steam or itch.io', '💡 Steam takes 30% revenue share. Greenlight fee: $100. Average indie game on Steam earns ~$16K lifetime.'],
                ['Console (PS/Xbox/Switch)', 1.5, 0, 'Console certification required', '💡 Console dev kits cost $500–2500. Certification takes 2–4 weeks. Platform rev share: 30%.'],
                ['Cross-platform (All)', 2.0, 0, 'Mobile + PC + Console', '💡 True cross-platform requires input abstraction, platform-specific UI, and per-platform optimization.'],
            ]);

        // Q3: Scope
        $this->q($id, 3, 'scope', 'single_select',
            'Game Scope & Content', 'How large is the game world?', [
                ['Small (1–5 levels, prototype)', 1.0, 0, 'Demo or vertical slice', '💡 A vertical slice is a polished demo that represents the final game quality. Ideal for pitching to publishers.'],
                ['Medium (5–15 levels)', 1.4, 0, '3–6 hours of gameplay', '💡 Medium-scope games are the sweet spot for indie studios. Manageable scope with publishable content.'],
                ['Large (15+ levels + open areas)', 1.8, 0, '10+ hours of gameplay', '💡 Large games need procedural content, deep mechanics, and extensive QA. Budget 6+ months minimum.'],
            ]);

        // Q4: Features
        $this->q($id, 4, 'features', 'multi_select',
            'Game Features', 'Select all features needed.', [
                ['Online Multiplayer', 1.0, 1500, 'Real-time multiplayer with matchmaking', '💡 Multiplayer needs dedicated servers ($20–100/month), netcode, anti-cheat, and matchmaking. Photon: $0.14/CCU.'],
                ['AI Opponents / NPCs', 1.0, 500, 'Computer-controlled enemies and characters', '💡 Game AI includes pathfinding (NavMesh), behavior trees, and state machines. ~40–80 hours of development.'],
                ['Physics Engine', 1.0, 300, 'Realistic physics interactions', '💡 Unity and Unreal have built-in physics. Custom physics (destruction, soft bodies) requires 30+ hours.'],
                ['Inventory & Upgrade System', 1.0, 400, 'Collectibles, crafting, skill trees', '💡 RPG systems need item databases, UI, save/load, and balancing. Each system: ~20–40 hours.'],
                ['In-App Purchases', 1.0, 200, 'Cosmetics, currency, or premium content', '💡 Platform stores take 30% commission. Design ethical monetization to avoid pay-to-win backlash.'],
                ['Cinematic Cutscenes', 1.0, 600, 'Scripted story sequences', '💡 Each cutscene takes 20–40 hours (scripting, camera, animation, audio). Include 3–5 cutscenes minimum for story.'],
                ['Custom Soundtrack', 1.0, 400, 'Original music and ambient audio', '💡 Game soundtracks: 5–10 tracks × $50–100/track for licensed, $100–300/track for custom composition.'],
            ]);

        // Q5: Art style
        $this->q($id, 5, 'design', 'single_select',
            'Art Style', 'What visual quality level?', [
                ['Low-poly / Stylized', 1.0, 0, 'Charming geometric art style', '💡 Low-poly is fast to produce and runs well on mobile. Games like Crossy Road use this effectively.'],
                ['Semi-realistic', 1.3, 0, 'Detailed but not photographic', '💡 Semi-realistic is the most common indie style. Achievable with good PBR materials and lighting.'],
                ['Photorealistic / AAA Quality', 2.0, 0, 'Near-photographic realism', '💡 Photorealistic games require 4K textures, ray-tracing, motion-captured animations. Budget: $50K–200K+.'],
            ]);

        // Q6: Engine
        $this->q($id, 6, 'stack', 'single_select',
            'Game Engine', 'Which engine should we use?', [
                ['Unity', 1.0, 0, 'Most versatile — mobile, PC, console, VR', '💡 Unity is free under $200K revenue. Pro license: $150/month. Supports C# scripting.'],
                ['Unreal Engine', 1.1, 0, 'Best for high-fidelity 3D — PC and console', '💡 Unreal is free until $1M revenue, then 5% royalty. Best built-in lighting and Blueprints visual scripting.'],
                ['Godot', 0.9, 0, 'Open-source, lightweight, no license fees', '💡 Godot is 100% free forever with no royalties. Growing community. Best for indie projects.'],
                ['No Preference', 1.0, 0, 'We\'ll recommend based on your needs', null],
            ]);
    }

    private function seedArvrQuestions($id)
    {
        // Q1: Type — base $5000
        $this->q($id, 1, 'scope', 'single_select',
            'Experience Type', 'What kind of AR/VR experience?', [
                ['AR Filter / Overlay (Phone)', 1.0, 0, 'Camera-based augmented reality on smartphones', '💡 AR filters work on any modern smartphone. Think Instagram/Snapchat AR filters or product try-on.'],
                ['AR Product Visualizer', 1.3, 0, 'Place 3D products in real environments', '💡 AR product viewers increase e-commerce conversion by 40%. Used by IKEA, Amazon, and Sephora.'],
                ['VR Training Simulation', 1.5, 0, 'Immersive training for workforce or education', '💡 VR training reduces learning time by 40% and improves retention by 75% (PwC study).'],
                ['VR Game / Entertainment', 1.8, 0, 'Interactive VR game or experience', '💡 The VR gaming market is $12B+ and growing 30% annually. Meta Quest 3 leads the consumer market.'],
                ['Mixed Reality (MR) Experience', 2.0, 0, 'Blends real and virtual environments', '💡 MR is cutting-edge. Apple Vision Pro and Meta Quest 3 support spatial computing and passthrough MR.'],
            ]);

        // Q2: Device
        $this->q($id, 2, 'scope', 'single_select',
            'Target Device', 'Which hardware platform?', [
                ['Phone AR (ARKit/ARCore)', 1.0, 0, 'Works on billions of smartphones', '💡 ARCore (Android) and ARKit (iOS) are free. 1B+ ARCore-capable devices, 1B+ ARKit devices worldwide.'],
                ['Meta Quest (Standalone VR)', 1.2, 0, 'All-in-one headset — no PC required', '💡 Meta Quest 3 costs $499. Quest Store submission requires developer registration ($15 one-time).'],
                ['PC VR (SteamVR)', 1.3, 0, 'High-end VR tethered to a gaming PC', '💡 SteamVR supports Valve Index, HTC Vive, and more. Best visual quality but requires $800+ gaming PC.'],
                ['Apple Vision Pro', 1.5, 0, 'Premium spatial computing platform', '💡 Apple Vision Pro is $3,499 per device. Developer program: $99/year. visionOS uses SwiftUI + RealityKit.'],
            ]);

        // Q3: Duration
        $this->q($id, 3, 'scope', 'single_select',
            'Experience Duration', 'How long should the experience last?', [
                ['Under 5 minutes', 1.0, 0, 'Quick demo or product showcase', '💡 5-minute experiences are perfect for trade shows, showrooms, and real estate walkthroughs.'],
                ['5–15 minutes', 1.3, 0, 'Standard training module or game level', '💡 Most effective duration for VR training. Longer sessions can cause motion sickness in some users.'],
                ['15–30 minutes', 1.6, 0, 'In-depth training or multi-level experience', '💡 Extended VR requires comfort optimizations: teleporting movement, rest areas, and FOV adjustments.'],
                ['30+ minutes', 2.0, 0, 'Full-length VR application or game', '💡 Long VR sessions need save points, adjustable comfort settings, and performance optimization.'],
            ]);

        // Q4: Features
        $this->q($id, 4, 'features', 'multi_select',
            'XR Features', 'Select all capabilities needed.', [
                ['Hand Tracking', 1.0, 500, 'Natural hand interaction without controllers', '💡 Hand tracking is built into Quest 3 and Vision Pro. Adds 30% dev time for gesture recognition tuning.'],
                ['Voice Commands', 1.0, 300, 'Speech recognition for UI control', '💡 Uses platform speech-to-text APIs. Works offline on most devices. Adds ~20 hours of dev time.'],
                ['Multiplayer / Shared Spaces', 1.0, 800, 'Multiple users in the same virtual space', '💡 Multiplayer VR needs Photon or Mirror networking. Server costs: $0.14/CCU (Photon). Complex setup.'],
                ['Analytics & Usage Tracking', 1.0, 150, 'Track user gaze, interaction patterns, completion', '💡 VR analytics track heatmaps, gaze direction, and completion rates. Essential for training ROI measurement.'],
                ['3D Asset Creation', 1.0, 400, 'Custom 3D models and environments', '💡 VR assets need optimization for real-time rendering at 72–120 FPS. Standard game assets may need LOD work.'],
                ['Haptic Feedback Integration', 1.0, 200, 'Controller vibration patterns for immersion', '💡 Haptic feedback increases immersion by 30%. Requires per-interaction vibration pattern design.'],
            ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  HELPER METHOD
    // ═══════════════════════════════════════════════════════════════

    private function q($projectTypeId, $order, $category, $type, $question, $description, $answers)
    {
        $q = CostCalculatorQuestion::create([
            'project_type_id' => $projectTypeId,
            'question' => $question,
            'description' => $description,
            'type' => $type,
            'order' => $order,
            'required' => true,
            'category' => $category,
            'active' => true,
        ]);

        foreach ($answers as $i => $a) {
            CostCalculatorAnswer::create([
                'question_id' => $q->id,
                'answer_text' => $a[0],
                'cost_multiplier' => $a[1],
                'additional_cost' => $a[2],
                'explanation' => $a[3] ?? null,
                'insight' => $a[4] ?? null,
                'is_included' => $a[5] ?? false,
                'is_enterprise' => $a[6] ?? false,
                'order' => $i + 1,
                'active' => true,
            ]);
        }
    }
}
