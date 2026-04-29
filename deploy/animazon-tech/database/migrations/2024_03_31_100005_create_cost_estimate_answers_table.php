<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cost_estimate_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_estimate_id')->constrained('cost_estimates')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('cost_calculator_questions')->cascadeOnDelete();
            $table->foreignId('answer_id')->nullable()->constrained('cost_calculator_answers')->cascadeOnDelete();
            $table->text('answer_value')->nullable(); // For text/input type questions
            $table->decimal('cost_contribution', 15, 2)->default(0);
            $table->timestamps();
            
            $table->index(['cost_estimate_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cost_estimate_answers');
    }
};
