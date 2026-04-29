<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->after('email')->nullable();
            }
            if (!Schema::hasColumn('users', 'plan')) {
                $table->integer('plan')->after('password')->nullable();
            }
            if (!Schema::hasColumn('users', 'plan_expire_date')) {
                $table->date('plan_expire_date')->after('plan')->nullable();
            }
            if (!Schema::hasColumn('users', 'type')) {
                $table->string('type', 100)->after('plan_expire_date')->nullable();
            }
            if (!Schema::hasColumn('users', 'storage_limit')) {
                $table->float('storage_limit')->after('type')->default('0.00');
            }
            if (!Schema::hasColumn('users', 'lang')) {
                $table->string('lang', 100)->after('storage_limit')->nullable();
            }
            if (!Schema::hasColumn('users', 'default_pipeline')) {
                $table->integer('default_pipeline')->after('lang')->nullable();
            }
            if (!Schema::hasColumn('users', 'delete_status')) {
                $table->integer('delete_status')->after('default_pipeline')->default(1);
            }
            if (!Schema::hasColumn('users', 'mode')) {
                $table->string('mode', 10)->after('delete_status')->default('light');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->integer('is_active')->after('mode')->default(1);
            }
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->datetime('last_login_at')->after('is_active')->nullable();
            }
            if (!Schema::hasColumn('users', 'created_by')) {
                $table->integer('created_by')->after('last_login_at')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'email_verified_at', 'plan', 'plan_expire_date', 'type', 'storage_limit',
                'lang', 'default_pipeline', 'delete_status', 'mode', 'is_active',
                'last_login_at', 'created_by'
            ]);
        });
    }
};
