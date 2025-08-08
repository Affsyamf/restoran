<x-layouts.guest>
    <div class="bg-white">
        {{-- Inisialisasi Alpine.js di sini --}}
        <div 
            x-data="{
                menus: [],
                pagination: {},
                isLoading: true,
                filters: {
                    search: '{{ request('search', '') }}',
                    category: '{{ request('category', '') }}',
                    min_price: '{{ request('min_price', '') }}',
                    max_price: '{{ request('max_price', '') }}',
                    sort: '{{ request('sort', '') }}',
                    page: 1
                },
                
                fetchMenus() {
                    this.isLoading = true;
                    // Reset page to 1 on new filter, but not on pagination click
                    if (this.filters.page === undefined) this.filters.page = 1;
                    const params = new URLSearchParams(this.filters).toString();
                    fetch(`/api/menus?${params}`)
                        .then(response => response.json())
                        .then(data => {
                            this.menus = data.data;
                            this.pagination = data;
                            this.isLoading = false;
                        });
                },

                changePage(page) {
                    if (page && page >= 1 && page <= this.pagination.last_page) {
                        this.filters.page = page;
                        this.fetchMenus();
                    }
                }
            }"
            x-init="fetchMenus()"
            class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8"
        >
            
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900">Jelajahi Menu Kami</h1>
                <p class="mt-4 max-w-2xl mx-auto text-base text-gray-500">Temukan hidangan favorit Anda atau coba sesuatu yang baru.</p>
            </div>

            {{-- Form Filter --}}
            <div class="mt-12 p-6 bg-gray-50 rounded-lg border">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Cari Menu</label>
                        <input type="text" x-model.debounce.500ms="filters.search" @input="filters.page = 1; fetchMenus()" placeholder="Contoh: Ayam Bakar" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="min_price" class="block text-sm font-medium text-gray-700">Harga Minimum</label>
                        <input type="number" x-model.debounce.500ms="filters.min_price" @input="filters.page = 1; fetchMenus()" placeholder="Rp 0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="max_price" class="block text-sm font-medium text-gray-700">Harga Maksimum</label>
                        <input type="number" x-model.debounce.500ms="filters.max_price" @input="filters.page = 1; fetchMenus()" placeholder="Rp 100.000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select x-model="filters.category" @change="filters.page = 1; fetchMenus()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700">Urutkan</label>
                        <select x-model="filters.sort" @change="filters.page = 1; fetchMenus()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Standar</option>
                            <option value="latest">Terbaru</option>
                            <option value="bestseller">Paling Laris</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="mt-8 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Daftar Menu --}}
            <div class="mt-8 relative">
                <div x-show="isLoading" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
                    <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-teal-600"></div>
                </div>

                <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    <template x-for="menu in menus" :key="menu.id">
                        <div class="group">
                            <a :href="`/menu/${menu.id}`" class="relative block">
                                <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                                    <img :src="menu.gambar ? `/storage/${menu.gambar}` : `https://placehold.co/400x400/CCCCCC/FFFFFF?text=Menu`" :alt="menu.nama_menu" 
                                         class="h-full w-full object-cover object-center transition-all"
                                         :class="{ 'grayscale': !menu.is_available }">
                                </div>
                                <template x-if="!menu.is_available">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-md">
                                        <span class="text-white font-bold text-lg bg-red-600 px-4 py-1 rounded-full">HABIS</span>
                                    </div>
                                </template>
                            </a>
                            <div class="mt-4">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-sm text-gray-700" x-text="menu.nama_menu"></h3>
                                    <p class="text-sm font-medium text-gray-900" x-text="`Rp ${new Intl.NumberFormat('id-ID').format(menu.harga)}`"></p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500" x-text="menu.kategori"></p>
                                <div class="mt-2 flex items-center">
                                    <template x-if="menu.reviews_count > 0">
                                        <div class="flex items-center">
                                            <template x-for="i in 5" :key="i">
                                                <svg :class="i <= Math.round(menu.reviews_avg_rating) ? 'text-yellow-400' : 'text-gray-300'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.368-2.448a1 1 0 00-1.175 0l-3.368 2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.06 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z" /></svg>
                                            </template>
                                            <p class="ml-2 text-xs text-gray-500" x-text="`${menu.reviews_count} ulasan`"></p>
                                        </div>
                                    </template>
                                    <template x-if="menu.reviews_count === 0">
                                        <p class="text-xs text-gray-500">Belum ada ulasan</p>
                                    </template>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button 
                                    @click.prevent="addToCart(menu.id, $event)"
                                    type="button" 
                                    class="w-full rounded-md px-5 py-2.5 text-sm font-medium text-white shadow transition"
                                    :disabled="!menu.is_available"
                                    :class="{
                                        'bg-teal-600 hover:bg-teal-700': menu.is_available,
                                        'bg-gray-400 cursor-not-allowed': !menu.is_available
                                    }"
                                >
                                    <span x-text="menu.is_available ? 'Pesan' : 'Habis'"></span>
                                </button>
                            </div>
                        </div>
                    </template>
                    <template x-if="!isLoading && menus.length === 0">
                        <div class="col-span-full text-center py-12">
                            <p class="text-lg text-gray-500">Menu yang Anda cari tidak ditemukan.</p>
                            <a href="{{ route('menu.index') }}" class="mt-4 inline-block text-sm font-medium text-teal-600 hover:text-teal-500">
                                Reset Filter & Lihat Semua Menu &rarr;
                            </a>
                        </div>
                    </template>
                </div>
            </div>
            
            {{-- Pagination Links --}}
            <nav class="mt-10 flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
                <div class="flex w-0 flex-1">
                    <a href="#" @click.prevent="changePage(pagination.current_page - 1)" x-show="pagination.prev_page_url" class="-mt-px inline-flex items-center border-t-2 border-transparent pr-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                        &larr; Sebelumnya
                    </a>
                </div>
                <div class="hidden md:-mt-px md:flex">
                    <template x-for="link in pagination.links">
                        <a href="#" @click.prevent="changePage(link.label.includes('...') ? null : link.label)"
                           :class="{
                               'border-teal-500 text-teal-600': link.active,
                               'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': !link.active
                           }"
                           class="inline-flex items-center border-t-2 px-4 pt-4 text-sm font-medium"
                           x-html="link.label">
                        </a>
                    </template>
                </div>
                <div class="flex w-0 flex-1 justify-end">
                    <a href="#" @click.prevent="changePage(pagination.current_page + 1)" x-show="pagination.next_page_url" class="-mt-px inline-flex items-center border-t-2 border-transparent pl-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                        Berikutnya &rarr;
                    </a>
                </div>
            </nav>
        </div>
    </div>
</x-layouts.guest>
