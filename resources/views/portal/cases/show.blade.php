@extends('layouts.portal')

@section('content')
<div class="mb-6">
    <a href="{{ route('portal.cases') }}" class="text-blue-600 hover:underline">← Nazad na predmete</a>
</div>

<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $legalCase->title }}</h1>
                <p class="text-gray-500 mt-1">{{ $legalCase->case_type }}</p>
            </div>
            <span class="px-3 py-1 text-sm rounded-full 
                {{ $legalCase->status === 'aktivan' ? 'bg-green-100 text-green-800' : '' }}
                {{ $legalCase->status === 'zavrsen' ? 'bg-gray-100 text-gray-800' : '' }}
                {{ $legalCase->status === 'pauziran' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                {{ ucfirst($legalCase->status) }}
            </span>
        </div>
    </div>
    <div class="p-6 grid grid-cols-2 gap-4">
        <div>
            <p class="text-sm text-gray-500">Sud</p>
            <p class="font-medium">{{ $legalCase->court ?? 'Nije navedeno' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Protivna strana</p>
            <p class="font-medium">{{ $legalCase->opponent ?? 'Nije navedeno' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Datum otvaranja</p>
            <p class="font-medium">{{ $legalCase->opened_at ? \Carbon\Carbon::parse($legalCase->opened_at)->format('d.m.Y') : 'N/A' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Advokat</p>
            <p class="font-medium">{{ $legalCase->user->name ?? 'N/A' }}</p>
        </div>
    </div>
</div>

<!-- Tabs -->
<div class="bg-white rounded-lg shadow">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <button onclick="showTab('documents')" id="tab-documents" class="tab-btn px-6 py-3 border-b-2 border-blue-500 text-blue-600 font-medium">
                📄 Dokumenta ({{ $legalCase->documents->count() }})
            </button>
            <button onclick="showTab('appointments')" id="tab-appointments" class="tab-btn px-6 py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                📅 Termini ({{ $legalCase->appointments->count() }})
            </button>
        </nav>
    </div>

    <!-- Documents Tab -->
    <div id="content-documents" class="tab-content p-6">
        @if($legalCase->documents->isEmpty())
            <p class="text-gray-500 text-center py-4">Nema dokumenata za ovaj predmet</p>
        @else
            <div class="space-y-3">
                @foreach($legalCase->documents as $document)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">📄</span>
                            <div>
                                <p class="font-medium">{{ $document->file_name }}</p>
                                <p class="text-sm text-gray-500">{{ $document->document_type }} - {{ \Carbon\Carbon::parse($document->uploaded_at)->format('d.m.Y') }}</p>
                            </div>
                        </div>
                        @if($document->file_path)
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                Preuzmi
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Appointments Tab -->
    <div id="content-appointments" class="tab-content p-6 hidden">
        @if($legalCase->appointments->isEmpty())
            <p class="text-gray-500 text-center py-4">Nema termina za ovaj predmet</p>
        @else
            <div class="space-y-3">
                @foreach($legalCase->appointments as $appointment)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">{{ $appointment->type === 'rociste' ? '⚖️' : '🤝' }}</span>
                            <div>
                                <p class="font-medium">{{ $appointment->type === 'rociste' ? 'Ročište' : 'Sastanak' }}</p>
                                <p class="text-sm text-gray-500">{{ $appointment->location }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium">{{ \Carbon\Carbon::parse($appointment->date_time)->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all content
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    // Reset all tabs
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('border-blue-500', 'text-blue-600');
        el.classList.add('border-transparent', 'text-gray-500');
    });
    // Show selected content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    // Activate tab
    const tab = document.getElementById('tab-' + tabName);
    tab.classList.remove('border-transparent', 'text-gray-500');
    tab.classList.add('border-blue-500', 'text-blue-600');
}
</script>
@endsection
