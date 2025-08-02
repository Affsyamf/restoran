<x-layouts.admin>
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">&larr; Kembali ke Daftar Pesanan</a>
        <h1 class="text-2xl font-bold mt-2">Detail Pesanan #{{ $order->id }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Detail Item Pesanan --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold border-b pb-3 mb-4">Item Pesanan</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        @if ($item->menu->gambar)
                            <img src="{{ asset('storage/' . $item->menu->gambar) }}" alt="{{ $item->menu->nama_menu }}" class="h-14 w-14 rounded-md object-cover mr-4">
                        @else
                            <div class="h-14 w-14 rounded-md bg-gray-200 mr-4"></div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-900">{{ $item->menu->nama_menu }}</p>
                            <p class="text-sm text-gray-500">Jumlah: {{ $item->jumlah }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">(@ Rp {{ number_format($item->harga, 0, ',', '.') }})</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Kolom Kanan: Ringkasan Pesanan --}}
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold border-b pb-3 mb-4">Ringkasan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">ID Pesanan:</span>
                        <span class="font-medium">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal:</span>
                        <span class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Pelanggan:</span>
                        <span class="font-medium">{{ $order->user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status:</span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="border-t pt-3 mt-3 flex justify-between text-base font-bold">
                        <span>Total Harga:</span>
                        <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
