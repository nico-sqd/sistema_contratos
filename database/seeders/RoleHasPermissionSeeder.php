<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //super-admin 
        $superadmin_permissions = Permission::all();
        Role::findOrFail(1)->syncPermissions($superadmin_permissions->pluck('id'));

        //admin
        $admin_permissions = $superadmin_permissions->filter(function($permission){
            return substr($permission->name, 0, 6) != 'super_';
        });
        Role::findOrFail(2)->syncPermissions($admin_permissions);

        $referente_permissions = $superadmin_permissions->filter(function($permission){
            return substr($permission->name, 0, 6) != 'super_' && 
                substr($permission->name, 0,6) != 'admin_';
        });
        Role::findOrFail(3)->syncPermissions($referente_permissions);
    }
}
