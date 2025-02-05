<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@restaurant.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create Manager
        User::create([
            'name' => 'Manager User',
            'email' => 'manager@restaurant.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
        ]);

        // Create Staff
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@restaurant.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);
    }
}
