<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran Enak - Cita Rasa Terbaik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    {{-- HEADER --}}

    {{-- NAVIGASI --}}
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                {{-- Logo --}}
                <div class="flex-1 md:flex md:items-center md:gap-12">
                    <a class="block text-teal-600 font-bold text-xl" href="/">
                        RestoranEnak
                    </a>
                </div>

                {{-- Menu Navigasi --}}
                <div class="md:flex md:items-center md:gap-12">
                    <nav aria-label="Global" class="hidden md:block">
                        <ul class="flex items-center gap-6 text-sm">
                            <li><a class="text-gray-500 transition hover:text-gray-500/75" href="/#about">Tentang Kami</a></li>
                            <li><a class="text-gray-500 transition hover:text-gray-500/75" href="{{ route('menu.index') }}">Menu</a></li>
                            <li><a class="text-gray-500 transition hover:text-gray-500/75" href="/#contact">Kontak</a></li>
                        </ul>
                    </nav>

            {{-- IKON KERANJANG BARU --}}
                <a href="{{ route('cart.show') }}" class="relative">
                         <svg class="h-6 w-6 text-gray-500 hover:text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                         </svg>
        @if(session('cart') && count(session('cart')) > 0)
            <span class="absolute -top-2 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                {{ count(session('cart')) }}
            </span>
        @endif
    </a>

                    {{-- Tombol Login/Register atau Dashboard --}}
                    <div class="flex items-center gap-4">
                        <div class="sm:flex sm:gap-4">
                            @auth
                                {{-- Jika user sudah login, tampilkan tombol Dashboard --}}
                                <a class="rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow" href="{{ url('/dashboard') }}">
                                    Dashboard
                                </a>
                            @else
                                {{-- Jika belum login, tampilkan Login & Register --}}
                                <a class="rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow" href="{{ route('login') }}">
                                    Login
                                </a>
                                <div class="hidden sm:flex">
                                    <a class="rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-teal-600" href="{{ route('register') }}">
                                        Register
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- KONTEN UTAMA HALAMAN --}}
    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-white">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="flex justify-center text-teal-600 sm:justify-start">
                    <span class="font-bold text-xl">RestoranEnak</span>
                </div>
                <p class="mt-4 text-center text-sm text-gray-500 lg:mt-0 lg:text-right">
                    Copyright &copy; {{ date('Y') }}. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>
