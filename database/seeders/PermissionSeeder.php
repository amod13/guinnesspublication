<?php

namespace Database\Seeders;

use App\Modules\UserManagement\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permission::truncate();

        $permissions = [
            // Dashboard
            [
                'name' => 'View Dashboard',
                'action' => 'AdminLayout',
                'controller' => 'DashboardManagementController',
                'group_name' => 'dashboard',
            ],

            // Role
            [
                'name' => 'View Roles',
                'action' => 'index',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Create Role',
                'action' => 'create',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Store Role',
                'action' => 'store',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Edit Role',
                'action' => 'edit',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Update Role',
                'action' => 'update',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Delete Role',
                'action' => 'delete',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Show Role Details',
                'action' => 'show',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Assign Permission to Role',
                'action' => 'addPermission',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],

            // Permission
            [
                'name' => 'View Permissions',
                'action' => 'index',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Create Permission',
                'action' => 'create',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Store Permission',
                'action' => 'store',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Edit Permission',
                'action' => 'edit',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Update Permission',
                'action' => 'update',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Delete Permission',
                'action' => 'delete',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Show Permission Details',
                'action' => 'show',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],

            // RoleHasPermission
            [
                'name' => 'Assign Permissions to Roles',
                'action' => 'store',
                'controller' => 'RoleHasPermissionController',
                'group_name' => 'role_permission',
            ],

            // User
            [
                'name' => 'View Users',
                'action' => 'index',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Create User',
                'action' => 'create',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Store User',
                'action' => 'store',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Edit User',
                'action' => 'edit',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Update User',
                'action' => 'update',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Delete User',
                'action' => 'delete',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Show User Details',
                'action' => 'show',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Search Users',
                'action' => 'getUserSearchByNameOrStatus',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],

            // User Management - Additional Actions
            [
                'name' => 'Bulk Delete Users',
                'action' => 'bulkDelete',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Export Users',
                'action' => 'export',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Import Users',
                'action' => 'import',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Change User Status',
                'action' => 'changeStatus',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Reset User Password',
                'action' => 'resetPassword',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],

            // Role Management - Additional Actions
            [
                'name' => 'Bulk Delete Roles',
                'action' => 'bulkDelete',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Clone Role',
                'action' => 'clone',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Change Role Status',
                'action' => 'changeStatus',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],

            // Permission Management - Additional Actions
            [
                'name' => 'Bulk Delete Permissions',
                'action' => 'bulkDelete',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Sync Permissions',
                'action' => 'sync',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],

            // Media Library
            [
                'name' => 'View Media Library',
                'action' => 'index',
                'controller' => 'MediaController',
                'group_name' => 'media',
            ],
            [
                'name' => 'Upload Media',
                'action' => 'upload',
                'controller' => 'MediaController',
                'group_name' => 'media',
            ],
            [
                'name' => 'Store Media',
                'action' => 'store',
                'controller' => 'MediaController',
                'group_name' => 'media',
            ],
            [
                'name' => 'Edit Media',
                'action' => 'edit',
                'controller' => 'MediaController',
                'group_name' => 'media',
            ],
            [
                'name' => 'Update Media',
                'action' => 'update',
                'controller' => 'MediaController',
                'group_name' => 'media',
            ],
            [
                'name' => 'Delete Media',
                'action' => 'delete',
                'controller' => 'MediaController',
                'group_name' => 'media',
            ],
            [
                'name' => 'Show Media Details',
                'action' => 'show',
                'controller' => 'MediaController',
                'group_name' => 'media',
            ],
            [
                'name' => 'Bulk Delete Media',
                'action' => 'bulkDelete',
                'controller' => 'MediaController',
                'group_name' => 'media',
            ],
            [
                'name' => 'Search Media',
                'action' => 'search',
                'controller' => 'MediaController',
                'group_name' => 'media',
            ],
            [
                'name' => 'Filter Media',
                'action' => 'filter',
                'controller' => 'MediaController',
                'group_name' => 'media',
            ],
            [
                'name' => 'Download Media',
                'action' => 'download',
                'controller' => 'MediaController',
                'group_name' => 'media',
            ],

            // User Detail
            [
                'name' => 'View User Details',
                'action' => 'userProfile',
                'controller' => 'UserController',
                'group_name' => 'user_detail',
            ],
            [
                'name' => 'Update User Details',
                'action' => 'updateProfile',
                'controller' => 'UserController',
                'group_name' => 'user_detail',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
