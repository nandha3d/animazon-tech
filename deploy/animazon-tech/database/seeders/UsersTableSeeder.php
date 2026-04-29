<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();
        
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'admin@animazon.com',
                'email_verified_at' => '2026-04-24 19:06:21',
                'password' => '$2y$12$tDIptbPJe4kwuBtGCkUVI.Z6Zw6P4jlP1w6ctLZOh.PAstaS95Fve',
                'type' => 'super admin',
                'storage_limit' => 0,
                'avatar' => null,
                'lang' => 'en',
                'default_pipeline' => null,
                'delete_status' => 1,
                'created_by' => 0,
                'plan' => 1,
                'plan_expire_date' => '2030-12-31',
                'requested_plan' => 0,
                'last_login_at' => null,
                'mode' => 'light',
                'is_active' => 1,
                'is_trial_done' => 1,
                'interested_plan_id' => 0,
                'is_register_trial' => 1,
                'active_status' => 1,
                'dark_mode' => 0,
                'messenger_color' => '#2180f3',
                'is_enable_login' => 1,
                'remember_token' => null,
                'created_at' => '2026-04-16 18:38:42',
                'updated_at' => '2026-04-16 18:38:42',
            ],
            [
                'id' => 2,
                'name' => 'Animazon',
                'email' => 'company@animazon.com',
                'email_verified_at' => '2026-04-24 19:04:55',
                'password' => '$2y$10$aAKg6Gy.2kpTWEWybWQM5eSFQ3jNC4SV9DghJi1mVIkvrmrfLd.v6',
                'type' => 'company',
                'storage_limit' => 0,
                'avatar' => null,
                'lang' => 'en',
                'default_pipeline' => null,
                'delete_status' => 1,
                'created_by' => 1,
                'plan' => 1,
                'plan_expire_date' => '2030-12-31',
                'requested_plan' => 0,
                'last_login_at' => '2026-04-26 05:04:35',
                'mode' => 'light',
                'is_active' => 1,
                'is_trial_done' => 1,
                'interested_plan_id' => 0,
                'is_register_trial' => 1,
                'active_status' => 1,
                'dark_mode' => 0,
                'messenger_color' => '#2180f3',
                'is_enable_login' => 1,
                'remember_token' => null,
                'created_at' => '2026-04-16 18:38:42',
                'updated_at' => '2026-04-26 05:04:35',
            ],
        ]);
    }
}
