<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_types', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });
        
        // Populate existing slugs
        $types = DB::table('project_types')->get();
        foreach ($types as $type) {
            $slug = Str::slug($type->name);
            // Handle duplicates
            $count = DB::table('project_types')->where('slug', $slug)->count();
            if ($count > 0) {
                $slug .= '-' . $type->id;
            }
            DB::table('project_types')->where('id', $type->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('project_types', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
