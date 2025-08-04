<x-layouts.guest>
    <div class="bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            {{-- Grid Layout Utama (Gambar di Kiri, Info di Kanan) --}}
            <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                
                {{-- Kolom Kiri: Gambar Menu --}}
                <div class="flex flex-col gap-y-8">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg">
                        <img src="{{ $menu->gambar ? asset('storage/' . $menu->gambar) : 'https://placehold.co/800x600/CCCCCC/FFFFFF?text=Menu' }}" alt="{{ $menu->nama_menu }}" class="h-full w-full object-cover object-center">
                    </div>
                    {{-- Anda bisa menambahkan galeri gambar kecil di sini jika perlu --}}
                </div>

                {{-- Kolom Kanan: Informasi Menu --}}
                <div class="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0">
                    {{-- Judul dan Rating --}}
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $menu->nama_menu }}</h1>
                        <div class="mt-3">
                            <h2 class="sr-only">Ulasan Produk</h2>
                            <div class="flex items-center">
                                <x-star-rating :rating="$menu->reviews->avg('rating')" :count="$menu->reviews->count()" />
                            </div>
                        </div>
                    </div>

                    {{-- Harga dan Tombol Pesan --}}
                    <div class="mt-6">
                        <p class="text-3xl tracking-tight text-gray-900">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                        <form class="mt-6" action="{{ route('cart.store', $menu->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex w-full max-w-xs items-center justify-center rounded-md border border-transparent bg-teal-600 px-8 py-3 text-base font-medium text-white hover:bg-teal-700">Pesan Sekarang</button>
                        </form>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-xl font-medium text-gray-900">Deskripsi</h3>
                        <div class="mt-4 space-y-6">
                            <p class="text-base text-gray-700">{{ $menu->deskripsi ?: 'Tidak ada deskripsi untuk menu ini.' }}</p>
                        </div>
                    </div>

                    {{-- Ulasan Pelanggan --}}
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-xl font-medium text-gray-900">Ulasan Pelanggan</h3>
                        <div class="mt-6 flow-root">
                            @forelse($menu->reviews as $review)
                                <div class="py-6 border-t border-gray-200">
                                    <div class="flex items-center">
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900">{{ $review->user->name }}</h4>
                                            <div class="mt-1 flex items-center">
                                                <x-star-rating :rating="$review->rating" />
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-4 text-base text-gray-600">{{ $review->comment }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 mt-4">Belum ada ulasan untuk menu ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
