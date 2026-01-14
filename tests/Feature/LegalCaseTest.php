<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegalCaseTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        return $this->actingAs($admin);
    }

    /**
     * Test UC2: Otvaranje novog predmeta za klijenta
     * Testira da se novi predmet uspešno kreira i povezuje sa klijentom
     */
    public function test_legal_case_can_be_created_for_client(): void
    {
        $client = Client::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);

        $caseData = [
            'title' => 'Radni spor - otkaz',
            'case_type' => 'radni spor',
            'court' => 'Osnovni sud Beograd',
            'opponent' => 'Kompanija DOO',
            'status' => 'novi',
            'opened_at' => now()->format('Y-m-d'),
            'client_id' => $client->id,
            'user_id' => $user->id,
        ];

        $response = $this->actingAs($user)->post(route('admin.legal-cases.store'), $caseData);

        $response->assertRedirect(route('admin.legal-cases.index'));

        $this->assertDatabaseHas('legal_cases', [
            'title' => 'Radni spor - otkaz',
            'case_type' => 'radni spor',
            'client_id' => $client->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test da predmet pripada klijentu (relacija)
     */
    public function test_legal_case_belongs_to_client(): void
    {
        $client = Client::factory()->create();
        $user = User::factory()->create();

        $legalCase = LegalCase::factory()->create([
            'client_id' => $client->id,
            'user_id' => $user->id,
        ]);

        $this->assertEquals($client->id, $legalCase->client->id);
        $this->assertEquals($user->id, $legalCase->user->id);
    }

    /**
     * Test da se predmet može dohvatiti sa relacijama
     */
    public function test_legal_case_can_be_loaded_with_relations(): void
    {
        $client = Client::factory()->create();
        $user = User::factory()->create();

        $legalCase = LegalCase::factory()->create([
            'client_id' => $client->id,
            'user_id' => $user->id,
        ]);

        $loadedCase = LegalCase::with(['client', 'user', 'documents', 'appointments'])
            ->find($legalCase->id);

        $this->assertNotNull($loadedCase);
        $this->assertEquals($client->id, $loadedCase->client->id);
    }

    /**
     * Test promene statusa predmeta (dijagram stanja iz dokumentacije)
     */
    public function test_legal_case_status_can_be_updated(): void
    {
        $client = Client::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);

        $legalCase = LegalCase::factory()->create([
            'status' => 'novi',
            'client_id' => $client->id,
            'user_id' => $user->id,
        ]);

        $updatedData = [
            'title' => $legalCase->title,
            'case_type' => $legalCase->case_type,
            'status' => 'otvoren',
            'opened_at' => $legalCase->opened_at->format('Y-m-d'),
            'client_id' => $client->id,
            'user_id' => $user->id,
        ];

        $response = $this->actingAs($user)->put(route('admin.legal-cases.update', $legalCase), $updatedData);

        $response->assertRedirect(route('admin.legal-cases.index'));

        $this->assertDatabaseHas('legal_cases', [
            'id' => $legalCase->id,
            'status' => 'otvoren',
        ]);
    }

    /**
     * Test validacije - naslov predmeta je obavezan
     */
    public function test_legal_case_title_is_required(): void
    {
        $client = Client::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);

        $caseData = [
            'title' => '',
            'case_type' => 'radni spor',
            'status' => 'novi',
            'opened_at' => now()->format('Y-m-d'),
            'client_id' => $client->id,
            'user_id' => $user->id,
        ];

        $response = $this->actingAs($user)->post(route('admin.legal-cases.store'), $caseData);

        $response->assertSessionHasErrors('title');
    }
}
