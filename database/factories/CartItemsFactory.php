<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Deal;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemsFactory extends Factory
{
    protected $model = CartItems::class;

    public function definition()
    {
        return [
            'cart_id' => Cart::factory(),
            'service_id' => $this->faker->boolean ? Service::factory() : null,
            'deal_id' => $this->faker->boolean ? Deal::factory() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
