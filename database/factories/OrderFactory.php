<?php

namespace Database\Factories;

use App\Models\Orders;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Orders::class;
    public function definition(): array
    {
        return [
            'customer_name' => $this->faker->name(),
            'customer_phone' => $this->faker->phoneNumber(),
            'customer_email' => $this->faker->unique()->safeEmail(),
            'total_payment' => $this->faker->numberBetween(100, 10000), // Adjust range as needed
            'date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['paid', 'unpaid']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
