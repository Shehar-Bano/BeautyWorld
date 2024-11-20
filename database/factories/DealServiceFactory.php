<?php

namespace Database\Factories;

use App\Models\Deal;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DealService>
 */
class DealServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'deal_id' => Deal::factory(),
            'service_id' => Service::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
