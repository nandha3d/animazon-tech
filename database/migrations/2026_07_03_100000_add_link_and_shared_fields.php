<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Link Client (users.type='client') and Customer (customers table) as the same
 * real entity, and give the users table the same billing/shipping/contact
 * fields the customer form already has so both forms can share one field set.
 */
class AddLinkAndSharedFields extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'customer_id')) {
                // link to the matching row in the customers table (nullable)
                $table->unsignedBigInteger('customer_id')->nullable()->after('created_by');
            }
            if (!Schema::hasColumn('users', 'job_title')) {
                $table->string('job_title')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'contact')) {
                $table->string('contact')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'tax_number')) {
                $table->string('tax_number')->nullable()->after('contact');
            }
            foreach (['billing', 'shipping'] as $g) {
                if (!Schema::hasColumn('users', $g . '_name')) {
                    $table->string($g . '_name')->nullable();
                    $table->string($g . '_country')->nullable();
                    $table->string($g . '_state')->nullable();
                    $table->string($g . '_city')->nullable();
                    $table->string($g . '_phone')->nullable();
                    $table->string($g . '_zip')->nullable();
                    $table->text($g . '_address')->nullable();
                }
            }
        });

        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'linked_user_id')) {
                // link back to the matching users row (the client)
                $table->unsignedBigInteger('linked_user_id')->nullable()->after('created_by');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $cols = ['customer_id', 'job_title', 'contact', 'tax_number'];
            foreach (['billing', 'shipping'] as $g) {
                foreach (['name', 'country', 'state', 'city', 'phone', 'zip', 'address'] as $f) {
                    $cols[] = $g . '_' . $f;
                }
            }
            foreach ($cols as $c) {
                if (Schema::hasColumn('users', $c)) {
                    $table->dropColumn($c);
                }
            }
        });

        Schema::table('customers', function (Blueprint $table) {
            if (Schema::hasColumn('customers', 'linked_user_id')) {
                $table->dropColumn('linked_user_id');
            }
        });
    }
}
