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
        $caseTypes = ['radni spor', 'privredni spor', 'krivicni postupak', 'porodicno pravo', 'naknada stete'];
        $courts = ['Osnovni sud Beograd', 'Viši sud Beograd', 'Privredni sud Beograd', 'Apelacioni sud Beograd'];
        $openedAt = fake()->dateTimeBetween('-2 years', 'now');
        $status = fake()->randomElement(['novi', 'otvoren', 'u_toku', 'na_cekanju', 'zatvoren']);
        
        return [
            'title' => fake()->sentence(3),
            'case_type' => fake()->randomElement($caseTypes),
            'court' => fake()->randomElement($courts),
            'opponent' => fake()->name(),
            'status' => $status,
            'opened_at' => $openedAt,
            'closed_at' => $status === 'zatvoren' ? fake()->dateTimeBetween($openedAt, 'now') : null,
            'client_id' => Client::factory(),
            'user_id' => User::factory(),
        ];
    }
}
