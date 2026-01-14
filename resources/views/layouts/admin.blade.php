<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Advokatska Kancelarija') }} - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white min-h-screen fixed">
            <div class="p-4 border-b border-gray-700">
                <h1 class="text-xl font-bold">⚖️ Advokatska kancelarija</h1>
                <p class="text-gray-400 text-sm">Admin Panel</p>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                    <span class="mr-3">📊</span>
                    Dashboard
                </a>
                <a href="{{ route('admin.clients.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.clients.*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                    <span class="mr-3">👥</span>
                    Klijenti
                </a>
                <a href="{{ route('admin.legal-cases.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.legal-cases.*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                    <span class="mr-3">📁</span>
                    Predmeti
                </a>
                <a href="{{ route('admin.documents.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.documents.*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                    <span class="mr-3">📄</span>
                    Dokumenta
                </a>
                <a href="{{ route('admin.appointments.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.appointments.*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                    <span class="mr-3">📅</span>
                    Kalendar
                </a>
            </nav>
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white">
                            🚪
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
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
