<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        // User::factory(10)->create();

        // Create Admin User
        $adminRole = \App\Models\Role::where('slug', 'admin')->first();
        if ($adminRole) {
             \App\Models\User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'System Admin',
                    'password' => bcrypt('password'),
                    'role_id' => $adminRole->id,
                ]
            );
        }

        // Create Staff User
        $staffRole = \App\Models\Role::where('slug', 'staff')->first();
        if ($staffRole) {
             \App\Models\User::firstOrCreate(
                ['email' => 'staff@example.com'],
                [
                    'name' => 'Staff User',
                    'password' => bcrypt('password'),
                    'role_id' => $staffRole->id,
                ]
            );
        }
    }
}
