<?php

namespace Database\Factories;

use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'date_time' => fake()->dateTime(),
            'type' => fake()->randomElement(["sastanak","rociste"]),
            'location' => fake()->word(),
            'note' => fake()->text(),
            'legal_case_id' => LegalCase::factory(),
            'user_id' => User::factory(),
        ];
    }
}
