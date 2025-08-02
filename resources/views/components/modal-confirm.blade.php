@props([
    'title' => 'Konfirmasi Tindakan',
    'message' => 'Apakah Anda yakin ingin melanjutkan tindakan ini?',
    'action' => '#',
    'method' => 'DELETE', // Default method is DELETE for safety
    'button_text' => 'Ya, Lanjutkan',
    'button_color' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500'
])

{{-- Latar Belakang Overlay --}}
<div 
    x-show="showModal" 
    x-on:keydown.escape.window="showModal = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75"
    style="display: none;"
    x-cloak
>
    {{-- Kontainer Modal dengan Transisi --}}
    <div 
        x-show="showModal" 
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        @click.away="showModal = false"
        class="w-full max-w-md mx-4 bg-white rounded-lg shadow-xl overflow-hidden"
    >
        {{-- Area Konten Modal --}}
        <div class="p-6">
            <div class="sm:flex sm:items-start">
                {{-- Ikon Peringatan --}}
                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                
                {{-- Judul dan Pesan --}}
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">
                        {{ $title }}
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            {{ $message }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Area Tombol Aksi (dengan latar belakang berbeda) --}}
        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <form :action="action" method="POST" class="w-full sm:w-auto">
                @csrf
                @method($method)
                <button 
                    type="submit"
                    class="inline-flex w-full justify-center rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 {{ $button_color }}"
                >
                    {{ $button_text }}
                </button>
            </form>
            <button 
                @click="showModal = false" 
                type="button" 
                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
            >
                Batal
            </button>
        </div>
    </div>
</div>
