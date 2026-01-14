@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-600 mt-2">Pregled aktivnosti kancelarije</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <span class="text-2xl">👥</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Klijenti</p>
                <p class="text-2xl font-bold text-gray-800">{{ $clientsCount }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <span class="text-2xl">📁</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Aktivni Predmeti</p>
                <p class="text-2xl font-bold text-gray-800">{{ $activeCasesCount }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <span class="text-2xl">📄</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Dokumenta</p>
                <p class="text-2xl font-bold text-gray-800">{{ $documentsCount }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
                <span class="text-2xl">📅</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Predstojeći Termini</p>
                <p class="text-2xl font-bold text-gray-800">{{ $upcomingAppointmentsCount }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Today's Appointments -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Današnji Termini</h2>
        </div>
        <div class="p-6">
            @if($todayAppointments->isEmpty())
                <p class="text-gray-500 text-center py-4">Nema termina za danas</p>
            @else
                <div class="space-y-4">
                    @foreach($todayAppointments as $appointment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                            <div>
                                <p class="font-medium">{{ $appointment->type === 'rociste' ? '⚖️ Ročište' : '🤝 Sastanak' }}</p>
                                <p class="text-sm text-gray-500">{{ $appointment->legalCase->title ?? 'N/A' }}</p>
                            </div>
                            <span class="text-gray-600">{{ \Carbon\Carbon::parse($appointment->date_time)->format('H:i') }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Cases -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Nedavni Predmeti</h2>
        </div>
        <div class="p-6">
            @if($recentCases->isEmpty())
                <p class="text-gray-500 text-center py-4">Nema predmeta</p>
            @else
                <div class="space-y-4">
                    @foreach($recentCases as $case)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                            <div>
                                <a href="{{ route('admin.legal-cases.show', $case) }}" class="font-medium text-blue-600 hover:underline">
                                    {{ $case->title }}
                                </a>
                                <p class="text-sm text-gray-500">{{ $case->client->name ?? 'N/A' }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $case->status === 'aktivan' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $case->status === 'zavrsen' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $case->status === 'pauziran' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                {{ ucfirst($case->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

