<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Full system access with all permissions',
                'is_active' => true
            ],
            [
                'name' => 'Administrator',
                'slug' => 'administrator',
                'description' => 'System administrator with most permissions',
                'is_active' => true
            ],
            [
                'name' => 'User Manager',
                'slug' => 'user-manager',
                'description' => 'Can manage users and basic roles',
                'is_active' => true
            ],
            [
                'name' => 'Role Manager',
                'slug' => 'role-manager',
                'description' => 'Can manage roles and permissions',
                'is_active' => true
            ],
            [
                'name' => 'Regular User',
                'slug' => 'regular-user',
                'description' => 'Standard user with basic access',
                'is_active' => true
            ],
            [
                'name' => 'Guest',
                'slug' => 'guest',
                'description' => 'Limited access user',
                'is_active' => false
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
