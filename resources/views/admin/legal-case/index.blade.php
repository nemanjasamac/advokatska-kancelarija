@extends('layouts.admin')

@section('title', 'Predmeti - Advokatska Kancelarija')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Predmeti</h1>
        <p class="text-gray-600">Lista svih pravnih predmeta</p>
    </div>
    <a href="{{ route('admin.legal-cases.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
        <span class="mr-2">+</span> Novi predmet
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naziv</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klijent</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tip</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Advokat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($legalCases as $case)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.legal-cases.show', $case) }}" class="text-blue-600 hover:underline font-medium">
                            {{ $case->title }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.clients.show', $case->client) }}" class="text-gray-600 hover:text-blue-600">
                            {{ $case->client->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $case->case_type }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($case->status === 'novi') bg-blue-100 text-blue-800
                            @elseif($case->status === 'otvoren') bg-green-100 text-green-800
                            @elseif($case->status === 'u_toku') bg-yellow-100 text-yellow-800
                            @elseif($case->status === 'na_cekanju') bg-orange-100 text-orange-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $case->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('admin.legal-cases.edit', $case) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Izmeni</a>
                        <form action="{{ route('admin.legal-cases.destroy', $case) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Obriši</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nema predmeta u sistemu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

