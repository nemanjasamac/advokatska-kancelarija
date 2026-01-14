<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kreiraj user naloge za neke klijente
        $clients = Client::take(3)->get();

        foreach ($clients as $index => $client) {
            // Kreiraj email od imena klijenta
            $email = strtolower(str_replace(' ', '.', $client->name)).'@gmail.com';

            User::create([
                'name' => $client->name,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'client',
                'client_id' => $client->id,
            ]);
        }

        // Dodaj demo klijenta sa poznatim kredencijalima
        $demoClient = Client::first();
        if ($demoClient) {
            User::create([
                'name' => 'Demo Klijent',
                'email' => 'klijent@demo.rs',
                'password' => Hash::make('password'),
                'role' => 'client',
                'client_id' => $demoClient->id,
            ]);
        }
    }
}
