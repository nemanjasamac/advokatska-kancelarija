<?php

namespace Database\Factories;

use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'file_name' => fake()->word(),
            'file_path' => fake()->word(),
            'document_type' => fake()->word(),
            'description' => fake()->text(),
            'uploaded_at' => fake()->dateTime(),
            'legal_case_id' => LegalCase::factory(),
            'user_id' => User::factory(),
        ];
    }
}
