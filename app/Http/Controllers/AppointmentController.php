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
        $appointments = Appointment::with(['legalCase', 'user'])->get();

        return view('appointment.index', [
            'appointments' => $appointments,
        ]);
    }

    public function create(Request $request): View
    {
        $legalCases = LegalCase::all();
        $users = User::all();

        return view('appointment.create', [
            'legalCases' => $legalCases,
            'users' => $users,
        ]);
    }

    public function store(AppointmentStoreRequest $request): RedirectResponse
    {
        $appointment = Appointment::create($request->validated());

        $request->session()->flash('appointment.id', $appointment->id);

        return redirect()->route('appointments.index');
    }

    public function show(Request $request, Appointment $appointment): View
    {
        return view('appointment.show', [
            'appointment' => $appointment,
        ]);
    }

    public function edit(Request $request, Appointment $appointment): View
    {
        $legalCases = LegalCase::all();
        $users = User::all();

        return view('appointment.edit', [
            'appointment' => $appointment,
            'legalCases' => $legalCases,
            'users' => $users,
        ]);
    }

    public function update(AppointmentUpdateRequest $request, Appointment $appointment): RedirectResponse
    {
        $appointment->update($request->validated());

        $request->session()->flash('appointment.id', $appointment->id);

        return redirect()->route('appointments.index');
    }

    public function destroy(Request $request, Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()->route('appointments.index');
    }
}
