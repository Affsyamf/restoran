    <x-layouts.guest>
        <div class="bg-white">
            <div class="pt-6">
                <!-- Image gallery -->
                <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-1 lg:gap-x-8 lg:px-8">
                    <div class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block">
                        @if ($menu->gambar)
                            <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="h-full w-full object-cover object-center">
                        @else
                            <img src="https://placehold.co/800x600/CCCCCC/FFFFFF?text=Menu" alt="{{ $menu->nama_menu }}" class="h-full w-full object-cover object-center">
                        @endif
                    </div>
                </div>

                <!-- Product info -->
                <div class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
                    <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $menu->nama_menu }}</h1>
                    </div>

                    <!-- Options -->
                    <div class="mt-4 lg:row-span-3 lg:mt-0">
                        <h2 class="sr-only">Product information</h2>
                        <p class="text-3xl tracking-tight text-gray-900">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>

                        <form class="mt-10" action="{{ route('cart.store', $menu->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-teal-600 px-8 py-3 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">Pesan Sekarang</button>
                        </form>
                    </div>

                    <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6">
                        <!-- Description and details -->
                        <div>
                            <h3 class="sr-only">Description</h3>
                            <div class="space-y-6">
                                <p class="text-base text-gray-900">{{ $menu->deskripsi }}</p>
                            </div>
                        </div>

                        <div class="mt-10">
                            <h3 class="text-sm font-medium text-gray-900">Kategori</h3>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600">{{ $menu->kategori }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.guest>
    