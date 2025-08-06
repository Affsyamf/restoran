<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Pesan Selamat Datang --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Selamat Datang Kembali, {{ Auth::user()->name }}!</h3>
                    <p class="mt-1 text-gray-600">Senang melihat Anda lagi. Berikut adalah ringkasan aktivitas Anda.</p>
                </div>
            </div>

            {{-- Kartu Statistik --}}
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Pesanan Anda</dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalOrders }}</dd>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex items-center justify-center p-6">
                    <a href="{{ route('menu.index') }}" class="w-full text-center inline-flex items-center justify-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-white hover:bg-teal-700">
                        Pesan Menu Sekarang
                    </a>
                </div>
            </div>

            {{-- Panel Pesanan Terbaru --}}
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Pesanan Terbaru Anda</h3>
                    <div class="mt-4 flow-root">
                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                            @forelse($recentOrders as $order)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">Pesanan #{{ $order->id }}</p>
                                            <p class="text-sm text-gray-500 truncate">{{ $order->created_at->format('d M Y') }}</p>
                                        </div>
                                        <div>
                                            <span @class([
                                                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                'bg-yellow-100 text-yellow-800' => $order->status == 'pending',
                                                'bg-blue-100 text-blue-800' => $order->status == 'processing',
                                                'bg-green-100 text-green-800' => $order->status == 'completed',
                                                'bg-red-100 text-red-800' => $order->status == 'cancelled',
                                            ])>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-4 text-sm text-gray-500">Anda belum memiliki pesanan.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('my-orders.index') }}" class="w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Lihat Semua Riwayat Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
