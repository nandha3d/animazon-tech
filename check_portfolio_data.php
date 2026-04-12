<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\LandingPage\Entities\LandingPageSetting;

$landing_settings = LandingPageSetting::landingPageSetting();
$portfolios = json_decode($landing_settings['portfolios'], true) ?? [];

echo json_encode($portfolios, JSON_PRETTY_PRINT);
