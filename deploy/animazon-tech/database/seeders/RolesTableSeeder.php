<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->delete();
        
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'super admin',
                'guard_name' => 'web',
                'created_by' => 0,
                'created_at' => '2026-03-10 05:00:41',
                'updated_at' => '2026-03-10 05:00:41',
            ],
            [
                'id' => 2,
                'name' => 'company',
                'guard_name' => 'web',
                'created_by' => 0,
                'created_at' => '2026-03-10 05:00:41',
                'updated_at' => '2026-03-10 05:00:41',
            ],
            [
                'id' => 3,
                'name' => 'accountant',
                'guard_name' => 'web',
                'created_by' => 2,
                'created_at' => '2026-03-10 05:00:42',
                'updated_at' => '2026-03-10 05:00:42',
            ],
            [
                'id' => 4,
                'name' => 'Employee',
                'guard_name' => 'web',
                'created_by' => 2,
                'created_at' => '2026-03-10 05:00:42',
                'updated_at' => '2026-03-10 05:00:42',
            ],
            [
                'id' => 5,
                'name' => 'client',
                'guard_name' => 'web',
                'created_by' => 2,
                'created_at' => '2026-03-10 05:00:42',
                'updated_at' => '2026-03-10 05:00:42',
            ],
        ]);
    }
}
