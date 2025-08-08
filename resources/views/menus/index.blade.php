<x-layouts.admin>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Menu</h1>
        <a href="{{ route('admin.menus.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500">
            + Tambah Menu Baru
        </a>
    </div>

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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
               @forelse ($menus as $menu)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ $menu->gambar ? asset('storage/' . $menu->gambar) : 'https://placehold.co/128x128/CCCCCC/FFFFFF?text=Menu' }}" alt="{{ $menu->nama_menu }}" class="h-12 w-12 rounded-md object-cover">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $menu->nama_menu }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $menu->kategori }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div x-data="{ on: {{ $menu->is_available ? 'true' : 'false' }} }" 
                                 @click="
                                     fetch('{{ route('admin.menus.toggleAvailability', $menu) }}', {
                                         method: 'PATCH',
                                         headers: {
                                             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                             'Accept': 'application/json'
                                         }
                                     })
                                     .then(response => response.json())
                                     .then(data => {
                                         if (data.success) {
                                             on = data.is_available;
                                         }
                                     })
                                 "
                                 class="relative inline-flex items-center h-6 rounded-full w-11 cursor-pointer transition-colors duration-200 ease-in-out"
                                 :class="on ? 'bg-teal-600' : 'bg-gray-200'">
                                <span class="sr-only">Ubah Ketersediaan</span>
                                <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                                      class="inline-block w-4 h-4 transform bg-white rounded-full transition-transform duration-200 ease-in-out"></span>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('admin.menus.edit', $menu->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
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
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data menu.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $menus->links() }}
    </div>
</x-layouts.admin>
