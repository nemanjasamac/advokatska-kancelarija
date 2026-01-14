@extends('layouts.admin')

@section('title', $legalCase->title . ' - Advokatska Kancelarija')

@section('content')
<div class="flex justify-between items-start mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">{{ $legalCase->title }}</h1>
        <p class="text-gray-600">
            <a href="{{ route('admin.clients.show', $legalCase->client) }}" class="text-blue-600 hover:underline">
                {{ $legalCase->client->name }}
            </a>
            • {{ $legalCase->case_type }}
        </p>
        <span class="mt-2 inline-block px-3 py-1 text-sm rounded 
            @if($legalCase->status === 'novi') bg-blue-100 text-blue-800
            @elseif($legalCase->status === 'otvoren') bg-green-100 text-green-800
            @elseif($legalCase->status === 'u_toku') bg-yellow-100 text-yellow-800
            @elseif($legalCase->status === 'na_cekanju') bg-orange-100 text-orange-800
            @else bg-gray-100 text-gray-800
            @endif">
            {{ ucfirst(str_replace('_', ' ', $legalCase->status)) }}
        </span>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('admin.legal-cases.edit', $legalCase) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
            Izmeni
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Info o predmetu -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Informacije o predmetu</h2>
        <div class="space-y-3">
            <div>
                <p class="text-sm text-gray-500">Sud</p>
                <p class="text-gray-800">{{ $legalCase->court ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Protivna strana</p>
                <p class="text-gray-800">{{ $legalCase->opponent ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Odgovorni advokat</p>
                <p class="text-gray-800">{{ $legalCase->user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Datum otvaranja</p>
                <p class="text-gray-800">{{ $legalCase->opened_at->format('d.m.Y.') }}</p>
            </div>
            @if($legalCase->closed_at)
            <div>
                <p class="text-sm text-gray-500">Datum zatvaranja</p>
                <p class="text-gray-800">{{ $legalCase->closed_at->format('d.m.Y.') }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Dokumenti -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow">
        <div class="p-6 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Dokumenti ({{ $legalCase->documents->count() }})</h2>
            <a href="{{ route('admin.documents.create', ['legal_case_id' => $legalCase->id]) }}" class="text-blue-600 hover:underline text-sm">
                + Dodaj dokument
            </a>
        </div>
        <div class="p-6">
            @if($legalCase->documents->count() > 0)
                <div class="space-y-3">
                    @foreach($legalCase->documents as $document)
                        <div class="p-4 bg-gray-50 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="font-medium">{{ $document->file_name }}</p>
                                <p class="text-sm text-gray-600">{{ $document->document_type }} • {{ $document->uploaded_at->format('d.m.Y.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Nema dokumenata.</p>
            @endif
        </div>
    </div>
</div>

<!-- Sastanci i ročišta -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-800">Sastanci i ročišta ({{ $legalCase->appointments->count() }})</h2>
        <a href="{{ route('admin.appointments.create', ['legal_case_id' => $legalCase->id]) }}" class="text-blue-600 hover:underline text-sm">
            + Zakaži termin
        </a>
    </div>
    <div class="p-6">
        @if($legalCase->appointments->count() > 0)
            <div class="space-y-3">
                @foreach($legalCase->appointments->sortBy('date_time') as $appointment)
                    <div class="p-4 bg-gray-50 rounded-lg flex justify-between items-center">
                        <div>
                            <span class="font-medium">{{ $appointment->date_time->format('d.m.Y. H:i') }}</span>
                            <span class="ml-2 px-2 py-1 text-xs rounded {{ $appointment->type === 'rociste' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $appointment->type === 'rociste' ? 'Ročište' : 'Sastanak' }}
                            </span>
                            <p class="text-sm text-gray-600 mt-1">{{ $appointment->location }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Nema zakazanih termina.</p>
        @endif
    </div>
</div>
@endsection

