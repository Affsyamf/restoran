<x-layouts.admin>
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">&larr; Kembali ke Daftar Pesanan</a>
        <h1 class="text-2xl font-bold mt-2">Kelola Pesanan #{{ $order->id }}</h1>
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

        {{-- Kolom Kanan: Ringkasan & Ubah Status --}}
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold border-b pb-3 mb-4">Ringkasan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Pelanggan:</span>
                        <span class="font-medium">{{ $order->user->name }}</span>
                    </div>
                    <div class="border-t pt-3 mt-3 flex justify-between text-base font-bold">
                        <span>Total Harga:</span>
                        <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Form Ubah Status --}}
                <div class="border-t mt-6 pt-6">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label for="status" class="block text-sm font-medium text-gray-700">Ubah Status Pesanan</label>
                        <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="pending" @selected($order->status == 'pending')>Pending</option>
                            <option value="processing" @selected($order->status == 'processing')>Processing</option>
                            <option value="completed" @selected($order->status == 'completed')>Completed</option>
                            <option value="cancelled" @selected($order->status == 'cancelled')>Cancelled</option>
                        </select>
                        <button type="submit" class="mt-4 w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
