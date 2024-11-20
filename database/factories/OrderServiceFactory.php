<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'order_id' => \App\Models\Orders::factory()->create()->id,
            'service_id' => \App\Models\Service::factory()->create()->id,
            'employee_id' => \App\Models\User::factory()->create()->id,
            'deal_id' => \App\Models\Deal::factory()->create()->id,
            'created_at' => now(),
            'updated_at' => now(),
            // Add other fields as needed
        ];
    }
}
