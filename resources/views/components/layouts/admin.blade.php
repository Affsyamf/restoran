<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Restoran Enak</title>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="flex min-h-screen">
        <!-- SIDEBAR (Latar Belakang Gelap) -->
        <div class="flex flex-col w-64 bg-gray-800 text-white">
            <div class="flex items-center justify-center h-16 flex-shrink-0 bg-gray-900">
                <span class="font-bold text-xl">Admin Panel</span>
            </div>
            <div class="flex-grow overflow-y-auto">
                <nav class="flex-1 px-2 py-4">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.menus.index') }}" class="mt-1 flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                        Manajemen Menu
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="mt-1 flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                        Manajemen User
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="mt-1 flex items-center justify-between px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                        <span>Manajemen Pesanan</span>
                        @if($pendingOrderCount > 0)
                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                {{ $pendingOrderCount }}
                            </span>
                        @endif
                    </a>

                    {{-- manajemen ulasan --}}
                    <a href="{{ route('admin.reviews.index') }}" class="mt-1 flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                        Manajemen Ulasan
                    </a>

                     <a href="{{ route('admin.promo-codes.index') }}" class="mt-1 flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                        Kode Promo
                    </a>

                    {{-- manajemen setting CMS --}}
                     <a href="{{ route('admin.settings.index') }}" class="mt-1 flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                        Setting Situs
                    </a>
                </nav>
            </div>
        </div>

        <!-- AREA KONTEN UTAMA (Latar Belakang Terang) -->
        <div class="flex flex-col flex-1">
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-end">
                    <!-- Tombol Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Log Out</button>
                    </form>
                </div>
            </header>
            <main class="flex-1 p-6 bg-gray-100">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
