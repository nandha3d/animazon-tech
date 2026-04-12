<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cost_calculator_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('cost_calculator_questions')->cascadeOnDelete();
            $table->text('answer_text');
            $table->decimal('cost_multiplier', 5, 2)->default(1.0); // 0.5, 1.0, 2.0, etc.
            $table->decimal('additional_cost', 15, 2)->default(0); // Fixed amount to add
            $table->text('explanation')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
            
            $table->index(['question_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cost_calculator_answers');
    }
};
