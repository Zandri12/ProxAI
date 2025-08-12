<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@proxa.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true
        ]);

        // Create Administrator
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true
        ]);

        // Create User Manager
        $userManager = User::create([
            'name' => 'User Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true
        ]);

        // Create Regular User
        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true
        ]);

        // Create Guest User (inactive)
        $guestUser = User::create([
            'name' => 'Guest User',
            'email' => 'guest@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => null,
            'is_active' => false
        ]);

        // Get roles
        $superAdminRole = Role::where('slug', 'super-admin')->first();
        $adminRole = Role::where('slug', 'administrator')->first();
        $userManagerRole = Role::where('slug', 'user-manager')->first();
        $regularUserRole = Role::where('slug', 'regular-user')->first();
        $guestRole = Role::where('slug', 'guest')->first();

        // Assign roles to users
        if ($superAdminRole) {
            $superAdmin->roles()->attach($superAdminRole->id);
        }
        
        if ($adminRole) {
            $admin->roles()->attach($adminRole->id);
        }
        
        if ($userManagerRole) {
            $userManager->roles()->attach($userManagerRole->id);
        }
        
        if ($regularUserRole) {
            $regularUser->roles()->attach($regularUserRole->id);
        }
        
        if ($guestRole) {
            $guestUser->roles()->attach($guestRole->id);
        }
    }
}
