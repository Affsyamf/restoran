<x-layouts.admin>
    <h1 class="text-2xl font-bold mb-6">Edit Menu: {{ $menu->nama_menu }}</h1>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <form method="POST" action="{{ route('admin.menus.update', $menu->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Method spoofing untuk request UPDATE --}}

            <!-- Nama Menu -->
            <div class="mb-4">
                <label for="nama_menu" class="block text-sm font-medium text-gray-700">Nama Menu</label>
                <input type="text" name="nama_menu" id="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('nama_menu')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
            </div>

            <!-- Harga -->
            <div class="mb-4">
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" name="harga" id="harga" value="{{ old('harga', $menu->harga) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('harga')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori" id="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="Makanan" @selected(old('kategori', $menu->kategori) == 'Makanan')>Makanan</option>
                    <option value="Minuman" @selected(old('kategori', $menu->kategori) == 'Minuman')>Minuman</option>
                    <option value="Snack" @selected(old('kategori', $menu->kategori) == 'Snack')>Snack</option>
                </select>
                @error('kategori')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Gambar -->
            <div class="mb-4">
                <label for="gambar" class="block text-sm font-medium text-gray-700">Ganti Gambar Menu (Opsional)</label>
                <input type="file" name="gambar" id="gambar"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @error('gambar')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
                
                @if ($menu->gambar)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="mt-2 h-24 w-24 rounded-md object-cover">
                    </div>
                @endif
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.menus.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50">Batal</a>
                <button type="submit" class="ml-3 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-500">
                    Update Menu
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
