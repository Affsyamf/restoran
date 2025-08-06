<x-layouts.guest>
    {{-- Inisialisasi data untuk "otak" global --}}
    <div x-init="
        cart = {{ json_encode(array_values($cart)) }};
        promoCode = '{{ session('promo_code.code', '') }}';
        appliedPromo = {{ json_encode(session('promo_code')) }};
    ">
        <div class="bg-white">
            <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Keranjang Belanja</h1>

                @if (session('success'))
                    <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="mt-12">
                    @if (!empty($cart))
                        <section aria-labelledby="cart-heading">
                            <ul role="list" class="divide-y divide-gray-200 border-b border-t border-gray-200">
                                @forelse ($cart as $id => $details)
                                    <li class="flex py-6">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $details['gambar'] ? asset('storage/' . $details['gambar']) : 'https://placehold.co/128x128/CCCCCC/FFFFFF?text=Menu' }}" alt="{{ $details['nama_menu'] }}" class="h-24 w-24 rounded-md object-cover object-center sm:h-32 sm:w-32">
                                        </div>
                                        <div class="ml-4 flex flex-1 flex-col sm:ml-6">
                                            <div>
                                                <div class="flex justify-between">
                                                    <h4 class="text-sm">
                                                        <span class="font-medium text-gray-700">{{ $details['nama_menu'] }}</span>
                                                    </h4>
                                                    <p class="ml-4 text-sm font-medium text-gray-900">Rp {{ number_format($details['harga'] * $details['jumlah'], 0, ',', '.') }}</p>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-500">Jumlah: {{ $details['jumlah'] }}</p>
                                            </div>
                                            <div class="mt-4 flex flex-1 items-end justify-between">
                                                <form action="{{ route('cart.destroy', $id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <div class="text-center py-12">
                                        <p class="text-gray-500">Keranjang belanja Anda masih kosong.</p>
                                        <a href="{{ route('menu.index') }}" class="mt-4 inline-block rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow hover:bg-teal-700">
                                            Mulai Belanja
                                        </a>
                                    </div>
                                @endforelse
                            </ul>
                        </section>

                        <section aria-labelledby="summary-heading" class="mt-10">
                            <div class="rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:p-8">
                                <h2 class="text-lg font-medium text-gray-900">Ringkasan Pesanan</h2>
                                <div class="mt-6">
                                    <label for="promo-code" class="block text-sm font-medium text-gray-700">Kode Promo</label>
                                    <div class="mt-1 flex space-x-4">
                                        <input type="text" x-model="promoCode" id="promo-code" class="block w-full rounded-md border-gray-300 shadow-sm" placeholder="Masukkan kode promo">
                                        <button @click="applyPromoCode()" :disabled="isLoading" class="rounded-md bg-gray-200 px-4 text-sm font-medium text-gray-600 hover:bg-gray-300">
                                            Gunakan
                                        </button>
                                    </div>
                                    <p x-show="promoMessage" x-text="promoMessage" class="mt-2 text-sm text-green-600"></p>
                                    <p x-show="promoError" x-text="promoError" class="mt-2 text-sm text-red-600"></p>
                                </div>
                                <dl class="mt-6 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <dt class="text-sm text-gray-600">Subtotal</dt>
                                        <dd class="text-sm font-medium text-gray-900" x-text="`Rp ${new Intl.NumberFormat('id-ID').format(total)}`"></dd>
                                    </div>
                                    <div x-show="appliedPromo" class="flex items-center justify-between border-t border-gray-200 pt-4">
                                        <dt class="flex items-center text-sm text-gray-600">
                                            <span>Diskon</span>
                                            <span x-text="`(${appliedPromo?.code})`" class="ml-2 rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800"></span>
                                        </dt>
                                        <dd class="text-sm font-medium text-green-600" x-text="`- Rp ${new Intl.NumberFormat('id-ID').format(discountAmount)}`"></dd>
                                    </div>
                                    <div class="flex items-center justify-between border-t border-gray-200 pt-4 text-base font-medium text-gray-900">
                                        <dt>Total Pesanan</dt>
                                        <dd x-text="`Rp ${new Intl.NumberFormat('id-ID').format(newTotal)}`"></dd>
                                    </div>
                                </dl>
                                <div class="mt-6">
                                    <button @click="handleCheckout()" :disabled="isLoading" class="w-full rounded-md border border-transparent bg-teal-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-teal-700">
                                        <span x-show="!isLoading">Lanjutkan ke Pembayaran</span>
                                        <span x-show="isLoading">Memproses...</span>
                                    </button>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
