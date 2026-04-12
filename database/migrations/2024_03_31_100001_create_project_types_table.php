<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Website, Mobile App, 3D Design, etc.
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Font icon or icon class
            $table->decimal('base_cost', 15, 2)->default(0); // Starting cost for this type
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_types');
    }
};
