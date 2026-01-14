<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $legalCases = LegalCase::all();
        $users = User::all();

        // Svaki predmet ima 1-5 dokumenata
        foreach ($legalCases as $legalCase) {
            $numberOfDocuments = rand(1, 5);
            
            Document::factory($numberOfDocuments)->create([
                'legal_case_id' => $legalCase->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
