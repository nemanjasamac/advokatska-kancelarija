@extends('layouts.app')

@section('title', 'Izmeni klijenta - Advokatska Kancelarija')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Izmeni klijenta</h1>
    <p class="text-gray-600">{{ $client->name }}</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('clients.update', $client) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Ime i prezime / Naziv firme *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $client->name) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Tip klijenta *</label>
            <div class="flex space-x-4">
                <label class="flex items-center">
                    <input type="radio" name="client_type" value="fizicko" {{ old('client_type', $client->client_type) === 'fizicko' ? 'checked' : '' }} class="mr-2">
                    Fizičko lice
                </label>
                <label class="flex items-center">
                    <input type="radio" name="client_type" value="pravno" {{ old('client_type', $client->client_type) === 'pravno' ? 'checked' : '' }} class="mr-2">
                    Pravno lice
                </label>
            </div>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $client->email) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefon</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $client->phone) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresa</label>
            <input type="text" name="address" id="address" value="{{ old('address', $client->address) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-6">
            <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Napomena</label>
            <textarea name="note" id="note" rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('note', $client->note) }}</textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('clients.show', $client) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Odustani
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Sačuvaj izmene
            </button>
        </div>
    </form>
</div>
@endsection
