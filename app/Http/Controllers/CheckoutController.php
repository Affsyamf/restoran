<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PromoCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $promoCodeData = $request->session()->get('promo_code');

        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang Anda kosong!'], 400);
        }

        DB::beginTransaction();

        try {
            $totalHargaAsli = 0;
            foreach ($cart as $details) {
                $totalHargaAsli += $details['harga'] * $details['jumlah'];
            }

            $totalHargaFinal = $totalHargaAsli;
            $promoCode = null;

            if ($promoCodeData) {
                $promoCode = PromoCode::where('code', $promoCodeData['code'])->first();

                if ($promoCode && (!$promoCode->expires_at || $promoCode->expires_at > Carbon::now()) && (!isset($promoCode->max_uses) || $promoCode->uses < $promoCode->max_uses)) {
                    $diskon = 0;
                    if ($promoCode->type === 'percent') {
                        $diskon = ($totalHargaAsli * $promoCode->value) / 100;
                    } else {
                        $diskon = $promoCode->value;
                    }
                    $totalHargaFinal = max(0, $totalHargaAsli - $diskon);
                } else {
                    $request->session()->forget('promo_code');
                }
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'total_harga' => $totalHargaFinal,
                'status' => 'pending',
            ]);

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
                    'price' => (int) $details['harga'], // Pastikan harga item juga integer
                    'quantity' => $details['jumlah'],
                    'name' => $details['nama_menu'],
                ];
            }
            
            if ($promoCode && $totalHargaFinal < $totalHargaAsli) {
                $item_details[] = [
                    'id' => 'DISCOUNT_' . $promoCode->code,
                    'price' => -(int)($totalHargaAsli - $totalHargaFinal), // Pastikan diskon juga integer
                    'quantity' => 1,
                    'name' => 'Discount (' . $promoCode->code . ')',
                ];
            }

            if ($promoCode) {
                $promoCode->increment('uses');
            }

            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    // PERBAIKAN UTAMA: Konversi total harga menjadi integer
                    'gross_amount' => (int) round($totalHargaFinal),
                ],
                'customer_details' => [
                    'first_name' => $request->user()->name,
                    'email' => $request->user()->email,
                ],
                'item_details' => $item_details,
            ];

            $snapToken = Snap::getSnapToken($params);

            DB::commit();

            $request->session()->forget('cart');
            $request->session()->forget('promo_code');

            return response()->json(['snap_token' => $snapToken]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Midtrans Error: ' . $e->getMessage()], 500);
        }
    }

    public function success()
    {
        return view('checkout.success');
    }
}
