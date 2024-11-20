<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('88888888'),
            'phone' => $this->faker->numerify('###########'), // Generates a phone number up to 15 characters
            'designation' => $this->faker->randomElement(['worker', 'manager', 'supervisor']),
            'joining_date' => $this->faker->date(),
            'salary' => $this->faker->randomFloat(2, 30000, 100000), // Salary between 30,000 and 100,000
            'status' => $this->faker->randomElement(['active', 'inactive', 'on leave']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
