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

        return view('admin.document.index', [
            'documents' => $documents,
        ]);
    }

    public function create(Request $request): View
    {
        $legalCases = LegalCase::all();
        $users = User::where('role', 'admin')->get();

        return view('admin.document.create', [
            'legalCases' => $legalCases,
            'users' => $users,
        ]);
    }

    public function store(DocumentStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('documents', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
        }

        $data['uploaded_at'] = now();
        $data['user_id'] = auth()->id();

        $document = Document::create($data);

        return redirect()->route('admin.documents.index')->with('success', 'Dokument je uspešno dodat.');
    }

    public function show(Request $request, Document $document): View
    {
        return view('admin.document.show', [
            'document' => $document,
        ]);
    }

    public function edit(Request $request, Document $document): View
    {
        $legalCases = LegalCase::all();
        $users = User::where('role', 'admin')->get();

        return view('admin.document.edit', [
            'document' => $document,
            'legalCases' => $legalCases,
            'users' => $users,
        ]);
    }

    public function update(DocumentUpdateRequest $request, Document $document): RedirectResponse
    {
        $data = $request->validated();

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($document->file_path) {
                \Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('documents', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')->with('success', 'Dokument je uspešno ažuriran.');
    }

    public function destroy(Request $request, Document $document): RedirectResponse
    {
        // Delete file if exists
        if ($document->file_path) {
            \Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Dokument je uspešno obrisan.');
    }
}
