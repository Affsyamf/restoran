<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // Baris debugging dd() sudah dihapus dari sini

        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang Anda kosong!'], 400);
        }

        DB::beginTransaction();

        try {
            // Hitung total harga
            $totalHarga = 0;
            foreach ($cart as $details) {
                $totalHarga += $details['harga'] * $details['jumlah'];
            }

            // Buat pesanan baru dengan status 'pending'
            $order = Order::create([
                'user_id' => $request->user()->id,
                'total_harga' => $totalHarga,
                'status' => 'pending',
            ]);

            // Siapkan detail item untuk Midtrans
            $item_details = [];
            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $id,
                    'jumlah' => $details['jumlah'],
                    'harga' => $details['harga'],
                ]);

                $item_details[] = [
                    'id' => $id,
                    'price' => $details['harga'],
                    'quantity' => $details['jumlah'],
                    'name' => $details['nama_menu'],
                ];
            }

            // Konfigurasi Midtrans sekarang membaca dari file config, yang mengambil dari .env
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            // Siapkan parameter untuk Midtrans Snap
            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $order->total_harga,
                ],
                'customer_details' => [
                    'first_name' => $request->user()->name,
                    'email' => $request->user()->email,
                ],
                'item_details' => $item_details,
            ];

            // Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            DB::commit();

            // Hapus keranjang dari sesi
            $request->session()->forget('cart');

            // Kirim Snap Token kembali sebagai JSON
            return response()->json(['snap_token' => $snapToken]);

        } catch (\Exception $e) {
            DB::rollBack();
            // Kirim pesan error yang lebih spesifik untuk debugging
            return response()->json(['error' => 'Midtrans Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan halaman sukses setelah checkout.
     */
    public function success()
    {
        return view('checkout.success');
    }
}
