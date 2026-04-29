<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // USD, INR, EUR, etc
            $table->string('name'); // US Dollar, Indian Rupee, Euro
            $table->string('symbol'); // $, ₹, €
            $table->decimal('exchange_rate', 15, 6)->default(1.0); // Rate vs USD
            $table->timestamp('last_updated')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['code', 'active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
