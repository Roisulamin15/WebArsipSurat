<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Arsip Surat') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-[#7A1E1E] text-white flex flex-col">
        <div class="p-6 text-center font-bold text-xl border-b border-white/20">
            Arsip Surat
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('dashboard') }}"
               class="block px-4 py-2 rounded hover:bg-[#4B0F0F]">
                Dashboard
            </a>

            <a href="{{ route('surat-masuk.index') }}"
                class="block px-4 py-2 rounded hover:bg-[#4B0F0F]">
                Surat Masuk
            </a>

            <a href="{{ route('surat-keluar.index') }}"
                class="block px-4 py-2 rounded hover:bg-[#4B0F0F]">
                Surat Keluar
            </a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="p-4">
            @csrf
            <button class="w-full py-2 rounded bg-[#4B0F0F] hover:bg-black">
                Logout
            </button>
        </form>
    </aside>

    {{-- CONTENT --}}
    <main class="flex-1">
        {{-- NAVBAR --}}
        <div class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="font-semibold text-gray-700">
                @yield('title')
            </h1>

            <div class="relative group">

    <button class="flex items-center gap-3 focus:outline-none">
        <div class="w-9 h-9 rounded-full bg-[#7A1E1E] flex items-center justify-center text-white font-bold">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

        <span class="text-sm text-gray-700">
            {{ auth()->user()->name }}
        </span>
    </button>

    {{-- DROPDOWN --}}
    <div class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-md hidden group-hover:block">
        <a href="{{ route('profile') }}"
        class="flex items-center gap-3 hover:opacity-80">

            <div class="w-9 h-9 rounded-full bg-[#7A1E1E]
                        flex items-center justify-center
                        text-white font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <span class="text-sm text-gray-700">
                {{ auth()->user()->name }}
            </span>
        </a>

            <form method="POST" action="{{ route('logout') }}">
            @csrf
            
        </form>
        </div>

</div>

        </div>

        {{-- PAGE CONTENT --}}
        <div class="p-6">
            @yield('content')
        </div>
    </main>

</div>

</body>
</html>
