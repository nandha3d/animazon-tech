<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Interlink the estimate -> project -> invoice pipeline so the Cost Calculator
 * estimate, its generated Project, and the billed Invoice all reference each
 * other instead of being connected only by free-text notes.
 */
class AddEstimateInvoiceProjectLinks extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'cost_estimate_id')) {
                $table->unsignedBigInteger('cost_estimate_id')->nullable()->after('category_id');
            }
            if (!Schema::hasColumn('invoices', 'project_id')) {
                $table->unsignedBigInteger('project_id')->nullable()->after('cost_estimate_id');
            }
        });

        if (Schema::hasTable('projects')) {
            Schema::table('projects', function (Blueprint $table) {
                if (!Schema::hasColumn('projects', 'cost_estimate_id')) {
                    $table->unsignedBigInteger('cost_estimate_id')->nullable();
                }
            });
        }

        if (Schema::hasTable('cost_estimates')) {
            Schema::table('cost_estimates', function (Blueprint $table) {
                if (!Schema::hasColumn('cost_estimates', 'invoice_id')) {
                    $table->unsignedBigInteger('invoice_id')->nullable();
                }
                if (!Schema::hasColumn('cost_estimates', 'project_id')) {
                    $table->unsignedBigInteger('project_id')->nullable();
                }
            });
        }
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            foreach (['cost_estimate_id', 'project_id'] as $c) {
                if (Schema::hasColumn('invoices', $c)) {
                    $table->dropColumn($c);
                }
            }
        });

        if (Schema::hasTable('projects') && Schema::hasColumn('projects', 'cost_estimate_id')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('cost_estimate_id');
            });
        }

        if (Schema::hasTable('cost_estimates')) {
            Schema::table('cost_estimates', function (Blueprint $table) {
                foreach (['invoice_id', 'project_id'] as $c) {
                    if (Schema::hasColumn('cost_estimates', $c)) {
                        $table->dropColumn($c);
                    }
                }
            });
        }
    }
}
