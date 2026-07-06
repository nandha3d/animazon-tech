<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Proposal;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("--- Seeding Customers & Proposals ---");

        // 1. Create or get Rudra Spirit customer
        $rudraCustomer = Customer::where('email', 'contact@rudraspirit.com')->first();
        if (!$rudraCustomer) {
            $rudraCustomer = Customer::create([
                'customer_id' => 3,
                'name' => 'Rudra Spirit (rudraspirit.com)',
                'email' => 'contact@rudraspirit.com',
                'created_by' => 2,
                'is_active' => 1,
                'lang' => 'en'
            ]);
            $this->command->info("Created Rudra Customer (ID: {$rudraCustomer->id})");
        } else {
            $this->command->info("Found Rudra Customer (ID: {$rudraCustomer->id})");
        }

        // 2. Create or get KPSTA customer
        $kpstaCustomer = Customer::where('email', 'kpsta@animazon.in')->first();
        if (!$kpstaCustomer) {
            $kpstaCustomer = Customer::create([
                'customer_id' => 4,
                'name' => "Kerala Pradesh School Teacher's Association (K.P.S.T.A.)",
                'email' => 'kpsta@animazon.in',
                'created_by' => 2,
                'is_active' => 1,
                'lang' => 'en'
            ]);
            $this->command->info("Created KPSTA Customer (ID: {$kpstaCustomer->id})");
        } else {
            $this->command->info("Found KPSTA Customer (ID: {$kpstaCustomer->id})");
        }

        // 3. Ensure Proposal #1 (Rudra Agreement - Nov 2025) exists
        $rudraAgreement = Proposal::where('url_slug', 'rudra-spirit-agreement')->first();
        if (!$rudraAgreement) {
            $rudraAgreement = Proposal::create([
                'proposal_id' => 1,
                'url_slug' => 'rudra-spirit-agreement',
                'customer_id' => $rudraCustomer->id,
                'issue_date' => '2025-11-28',
                'valid_till' => '2025-12-05',
                'category_id' => 2,
                'status' => 2, // Accepted
                'created_by' => 2
            ]);
            $this->command->info("Created Proposal #1: rudra-spirit-agreement");
        } else {
            $rudraAgreement->update(['proposal_id' => 1, 'status' => 2]);
            $this->command->info("Updated Proposal #1: rudra-spirit-agreement");
        }

        // 4. Ensure Proposal #2 (Rudra Hosting - Jul 2026) exists
        $rudraHosting = Proposal::where('url_slug', 'rudra-spirit-hosting')->first();
        if ($rudraHosting) {
            $rudraHosting->update(['proposal_id' => 2]);
            $this->command->info("Updated Proposal #2: rudra-spirit-hosting");
        } else {
            $rudraHosting = Proposal::create([
                'proposal_id' => 2,
                'url_slug' => 'rudra-spirit-hosting',
                'customer_id' => $rudraCustomer->id,
                'issue_date' => '2026-07-04',
                'valid_till' => '2026-07-09',
                'category_id' => 2,
                'status' => 1, // Open
                'created_by' => 2
            ]);
            $this->command->info("Created Proposal #2: rudra-spirit-hosting");
        }

        // 5. Ensure Proposal #3 (KPSTA Website - Jul 2026) exists
        $kpstaProposal = Proposal::where('url_slug', 'kpsta-website')->first();
        if (!$kpstaProposal) {
            $kpstaProposal = Proposal::create([
                'proposal_id' => 3,
                'url_slug' => 'kpsta-website',
                'customer_id' => $kpstaCustomer->id,
                'issue_date' => '2026-07-06',
                'valid_till' => '2026-07-15',
                'category_id' => 2,
                'status' => 1, // Open
                'created_by' => 2
            ]);
            $this->command->info("Created Proposal #3: kpsta-website");
        } else {
            $kpstaProposal->update(['proposal_id' => 3, 'customer_id' => $kpstaCustomer->id]);
            $this->command->info("Updated Proposal #3: kpsta-website");
        }

        $this->command->info("--- Proposal Seeding Completed Successfully ---");
    }
}
