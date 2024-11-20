<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_name'=> $this->faker->name,
            'customer_email' => $this->faker->unique()->safeEmail,
            'customer_phone' => $this->faker->phoneNumber,
            'date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['paid', 'unpaid']),
            'total_payment' => $this->faker->randomFloat(2, 100, 10000),
            'created_at' => now(),
            'updated_at' => now(),
            // Add other fields as needed
        ];
    }
}
