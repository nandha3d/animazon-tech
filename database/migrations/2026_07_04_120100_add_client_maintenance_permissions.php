<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AddClientMaintenancePermissions extends Migration
{
    private array $perms = [
        'manage client maintenance',
        'create client maintenance',
        'edit client maintenance',
        'delete client maintenance',
    ];

    public function up()
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach ($this->perms as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        foreach (Role::where('guard_name', 'web')->get() as $role) {
            if ($role->hasPermissionTo('manage client')) {
                $role->givePermissionTo($this->perms);
            }
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down()
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Permission::whereIn('name', $this->perms)->where('guard_name', 'web')->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
