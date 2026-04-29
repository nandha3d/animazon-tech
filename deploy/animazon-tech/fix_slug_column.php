<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

echo "Checking project_types table for slug column...\n";

if (!Schema::hasColumn('project_types', 'slug')) {
    echo "Adding slug column to project_types...\n";
    try {
        Schema::table('project_types', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });
        echo "Column added successfully.\n";
    } catch (\Exception $e) {
        echo "Error adding column: " . $e->getMessage() . "\n";
    }
} else {
    echo "Slug column already exists.\n";
}

echo "Populating slugs...\n";
$types = DB::table('project_types')->get();
foreach ($types as $type) {
    if (empty($type->slug)) {
        $slug = Str::slug($type->name);
        $count = DB::table('project_types')->where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . $type->id;
        }
        DB::table('project_types')->where('id', $type->id)->update(['slug' => $slug]);
        echo "Updated slug for ID {$type->id}: {$slug}\n";
    }
}

echo "Done!\n";
