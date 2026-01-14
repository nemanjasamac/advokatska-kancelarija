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

        // ========================================
        // RAF Admin - nsamac6623it@raf.rs
        // ========================================
        User::create([
            'name' => 'Nemanja Samac',
            'email' => 'nsamac6623it@raf.rs',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'client_id' => null,
        ]);

        // ========================================
        // RAF Klijent - klijent@raf.rs sa 3 predmeta
        // ========================================
        $rafClient = Client::create([
            'name' => 'RAF Klijent',
            'client_type' => 'pravno',
            'email' => 'klijent@raf.rs',
            'phone' => '0641234567',
            'address' => 'Kneza Višeslava 43, Beograd',
            'note' => 'RAF demo nalog',
        ]);

        User::create([
            'name' => 'RAF Klijent',
            'email' => 'klijent@raf.rs',
            'password' => Hash::make('password'),
            'role' => 'client',
            'client_id' => $rafClient->id,
        ]);

        // Predmet 1 - Ugovorni spor
        $rafCase1 = LegalCase::create([
            'title' => 'Ugovorni spor - neispunjenje obaveza',
            'case_type' => 'ugovorni spor',
            'court' => 'Privredni sud Beograd',
            'opponent' => 'Tech Solutions d.o.o.',
            'status' => 'otvoren',
            'opened_at' => now()->subMonths(3),
            'client_id' => $rafClient->id,
            'user_id' => $admin->id,
        ]);

        // Predmet 2 - Intelektualna svojina
        $rafCase2 = LegalCase::create([
            'title' => 'Zaštita autorskih prava - softver',
            'case_type' => 'intelektualna svojina',
            'court' => 'Viši sud Beograd',
            'opponent' => 'Nepoznati',
            'status' => 'u_toku',
            'opened_at' => now()->subMonths(1),
            'client_id' => $rafClient->id,
            'user_id' => $admin->id,
        ]);

        // Predmet 3 - Osnivanje firme
        $rafCase3 = LegalCase::create([
            'title' => 'Registracija DOO - IT startup',
            'case_type' => 'privredno pravo',
            'court' => 'APR',
            'opponent' => null,
            'status' => 'novi',
            'opened_at' => now()->subDays(5),
            'client_id' => $rafClient->id,
            'user_id' => $admin->id,
        ]);

        // Dokumenti za RAF predmete
        Document::create([
            'file_name' => 'Ugovor_IT_usluge.pdf',
            'file_path' => 'documents/placeholder.pdf',
            'document_type' => 'ugovor',
            'description' => 'Ugovor o IT uslugama',
            'uploaded_at' => now()->subWeeks(10),
            'legal_case_id' => $rafCase1->id,
            'user_id' => $admin->id,
        ]);

        Document::create([
            'file_name' => 'Izvorni_kod_dokaz.pdf',
            'file_path' => 'documents/placeholder.pdf',
            'document_type' => 'dokaz',
            'description' => 'Dokaz o autorstvu softvera',
            'uploaded_at' => now()->subWeeks(3),
            'legal_case_id' => $rafCase2->id,
            'user_id' => $admin->id,
        ]);

        // Termin za RAF klijenta
        Appointment::create([
            'date_time' => now()->addDays(3)->setHour(14)->setMinute(0),
            'type' => 'sastanak',
            'location' => 'Kancelarija',
            'note' => 'Konsultacije oko registracije firme',
            'legal_case_id' => $rafCase3->id,
            'user_id' => $admin->id,
        ]);
    }
}
