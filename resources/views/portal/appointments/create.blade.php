@extends('layouts.portal')

@section('content')
<div class="mb-6">
    <a href="{{ route('portal.appointments') }}" class="text-blue-600 hover:underline">← Nazad na termine</a>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">Zakaži Termin</h1>
            <p class="text-gray-500 mt-1">Pošaljite zahtev za zakazivanje termina sa vašim advokatom</p>
        </div>
        
        <form action="{{ route('portal.appointments.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-4">
                <label for="legal_case_id" class="block text-sm font-medium text-gray-700 mb-1">Predmet *</label>
                <select name="legal_case_id" id="legal_case_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Izaberite predmet</option>
                    @foreach($cases as $case)
                        <option value="{{ $case->id }}" {{ old('legal_case_id') == $case->id ? 'selected' : '' }}>
                            {{ $case->title }}
                        </option>
                    @endforeach
                </select>
                @error('legal_case_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @if($cases->isEmpty())
                    <p class="text-yellow-600 text-sm mt-1">Nemate aktivnih predmeta za zakazivanje termina</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tip termina *</label>
                <select name="type" id="type" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="sastanak" {{ old('type') == 'sastanak' ? 'selected' : '' }}>Sastanak</option>
                    <option value="rociste" {{ old('type') == 'rociste' ? 'selected' : '' }}>Ročište</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="date_time" class="block text-sm font-medium text-gray-700 mb-1">Željeni datum i vreme *</label>
                <input type="datetime-local" name="date_time" id="date_time" required
                    value="{{ old('date_time') }}"
                    min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('date_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Termin mora biti najmanje 24 sata unapred</p>
            </div>

            <div class="mb-6">
                <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Napomena</label>
                <textarea name="note" id="note" rows="3"
                    placeholder="Opišite razlog zakazivanja termina..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('note') }}</textarea>
                @error('note')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('portal.appointments') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Otkaži
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700" {{ $cases->isEmpty() ? 'disabled' : '' }}>
                    Pošalji Zahtev
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
