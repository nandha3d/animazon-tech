<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$type = App\Models\CostCalculatorProjectType::where('name', 'like', '%Commerce%')->first();
echo 'URL: /pricing/' . ($type->id ?? 2);
