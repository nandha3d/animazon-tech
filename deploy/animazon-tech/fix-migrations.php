<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

$migrationFiles = File::allFiles(database_path('migrations'));
$batch = DB::table('migrations')->max('batch') + 1;

foreach ($migrationFiles as $file) {
    if ($file->getExtension() !== 'php') continue;
    $migrationName = str_replace('.php', '', $file->getFilename());

    // Check if it's already in migrations table
    if (DB::table('migrations')->where('migration', $migrationName)->exists()) {
        continue;
    }

    $content = file_get_contents($file->getPathname());
    
    // Check if it's a create table migration
    if (preg_match('/Schema::create\(\s*[\'"]([a-zA-Z0-9_]+)[\'"]/', $content, $matches)) {
        $tableName = $matches[1];
        
        // If table exists, pretend we already ran this migration so it doesn't crash trying to recreate it
        if (Schema::hasTable($tableName)) {
            echo "Skipping table creation migration for existing table: $tableName ($migrationName)\n";
            DB::table('migrations')->insert([
                'migration' => $migrationName,
                'batch' => $batch
            ]);
        }
    }
}
echo "Done checking base table migrations.\n";
