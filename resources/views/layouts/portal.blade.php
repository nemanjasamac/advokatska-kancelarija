<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Advokatska Kancelarija') }} - Klijent Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-blue-800 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('portal.dashboard') }}" class="text-xl font-bold">
                            ⚖️ Moj Portal
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-blue-200">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-blue-200 hover:text-white">
                                Odjavi se
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-white shadow-md min-h-screen">
                <nav class="mt-6">
                    <a href="{{ route('portal.dashboard') }}" 
                       class="flex items-center px-6 py-3 {{ request()->routeIs('portal.dashboard') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        <span class="mr-3">📊</span>
                        Početna
                    </a>
                    <a href="{{ route('portal.cases') }}" 
                       class="flex items-center px-6 py-3 {{ request()->routeIs('portal.cases*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        <span class="mr-3">📁</span>
                        Moji Predmeti
                    </a>
                    <a href="{{ route('portal.documents') }}" 
                       class="flex items-center px-6 py-3 {{ request()->routeIs('portal.documents*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        <span class="mr-3">📄</span>
                        Dokumenta
                    </a>
                    <a href="{{ route('portal.appointments') }}" 
                       class="flex items-center px-6 py-3 {{ request()->routeIs('portal.appointments*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        <span class="mr-3">📅</span>
                        Termini
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-8">
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
    </div>
</body>
</html>
