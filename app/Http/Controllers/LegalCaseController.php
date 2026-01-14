<?php

namespace App\Http\Controllers;

use App\Http\Requests\LegalCaseStoreRequest;
use App\Http\Requests\LegalCaseUpdateRequest;
use App\Models\Client;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegalCaseController extends Controller
{
    public function index(Request $request): View
    {
        $legalCases = LegalCase::with(['client', 'user'])->get();

        return view('admin.legal-case.index', [
            'legalCases' => $legalCases,
        ]);
    }

    public function create(Request $request): View
    {
        $clients = Client::all();
        $users = User::where('role', 'admin')->get();

        return view('admin.legal-case.create', [
            'clients' => $clients,
            'users' => $users,
        ]);
    }

    public function store(LegalCaseStoreRequest $request): RedirectResponse
    {
        $legalCase = LegalCase::create($request->validated());

        $request->session()->flash('legalCase.id', $legalCase->id);

        return redirect()->route('admin.legal-cases.index');
    }

    public function show(Request $request, LegalCase $legalCase): View
    {
        $legalCase->load(['client', 'user', 'documents', 'appointments']);

        return view('admin.legal-case.show', [
            'legalCase' => $legalCase,
        ]);
    }

    public function edit(Request $request, LegalCase $legalCase): View
    {
        $clients = Client::all();
        $users = User::where('role', 'admin')->get();

        return view('admin.legal-case.edit', [
            'legalCase' => $legalCase,
            'clients' => $clients,
            'users' => $users,
        ]);
    }

    public function update(LegalCaseUpdateRequest $request, LegalCase $legalCase): RedirectResponse
    {
        $legalCase->update($request->validated());

        $request->session()->flash('legalCase.id', $legalCase->id);

        return redirect()->route('admin.legal-cases.index');
    }

    public function destroy(Request $request, LegalCase $legalCase): RedirectResponse
    {
        $legalCase->delete();

        return redirect()->route('admin.legal-cases.index');
    }
}
