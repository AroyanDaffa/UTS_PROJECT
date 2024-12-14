<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Shipping;
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
        // Admin User
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
            $customer = Customer::create([
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'orders' => 0,
                'last_order' => Date::now(),
            ]);
        }

        // Categories
        $categories = [
            'Electronics',
            'Clothing',
            'Books',
            'Home & Garden',
            'Toys'
        ];

        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName
            ]);
        }

        // Products
        $products = [
            [
                'name' => 'Smartphone',
                'price' => 799.99,
                'stock' => 50,
                'category_id' => 1,
                'category_name' => 'Electronics'
            ],
            [
                'name' => 'T-Shirt',
                'price' => 29.99,
                'stock' => 100,
                'category_id' => 2,
                'category_name' => 'Clothing'
            ],
            [
                'name' => 'Novel',
                'price' => 19.99,
                'stock' => 75,
                'category_id' => 3,
                'category_name' => 'Books'
            ],
            [
                'name' => 'Garden Tools Set',
                'price' => 149.99,
                'stock' => 30,
                'category_id' => 4,
                'category_name' => 'Home & Garden'
            ],
            [
                'name' => 'LEGO Set',
                'price' => 59.99,
                'stock' => 45,
                'category_id' => 5,
                'category_name' => 'Toys'
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Orders
        $order = Order::create([
            'total' => 799.99,
            'date' => Date::now(),
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'product_id' => 1,
            'product_name' => 'Smartphone',
            'destination_address' => '123 Main St, City, Country'
        ]);

        // Update customer's order count and last order date
        $customer->update([
            'orders' => 1,
            'last_order' => Date::now()
        ]);

        // Shipping
        Shipping::create([
            'shipping_status' => 'Processing',
            'shipping_current_location' => 'Warehouse',
            'address' => '123 Main St, City, Country',
            'no_resi' => 'SHP' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT),
            'order_id' => $order->id
        ]);
    }
}
