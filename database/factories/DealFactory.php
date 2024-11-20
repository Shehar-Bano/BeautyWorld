<?php

namespace Database\Factories;

use App\Models\Deal;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
    protected $model = Deal::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'dis_price' => $this->faker->numberBetween(50, 500),
            'duration' => $this->faker->randomElement(['1 hour', '2 hours']),
            'description' => $this->faker->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
