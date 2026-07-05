<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();        // per-visitor browser session
            $table->enum('direction', ['visitor', 'agent']); // visitor -> site, agent -> reply from WhatsApp
            $table->text('body');
            $table->string('visitor_name')->nullable();
            $table->string('wa_message_id')->nullable()->index(); // Cloud API message id (for reply threading)
            $table->boolean('delivered')->default(false);  // pushed to the widget already
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
