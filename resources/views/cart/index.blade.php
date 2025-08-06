<x-layouts.guest>
    {{-- Tambahkan x-data di sini untuk menangani checkout --}}
    <div x-data="{
        isLoading: false,
        handleCheckout() {
            this.isLoading = true;
            fetch('{{ route('checkout.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result){
                            window.location.href = '{{ route('checkout.success') }}';
                        },
                        onPending: function(result){
                            alert('Pembayaran Anda sedang diproses.');
                            window.location.href = '{{ route('my-orders.index') }}';
                        },
                        onError: function(result){
                            alert('Pembayaran gagal!');
                            this.isLoading = false;
                        },
                        onClose: function(){
                            // Pengguna menutup pop-up sebelum menyelesaikan pembayaran
                            this.isLoading = false;
                        }
                    });
                } else {
                    alert(data.error || 'Terjadi kesalahan saat memproses checkout.');
                    this.isLoading = false;
                }
            })
            .catch(error => {
                console.error('Checkout Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                this.isLoading = false;
            });
        }
    }">
        <div class="bg-white">
            <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Keranjang Belanja</h1>

                {{-- Notifikasi --}}
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
                            <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                            <ul role="list" class="divide-y divide-gray-200 border-b border-t border-gray-200">
                                @php $total = 0; @endphp
                                @foreach ($cart as $id => $details)
                                    @php $total += $details['harga'] * $details['jumlah']; @endphp
                                    <li class="flex py-6">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $details['gambar'] ? asset('storage/' . $details['gambar']) : 'https://placehold.co/128x128/CCCCCC/FFFFFF?text=Menu' }}" alt="{{ $details['nama_menu'] }}" class="h-24 w-24 rounded-md object-cover object-center sm:h-32 sm:w-32">
                                        </div>

                                        <div class="ml-4 flex flex-1 flex-col sm:ml-6">
                                            <div>
                                                <div class="flex justify-between">
                                                    <h4 class="text-sm">
                                                        <span class="font-medium text-gray-700 hover:text-gray-800">{{ $details['nama_menu'] }}</span>
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
                                @endforeach
                            </ul>
                        </section>

                        <!-- Order summary -->
                        <section aria-labelledby="summary-heading" class="mt-10">
                            <div class="rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:p-8">
                                <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Ringkasan Pesanan</h2>

                                <dl class="mt-6 space-y-4">
                                    <div class="flex items-center justify-between border-t border-gray-200 pt-4 text-base font-medium text-gray-900">
                                        <dt>Total Pesanan</dt>
                                        <dd>Rp {{ number_format($total, 0, ',', '.') }}</dd>
                                    </div>
                                </dl>

                                <div class="mt-6">
                                    <button 
                                        @click="handleCheckout()"
                                        :disabled="isLoading"
                                        class="w-full rounded-md border border-transparent bg-teal-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-gray-50 disabled:opacity-50"
                                    >
                                        <span x-show="!isLoading">Lanjutkan ke Pembayaran</span>
                                        <span x-show="isLoading">Memproses...</span>
                                    </button>
                                </div>
                            </div>
                        </section>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">Keranjang belanja Anda masih kosong.</p>
                            <a href="{{ route('menu.index') }}" class="mt-4 inline-block rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow hover:bg-teal-700">
                                Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
