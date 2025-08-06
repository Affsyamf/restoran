    <x-layouts.guest>
        <div class="text-center py-24">
            <h1 class="text-4xl font-bold text-green-600">Pembayaran Berhasil!</h1>
            <p class="mt-4 text-lg text-gray-600">Terima kasih telah memesan di Restoran Enak.</p>
            <p class="mt-2 text-gray-500">Pesanan Anda sedang kami proses.</p>
            <div class="mt-8">
                <a href="{{ route('my-orders.index') }}" class="inline-block rounded-md bg-teal-600 px-6 py-3 text-sm font-medium text-white shadow hover:bg-teal-700">
                    Lihat Riwayat Pesanan
                </a>
            </div>
        </div>
    </x-layouts.guest>
    