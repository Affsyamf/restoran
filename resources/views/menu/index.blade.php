<x-layouts.guest>
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            
            {{-- Header dan Form Filter --}}
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900">Jelajahi Menu Kami</h1>
                <p class="mt-4 max-w-2xl mx-auto text-base text-gray-500">Temukan hidangan favorit Anda atau coba sesuatu yang baru dari koleksi kami.</p>
            </div>

            <form method="GET" action="{{ route('menu.index') }}" class="mt-12 p-6 bg-gray-50 rounded-lg border">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Cari Menu</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Contoh: Ayam Bakar" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="min_price" class="block text-sm font-medium text-gray-700">Harga Minimum</label>
                        <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" placeholder="Rp 0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="max_price" class="block text-sm font-medium text-gray-700">Harga Maksimum</label>
                        <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" placeholder="Rp 100.000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" @selected(request('category') == $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700">Urutkan</label>
                        <select name="sort" id="sort" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="" @selected(!request('sort'))>Standar</option>
                            <option value="latest" @selected(request('sort') == 'latest')>Terbaru</option>
                            <option value="bestseller" @selected(request('sort') == 'bestseller')>Paling Laris</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-4">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-teal-700">Terapkan Filter</button>
                        <a href="{{ route('menu.index') }}" class="w-full inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Reset</a>
                    </div>
                </div>
            </form>

            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="mt-8 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Daftar Menu --}}
            <div class="mt-8 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @forelse ($menus as $menu)
                    <div class="group">
                        <a href="{{ route('menu.show', $menu) }}">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                                <img src="{{ $menu->gambar ? asset('storage/' . $menu->gambar) : 'https://placehold.co/400x400/CCCCCC/FFFFFF?text=Menu' }}" alt="{{ $menu->nama_menu }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-sm text-gray-700">{{ $menu->nama_menu }}</h3>
                                    <p class="text-sm font-medium text-gray-900">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">{{ $menu->kategori }}</p>
                                <div class="mt-2">
                                    <x-star-rating :rating="$menu->reviews_avg_rating" :count="$menu->reviews->count()" />
                                </div>
                            </div>
                        </a>
                        <form action="{{ route('cart.store', $menu->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow hover:bg-teal-700">
                                Pesan
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-lg text-gray-500">Menu yang Anda cari tidak ditemukan.</p>
                        <a href="{{ route('menu.index') }}" class="mt-4 inline-block text-sm font-medium text-teal-600 hover:text-teal-500">
                            Reset Filter & Lihat Semua Menu &rarr;
                        </a>
                    </div>
                @endforelse
            </div>
            
            {{-- Pagination Links --}}
            <div class="mt-10">
                {{ $menus->links() }}
            </div>
        </div>
    </div>
</x-layouts.guest>
