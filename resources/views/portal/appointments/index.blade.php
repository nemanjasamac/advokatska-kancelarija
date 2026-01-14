@extends('layouts.portal')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Moji Termini</h1>
    <a href="{{ route('portal.appointments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Zakaži Termin
    </a>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tip</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Predmet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datum i Vreme</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokacija</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($appointments as $appointment)
                    @php
                        $isPast = \Carbon\Carbon::parse($appointment->date_time)->isPast();
                    @endphp
                    <tr class="{{ $isPast ? 'bg-gray-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-xl mr-2">{{ $appointment->type === 'rociste' ? '⚖️' : '🤝' }}</span>
                                <span class="font-medium text-gray-900">
                                    {{ $appointment->type === 'rociste' ? 'Ročište' : 'Sastanak' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ $appointment->legalCase->title ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-medium {{ $isPast ? 'text-gray-400' : 'text-gray-900' }}">
                                {{ \Carbon\Carbon::parse($appointment->date_time)->format('d.m.Y') }}
                            </span>
                            <span class="text-gray-500 ml-2">
                                {{ \Carbon\Carbon::parse($appointment->date_time)->format('H:i') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ $appointment->location }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($isPast)
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                                    Završen
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    Predstojeći
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Nemate zakazanih termina
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
