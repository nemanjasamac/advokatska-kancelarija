<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Client;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LegalCaseController
 */
final class LegalCaseControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $legalCases = LegalCase::factory()->count(3)->create();

        $response = $this->get(route('legal-cases.index'));

        $response->assertOk();
        $response->assertViewIs('legalCase.index');
        $response->assertViewHas('legalCases', $legalCases);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('legal-cases.create'));

        $response->assertOk();
        $response->assertViewIs('legalCase.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LegalCaseController::class,
            'store',
            \App\Http\Requests\LegalCaseStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $case_type = fake()->word();
        $status = fake()->randomElement(/** enum_attributes **/);
        $opened_at = Carbon::parse(fake()->date());
        $client = Client::factory()->create();
        $user = User::factory()->create();

        $response = $this->post(route('legal-cases.store'), [
            'title' => $title,
            'case_type' => $case_type,
            'status' => $status,
            'opened_at' => $opened_at->toDateString(),
            'client_id' => $client->id,
            'user_id' => $user->id,
        ]);

        $legalCases = LegalCase::query()
            ->where('title', $title)
            ->where('case_type', $case_type)
            ->where('status', $status)
            ->where('opened_at', $opened_at)
            ->where('client_id', $client->id)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $legalCases);
        $legalCase = $legalCases->first();

        $response->assertRedirect(route('legalCases.index'));
        $response->assertSessionHas('legalCase.id', $legalCase->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $legalCase = LegalCase::factory()->create();

        $response = $this->get(route('legal-cases.show', $legalCase));

        $response->assertOk();
        $response->assertViewIs('legalCase.show');
        $response->assertViewHas('legalCase', $legalCase);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $legalCase = LegalCase::factory()->create();

        $response = $this->get(route('legal-cases.edit', $legalCase));

        $response->assertOk();
        $response->assertViewIs('legalCase.edit');
        $response->assertViewHas('legalCase', $legalCase);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LegalCaseController::class,
            'update',
            \App\Http\Requests\LegalCaseUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $legalCase = LegalCase::factory()->create();
        $title = fake()->sentence(4);
        $case_type = fake()->word();
        $status = fake()->randomElement(/** enum_attributes **/);
        $opened_at = Carbon::parse(fake()->date());
        $client = Client::factory()->create();
        $user = User::factory()->create();

        $response = $this->put(route('legal-cases.update', $legalCase), [
            'title' => $title,
            'case_type' => $case_type,
            'status' => $status,
            'opened_at' => $opened_at->toDateString(),
            'client_id' => $client->id,
            'user_id' => $user->id,
        ]);

        $legalCase->refresh();

        $response->assertRedirect(route('legalCases.index'));
        $response->assertSessionHas('legalCase.id', $legalCase->id);

        $this->assertEquals($title, $legalCase->title);
        $this->assertEquals($case_type, $legalCase->case_type);
        $this->assertEquals($status, $legalCase->status);
        $this->assertEquals($opened_at, $legalCase->opened_at);
        $this->assertEquals($client->id, $legalCase->client_id);
        $this->assertEquals($user->id, $legalCase->user_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $legalCase = LegalCase::factory()->create();

        $response = $this->delete(route('legal-cases.destroy', $legalCase));

        $response->assertRedirect(route('legalCases.index'));

        $this->assertModelMissing($legalCase);
    }
}
