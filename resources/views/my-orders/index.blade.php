<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @forelse ($orders as $order)
                        <div class="border rounded-lg p-4 mb-4">
                            <div class="sm:flex sm:justify-between">
                                <div>
                                    <h3 class="text-lg font-bold">Pesanan #{{ $order->id }}</h3>
                                    <p class="text-sm text-gray-500">Dipesan pada: {{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="mt-2 sm:mt-0">
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="border-t my-4"></div>

                            {{-- Daftar Item --}}
                            <div class="space-y-3">
                                @foreach($order->items as $item)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if ($item->menu->gambar)
                                            <img src="{{ asset('storage/' . $item->menu->gambar) }}" class="h-12 w-12 rounded-md object-cover mr-4">
                                        @else
                                            <div class="h-12 w-12 rounded-md bg-gray-200 mr-4"></div>
                                        @endif
                                        <div>
                                            <p class="font-semibold">{{ $item->menu->nama_menu }}</p>
                                            <p class="text-sm text-gray-600">{{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <p class="font-semibold">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</p>
                                </div>
                                @endforeach
                            </div>

                            <div class="border-t my-4"></div>

                            <div class="text-right">
                                <p class="text-md font-bold">Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
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
</x-app-layout>
