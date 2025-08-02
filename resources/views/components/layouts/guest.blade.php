<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran Enak - Cita Rasa Terbaik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

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
                            <li><a class="text-gray-500 transition hover:text-gray-500/75" href="#about">Tentang Kami</a></li>
                            <li><a class="text-gray-500 transition hover:text-gray-500/75" href="#menu">Menu</a></li>
                            <li><a class="text-gray-500 transition hover:text-gray-500/75" href="#contact">Kontak</a></li>
                        </ul>
                    </nav>

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
    <main>
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
