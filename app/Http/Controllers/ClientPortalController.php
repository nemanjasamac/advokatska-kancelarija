<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Document;
use App\Models\LegalCase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientPortalController extends Controller
{
    /**
     * Get the client for the authenticated user
     */
    private function getClient()
    {
        $user = auth()->user();

        if (! $user->client_id) {
            abort(403, 'Vaš nalog nije povezan sa klijentskim profilom.');
        }

        return $user->client;
    }

    /**
     * Show client dashboard
     */
    public function index(): View
    {
        $client = $this->getClient();

        $activeCases = $client->legalCases()->where('status', 'aktivan')->count();
        $totalDocuments = Document::whereIn('legal_case_id', $client->legalCases()->pluck('id'))->count();
        $upcomingAppointments = Appointment::whereIn('legal_case_id', $client->legalCases()->pluck('id'))
            ->where('date_time', '>=', now())
            ->orderBy('date_time')
            ->take(5)
            ->get();

        return view('portal.dashboard', compact('client', 'activeCases', 'totalDocuments', 'upcomingAppointments'));
    }

    /**
     * Show client's legal cases
     */
    public function cases(): View
    {
        $client = $this->getClient();
        $cases = $client->legalCases()->with('user')->latest()->paginate(10);

        return view('portal.cases.index', compact('cases'));
    }

    /**
     * Show single case details
     */
    public function showCase(LegalCase $legalCase): View
    {
        $client = $this->getClient();

        // Ensure the case belongs to this client
        if ($legalCase->client_id !== $client->id) {
            abort(403, 'Nemate pristup ovom predmetu.');
        }

        $legalCase->load(['documents', 'appointments']);

        return view('portal.cases.show', compact('legalCase'));
    }

    /**
     * Show client's documents
     */
    public function documents(): View
    {
        $client = $this->getClient();
        $documents = Document::whereIn('legal_case_id', $client->legalCases()->pluck('id'))
            ->with('legalCase')
            ->latest()
            ->paginate(10);

        return view('portal.documents.index', compact('documents'));
    }

    /**
     * Show client's appointments
     */
    public function appointments(): View
    {
        $client = $this->getClient();
        $appointments = Appointment::whereIn('legal_case_id', $client->legalCases()->pluck('id'))
            ->with('legalCase')
            ->orderBy('date_time')
            ->paginate(10);

        return view('portal.appointments.index', compact('appointments'));
    }

    /**
     * Show form to create appointment request
     */
    public function createAppointment(): View
    {
        $client = $this->getClient();
        $cases = $client->legalCases()->where('status', 'aktivan')->get();

        return view('portal.appointments.create', compact('cases'));
    }

    /**
     * Store new appointment request
     */
    public function storeAppointment(Request $request): RedirectResponse
    {
        $client = $this->getClient();

        $validated = $request->validate([
            'legal_case_id' => 'required|exists:legal_cases,id',
            'date_time' => 'required|date|after:now',
            'type' => 'required|in:sastanak,rociste',
            'note' => 'nullable|string|max:1000',
        ]);

        // Verify the case belongs to this client
        $case = LegalCase::findOrFail($validated['legal_case_id']);
        if ($case->client_id !== $client->id) {
            abort(403, 'Nemate pristup ovom predmetu.');
        }

        Appointment::create([
            'legal_case_id' => $validated['legal_case_id'],
            'user_id' => $case->user_id, // Assign to the lawyer on the case
            'date_time' => $validated['date_time'],
            'type' => $validated['type'],
            'location' => 'Kancelarija',
            'note' => $validated['note'] ?? 'Zahtev klijenta za termin',
        ]);

        return redirect()->route('portal.appointments')->with('success', 'Zahtev za termin je uspešno poslat.');
    }
}
