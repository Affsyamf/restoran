<x-layouts.admin>
    <h1 class="text-2xl font-bold mb-6">Edit Pengguna: {{ $user->name }}</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT') {{-- Method spoofing untuk request UPDATE --}}

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
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="user" @selected(old('role', $user->role) == 'user')>User</option>
                    <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                </select>
                @error('role')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50">Batal</a>
                <button type="submit" class="ml-3 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-500">
                    Update Role
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
