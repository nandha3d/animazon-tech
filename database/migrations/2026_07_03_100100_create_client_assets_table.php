<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Website / infrastructure assets managed per client (MSP-style vault).
 * Secret columns are encrypted at the model layer (AES-256 via APP_KEY),
 * so they are stored as TEXT to hold the ciphertext.
 */
class CreateClientAssetsTable extends Migration
{
    public function up()
    {
        Schema::create('client_assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');       // -> users.id (type=client)
            $table->string('label')->nullable();           // e.g. "Main site", "Staging"

            $table->string('website_url')->nullable();
            $table->string('admin_url')->nullable();
            $table->string('admin_username')->nullable();
            $table->text('admin_password')->nullable();     // encrypted

            $table->string('hosting_provider')->nullable();
            $table->string('cpanel_url')->nullable();
            $table->string('cpanel_username')->nullable();
            $table->text('cpanel_password')->nullable();     // encrypted

            $table->string('ftp_host')->nullable();
            $table->string('ftp_username')->nullable();
            $table->text('ftp_password')->nullable();        // encrypted

            $table->string('ssh_host')->nullable();
            $table->string('db_name')->nullable();

            $table->string('domain_registrar')->nullable();
            $table->date('ssl_expiry')->nullable();
            $table->date('hosting_renewal')->nullable();
            $table->date('domain_renewal')->nullable();

            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->index('client_id');
            $table->index('created_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_assets');
    }
}
