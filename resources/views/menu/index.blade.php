<x-layouts.guest>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Menu Restoran Kami</h2>
            
            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @forelse ($menus as $menu)
                    <div class="group relative">
                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                            @if ($menu->gambar)
                                <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            @else
                                <img src="https://placehold.co/400x400/CCCCCC/FFFFFF?text=Menu" alt="{{ $menu->nama_menu }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            @endif
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $menu->nama_menu }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $menu->kategori }}</p>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                        </div>
                        
                        {{-- Form Tombol Pesan --}}
                        <form action="{{ route('cart.store', $menu->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow hover:bg-teal-700">
                                Pesan
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="col-span-4 text-center text-gray-500">Saat ini belum ada menu yang tersedia.</p>
                @endforelse
            </div>
            
            {{-- Pagination Links --}}
            <div class="mt-10">
                {{ $menus->links() }}
            </div>
        </div>
    </div>
</x-layouts.guest>
