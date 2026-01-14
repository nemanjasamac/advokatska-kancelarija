<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentStoreRequest;
use App\Http\Requests\DocumentUpdateRequest;
use App\Models\Document;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $documents = Document::with(['legalCase', 'user'])->get();

        return view('document.index', [
            'documents' => $documents,
        ]);
    }

    public function create(Request $request): View
    {
        $legalCases = LegalCase::all();
        $users = User::all();

        return view('document.create', [
            'legalCases' => $legalCases,
            'users' => $users,
        ]);
    }

    public function store(DocumentStoreRequest $request): RedirectResponse
    {
        $document = Document::create($request->validated());

        $request->session()->flash('document.id', $document->id);

        return redirect()->route('documents.index');
    }

    public function show(Request $request, Document $document): View
    {
        return view('document.show', [
            'document' => $document,
        ]);
    }

    public function edit(Request $request, Document $document): View
    {
        $legalCases = LegalCase::all();
        $users = User::all();

        return view('document.edit', [
            'document' => $document,
            'legalCases' => $legalCases,
            'users' => $users,
        ]);
    }

    public function update(DocumentUpdateRequest $request, Document $document): RedirectResponse
    {
        $document->update($request->validated());

        $request->session()->flash('document.id', $document->id);

        return redirect()->route('documents.index');
    }

    public function destroy(Request $request, Document $document): RedirectResponse
    {
        $document->delete();

        return redirect()->route('documents.index');
    }
}
