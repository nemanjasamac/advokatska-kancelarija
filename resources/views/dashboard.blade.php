@extends('layouts.app')

@section('title', 'Dashboard - Advokatska Kancelarija')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-600">Dobrodošli u sistem za upravljanje advokatskom kancelarijom</p>
</div>

<!-- Statistike -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <span class="text-2xl">👥</span>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Ukupno klijenata</p>
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
                <p class="text-gray-500 text-sm">Aktivni predmeti</p>
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
                <p class="text-gray-500 text-sm">Dokumenta</p>
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
                <p class="text-gray-500 text-sm">Zakazani termini</p>
                <p class="text-2xl font-bold text-gray-800">{{ $upcomingAppointmentsCount }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Današnji termini -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">📅 Danas</h2>
        </div>
        <div class="p-6">
            @if($todayAppointments->count() > 0)
                <ul class="space-y-3">
                    @foreach($todayAppointments as $appointment)
                        <li class="flex items-center justify-between p-3 bg-gray-50 rounded">
                            <div>
                                <span class="font-medium">{{ $appointment->date_time->format('H:i') }}</span>
                                <span class="ml-2 px-2 py-1 text-xs rounded {{ $appointment->type === 'rociste' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $appointment->type === 'rociste' ? 'Ročište' : 'Sastanak' }}
                                </span>
                                <p class="text-sm text-gray-600 mt-1">{{ $appointment->location }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Nema zakazanih termina za danas.</p>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">📁 Poslednji predmeti</h2>
        </div>
        <div class="p-6">
            @if($recentCases->count() > 0)
                <ul class="space-y-3">
                    @foreach($recentCases as $case)
                        <li class="p-3 bg-gray-50 rounded">
                            <a href="{{ route('legal-cases.show', $case) }}" class="font-medium text-blue-600 hover:underline">
                                {{ $case->title }}
                            </a>
                            <p class="text-sm text-gray-600">{{ $case->client->name }} • {{ $case->case_type }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Nema predmeta.</p>
            @endif
        </div>
    </div>
</div>
@endsection
