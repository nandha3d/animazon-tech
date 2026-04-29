<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$portfolios = \Modules\LandingPage\Entities\LandingPageSetting::where('name', 'portfolios')->value('value');
echo json_encode(json_decode($portfolios), JSON_PRETTY_PRINT);
