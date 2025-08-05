<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran Enak - Cita Rasa Terbaik</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body 
    x-data="{ 
        cartCount: {{ count(session('cart', [])) }},
        showToast: false,
        toastMessage: '',

        showSuccessToast(message) {
            this.toastMessage = message;
            this.showToast = true;
            setTimeout(() => this.showToast = false, 3000); // Sembunyikan setelah 3 detik
        },

        addToCart(menuId, event) {
            const button = event.currentTarget;
            const originalText = button.innerHTML;
            button.innerHTML = 'Menambahkan...';
            button.disabled = true;

            fetch(`/api/cart/add/${menuId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.status === 401) { // Jika tidak terautentikasi
                    window.location.href = '{{ route('login') }}';
                    return Promise.reject('Unauthenticated');
                }
                return response.json();
            })
            .then(data => {
                if (data) {
                    this.cartCount = data.cartCount;
                    this.showSuccessToast(data.message);
                }
            })
            .catch(error => {
                if (error !== 'Unauthenticated') {
                    console.error('Error:', error);
                }
            })
            .finally(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }
    }"
    class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    {{-- NAVIGASI --}}
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex-1 md:flex md:items-center md:gap-12">
                    <a class="block text-teal-600 font-bold text-xl" href="/">
                        RestoranEnak
                    </a>
                </div>
                <div class="md:flex md:items-center md:gap-12">
                    <nav aria-label="Global" class="hidden md:block">
                        <ul class="flex items-center gap-6 text-sm">
                            <li><a class="text-gray-500 transition hover:text-gray-500/75" href="/#about">Tentang Kami</a></li>
                            <li><a class="text-gray-500 transition hover:text-gray-500/75" href="{{ route('menu.index') }}">Menu</a></li>
                            <li><a class="text-gray-500 transition hover:text-gray-500/75" href="/#contact">Kontak</a></li>
                        </ul>
                    </nav>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('cart.show') }}" class="relative">
                            <svg class="h-6 w-6 text-gray-500 hover:text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span x-show="cartCount > 0"
                                  x-text="cartCount"
                                  class="absolute -top-2 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                            </span>
                        </a>
                        <div class="sm:flex sm:gap-4">
                            @auth
                                <a class="rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}">
                                    Dashboard
                                </a>
                            @else
                                <a class="rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow" href="{{ route('login') }}">
                                    Login
                                </a>
                                <div class="hidden sm:flex">
                                    <a class="rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-teal-600" href="{{ route('register') }}">
                                        Register
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="bg-gray-900 text-white">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="flex justify-center text-teal-600 sm:justify-start">
                    <span class="font-bold text-xl">RestoranEnak</span>
                </div>
                <p class="mt-4 text-center text-sm text-gray-500 lg:mt-0 lg:text-right">
                    Copyright &copy; {{ date('Y') }}. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    {{-- KOMPONEN NOTIFIKASI TOAST --}}
    <div 
        x-show="showToast"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-5 right-5 w-full max-w-xs p-4 bg-white border border-gray-200 rounded-lg shadow-lg"
        style="display: none;"
        x-cloak
    >
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900" x-text="toastMessage"></p>
            </div>
        </div>
    </div>

</body>
</html>
