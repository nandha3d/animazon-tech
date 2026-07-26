<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Customer;
use App\Models\Proposal;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the proposal is not already created
        if (Proposal::where('url_slug', 'ipcatn-event')->exists()) {
            return;
        }

        $admin = User::where('type', 'company')->first();
        $adminId = $admin ? $admin->id : 2;

        // Find a customer matching "Babu" or "Platinaa", or create a new one
        $customer = Customer::where('name', 'LIKE', '%Babu%')
            ->orWhere('name', 'LIKE', '%Platinaa%')
            ->first();
            
        if (!$customer) {
            $customer = Customer::create([
                'customer_id' => (Customer::max('customer_id') ?? 0) + 1,
                'name' => 'Babu (IPCATN)',
                'email' => 'babu@ipcatn.local',
                'contact' => '0000000000',
                'created_by' => $adminId,
                'is_active' => 1,
            ]);
        }

        $maxProposalId = Proposal::max('proposal_id') ?? 0;
        
        $proposal = new Proposal();
        $proposal->proposal_id = $maxProposalId + 1;
        $proposal->url_slug = 'ipcatn-event';
        $proposal->customer_id = $customer->id;
        $proposal->issue_date = date('Y-m-d');
        $proposal->valid_till = date('Y-m-d', strtotime('+30 days'));
        // Try to find a valid category, else default to 1
        $category = \App\Models\ProductServiceCategory::first();
        $proposal->category_id = $category ? $category->id : 1; 
        $proposal->status = 1; // 0 = Draft, 1 = Open, 2 = Accepted
        $proposal->discount_apply = 0;
        $proposal->is_convert = 0;
        $proposal->converted_invoice_id = 0;
        $proposal->created_by = $adminId;
        $proposal->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Proposal::where('url_slug', 'ipcatn-event')->delete();
    }
};
