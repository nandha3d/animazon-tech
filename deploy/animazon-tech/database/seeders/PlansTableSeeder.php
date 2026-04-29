<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('plans')->delete();
        
        DB::table('plans')->insert([
            [
                'id' => 1,
                'name' => 'Free Plan',
                'price' => 0.00,
                'duration' => 'lifetime',
                'max_users' => 5,
                'max_customers' => 5,
                'max_venders' => 5,
                'max_clients' => 5,
                'trial' => 0,
                'trial_days' => null,
                'is_disable' => 1,
                'storage_limit' => 1024,
                'chatgpt' => 1,
                'crm' => 1,
                'hrm' => 1,
                'account' => 1,
                'project' => 1,
                'pos' => 1,
                'description' => null,
                'image' => 'free_plan.png',
                'created_at' => '2026-03-10 05:00:41',
                'updated_at' => '2026-03-10 05:00:41',
            ],
        ]);
    }
}
