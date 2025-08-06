<x-layouts.admin>
    <h1 class="text-2xl font-bold mb-6">Buat Kode Promo Baru</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl">
        <form method="POST" action="{{ route('admin.promo-codes.store') }}">
            @csrf
            <div class="space-y-6">
                {{-- Kode Promo --}}
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Kode Unik</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" placeholder="Contoh: DISKON10"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('code')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipe Diskon --}}
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipe Diskon</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="percent" @selected(old('type') == 'percent')>Persentase (%)</option>
                        <option value="fixed" @selected(old('type') == 'fixed')>Potongan Tetap (Rp)</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nilai Diskon --}}
                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700">Nilai Diskon</label>
                    <input type="number" name="value" id="value" value="{{ old('value') }}" placeholder="Contoh: 10 (untuk 10%) atau 10000 (untuk Rp 10.000)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('value')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Batas Penggunaan --}}
                <div>
                    <label for="max_uses" class="block text-sm font-medium text-gray-700">Batas Maksimal Penggunaan (Opsional)</label>
                    <input type="number" name="max_uses" id="max_uses" value="{{ old('max_uses') }}" placeholder="Biarkan kosong untuk tanpa batas"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('max_uses')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Kadaluarsa --}}
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700">Tanggal Kadaluarsa (Opsional)</label>
                    <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('expires_at')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.promo-codes.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50">Batal</a>
                <button type="submit" class="ml-3 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-500">
                    Simpan Kode Promo
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
