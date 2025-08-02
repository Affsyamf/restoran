<x-layouts.admin>
    {{-- Pembungkus utama dengan state Alpine.js untuk modal --}}
    <div x-data="{ showModal: false, action: '' }">
        <h1 class="text-2xl font-bold mb-6">Edit Pengguna: {{ $user->name }}</h1>

        {{-- Grid Layout Dua Kolom --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Kolom Kiri: Form Edit --}}
            <div class="lg:col-span-2">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nama (Read-only) -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" id="name" value="{{ $user->name }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm" disabled>
                        </div>

                        <!-- Email (Read-only) -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" value="{{ $user->email }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm" disabled>
                        </div>

                        <!-- Role (Dropdown untuk diubah) -->
                        <div class="mb-6">
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="user" @selected(old('role', $user->role) == 'user')>User</option>
                                <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-8 flex justify-end">
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Batal</a>
                            <button type="submit" class="ml-3 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-green-500">
                                Update Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Kolom Kanan: Panel Informasi --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">Informasi Peran (Role)</h3>
                    <div class="space-y-4 text-sm text-gray-600">
                        <div>
                            <p class="font-bold text-gray-900">Admin</p>
                            <p>Memiliki akses penuh ke semua fitur manajemen, termasuk mengelola menu dan pengguna lain.</p>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">User</p>
                            <p>Peran standar untuk pengguna yang mendaftar. Hanya memiliki akses ke fitur-fitur publik dan dashboard pribadi mereka.</p>
                        </div>
                        <div class="mt-4 p-3 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800">
                            <p class="font-bold">Perhatian!</p>
                            <p>Mengubah peran pengguna akan secara langsung mengubah hak akses mereka di seluruh aplikasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN BARU: Zona Berbahaya --}}
        <div class="mt-8">
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
                <h3 class="text-lg font-semibold text-red-700">Zona Berbahaya</h3>
                <div class="mt-4 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Hapus pengguna ini secara permanen.</p>
                        <p class="text-xs text-gray-500 mt-1">Setelah akun dihapus, semua data terkait akan hilang selamanya. Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        {{-- Tombol Hapus hanya aktif jika bukan user yang sedang login --}}
                        @if(auth()->id() !== $user->id)
                            <button 
                                @click="showModal = true; action = '{{ route('admin.users.destroy', $user->id) }}'"
                                type="button" 
                                class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                            >
                                Hapus Pengguna
                            </button>
                        @else
                            <button 
                                type="button" 
                                class="inline-flex items-center justify-center rounded-md border border-transparent bg-gray-300 px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed"
                                disabled
                            >
                                Hapus Pengguna
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Komponen Modal untuk konfirmasi hapus --}}
        <x-modal-confirm 
            title="Hapus Pengguna" 
            :message="'Apakah Anda yakin ingin menghapus pengguna \''. e($user->name) .'\'? Tindakan ini tidak dapat dibatalkan.'"
            button_text="Ya, Hapus"
        />
    </div>
</x-layouts.admin>
