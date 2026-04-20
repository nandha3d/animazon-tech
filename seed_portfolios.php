<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\LandingPage\Entities\LandingPageSetting;

$websites = [
    [
        'title' => 'Indian Paint & Coating Association',
        'description' => 'A comprehensive platform for the Indian Paint & Coating Association, featuring member directories, event management, and industry news.',
        'category' => 'Websites',
        'type' => 'website',
        'website_url' => 'https://ipcaonline.com',
        'completion_date' => '2025-09-01',
        'tech_stack' => 'Laravel, Vue.js, Tailwind CSS',
    ],
    [
        'title' => 'Hospital Patient Management System',
        'description' => 'An advanced patient management system for hospitals, streamlining appointments, electronic health records (EHR), and billing processes.',
        'category' => 'Web Apps',
        'type' => 'website',
        'website_url' => 'https://hms.animazon.in',
        'completion_date' => '2025-12-01',
        'tech_stack' => 'Laravel, React, MySQL',
    ],
    [
        'title' => 'Supplement E-Commerce Website',
        'description' => 'A high-performance e-commerce platform for fitness supplements, featuring subscription models and advanced filtering.',
        'category' => 'Websites',
        'type' => 'website',
        'website_url' => 'https://supplements.example.com', // Placeholder URL since I don't have the real one
        'completion_date' => '2025-11-01',
        'tech_stack' => 'WooCommerce, WordPress, PHP',
    ],
    [
        'title' => 'Wild Life Leather E-Commerce Website',
        'description' => 'A luxury e-commerce storefront for premium leather goods with dynamic product customization features.',
        'category' => 'Websites',
        'type' => 'website',
        'website_url' => 'https://wildlifeleather.example.com',
        'completion_date' => '2025-02-01',
        'tech_stack' => 'Shopify, Liquid, JS',
    ]
];

$videos = [
    [
        'title' => 'How MCB Works — Circuit Breaker Explained',
        'description' => 'We engineered a detailed exploded-view animation of a Miniature Circuit Breaker.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/nd6IVLni9lE',
        'tech_stack' => 'Blender, After Effects'
    ],
    [
        'title' => '3D Interior Visualization',
        'description' => 'A photorealistic architectural walkthrough showcasing modern interior design with dynamic lighting.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/xgGfezI8WXs',
        'tech_stack' => '3ds Max, V-Ray'
    ],
    [
        'title' => 'Trojan Horse Inside Your Body',
        'description' => 'A cinematic medical animation illustrating how pathogens infiltrate the human immune system.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/HkTKc1tBlUY',
        'tech_stack' => 'Maya, Arnold'
    ],
    [
        'title' => 'Dental Implants — Surgical Procedure',
        'description' => 'We created a step-by-step 3D visualization of the dental implant procedure.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/t77d2ycQYO8',
    ],
    [
        'title' => 'Nuclear Power Plant — How It Works',
        'description' => 'An industrial-grade 3D animation breaking down the complete nuclear fission process.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/XYjSwK8EI9M',
    ],
    [
        'title' => 'Wind Turbine — Engineering Breakdown',
        'description' => 'A detailed technical animation showing the internal mechanics of a wind turbine.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/wnR4naujJQ0',
    ],
    [
        'title' => 'Stepper Motor — Internal Mechanics',
        'description' => 'We reverse-engineered a stepper motor into a fully exploded 3D model.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/wBloyozjceI',
    ],
    [
        'title' => 'DC Motor — Working Principle',
        'description' => 'A clean, educational 3D animation demonstrating how a DC motor converts electrical energy.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/D9jdk2PQD98',
    ],
    [
        'title' => 'How Electricity Works',
        'description' => 'A foundational explainer animation visualizing the journey of electricity from power generation.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/wE0k8Hxr9_Q',
    ],
    [
        'title' => 'IRIS — Human Eye Anatomy',
        'description' => 'A scientifically precise 3D animation of the human iris and pupil mechanism.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/4a_diCTcvp4',
    ],
    [
        'title' => '360° Auditorium Visualization',
        'description' => 'An immersive 360-degree architectural visualization of a modern auditorium.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/ASu3lPqHiLw',
    ],
    [
        'title' => 'How Touch Screens Work',
        'description' => 'We animated the science behind capacitive touch technology.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/l-v1uJbzMEo',
    ],
    [
        'title' => 'How a Grenade Works — MK2 Explained',
        'description' => 'A technically accurate exploded-view animation of the iconic MK2 fragmentation grenade.',
        'category' => '3D Animation',
        'type' => 'video',
        'video_url' => 'https://youtu.be/o3JYBhp9RH8',
    ],
];

$final = array_merge($websites, $videos);

LandingPageSetting::updateOrCreate(
    ['name' => 'portfolios'],
    ['value' => json_encode($final)]
);

echo "✅ Portfolio seeded successfully!\n";
echo "Total items: " . count($final) . "\n";
echo "- Websites: " . count($websites) . "\n";
echo "- Videos: " . count($videos) . "\n";
