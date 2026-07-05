<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHostingAmountToClientAssets extends Migration
{
    public function up()
    {
        Schema::table('client_assets', function (Blueprint $table) {
            if (!Schema::hasColumn('client_assets', 'hosting_amount')) {
                $table->decimal('hosting_amount', 15, 2)->nullable()->after('hosting_renewal');
            }
        });
    }

    public function down()
    {
        Schema::table('client_assets', function (Blueprint $table) {
            if (Schema::hasColumn('client_assets', 'hosting_amount')) {
                $table->dropColumn('hosting_amount');
            }
        });
    }
}
