<x-layouts.admin>
    <h1 class="text-2xl font-bold mb-6">Pengaturan Situs</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white p-8 rounded-lg shadow-md">
        <form method="POST" action="{{ route('admin.settings.store') }}">
            @csrf
            <div class="space-y-6">
                {{-- Bagian Hero --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Halaman Utama (Hero)</h3>
                    <div class="mb-4">
                        <label for="hero_title" class="block text-sm font-medium text-gray-700">Judul Utama</label>
                        <input type="text" name="hero_title" id="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="hero_subtitle" class="block text-sm font-medium text-gray-700">Sub-judul</label>
                        <textarea name="hero_subtitle" id="hero_subtitle" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Bagian Tentang Kami --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Tentang Kami</h3>
                    <div class="mb-4">
                        <label for="about_title" class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="about_title" id="about_title" value="{{ old('about_title', $settings['about_title'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="about_text" class="block text-sm font-medium text-gray-700">Teks</label>
                        <textarea name="about_text" id="about_text" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('about_text', $settings['about_text'] ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Bagian Kontak --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Kontak</h3>
                    <div class="mb-4">
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
