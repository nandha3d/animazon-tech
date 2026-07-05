<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Register the "client asset" permissions and grant them to every role that
 * can already manage clients, so existing admins get the new module for free.
 */
class AddClientAssetPermissions extends Migration
{
    private array $perms = [
        'manage client asset',
        'create client asset',
        'edit client asset',
        'delete client asset',
        'show client asset',
    ];

    public function up()
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach ($this->perms as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // grant to roles that already have 'manage client'
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
