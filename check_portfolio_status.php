<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\LandingPage\Entities\LandingPageSetting;

$s = LandingPageSetting::landingPageSetting();
echo "portfolio_status: " . ($s['portfolio_status'] ?? 'NOT SET') . PHP_EOL;
echo "portfolio_heading: " . ($s['portfolio_heading'] ?? 'NOT SET') . PHP_EOL;
echo "portfolio_description: " . ($s['portfolio_description'] ?? 'NOT SET') . PHP_EOL;
