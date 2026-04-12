<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

config(['database.connections.old_db' => config('database.connections.mysql')]);
config(['database.connections.old_db.database' => 'u362580417_lenzbreeze']);

$users = \DB::connection('old_db')->table('users')->get();
echo "Found " . count($users) . " users in old_db\n";
