@extends('layouts.app')

@section('title', $client->name . ' - Advokatska Kancelarija')

@section('content')
<div class="flex justify-between items-start mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">{{ $client->name }}</h1>
        <span class="px-2 py-1 text-sm rounded {{ $client->client_type === 'fizicko' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
            {{ $client->client_type === 'fizicko' ? 'Fizičko lice' : 'Pravno lice' }}
        </span>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('clients.edit', $client) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
            Izmeni
        </a>
        <a href="{{ route('legal-cases.create', ['client_id' => $client->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            + Novi predmet
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Kontakt info -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Kontakt informacije</h2>
        <div class="space-y-3">
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="text-gray-800">{{ $client->email ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Telefon</p>
                <p class="text-gray-800">{{ $client->phone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Adresa</p>
                <p class="text-gray-800">{{ $client->address ?? '-' }}</p>
            </div>
            @if($client->note)
            <div>
                <p class="text-sm text-gray-500">Napomena</p>
                <p class="text-gray-800">{{ $client->note }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Predmeti -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow">
        <div class="p-6 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Predmeti ({{ $client->legalCases->count() }})</h2>
        </div>
        <div class="p-6">
            @if($client->legalCases->count() > 0)
                <div class="space-y-3">
                    @foreach($client->legalCases as $case)
                        <div class="p-4 bg-gray-50 rounded-lg flex justify-between items-center">
                            <div>
                                <a href="{{ route('legal-cases.show', $case) }}" class="font-medium text-blue-600 hover:underline">
                                    {{ $case->title }}
                                </a>
                                <p class="text-sm text-gray-600">{{ $case->case_type }} • {{ $case->court ?? 'Nije navedeno' }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded 
                                @if($case->status === 'novi') bg-blue-100 text-blue-800
                                @elseif($case->status === 'otvoren') bg-green-100 text-green-800
                                @elseif($case->status === 'u_toku') bg-yellow-100 text-yellow-800
                                @elseif($case->status === 'na_cekanju') bg-orange-100 text-orange-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Klijent nema predmete.</p>
            @endif
        </div>
    </div>
</div>
@endsection
