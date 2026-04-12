<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_types', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('icon');
        });

        Schema::table('cost_calculator_answers', function (Blueprint $table) {
            $table->text('insight')->nullable()->after('explanation');
        });
    }

    public function down(): void
    {
        Schema::table('project_types', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });

        Schema::table('cost_calculator_answers', function (Blueprint $table) {
            $table->dropColumn('insight');
        });
    }
};
