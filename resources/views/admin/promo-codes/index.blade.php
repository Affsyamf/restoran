<x-layouts.admin>
    <div x-data="{ showModal: false, action: '' }">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Manajemen Kode Promo</h1>
            <a href="{{ route('admin.promo-codes.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500">
                + Buat Kode Promo Baru
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penggunaan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kadaluarsa</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($promoCodes as $promoCode)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-sm text-gray-800">{{ $promoCode->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($promoCode->type) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($promoCode->type == 'percent')
                                    {{ $promoCode->value }}%
                                @else
                                    Rp {{ number_format($promoCode->value, 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $promoCode->uses }} / {{ $promoCode->max_uses ?? '∞' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $promoCode->expires_at ? $promoCode->expires_at->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('admin.promo-codes.edit', $promoCode->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <button 
                                        @click="showModal = true; action = '{{ route('admin.promo-codes.destroy', $promoCode->id) }}'"
                                        type="button" 
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada kode promo yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $promoCodes->links() }}
        </div>

        <x-modal-confirm 
            title="Hapus Kode Promo" 
            message="Apakah Anda yakin ingin menghapus kode promo ini secara permanen?"
            button_text="Ya, Hapus"
        />
    </div>
</x-layouts.admin>
