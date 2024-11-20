<?php

namespace Database\Factories;

use App\Models\Orders;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersFactory extends Factory
{
    protected $model = Orders::class;

    public function definition()
    {
        return [
            'customer_name' => $this->faker->name,
            'customer_phone' => $this->faker->phoneNumber,
            'customer_email' => $this->faker->safeEmail,
            'total_payment' => $this->faker->numberBetween(100, 2000),
            'date' => now(),
            'status' => 'unpaid',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
