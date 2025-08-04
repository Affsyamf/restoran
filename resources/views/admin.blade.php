<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <title>Admin Panel - Restoran Enak</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="min-h-full flex">
        <!-- SIDEBAR -->
        <div class="flex flex-col w-64 bg-gray-800">
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <span class="text-white font-bold text-xl">Admin Panel</span>
            </div>
            <div class="flex flex-col flex-1 overflow-y-auto">
                <nav class="flex-1 px-2 py-4 bg-gray-800">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.menus.index') }}" class="mt-1 flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                        Manajemen Menu
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="mt-1 flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                        Manajemen User
                    </a>
                    {{-- LINK BARU: Manajemen Pesanan --}}
                    <a href="{{ route('admin.orders.index') }}" class="mt-1 flex items-center justify-between px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                     <span>Manajemen Pesanan</span>

                     @if($pendingOrderCount > 0)
            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                {{ $pendingOrderCount }}
            </span>
        @endif
                </nav>
            </div>
        </div>

        <!-- KONTEN UTAMA -->
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
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
