<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Advokatska Kancelarija')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 min-h-screen fixed">
            <div class="p-4">
                <h1 class="text-white text-xl font-bold">⚖️ Advokatska Kancelarija</h1>
            </div>
            <nav class="mt-4">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <span class="mr-3">📊</span>
                    Dashboard
                </a>
                <a href="{{ route('clients.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('clients.*') ? 'bg-gray-700 text-white' : '' }}">
                    <span class="mr-3">👥</span>
                    Klijenti
                </a>
                <a href="{{ route('legal-cases.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('legal-cases.*') ? 'bg-gray-700 text-white' : '' }}">
                    <span class="mr-3">📁</span>
                    Predmeti
                </a>
                <a href="{{ route('documents.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('documents.*') ? 'bg-gray-700 text-white' : '' }}">
                    <span class="mr-3">📄</span>
                    Dokumenta
                </a>
                <a href="{{ route('appointments.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('appointments.*') ? 'bg-gray-700 text-white' : '' }}">
                    <span class="mr-3">📅</span>
                    Kalendar
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
