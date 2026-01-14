<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Database\Seeder;

class LegalCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();
        $users = User::all();

        // Svaki klijent ima 1-3 predmeta
        foreach ($clients as $client) {
            $numberOfCases = rand(1, 3);

            LegalCase::factory($numberOfCases)->create([
                'client_id' => $client->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
