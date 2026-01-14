@extends('layouts.portal')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Moja Dokumenta</h1>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naziv</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tip</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Predmet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Akcije</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($documents as $document)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-xl mr-2">📄</span>
                                <span class="font-medium text-gray-900">{{ $document->file_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ $document->document_type }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ $document->legalCase->title ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ \Carbon\Carbon::parse($document->uploaded_at)->format('d.m.Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($document->file_path)
                                <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                    Preuzmi
                                </a>
                            @else
                                <span class="text-gray-400">Nema fajla</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Nemate dokumenata
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4">
        {{ $documents->links() }}
    </div>
</div>
@endsection
