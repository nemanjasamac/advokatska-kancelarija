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
        $type = fake()->randomElement(['sastanak', 'rociste']);
        $locations = $type === 'rociste'
            ? ['Osnovni sud Beograd', 'Viši sud Beograd', 'Privredni sud Beograd']
            : ['Kancelarija', 'Online - Zoom', 'Kancelarija klijenta'];

        return [
            'date_time' => fake()->dateTimeBetween('now', '+3 months'),
            'type' => $type,
            'location' => fake()->randomElement($locations),
            'note' => fake()->optional()->sentence(),
            'legal_case_id' => LegalCase::factory(),
            'user_id' => User::factory(),
        ];
    }
}
