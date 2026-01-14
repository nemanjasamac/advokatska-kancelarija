<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Document;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DocumentController
 */
final class DocumentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $documents = Document::factory()->count(3)->create();

        $response = $this->get(route('documents.index'));

        $response->assertOk();
        $response->assertViewIs('document.index');
        $response->assertViewHas('documents', $documents);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('documents.create'));

        $response->assertOk();
        $response->assertViewIs('document.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DocumentController::class,
            'store',
            \App\Http\Requests\DocumentStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $file_name = fake()->word();
        $file_path = fake()->word();
        $document_type = fake()->word();
        $uploaded_at = Carbon::parse(fake()->dateTime());
        $legal_case = LegalCase::factory()->create();
        $user = User::factory()->create();

        $response = $this->post(route('documents.store'), [
            'file_name' => $file_name,
            'file_path' => $file_path,
            'document_type' => $document_type,
            'uploaded_at' => $uploaded_at->toDateTimeString(),
            'legal_case_id' => $legal_case->id,
            'user_id' => $user->id,
        ]);

        $documents = Document::query()
            ->where('file_name', $file_name)
            ->where('file_path', $file_path)
            ->where('document_type', $document_type)
            ->where('uploaded_at', $uploaded_at)
            ->where('legal_case_id', $legal_case->id)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $documents);
        $document = $documents->first();

        $response->assertRedirect(route('documents.index'));
        $response->assertSessionHas('document.id', $document->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $document = Document::factory()->create();

        $response = $this->get(route('documents.show', $document));

        $response->assertOk();
        $response->assertViewIs('document.show');
        $response->assertViewHas('document', $document);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $document = Document::factory()->create();

        $response = $this->get(route('documents.edit', $document));

        $response->assertOk();
        $response->assertViewIs('document.edit');
        $response->assertViewHas('document', $document);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DocumentController::class,
            'update',
            \App\Http\Requests\DocumentUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $document = Document::factory()->create();
        $file_name = fake()->word();
        $file_path = fake()->word();
        $document_type = fake()->word();
        $uploaded_at = Carbon::parse(fake()->dateTime());
        $legal_case = LegalCase::factory()->create();
        $user = User::factory()->create();

        $response = $this->put(route('documents.update', $document), [
            'file_name' => $file_name,
            'file_path' => $file_path,
            'document_type' => $document_type,
            'uploaded_at' => $uploaded_at->toDateTimeString(),
            'legal_case_id' => $legal_case->id,
            'user_id' => $user->id,
        ]);

        $document->refresh();

        $response->assertRedirect(route('documents.index'));
        $response->assertSessionHas('document.id', $document->id);

        $this->assertEquals($file_name, $document->file_name);
        $this->assertEquals($file_path, $document->file_path);
        $this->assertEquals($document_type, $document->document_type);
        $this->assertEquals($uploaded_at, $document->uploaded_at);
        $this->assertEquals($legal_case->id, $document->legal_case_id);
        $this->assertEquals($user->id, $document->user_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $document = Document::factory()->create();

        $response = $this->delete(route('documents.destroy', $document));

        $response->assertRedirect(route('documents.index'));

        $this->assertModelMissing($document);
    }
}
