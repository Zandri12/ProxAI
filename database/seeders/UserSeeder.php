<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@proxa.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // Create Regular User
        $john = User::create([
            'name' => 'John Doe',
            'email' => 'john@proxa.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // Create Another User
        $jane = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@proxa.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // Create Developer User
        $developer = User::create([
            'name' => 'Developer',
            'email' => 'dev@proxa.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // Create Test User
        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@proxa.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // Assign roles to users
        $adminRole = Role::where('slug', 'admin')->first();
        $userRole = Role::where('slug', 'user')->first();
        $developerRole = Role::where('slug', 'developer')->first();

        if ($adminRole) {
            $admin->roles()->attach($adminRole);
        }

        if ($userRole) {
            $john->roles()->attach($userRole);
            $jane->roles()->attach($userRole);
            $testUser->roles()->attach($userRole);
        }

        if ($developerRole) {
            $developer->roles()->attach($developerRole);
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Default password for all users: password123');
        $this->command->info('Roles assigned to users successfully!');
    }
}
