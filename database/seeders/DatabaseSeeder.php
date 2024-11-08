<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'is_admin' => true
        ]);

        // User
        User::factory()->create([
            'name' => 'Test User Two',
            'email' => 'test2@example.com',
            'password' => Hash::make('password123'),
            'is_admin' => false
        ]);
    }
}
