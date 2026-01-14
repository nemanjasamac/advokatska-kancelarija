<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Document;
use App\Models\LegalCase;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $clientsCount = Client::count();
        $activeCasesCount = LegalCase::whereNotIn('status', ['zatvoren'])->count();
        $documentsCount = Document::count();
        $upcomingAppointmentsCount = Appointment::where('date_time', '>=', now())->count();

        $todayAppointments = Appointment::whereDate('date_time', today())
            ->orderBy('date_time')
            ->get();

        $recentCases = LegalCase::with('client')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'clientsCount',
            'activeCasesCount',
            'documentsCount',
            'upcomingAppointmentsCount',
            'todayAppointments',
            'recentCases'
        ));
    }
}
