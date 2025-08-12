<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all roles
        $superAdmin = Role::where('slug', 'super-admin')->first();
        $admin = Role::where('slug', 'administrator')->first();
        $userManager = Role::where('slug', 'user-manager')->first();
        $roleManager = Role::where('slug', 'role-manager')->first();
        $regularUser = Role::where('slug', 'regular-user')->first();
        $guest = Role::where('slug', 'guest')->first();

        // Get all permissions
        $permissions = Permission::all();

        // Super Admin gets all permissions
        if ($superAdmin && $permissions->count() > 0) {
            $superAdmin->permissions()->attach($permissions->pluck('id')->toArray());
        }

        // Administrator gets most permissions (except some sensitive ones)
        if ($admin) {
            $adminPermissions = Permission::whereNotIn('name', [
                'permission.delete',
                'role.delete'
            ])->get();
            if ($adminPermissions->count() > 0) {
                $admin->permissions()->attach($adminPermissions->pluck('id')->toArray());
            }
        }

        // User Manager gets user-related permissions
        if ($userManager) {
            $userPermissions = Permission::whereIn('name', [
                'user.view',
                'user.create',
                'user.edit',
                'user.delete',
                'role.view'
            ])->get();
            if ($userPermissions->count() > 0) {
                $userManager->permissions()->attach($userPermissions->pluck('id')->toArray());
            }
        }

        // Role Manager gets role and permission management permissions
        if ($roleManager) {
            $rolePermissions = Permission::whereIn('name', [
                'role.view',
                'role.create',
                'role.edit',
                'role.delete',
                'permission.view',
                'permission.create',
                'permission.edit',
                'permission.delete'
            ])->get();
            if ($rolePermissions->count() > 0) {
                $roleManager->permissions()->attach($rolePermissions->pluck('id')->toArray());
            }
        }

        // Regular User gets basic view permissions
        if ($regularUser) {
            $basicPermissions = Permission::whereIn('name', [
                'user.view',
                'role.view'
            ])->get();
            if ($basicPermissions->count() > 0) {
                $regularUser->permissions()->attach($basicPermissions->pluck('id')->toArray());
            }
        }

        // Guest gets minimal permissions
        if ($guest) {
            $guestPermissions = Permission::whereIn('name', [
                'user.view'
            ])->get();
            if ($guestPermissions->count() > 0) {
                $guest->permissions()->attach($guestPermissions->pluck('id')->toArray());
            }
        }
    }
}
