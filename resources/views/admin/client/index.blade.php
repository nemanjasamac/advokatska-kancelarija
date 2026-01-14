@extends('layouts.admin')

@section('title', 'Klijenti - Advokatska Kancelarija')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Klijenti</h1>
        <p class="text-gray-600">Lista svih klijenata</p>
    </div>
    <a href="{{ route('admin.clients.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
        <span class="mr-2">+</span> Novi klijent
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ime/Naziv</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tip</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefon</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($clients as $client)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.clients.show', $client) }}" class="text-blue-600 hover:underline font-medium">
                            {{ $client->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded {{ $client->client_type === 'fizicko' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $client->client_type === 'fizicko' ? 'Fizičko lice' : 'Pravno lice' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $client->email ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $client->phone ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('admin.clients.edit', $client) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Izmeni</a>
                        <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Obriši</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nema klijenata u sistemu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

