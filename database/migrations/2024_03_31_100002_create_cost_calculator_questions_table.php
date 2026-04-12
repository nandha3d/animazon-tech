<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cost_calculator_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_type_id')->constrained('project_types')->cascadeOnDelete();
            $table->text('question');
            $table->text('description')->nullable();
            $table->enum('type', ['single_select', 'multi_select', 'input'])->default('single_select');
            $table->integer('order')->default(0);
            $table->boolean('required')->default(true);
            $table->string('category')->nullable(); // scope, timeline, features, design, etc.
            $table->boolean('active')->default(true);
            $table->timestamps();
            
            $table->index(['project_type_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cost_calculator_questions');
    }
};
