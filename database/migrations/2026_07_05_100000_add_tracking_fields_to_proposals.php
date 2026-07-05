<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds what the client-facing tracking page needs: a validity window, terms
 * shown to the client, and timestamps/reason for the accept/decline decision.
 */
class AddTrackingFieldsToProposals extends Migration
{
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
            if (!Schema::hasColumn('proposals', 'valid_till')) {
                $table->date('valid_till')->nullable()->after('issue_date');
            }
            if (!Schema::hasColumn('proposals', 'terms')) {
                $table->text('terms')->nullable()->after('category_id');
            }
            if (!Schema::hasColumn('proposals', 'accepted_at')) {
                $table->timestamp('accepted_at')->nullable();
            }
            if (!Schema::hasColumn('proposals', 'declined_at')) {
                $table->timestamp('declined_at')->nullable();
            }
            if (!Schema::hasColumn('proposals', 'decline_reason')) {
                $table->string('decline_reason')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            foreach (['valid_till', 'terms', 'accepted_at', 'declined_at', 'decline_reason'] as $c) {
                if (Schema::hasColumn('proposals', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
}
