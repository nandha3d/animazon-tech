<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Recurring maintenance / retainer billing per client — not tied to a
 * website (client_assets). Covers whatever an agency bills on a cycle:
 * software maintenance, hosting support, 3D animation retainers, etc.
 * service_type is free text (with UI suggestions) since offerings vary.
 */
class CreateClientMaintenancePlansTable extends Migration
{
    public function up()
    {
        Schema::create('client_maintenance_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id'); // -> users.id (type=client)
            $table->string('service_type');           // e.g. "Website Maintenance", "3D Animation Retainer"
            $table->string('title')->nullable();       // short label, e.g. "Monthly retainer"
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('billing_cycle');           // monthly|quarterly|half_yearly|yearly|one_time
            $table->date('start_date')->nullable();
            $table->date('next_due_date')->nullable();
            $table->string('status')->default('active'); // active|paused|cancelled
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->index('client_id');
            $table->index('created_by');
            $table->index('next_due_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_maintenance_plans');
    }
}
