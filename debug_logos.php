<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Utility;

echo "--- Current Settings in DB ---\n";
$settings = DB::table('settings')->where('name', 'LIKE', '%logo%')->orWhere('name', 'LIKE', '%favicon%')->pluck('value', 'name')->toArray();
print_r($settings);

echo "\n--- Updating Settings ---\n";
$toUpdate = [
    'company_logo_dark' => 'logo-dark.png',
    'company_logo_light' => 'logo-light.png',
    'company_favicon' => 'favicon.png',
    'dark_logo' => 'logo-dark.png',
    'light_logo' => 'logo-light.png',
];

foreach ($toUpdate as $name => $value) {
    $count = DB::table('settings')->where('name', $name)->update(['value' => $value]);
    echo "Updated $name to $value (affected $count rows)\n";
}

echo "\n--- Generated URLs ---\n";
$logoPath = Utility::get_file('uploads/logo');
echo "Logo Base URL: $logoPath\n";
echo "Full Logo Dark URL: " . $logoPath . '/logo-dark.png' . "\n";
echo "Full Favicon URL: " . $logoPath . '/favicon.png' . "\n";

echo "\n--- Filesystem Check ---\n";
echo "Storage Path: " . storage_path('app/public/uploads/logo') . "\n";
$files = glob(storage_path('app/public/uploads/logo/*'));
foreach ($files as $file) {
    echo "File: " . basename($file) . " (" . filesize($file) . " bytes)\n";
}

echo "\n--- Public Path Check ---\n";
echo "Public Storage Path: " . public_path('storage/uploads/logo') . "\n";
$publicFiles = glob(public_path('storage/uploads/logo/*'));
if ($publicFiles === false) {
    echo "Could not read public storage - possibly broken link.\n";
} else {
    foreach ($publicFiles as $file) {
        echo "Public File: " . basename($file) . "\n";
    }
}
