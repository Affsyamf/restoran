<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Restoran Enak</title>
    
    <!-- Aset dimuat oleh Vite. Pastikan path ini sesuai dengan proyek Anda. -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="h-full font-sans">
    <!-- Komponen utama dengan state Alpine.js untuk sidebar -->
    <!-- Alpine.js akan di-bundle oleh Vite melalui resources/js/app.js -->
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        
        <!-- Overlay untuk mobile saat sidebar terbuka -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-gray-900/50 transition-opacity md:hidden"></div>

        <!-- SIDEBAR -->
        <div 
            :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }" 
            class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-gray-800 text-white transition-transform duration-300 ease-in-out md:relative md:translate-x-0">
            
            <!-- Logo/Judul Sidebar -->
            <div class="flex h-16 flex-shrink-0 items-center justify-center bg-gray-900 px-4">
                <span class="text-xl font-bold">Admin Panel</span>
            </div>
            
            <!-- Navigasi Sidebar -->
            <div class="flex-grow overflow-y-auto">
                <nav class="flex-1 px-2 py-4">
                    {{-- Helper untuk menentukan kelas 'active' --}}
                    @php
                        $activeClass = 'bg-gray-900 text-white';
                        $inactiveClass = 'text-gray-300 hover:bg-gray-700 hover:text-white';
                    @endphp

                    <a href="{{ route('admin.dashboard') }}" class="flex items-center rounded-md px-4 py-2 {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.menus.index') }}" class="mt-1 flex items-center rounded-md px-4 py-2 {{ request()->routeIs('admin.menus.*') ? $activeClass : $inactiveClass }}">
                        Manajemen Menu
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="mt-1 flex items-center rounded-md px-4 py-2 {{ request()->routeIs('admin.users.*') ? $activeClass : $inactiveClass }}">
                        Manajemen User
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="mt-1 flex items-center justify-between rounded-md px-4 py-2 {{ request()->routeIs('admin.orders.*') ? $activeClass : $inactiveClass }}">
                        <span>Manajemen Pesanan</span>
                        @if(isset($pendingOrderCount) && $pendingOrderCount > 0)
                            <span class="inline-flex items-center justify-center rounded-full bg-red-600 px-2 py-1 text-xs font-bold leading-none text-red-100">
                                {{ $pendingOrderCount }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('admin.reviews.index') }}" class="mt-1 flex items-center rounded-md px-4 py-2 {{ request()->routeIs('admin.reviews.*') ? $activeClass : $inactiveClass }}">
                        Manajemen Ulasan
                    </a>
                    <a href="{{ route('admin.promo-codes.index') }}" class="mt-1 flex items-center rounded-md px-4 py-2 {{ request()->routeIs('admin.promo-codes.*') ? $activeClass : $inactiveClass }}">
                        Kode Promo
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="mt-1 flex items-center rounded-md px-4 py-2 {{ request()->routeIs('admin.settings.*') ? $activeClass : $inactiveClass }}">
                        Pengaturan Situs
                    </a>
                </nav>
            </div>
        </div>

        <!-- AREA KONTEN UTAMA -->
        <div class="flex flex-1 flex-col">
            <!-- Header Konten -->
            <header class="bg-white shadow-sm">
                <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                    <!-- Tombol Hamburger (hanya terlihat di mobile) -->
                    <button @click="sidebarOpen = !sidebarOpen" type="button" class="rounded-md p-2 text-gray-700 hover:bg-gray-100 md:hidden">
                        <span class="sr-only">Buka menu</span>
                        <!-- Ikon Hamburger -->
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    
                    <!-- Spacer untuk mendorong tombol logout ke kanan di desktop -->
                    <div class="hidden md:block"></div>

                    <!-- Tombol Logout -->
                    <div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            
            <!-- Konten Utama (Slot) -->
            <main class="flex-1 p-4 sm:p-6 bg-gray-100">
                <!-- Konten dari halaman spesifik (dashboard, menu, dll.) akan dirender di sini -->
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
