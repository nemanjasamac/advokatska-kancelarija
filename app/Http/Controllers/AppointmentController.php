<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentStoreRequest;
use App\Http\Requests\AppointmentUpdateRequest;
use App\Models\Appointment;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $appointments = Appointment::with(['legalCase', 'user'])->orderBy('date_time')->get();

        return view('admin.appointment.index', [
            'appointments' => $appointments,
        ]);
    }

    public function create(Request $request): View
    {
        $legalCases = LegalCase::all();
        $users = User::where('role', 'admin')->get();

        return view('admin.appointment.create', [
            'legalCases' => $legalCases,
            'users' => $users,
        ]);
    }

    public function store(AppointmentStoreRequest $request): RedirectResponse
    {
        $appointment = Appointment::create($request->validated());

        return redirect()->route('admin.appointments.index')->with('success', 'Termin je uspešno kreiran.');
    }

    public function show(Request $request, Appointment $appointment): View
    {
        return view('admin.appointment.show', [
            'appointment' => $appointment,
        ]);
    }

    public function edit(Request $request, Appointment $appointment): View
    {
        $legalCases = LegalCase::all();
        $users = User::where('role', 'admin')->get();

        return view('admin.appointment.edit', [
            'appointment' => $appointment,
            'legalCases' => $legalCases,
            'users' => $users,
        ]);
    }

    public function update(AppointmentUpdateRequest $request, Appointment $appointment): RedirectResponse
    {
        $appointment->update($request->validated());

        return redirect()->route('admin.appointments.index')->with('success', 'Termin je uspešno ažuriran.');
    }

    public function destroy(Request $request, Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', 'Termin je uspešno obrisan.');
    }
}
