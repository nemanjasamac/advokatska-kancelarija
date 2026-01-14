@extends('layouts.app')

@section('title', 'Dodaj dokument - Advokatska Kancelarija')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dodaj dokument</h1>
    <p class="text-gray-600">Unesite podatke o dokumentu</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('documents.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="file_name" class="block text-sm font-medium text-gray-700 mb-1">Naziv fajla *</label>
            <input type="text" name="file_name" id="file_name" value="{{ old('file_name') }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @error('file_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="file_path" class="block text-sm font-medium text-gray-700 mb-1">Putanja do fajla *</label>
            <input type="text" name="file_path" id="file_path" value="{{ old('file_path', 'documents/') }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="document_type" class="block text-sm font-medium text-gray-700 mb-1">Tip dokumenta *</label>
            <select name="document_type" id="document_type" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Izaberite tip --</option>
                <option value="tuzba" {{ old('document_type') === 'tuzba' ? 'selected' : '' }}>Tužba</option>
                <option value="zalba" {{ old('document_type') === 'zalba' ? 'selected' : '' }}>Žalba</option>
                <option value="zapisnik" {{ old('document_type') === 'zapisnik' ? 'selected' : '' }}>Zapisnik</option>
                <option value="punomoce" {{ old('document_type') === 'punomoce' ? 'selected' : '' }}>Punomoćje</option>
                <option value="ugovor" {{ old('document_type') === 'ugovor' ? 'selected' : '' }}>Ugovor</option>
                <option value="resenje" {{ old('document_type') === 'resenje' ? 'selected' : '' }}>Rešenje</option>
                <option value="presuda" {{ old('document_type') === 'presuda' ? 'selected' : '' }}>Presuda</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="legal_case_id" class="block text-sm font-medium text-gray-700 mb-1">Predmet *</label>
            <select name="legal_case_id" id="legal_case_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Izaberite predmet --</option>
                @foreach($legalCases as $case)
                    <option value="{{ $case->id }}" {{ old('legal_case_id', request('legal_case_id')) == $case->id ? 'selected' : '' }}>
                        {{ $case->title }} ({{ $case->client->name ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Dodao *</label>
            <select name="user_id" id="user_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="uploaded_at" class="block text-sm font-medium text-gray-700 mb-1">Datum *</label>
            <input type="datetime-local" name="uploaded_at" id="uploaded_at" value="{{ old('uploaded_at', now()->format('Y-m-d\TH:i')) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Opis</label>
            <textarea name="description" id="description" rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('documents.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Odustani
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Sačuvaj dokument
            </button>
        </div>
    </form>
</div>
@endsection
