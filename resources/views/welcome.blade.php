<x-layouts.guest>
    {{-- BAGIAN HERO --}}
    <section class="relative bg-cover bg-center bg-no-repeat" style="background-image: url(https://placehold.co/1920x800/333333/FFFFFF?text=Hidangan+Lezat)">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative mx-auto max-w-screen-xl px-4 py-32 sm:px-6 lg:flex lg:h-screen lg:items-center lg:px-8">
            <div class="max-w-xl text-center sm:text-left text-white">
                <h1 class="text-3xl font-extrabold sm:text-5xl">
                    Sajikan Momen Terbaik
                    <strong class="block font-extrabold text-teal-500"> Bersama Kami. </strong>
                </h1>
                <p class="mt-4 max-w-lg sm:text-xl/relaxed">
                    Nikmati hidangan istimewa yang dibuat dari bahan-bahan segar pilihan, disajikan dengan cinta dan kehangatan.
                </p>
                <div class="mt-8 flex flex-wrap gap-4 text-center">
                    <a href="#menu" class="block w-full rounded bg-teal-600 px-12 py-3 text-sm font-medium text-white shadow hover:bg-teal-700 focus:outline-none focus:ring active:bg-teal-500 sm:w-auto">
                        Lihat Menu
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- BAGIAN TENTANG KAMI --}}
    <section id="about" class="py-16">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
                <div class="relative h-64 overflow-hidden rounded-lg sm:h-80 lg:h-full">
                    <img alt="Interior Restoran" src="https://placehold.co/800x600/555555/FFFFFF?text=Suasana+Restoran" class="absolute inset-0 h-full w-full object-cover">
                </div>
                <div class="lg:py-16">
                    <h2 class="text-3xl font-bold sm:text-4xl">Cerita di Balik Cita Rasa</h2>
                    <p class="mt-4 text-gray-600">
                        Restoran Enak lahir dari kecintaan kami terhadap masakan otentik dan keinginan untuk menciptakan tempat di mana setiap orang bisa menikmati makanan lezat dalam suasana yang nyaman dan hangat. Kami percaya bahwa makanan adalah cara terbaik untuk menyatukan orang.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- BAGIAN MENU UNGGULAN --}}
    <section id="menu" class="bg-gray-100 py-16">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-3xl font-bold sm:text-4xl mb-12">Menu Unggulan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse ($featuredMenus as $menu)
                    <div class="block rounded-lg p-4 shadow-sm shadow-indigo-100 bg-white">
                        <img alt="Menu" src="https://placehold.co/400x300/CCCCCC/FFFFFF?text={{ urlencode($menu->nama_menu) }}" class="h-56 w-full rounded-md object-cover" />
                        <div class="mt-2">
                            <dl>
                                <div>
                                    <dt class="sr-only">Harga</dt>
                                    <dd class="text-sm text-gray-500">Rp {{ number_format($menu->harga, 0, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="sr-only">Nama Menu</dt>
                                    <dd class="font-medium">{{ $menu->nama_menu }}</dd>
                                </div>
                            </dl>
                            <p class="text-xs text-gray-600 mt-2">{{ Str::limit($menu->deskripsi, 50) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="col-span-4 text-center text-gray-500">Menu unggulan akan segera hadir!</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- BAGIAN KONTAK --}}
    <section id="contact" class="py-16">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold sm:text-4xl">Hubungi Kami</h2>
            <p class="mt-4 text-gray-600">
                Punya pertanyaan atau ingin reservasi? Jangan ragu untuk menghubungi kami.
            </p>
            <p class="mt-4 font-bold text-teal-600 text-lg">Telepon: (021) 123-4567</p>
        </div>
    </section>
</x-layouts.guest>
