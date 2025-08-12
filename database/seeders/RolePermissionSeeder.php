<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all roles and permissions
        $superAdmin = Role::where('slug', 'super-admin')->first();
        $admin = Role::where('slug', 'admin')->first();
        $developer = Role::where('slug', 'developer')->first();
        $user = Role::where('slug', 'user')->first();

        // Super Admin gets all permissions
        if ($superAdmin) {
            $superAdmin->permissions()->attach(Permission::all());
        }

        // Admin gets most permissions except super admin specific ones
        if ($admin) {
            $adminPermissions = Permission::whereNotIn('slug', [
                'permissions.create',
                'permissions.delete'
            ])->get();
            $admin->permissions()->attach($adminPermissions);
        }

        // Developer gets technical permissions
        if ($developer) {
            $developerPermissions = Permission::whereIn('slug', [
                'users.view',
                'roles.view',
                'permissions.view',
                'dashboard.access',
                'profile.edit'
            ])->get();
            $developer->permissions()->attach($developerPermissions);
        }

        // User gets basic permissions
        if ($user) {
            $userPermissions = Permission::whereIn('slug', [
                'dashboard.access',
                'profile.edit'
            ])->get();
            $user->permissions()->attach($userPermissions);
        }

        $this->command->info('Role permissions assigned successfully!');
    }
}
