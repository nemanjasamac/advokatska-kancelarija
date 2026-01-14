<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Document;
use App\Models\LegalCase;
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

        // Kreiraj demo klijenta sa predmetima
        $admin = User::where('role', 'admin')->first();

        $demoClient = Client::create([
            'name' => 'Demo Klijent',
            'client_type' => 'fizicko',
            'email' => 'demo@klijent.rs',
            'phone' => '0611234567',
            'address' => 'Knez Mihailova 1, Beograd',
            'note' => 'Demo nalog za testiranje',
        ]);

        // Kreiraj user nalog za demo klijenta
        User::create([
            'name' => 'Demo Klijent',
            'email' => 'klijent@demo.rs',
            'password' => Hash::make('password'),
            'role' => 'client',
            'client_id' => $demoClient->id,
        ]);

        // Kreiraj aktivne predmete za demo klijenta
        $case1 = LegalCase::create([
            'title' => 'Radni spor - nezakoniti otkaz',
            'case_type' => 'radni spor',
            'court' => 'Osnovni sud Beograd',
            'opponent' => 'Kompanija ABC d.o.o.',
            'status' => 'otvoren',
            'opened_at' => now()->subMonths(2),
            'client_id' => $demoClient->id,
            'user_id' => $admin->id,
        ]);

        $case2 = LegalCase::create([
            'title' => 'Naknada štete - saobraćajna nezgoda',
            'case_type' => 'naknada stete',
            'court' => 'Viši sud Beograd',
            'opponent' => 'Osiguravajuće društvo XYZ',
            'status' => 'u_toku',
            'opened_at' => now()->subMonths(1),
            'client_id' => $demoClient->id,
            'user_id' => $admin->id,
        ]);

        // Kreiraj dokumente za predmete
        Document::create([
            'file_name' => 'Tuzba_radni_spor.pdf',
            'file_path' => 'documents/placeholder.pdf',
            'document_type' => 'tuzba',
            'description' => 'Tužba za nezakoniti otkaz',
            'uploaded_at' => now()->subWeeks(6),
            'legal_case_id' => $case1->id,
            'user_id' => $admin->id,
        ]);

        Document::create([
            'file_name' => 'Ugovor_o_radu.pdf',
            'file_path' => 'documents/placeholder.pdf',
            'document_type' => 'ugovor',
            'description' => 'Ugovor o radu sa poslodavcem',
            'uploaded_at' => now()->subWeeks(6),
            'legal_case_id' => $case1->id,
            'user_id' => $admin->id,
        ]);

        // Kreiraj termine
        Appointment::create([
            'date_time' => now()->addDays(7)->setHour(10)->setMinute(0),
            'type' => 'sastanak',
            'location' => 'Kancelarija',
            'note' => 'Priprema za ročište',
            'legal_case_id' => $case1->id,
            'user_id' => $admin->id,
        ]);

        Appointment::create([
            'date_time' => now()->addDays(14)->setHour(9)->setMinute(30),
            'type' => 'rociste',
            'location' => 'Osnovni sud Beograd, sala 5',
            'note' => 'Prvo ročište',
            'legal_case_id' => $case1->id,
            'user_id' => $admin->id,
        ]);
    }
}
