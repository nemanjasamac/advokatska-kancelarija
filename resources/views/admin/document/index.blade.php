@extends('layouts.admin')

@section('title', 'Dokumenta - Advokatska Kancelarija')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Dokumenta</h1>
        <p class="text-gray-600">Svi dokumenti u sistemu</p>
    </div>
    <a href="{{ route('admin.documents.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
        <span class="mr-2">+</span> Novi dokument
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naziv</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tip</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Predmet</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($documents as $document)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $document->file_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-800">{{ $document->document_type }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.legal-cases.show', $document->legalCase) }}" class="text-blue-600 hover:underline">
                            {{ $document->legalCase->title }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $document->uploaded_at->format('d.m.Y.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <form action="{{ route('admin.documents.destroy', $document) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Obriši</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nema dokumenata u sistemu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

