<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $clientType = fake()->randomElement(['fizicko', 'pravno']);

        return [
            'name' => $clientType === 'fizicko'
                ? fake()->name()
                : fake()->company(),
            'client_type' => $clientType,
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'note' => fake()->optional()->sentence(),
        ];
    }
}
