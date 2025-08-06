<x-layouts.admin>
    <h1 class="text-2xl font-bold mb-6">Edit Kode Promo: {{ $promoCode->code }}</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl">
        <form method="POST" action="{{ route('admin.promo-codes.update', $promoCode->id) }}">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                {{-- Kode Promo --}}
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Kode Unik</label>
                    <input type="text" name="code" id="code" value="{{ old('code', $promoCode->code) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('code')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipe Diskon --}}
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipe Diskon</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="percent" @selected(old('type', $promoCode->type) == 'percent')>Persentase (%)</option>
                        <option value="fixed" @selected(old('type', $promoCode->type) == 'fixed')>Potongan Tetap (Rp)</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nilai Diskon --}}
                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700">Nilai Diskon</label>
                    <input type="number" name="value" id="value" value="{{ old('value', $promoCode->value) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('value')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Batas Penggunaan --}}
                <div>
                    <label for="max_uses" class="block text-sm font-medium text-gray-700">Batas Maksimal Penggunaan (Opsional)</label>
                    <input type="number" name="max_uses" id="max_uses" value="{{ old('max_uses', $promoCode->max_uses) }}" placeholder="Biarkan kosong untuk tanpa batas"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('max_uses')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Kadaluarsa --}}
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700">Tanggal Kadaluarsa (Opsional)</label>
                    <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at', $promoCode->expires_at ? $promoCode->expires_at->format('Y-m-d') : '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('expires_at')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.promo-codes.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50">Batal</a>
                <button type="submit" class="ml-3 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-500">
                    Update Kode Promo
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
