<?php

namespace Database\Seeders;

use App\Modules\UserManagement\Models\Role;
use App\Modules\UserManagement\Models\Permission;
use App\Modules\UserManagement\Models\RoleHasPermission;
use Illuminate\Database\Seeder;

class RoleHasPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Get superadmin role
        $superadminRole = Role::where('name', 'Super Admin')->first();

        if ($superadminRole) {
            // Get all permissions
            $permissions = Permission::all();

            // Assign all permissions to superadmin
            foreach ($permissions as $permission) {
                RoleHasPermission::create([
                    'role_id' => $superadminRole->id,
                    'permission_id' => $permission->id,
                ]);
            }
        }
    }
}
