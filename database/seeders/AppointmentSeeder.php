<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $legalCases = LegalCase::where('status', '!=', 'zatvoren')->get();
        $users = User::all();

        // Aktivni predmeti imaju 0-3 zakazana termina
        foreach ($legalCases as $legalCase) {
            $numberOfAppointments = rand(0, 3);
            
            Appointment::factory($numberOfAppointments)->create([
                'legal_case_id' => $legalCase->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
