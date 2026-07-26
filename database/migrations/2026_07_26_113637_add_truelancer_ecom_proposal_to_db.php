<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Avoid inserting if the slug already exists to prevent unique constraint errors
        if (DB::table('proposals')->where('url_slug', 'ecom-crm-erp')->exists()) {
            return;
        }

        $now = Carbon::now();

        // 1. Get or Create Customer
        $customerId = DB::table('customers')->insertGetId([
            'customer_id' => DB::table('customers')->max('customer_id') + 1,
            'name' => 'Esteemed Customer',
            'email' => 'client@animazon.in',
            'contact' => '0000000000',
            'created_by' => 2, // Default admin
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Create Proposal
        $proposalId = DB::table('proposals')->insertGetId([
            'proposal_id' => DB::table('proposals')->max('proposal_id') + 1,
            'url_slug' => 'ecom-crm-erp',
            'customer_id' => $customerId,
            'issue_date' => $now->toDateString(),
            'valid_till' => $now->copy()->addDays(30)->toDateString(),
            'category_id' => 1,
            'status' => 1, // Open status
            'discount_apply' => 0,
            'is_convert' => 0,
            'converted_invoice_id' => 0,
            'created_by' => 2,
            'terms' => 'Custom eCommerce Website with CRM and ERP Integration. Fixed price ₹35,000.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3. Add Line Item
        DB::table('proposal_products')->insert([
            'proposal_id' => $proposalId,
            'product_id' => 1,
            'quantity' => 1,
            'tax' => '0',
            'discount' => 0,
            'price' => 35000,
            'description' => 'Custom eCommerce platform development, CRM integration, and lightweight ERP module as per proposal.',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $proposal = DB::table('proposals')->where('url_slug', 'ecom-crm-erp')->first();
        if ($proposal) {
            DB::table('proposal_products')->where('proposal_id', $proposal->id)->delete();
            DB::table('customers')->where('id', $proposal->customer_id)->delete();
            DB::table('proposals')->where('id', $proposal->id)->delete();
        }
    }
};
