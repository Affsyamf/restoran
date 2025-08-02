<x-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Menu</h1>
        <a href="{{ route('admin.menus.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500">
            + Tambah Menu Baru
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Menu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($menus as $menu)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $menu->nama_menu }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $menu->kategori }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <a href="#" class="text-red-600 hover:text-red-900 ml-4">Hapus</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data menu.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
