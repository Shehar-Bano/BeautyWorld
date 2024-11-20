<?php

namespace Database\Factories;

use App\Models\Deal;
use App\Models\Orders;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderService>
 */
class OrderServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Find an existing user with the designation 'worker'
        $user = User::where('designation', 'worker')->inRandomOrder()->first() ?? User::first();

        return [
            'order_id' => Orders::factory(),
            'service_id' => $this->faker->boolean ? Service::factory() : null,
            'deal_id' => $this->faker->boolean ? Deal::factory() : null,
            'employee_id' =>  $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
