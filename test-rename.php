<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
DB::statement('ALTER TABLE settings CHANGE `key` `name` VARCHAR(255) NOT NULL');
echo "Done\n";
