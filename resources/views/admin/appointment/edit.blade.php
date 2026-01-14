@extends('layouts.admin')

@section('title', 'Izmeni termin - Advokatska Kancelarija')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Izmeni termin</h1>
    <p class="text-gray-600">Ažuriranje podataka o terminu</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="date_time" class="block text-sm font-medium text-gray-700 mb-1">Datum i vreme *</label>
            <input type="datetime-local" name="date_time" id="date_time" 
                value="{{ old('date_time', $appointment->date_time->format('Y-m-d\TH:i')) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @error('date_time')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Tip termina *</label>
            <div class="flex space-x-4">
                <label class="flex items-center">
                    <input type="radio" name="type" value="sastanak" {{ old('type', $appointment->type) === 'sastanak' ? 'checked' : '' }} class="mr-2">
                    Sastanak
                </label>
                <label class="flex items-center">
                    <input type="radio" name="type" value="rociste" {{ old('type', $appointment->type) === 'rociste' ? 'checked' : '' }} class="mr-2">
                    Ročište
                </label>
            </div>
        </div>

        <div class="mb-4">
            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokacija</label>
            <input type="text" name="location" id="location" value="{{ old('location', $appointment->location) }}" placeholder="npr. Osnovni sud Beograd, Kancelarija..."
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="legal_case_id" class="block text-sm font-medium text-gray-700 mb-1">Predmet</label>
            <select name="legal_case_id" id="legal_case_id"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Bez predmeta --</option>
                @foreach($legalCases as $case)
                    <option value="{{ $case->id }}" {{ old('legal_case_id', $appointment->legal_case_id) == $case->id ? 'selected' : '' }}>
                        {{ $case->title }} ({{ $case->client->name ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Odgovorni advokat *</label>
            <select name="user_id" id="user_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $appointment->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Napomena</label>
            <textarea name="note" id="note" rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('note', $appointment->note) }}</textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.appointments.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Odustani
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Sačuvaj izmene
            </button>
        </div>
    </form>
</div>
@endsection

