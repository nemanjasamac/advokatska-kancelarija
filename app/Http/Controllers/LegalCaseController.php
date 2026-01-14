<?php

namespace App\Http\Controllers;

use App\Http\Requests\LegalCaseStoreRequest;
use App\Http\Requests\LegalCaseUpdateRequest;
use App\Models\LegalCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegalCaseController extends Controller
{
    public function index(Request $request): Response
    {
        $legalCases = LegalCase::all();

        return view('legalCase.index', [
            'legalCases' => $legalCases,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('legalCase.create');
    }

    public function store(LegalCaseStoreRequest $request): Response
    {
        $legalCase = LegalCase::create($request->validated());

        $request->session()->flash('legalCase.id', $legalCase->id);

        return redirect()->route('legalCases.index');
    }

    public function show(Request $request, LegalCase $legalCase): Response
    {
        return view('legalCase.show', [
            'legalCase' => $legalCase,
        ]);
    }

    public function edit(Request $request, LegalCase $legalCase): Response
    {
        return view('legalCase.edit', [
            'legalCase' => $legalCase,
        ]);
    }

    public function update(LegalCaseUpdateRequest $request, LegalCase $legalCase): Response
    {
        $legalCase->update($request->validated());

        $request->session()->flash('legalCase.id', $legalCase->id);

        return redirect()->route('legalCases.index');
    }

    public function destroy(Request $request, LegalCase $legalCase): Response
    {
        $legalCase->delete();

        return redirect()->route('legalCases.index');
    }
}
