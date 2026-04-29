<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cost_estimates', function (Blueprint $table) {
            $table->string('visitor_name')->nullable()->after('project_name');
            $table->string('visitor_email')->nullable()->after('visitor_name');
            $table->string('visitor_phone')->nullable()->after('visitor_email');
        });
    }

    public function down(): void
    {
        Schema::table('cost_estimates', function (Blueprint $table) {
            $table->dropColumn(['visitor_name', 'visitor_email', 'visitor_phone']);
        });
    }
};
