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
        $documentTypes = ['tuzba', 'zalba', 'zapisnik', 'punomoce', 'ugovor', 'resenje', 'presuda'];
        $fileName = fake()->word().'.pdf';

        return [
            'file_name' => $fileName,
            'file_path' => 'documents/'.$fileName,
            'document_type' => fake()->randomElement($documentTypes),
            'description' => fake()->optional()->sentence(),
            'uploaded_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'legal_case_id' => LegalCase::factory(),
            'user_id' => User::factory(),
        ];
    }
}
