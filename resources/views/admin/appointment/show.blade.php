@extends('layouts.admin')

@section('title', 'Detalji termina - Advokatska Kancelarija')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Detalji termina</h1>
        <p class="text-gray-600">{{ $appointment->date_time->format('d.m.Y H:i') }}</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.appointments.edit', $appointment) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
            Izmeni
        </a>
        <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" 
            onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovaj termin?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                Obriši
            </button>
        </form>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-sm font-medium text-gray-500">Datum i vreme</h3>
            <p class="text-lg text-gray-900">{{ $appointment->date_time->format('d.m.Y H:i') }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500">Tip</h3>
            <p class="text-lg">
                @if($appointment->type === 'sastanak')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        Sastanak
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        Ročište
                    </span>
                @endif
            </p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500">Lokacija</h3>
            <p class="text-lg text-gray-900">{{ $appointment->location ?? 'Nije navedena' }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500">Odgovorni advokat</h3>
            <p class="text-lg text-gray-900">{{ $appointment->user->name ?? 'N/A' }}</p>
        </div>

        @if($appointment->legalCase)
        <div class="md:col-span-2">
            <h3 class="text-sm font-medium text-gray-500">Predmet</h3>
            <p class="text-lg">
                <a href="{{ route('admin.legal-cases.show', $appointment->legalCase) }}" class="text-blue-600 hover:text-blue-800">
                    {{ $appointment->legalCase->title }}
                </a>
                <span class="text-gray-500">
                    ({{ $appointment->legalCase->client->name ?? 'N/A' }})
                </span>
            </p>
        </div>
        @endif

        @if($appointment->note)
        <div class="md:col-span-2">
            <h3 class="text-sm font-medium text-gray-500">Napomena</h3>
            <p class="text-gray-900">{{ $appointment->note }}</p>
        </div>
        @endif
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('admin.appointments.index') }}" class="text-blue-600 hover:text-blue-800">
        &larr; Nazad na listu termina
    </a>
</div>
@endsection

