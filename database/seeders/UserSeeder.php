<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $managerRole = Role::where('name', 'manager')->first();
        $staffRole = Role::where('name', 'staff_engineering')->first();

        // Create Manager
        User::firstOrCreate(
            ['email' => 'manager@hospital.com'],
            [
                'name' => 'Hospital Manager',
                'password' => Hash::make('password'),
                'role_id' => $managerRole->id,
                'email_verified_at' => now(),
            ]
        );

        // Create Staff Engineering users
        $staffUsers = [
            [
                'name' => 'John Engineer',
                'email' => 'john@hospital.com',
            ],
            [
                'name' => 'Sarah Technician',
                'email' => 'sarah@hospital.com',
            ],
            [
                'name' => 'Mike Maintenance',
                'email' => 'mike@hospital.com',
            ],
        ];

        foreach ($staffUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'role_id' => $staffRole->id,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}