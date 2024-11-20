<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Deal;
use App\Models\DealService;
use App\Models\Orders;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Import this
use Illuminate\Support\Str; // Import this

class DatabaseSeeder extends Seeder
{
   
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Unique identifier for the admin
            [
                'name' => 'Admin User',
                'password' => Hash::make('88888888'), // Set a secure password
                'phone' => '1234567890876',
                'designation' => 'admin',
                'joining_date' => now(),
                'salary' => 100000.00,
                'status' => 'active',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );

        // Run other factory-generated seeds
        User::factory(10)->create();
        ServiceCategory::factory()->count(10)->create();
        Service::factory()->count(20)->create();
        Deal::factory()->count(10)->create();
        DealService::factory()->count(20)->create();
        Cart::factory()->count(10)->create();
        CartItems::factory()->count(30)->create();
        Orders::factory()->count(10)->create();
        OrderService::factory()->count(30)->create();

    }
}
