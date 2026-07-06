<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalCollaborationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('proposal_comments')) {
            Schema::create('proposal_comments', function (Blueprint $table) {
                $table->id();
                $table->integer('proposal_id')->default(0);
                $table->integer('user_id')->default(0);
                $table->string('client_name')->nullable();
                $table->string('client_email')->nullable();
                $table->string('category')->nullable();
                $table->text('comment')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('proposal_attachments')) {
            Schema::create('proposal_attachments', function (Blueprint $table) {
                $table->id();
                $table->integer('proposal_id')->default(0);
                $table->integer('user_id')->default(0);
                $table->string('client_name')->nullable();
                $table->string('category')->nullable();
                $table->string('file_name')->nullable();
                $table->string('file_path')->nullable();
                $table->string('file_size')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposal_comments');
        Schema::dropIfExists('proposal_attachments');
    }
}
