@extends('layouts.portal')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dobrodošli, {{ $client->name }}!</h1>
    <p class="text-gray-600 mt-2">Pratite svoje predmete i zakazujte termine</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <span class="text-2xl">📁</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Aktivni Predmeti</p>
                <p class="text-2xl font-bold text-gray-800">{{ $activeCases }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <span class="text-2xl">📄</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Dokumenta</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalDocuments }}</p>
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
                <p class="text-2xl font-bold text-gray-800">{{ $upcomingAppointments->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Appointments -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Predstojeći Termini</h2>
        <a href="{{ route('portal.appointments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Zakaži Termin
        </a>
    </div>
    <div class="p-6">
        @if($upcomingAppointments->isEmpty())
            <p class="text-gray-500 text-center py-4">Nemate zakazanih termina</p>
        @else
            <div class="space-y-4">
                @foreach($upcomingAppointments as $appointment)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-2 {{ $appointment->type === 'rociste' ? 'bg-red-100' : 'bg-blue-100' }} rounded-full mr-4">
                                <span class="text-xl">{{ $appointment->type === 'rociste' ? '⚖️' : '🤝' }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">
                                    {{ $appointment->type === 'rociste' ? 'Ročište' : 'Sastanak' }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $appointment->legalCase->title ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($appointment->date_time)->format('d.m.Y') }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($appointment->date_time)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
