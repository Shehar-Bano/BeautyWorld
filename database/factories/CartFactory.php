<?php

namespace Database\Factories;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition()
    {
        return [
            'seat_number' => $this->faker->unique()->bothify('Seat-###'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
