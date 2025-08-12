<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management
            [
                'name' => 'user.view',
                'slug' => 'user-view',
                'display_name' => 'View Users',
                'description' => 'Can view user list and details',
                'module' => 'User Management',
                'action' => 'View',
                'is_active' => true
            ],
            [
                'name' => 'user.create',
                'slug' => 'user-create',
                'display_name' => 'Create Users',
                'description' => 'Can create new users',
                'module' => 'User Management',
                'action' => 'Create',
                'is_active' => true
            ],
            [
                'name' => 'user.edit',
                'slug' => 'user-edit',
                'display_name' => 'Edit Users',
                'description' => 'Can edit existing users',
                'module' => 'User Management',
                'action' => 'Edit',
                'is_active' => true
            ],
            [
                'name' => 'user.delete',
                'slug' => 'user-delete',
                'display_name' => 'Delete Users',
                'description' => 'Can delete users',
                'module' => 'User Management',
                'action' => 'Delete',
                'is_active' => true
            ],
            
            // Role Management
            [
                'name' => 'role.view',
                'slug' => 'role-view',
                'display_name' => 'View Roles',
                'description' => 'Can view role list and details',
                'module' => 'Role Management',
                'action' => 'View',
                'is_active' => true
            ],
            [
                'name' => 'role.create',
                'slug' => 'role-create',
                'display_name' => 'Create Roles',
                'description' => 'Can create new roles',
                'module' => 'Role Management',
                'action' => 'Create',
                'is_active' => true
            ],
            [
                'name' => 'role.edit',
                'slug' => 'role-edit',
                'display_name' => 'Edit Roles',
                'description' => 'Can edit existing roles',
                'module' => 'Role Management',
                'action' => 'Edit',
                'is_active' => true
            ],
            [
                'name' => 'role.delete',
                'slug' => 'role-delete',
                'display_name' => 'Delete Roles',
                'description' => 'Can delete roles',
                'module' => 'Role Management',
                'action' => 'Delete',
                'is_active' => true
            ],
            
            // Permission Management
            [
                'name' => 'permission.view',
                'slug' => 'permission-view',
                'display_name' => 'View Permissions',
                'description' => 'Can view permission list and details',
                'module' => 'Permission Management',
                'action' => 'View',
                'is_active' => true
            ],
            [
                'name' => 'permission.create',
                'slug' => 'permission-create',
                'display_name' => 'Create Permissions',
                'description' => 'Can create new permissions',
                'module' => 'Permission Management',
                'action' => 'Create',
                'is_active' => true
            ],
            [
                'name' => 'permission.edit',
                'slug' => 'permission-edit',
                'display_name' => 'Edit Permissions',
                'description' => 'Can edit existing permissions',
                'module' => 'Permission Management',
                'action' => 'Edit',
                'is_active' => true
            ],
            [
                'name' => 'permission.delete',
                'slug' => 'permission-delete',
                'display_name' => 'Delete Permissions',
                'description' => 'Can delete permissions',
                'module' => 'Permission Management',
                'action' => 'Delete',
                'is_active' => true
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
