<x-layouts.admin>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Menu</h1>
        <a href="{{ route('admin.menus.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500">
            + Tambah Menu Baru
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Menu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
               @forelse ($menus as $menu)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">
                @if ($menu->gambar)
                    <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="h-12 w-12 rounded-md object-cover">
                @else
                    <div class="h-12 w-12 rounded-md bg-gray-200 flex items-center justify-center text-xs text-gray-500">No Image</div>
                @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $menu->nama_menu }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $menu->kategori }}</td>
            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
            
            {{-- INI BAGIAN YANG PALING PENTING UNTUK DIPERBARUI --}}
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex justify-end items-center gap-2">
                    
                    {{-- Tombol Edit mengarah ke route edit --}}
                    <a href="{{ route('admin.menus.edit', $menu->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    
                    {{-- Tombol Hapus sekarang ada di dalam form --}}
                    <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                    </form>

                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data menu. Silakan tambahkan menu baru.</td>
        </tr>
    @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Pagination Links --}}
    <div class="mt-6">
        {{ $menus->links() }}
    </div>
</x-layouts.admin>
