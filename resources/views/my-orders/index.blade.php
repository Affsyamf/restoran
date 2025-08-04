<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    {{-- Pembungkus utama dengan state Alpine.js untuk modal ulasan --}}
    <div x-data="{ showReviewModal: false, reviewAction: '', reviewMenuId: null, reviewMenuName: '' }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        
                        {{-- Notifikasi Sukses & Error --}}
                        @if (session('success'))
                            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        @forelse ($orders as $order)
                            <div class="border rounded-lg p-4 mb-4 shadow-sm">
                                {{-- Header Pesanan --}}
                                <div class="sm:flex sm:justify-between sm:items-start">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">Pesanan #{{ $order->id }}</h3>
                                        <p class="text-sm text-gray-500">Dipesan pada: {{ $order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div class="mt-2 sm:mt-0">
                                        <span @class([
                                            'px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full',
                                            'bg-yellow-100 text-yellow-800' => $order->status == 'pending',
                                            'bg-blue-100 text-blue-800' => $order->status == 'processing',
                                            'bg-green-100 text-green-800' => $order->status == 'completed',
                                            'bg-red-100 text-red-800' => $order->status == 'cancelled',
                                        ])>
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="border-t my-4"></div>

                                {{-- Daftar Item Pesanan --}}
                                <div class="space-y-4">
                                    @foreach($order->items as $item)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            @if ($item->menu->gambar)
                                                <img src="{{ asset('storage/' . $item->menu->gambar) }}" class="h-14 w-14 rounded-md object-cover mr-4">
                                            @else
                                                <div class="h-14 w-14 rounded-md bg-gray-200 mr-4"></div>
                                            @endif
                                            <div>
                                                <p class="font-semibold">{{ $item->menu->nama_menu }}</p>
                                                <p class="text-sm text-gray-600">{{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</p>
                                            
                                            {{-- Tampilkan tombol "Beri Ulasan" hanya jika pesanan sudah 'completed' --}}
                                            @if($order->status == 'completed')
                                                <button 
                                                    @click="
                                                        showReviewModal = true; 
                                                        reviewAction = '{{ route('reviews.store') }}';
                                                        reviewMenuId = {{ $item->menu->id }};
                                                        reviewMenuName = '{{ e($item->menu->nama_menu) }}';
                                                    "
                                                    class="mt-2 text-sm font-medium text-indigo-600 hover:text-indigo-500"
                                                >
                                                    Beri Ulasan
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="border-t my-4"></div>

                                <div class="text-right">
                                    <p class="text-md font-bold text-gray-800">Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">Anda belum memiliki riwayat pesanan.</p>
                        @endforelse

                        {{-- Pagination Links --}}
                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panggil komponen modal ulasan di sini --}}
        <x-modal-review />
    </div>
</x-app-layout>
