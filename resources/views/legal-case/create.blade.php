@extends('layouts.app')

@section('title', 'Novi predmet - Advokatska Kancelarija')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Novi predmet</h1>
    <p class="text-gray-600">Unesite podatke o novom predmetu</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('legal-cases.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Naziv predmeta *</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">Klijent *</label>
            <select name="client_id" id="client_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Izaberite klijenta --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id', request('client_id')) == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
            @error('client_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="case_type" class="block text-sm font-medium text-gray-700 mb-1">Tip predmeta *</label>
            <select name="case_type" id="case_type" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Izaberite tip --</option>
                <option value="radni spor" {{ old('case_type') === 'radni spor' ? 'selected' : '' }}>Radni spor</option>
                <option value="privredni spor" {{ old('case_type') === 'privredni spor' ? 'selected' : '' }}>Privredni spor</option>
                <option value="krivicni postupak" {{ old('case_type') === 'krivicni postupak' ? 'selected' : '' }}>Krivični postupak</option>
                <option value="porodicno pravo" {{ old('case_type') === 'porodicno pravo' ? 'selected' : '' }}>Porodično pravo</option>
                <option value="naknada stete" {{ old('case_type') === 'naknada stete' ? 'selected' : '' }}>Naknada štete</option>
            </select>
            @error('case_type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="court" class="block text-sm font-medium text-gray-700 mb-1">Sud</label>
            <input type="text" name="court" id="court" value="{{ old('court') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="opponent" class="block text-sm font-medium text-gray-700 mb-1">Protivna strana</label>
            <input type="text" name="opponent" id="opponent" value="{{ old('opponent') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
            <select name="status" id="status" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="novi" {{ old('status', 'novi') === 'novi' ? 'selected' : '' }}>Novi</option>
                <option value="otvoren" {{ old('status') === 'otvoren' ? 'selected' : '' }}>Otvoren</option>
                <option value="u_toku" {{ old('status') === 'u_toku' ? 'selected' : '' }}>U toku</option>
                <option value="na_cekanju" {{ old('status') === 'na_cekanju' ? 'selected' : '' }}>Na čekanju</option>
                <option value="zatvoren" {{ old('status') === 'zatvoren' ? 'selected' : '' }}>Zatvoren</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Odgovorni advokat *</label>
            <select name="user_id" id="user_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Izaberite advokata --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="opened_at" class="block text-sm font-medium text-gray-700 mb-1">Datum otvaranja *</label>
            <input type="date" name="opened_at" id="opened_at" value="{{ old('opened_at', date('Y-m-d')) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('legal-cases.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Odustani
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Sačuvaj predmet
            </button>
        </div>
    </form>
</div>
@endsection
