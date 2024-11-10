<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Date;

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
            'is_admin' => true,
        ]);

        // Non-admin User
        $user = User::factory()->create([
            'name' => 'Test User Two',
            'email' => 'test2@example.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
        ]);

        // Register as Customer if user is non-admin
        if (!$user->is_admin) {
            Customer::create([
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'orders' => 0,
                'last_order' => Date::now(),
            ]);
        }
    }
}
