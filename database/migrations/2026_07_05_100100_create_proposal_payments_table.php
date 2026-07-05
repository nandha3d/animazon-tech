<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Payments recorded against a proposal (client pays on the public tracking
 * page). Mirrors invoice_payments; Proposal::getDue() already summed
 * $this->payments but the relation/table never existed — this fixes that.
 */
class CreateProposalPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('proposal_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('proposal_id');
            $table->date('date');
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('payment_type')->default('razorpay'); // razorpay|bank|cash|other
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->index('proposal_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('proposal_payments');
    }
}
