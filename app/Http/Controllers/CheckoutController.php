<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Menyimpan keranjang belanja sebagai pesanan baru di database.
     */
    public function store(Request $request)
    {
        // 1. Ambil keranjang dari sesi
        $cart = $request->session()->get('cart', []);

        // 2. Jika keranjang kosong, kembalikan ke halaman menu
        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang Anda kosong!');
        }

        // 3. Gunakan database transaction untuk keamanan
        // Jika ada error di tengah jalan, semua proses akan dibatalkan
        DB::beginTransaction();

        try {
            // 4. Hitung total harga dari item di keranjang
            $totalHarga = 0;
            foreach ($cart as $details) {
                $totalHarga += $details['harga'] * $details['jumlah'];
            }

            // 5. Buat pesanan baru di tabel 'orders'
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_harga' => $totalHarga,
                'status' => 'pending', // Status awal pesanan
            ]);

            // 6. Simpan setiap item di keranjang ke tabel 'order_items'
            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $id,
                    'jumlah' => $details['jumlah'],
                    'harga' => $details['harga'],
                ]);
            }

            // 7. Jika semua berhasil, konfirmasi transaksi
            DB::commit();

            // 8. Hapus keranjang dari sesi
            $request->session()->forget('cart');

            // 9. Redirect ke halaman menu dengan pesan sukses
            return redirect()->route('menu.index')->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            // 10. Jika terjadi error, batalkan semua transaksi
            DB::rollBack();
            
            // Redirect kembali dengan pesan error
            return redirect()->route('cart.show')->with('error', 'Terjadi kesalahan saat memproses pesanan Anda.');
        }
    }
}
