<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InitController extends Controller
{
    public function initialize()
    {

        if (DB::table('permissions')->get()->count() == 0) {
            $module = [
                'Role',
                'Admin',
                'User',
                'Category',
                'SubCategory',
                'Product',
                'Pages',
                'Store',
            ];

            foreach ($module as $moduleName) {
                Permission::create([
                    'name' => 'Create' . $moduleName,
                    'guard_name' => 'admin'
                ]);
                Permission::create([
                    'name' => 'View' . $moduleName,
                    'guard_name' => 'admin'
                ]);
                Permission::create([
                    'name' => 'Edit' . $moduleName,
                    'guard_name' => 'admin'
                ]);
                Permission::create([
                    'name' => 'Delete' . $moduleName,
                    'guard_name' => 'admin'
                ]);
            }
        }

        if (DB::table('roles')->get()->count()) {
            $role = Role::create([
                'name' => 'Super Admin',
                'guard_name' => 'admin'
            ]);
        }

        if (DB::table('role_has_permissions')->get()->count()) {
            $user = DB::table('admins')->where(['status' => 'Active'])->get();
            $role = Role::first();
            $role->givePermissionTo('Create Role');
            $role->givePermissionTo('View Role');
            $role->givePermissionTo('Edit Role');
            $role->givePermissionTo('Delete Role');
            $role->givePermissionTo('Create Role');
            $role->givePermissionTo('View Role');
            $role->givePermissionTo('Edit Role');
            $role->givePermissionTo('Delete Role');
        }

        if (DB::table('model_has_roles')->get()->count() == 0) {
            $role = Role::first();
            $user = Admin::first();
            $user->assignRole($role);
        }

        return true;
    }
}
