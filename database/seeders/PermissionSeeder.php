<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management
            ['name' => 'user.view', 'slug' => 'user-view', 'description' => 'Can view user list', 'module' => 'user', 'action' => 'view'],
            ['name' => 'user.create', 'slug' => 'user-create', 'description' => 'Can create new users', 'module' => 'user', 'action' => 'create'],
            ['name' => 'user.edit', 'slug' => 'user-edit', 'description' => 'Can edit existing users', 'module' => 'user', 'action' => 'edit'],
            ['name' => 'user.delete', 'slug' => 'user-delete', 'description' => 'Can delete users', 'module' => 'user', 'action' => 'delete'],
            
            // Role Management
            ['name' => 'role.view', 'slug' => 'role-view', 'description' => 'Can view role list', 'module' => 'role', 'action' => 'view'],
            ['name' => 'role.create', 'slug' => 'role-create', 'description' => 'Can create new roles', 'module' => 'role', 'action' => 'create'],
            ['name' => 'role.edit', 'slug' => 'role-edit', 'description' => 'Can edit existing roles', 'module' => 'role', 'action' => 'edit'],
            ['name' => 'role.delete', 'slug' => 'role-delete', 'description' => 'Can delete roles', 'module' => 'role', 'action' => 'delete'],
            
            // Permission Management
            ['name' => 'permission.view', 'slug' => 'permission-view', 'description' => 'Can view permission list', 'module' => 'permission', 'action' => 'view'],
            ['name' => 'permission.create', 'slug' => 'permission-create', 'description' => 'Can create new permissions', 'module' => 'permission', 'action' => 'create'],
            ['name' => 'permission.edit', 'slug' => 'permission-edit', 'description' => 'Can edit existing permissions', 'module' => 'permission', 'action' => 'edit'],
            ['name' => 'permission.delete', 'slug' => 'permission-delete', 'description' => 'Can delete permissions', 'module' => 'permission', 'action' => 'delete'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $this->command->info('Permissions seeded successfully!');
    }
}
