<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Orders;
use App\Models\Expence;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Service;
use App\Models\OrderService;
use App\Models\ExpenceCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // In a seeder
        Orders::factory()->count(10)->create();
        Expence::factory()->count(10)->create();
        ExpenceCategory::factory()->count(10)->create();
        OrderService::factory()->count(10)->create();
        Service::factory()->count(10)->create();

    }
}
