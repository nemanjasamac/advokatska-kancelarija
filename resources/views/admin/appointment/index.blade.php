@extends('layouts.admin')

@section('title', 'Kalendar - Advokatska Kancelarija')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Kalendar</h1>
        <p class="text-gray-600">Svi zakazani sastanci i ročišta</p>
    </div>
    <a href="{{ route('admin.appointments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
        <span class="mr-2">+</span> Zakaži termin
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum i vreme</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tip</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokacija</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Predmet</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Advokat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($appointments->sortBy('date_time') as $appointment)
                <tr class="hover:bg-gray-50 {{ $appointment->date_time < now() ? 'opacity-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                        {{ $appointment->date_time->format('d.m.Y. H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded {{ $appointment->type === 'rociste' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $appointment->type === 'rociste' ? 'Ročište' : 'Sastanak' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $appointment->location ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($appointment->legalCase)
                            <a href="{{ route('admin.legal-cases.show', $appointment->legalCase) }}" class="text-blue-600 hover:underline">
                                {{ $appointment->legalCase->title }}
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $appointment->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('admin.appointments.edit', $appointment) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Izmeni</a>
                        <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Obriši</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nema zakazanih termina.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

