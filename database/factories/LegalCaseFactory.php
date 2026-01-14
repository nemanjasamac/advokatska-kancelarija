<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LegalCaseFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'case_type' => fake()->word(),
            'court' => fake()->word(),
            'opponent' => fake()->word(),
            'status' => fake()->randomElement(["novi","otvoren","u_toku","na_cekanju","zatvoren"]),
            'opened_at' => fake()->date(),
            'closed_at' => fake()->date(),
            'client_id' => Client::factory(),
            'user_id' => User::factory(),
        ];
    }
}
