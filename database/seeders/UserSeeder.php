<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kreiranje admin korisnika
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kancelarija.rs',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Kreiranje advokata - Marko Jovanović (persona 1)
        User::create([
            'name' => 'Marko Jovanović',
            'email' => 'marko@kancelarija.rs',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Kreiranje pravnog asistenta - Ana Petrović (persona 2)
        User::create([
            'name' => 'Ana Petrović',
            'email' => 'ana@kancelarija.rs',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Kreiranje advokata saradnika - Milan Nikolić (persona 3)
        User::create([
            'name' => 'Milan Nikolić',
            'email' => 'milan@kancelarija.rs',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
