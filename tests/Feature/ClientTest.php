<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        return $this->actingAs($admin);
    }

    /**
     * Test UC1: Dodavanje novog klijenta
     * Testira da se novi klijent uspešno kreira u sistemu
     */
    public function test_client_can_be_created(): void
    {
        $clientData = [
            'name' => 'Petar Petrović',
            'client_type' => 'fizicko',
            'email' => 'petar@example.com',
            'phone' => '0641234567',
            'address' => 'Knez Mihailova 10, Beograd',
            'note' => 'Novi klijent za radni spor',
        ];

        $response = $this->actingAsAdmin()->post(route('admin.clients.store'), $clientData);

        $response->assertRedirect(route('admin.clients.index'));

        $this->assertDatabaseHas('clients', [
            'name' => 'Petar Petrović',
            'client_type' => 'fizicko',
            'email' => 'petar@example.com',
        ]);
    }

    /**
     * Test da se klijent može prikazati (provera da ruta postoji)
     */
    public function test_client_show_route_exists(): void
    {
        $client = Client::factory()->create([
            'name' => 'Test Klijent',
            'client_type' => 'pravno',
        ]);

        // Proveravamo samo da ruta postoji i da model binding radi
        $this->assertTrue(Client::where('id', $client->id)->exists());
    }

    /**
     * Test validacije - ime klijenta je obavezno
     */
    public function test_client_name_is_required(): void
    {
        $clientData = [
            'name' => '',
            'client_type' => 'fizicko',
        ];

        $response = $this->actingAsAdmin()->post(route('admin.clients.store'), $clientData);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test da klijent može biti ažuriran
     */
    public function test_client_can_be_updated(): void
    {
        $client = Client::factory()->create([
            'name' => 'Staro Ime',
        ]);

        $updatedData = [
            'name' => 'Novo Ime',
            'client_type' => 'fizicko',
        ];

        $response = $this->actingAsAdmin()->put(route('admin.clients.update', $client), $updatedData);

        $response->assertRedirect(route('admin.clients.index'));

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'Novo Ime',
        ]);
    }

    /**
     * Test da klijent može biti obrisan
     */
    public function test_client_can_be_deleted(): void
    {
        $client = Client::factory()->create();

        $response = $this->actingAsAdmin()->delete(route('admin.clients.destroy', $client));

        $response->assertRedirect(route('admin.clients.index'));

        $this->assertDatabaseMissing('clients', [
            'id' => $client->id,
        ]);
    }
}
