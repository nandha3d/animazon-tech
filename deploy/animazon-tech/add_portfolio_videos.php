<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\LandingPage\Entities\LandingPageSetting;

$landing_settings = LandingPageSetting::landingPageSetting();
$portfolios = json_decode($landing_settings['portfolios'], true) ?? [];

// Keep existing non-video items (Websites etc.)
$existing_non_video = array_filter($portfolios, fn($item) => ($item['type'] ?? '') !== 'video');

// All 13 portfolio videos with professional descriptions
$new_videos = [
    [
        'title' => 'How MCB Works — Circuit Breaker Explained',
        'description' => 'We engineered a detailed exploded-view animation of a Miniature Circuit Breaker, revealing every internal component and its electromagnetic trip mechanism to simplify a complex safety device for engineering students and professionals.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/nd6IVLni9lE',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
    [
        'title' => '3D Interior Visualization',
        'description' => 'A photorealistic architectural walkthrough showcasing modern interior design with dynamic lighting, material rendering, and spatial composition — crafted to help real estate developers present properties before construction begins.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/xgGfezI8WXs',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
    [
        'title' => 'Trojan Horse Inside Your Body',
        'description' => 'A cinematic medical animation illustrating how pathogens infiltrate the human immune system using a "Trojan Horse" mechanism. Built to make advanced immunology concepts accessible through stunning cellular-level 3D visualization.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/HkTKc1tBlUY',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
    [
        'title' => 'Dental Implants — Surgical Procedure',
        'description' => 'We created a step-by-step 3D visualization of the dental implant procedure, from jawbone preparation to crown placement. Designed for dental clinics and patient education, this animation demystifies a complex surgical process with clinical accuracy.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/t77d2ycQYO8',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
    [
        'title' => 'Nuclear Power Plant — How It Works',
        'description' => 'An industrial-grade 3D animation breaking down the complete nuclear fission process, reactor core mechanics, and energy generation cycle. Created to provide clear, scientifically accurate visual education for engineering institutions.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/XYjSwK8EI9M',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
    [
        'title' => 'Wind Turbine — Engineering Breakdown',
        'description' => 'A detailed technical animation showing the internal mechanics of a wind turbine — from blade aerodynamics to generator operation. Built to explain renewable energy technology with precision engineering visuals.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/wnR4naujJQ0',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
    [
        'title' => 'Stepper Motor — Internal Mechanics',
        'description' => 'We reverse-engineered a stepper motor into a fully exploded 3D model, animating each phase of electromagnetic rotation. This visualization helps robotics and automation students understand precise motor control at a component level.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/wBloyozjceI',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
    [
        'title' => 'DC Motor — Working Principle',
        'description' => 'A clean, educational 3D animation demonstrating how a DC motor converts electrical energy into mechanical rotation through commutator and armature interaction. Designed for physics and electrical engineering curricula.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/D9jdk2PQD98',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
    [
        'title' => 'How Electricity Works',
        'description' => 'A foundational explainer animation visualizing the journey of electricity from power generation to household delivery. We simplified complex electrical concepts into an engaging visual narrative for broad audiences.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/wE0k8Hxr9_Q',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
    [
        'title' => 'IRIS — Human Eye Anatomy',
        'description' => 'A scientifically precise 3D animation of the human iris and pupil mechanism, showcasing how light enters the eye and how muscles contract to control aperture. Built for ophthalmology education and medical presentations.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/4a_diCTcvp4',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
    [
        'title' => '360° Auditorium Visualization',
        'description' => 'An immersive 360-degree architectural visualization of a modern auditorium, featuring realistic lighting, acoustic panel detailing, and seating arrangements. Created for architects and event venue developers to present design proposals.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/ASu3lPqHiLw',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
    [
        'title' => 'How Touch Screens Work',
        'description' => 'We animated the science behind capacitive touch technology — from finger contact through the glass sensor layer to signal processing. A popular educational piece explaining the technology billions of people use daily.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/l-v1uJbzMEo',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
    [
        'title' => 'How a Grenade Works — MK2 Explained',
        'description' => 'A technically accurate exploded-view animation of the iconic MK2 fragmentation grenade, detailing the fuse mechanism, detonation sequence, and fragmentation pattern. Created for defense education and military history content.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/o3JYBhp9RH8',
        'game_url' => '',
        'website_url' => '',
        'mobile_app_url' => '',
    ],
];

// Merge: existing non-video items + new videos
$final = array_values(array_merge(array_values($existing_non_video), $new_videos));

// Save to database
LandingPageSetting::updateOrCreate(
    ['name' => 'portfolios'],
    ['value' => json_encode($final)]
);

echo "✅ Portfolio updated successfully!\n";
echo "Total items: " . count($final) . "\n";
echo "- Websites: " . count(array_filter($final, fn($i) => $i['type'] === 'website')) . "\n";
echo "- Videos: " . count(array_filter($final, fn($i) => $i['type'] === 'video')) . "\n";
