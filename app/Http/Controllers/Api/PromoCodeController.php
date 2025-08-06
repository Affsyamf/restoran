<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function apply(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);

        $promoCode = PromoCode::where('code', $validated['code'])->first();

        // Cek 1: Apakah kode ada?
        if (!$promoCode) {
            return response()->json(['message' => 'Kode promo tidak valid.'], 404);
        }

        // Cek 2: Apakah kode sudah kadaluarsa?
        if ($promoCode->expires_at && $promoCode->expires_at < Carbon::now()) {
            return response()->json(['message' => 'Kode promo sudah kadaluarsa.'], 422);
        }

        // Cek 3: Apakah batas penggunaan sudah tercapai?
        if (isset($promoCode->max_uses) && $promoCode->uses >= $promoCode->max_uses) {
            return response()->json(['message' => 'Kode promo sudah mencapai batas penggunaan.'], 422);
        }

        // Jika semua validasi lolos, simpan kode promo di session
        $request->session()->put('promo_code', [
            'code' => $promoCode->code,
            'type' => $promoCode->type,
            'value' => $promoCode->value,
        ]);

        return response()->json([
            'message' => 'Kode promo berhasil digunakan!',
            'promo_code' => session('promo_code'),
        ]);
    }

    /**
     * Menghapus kode promo dari sesi.
     */
    public function remove(Request $request)
    {
        $request->session()->forget('promo_code');

        return response()->json(['message' => 'Kode promo berhasil dihapus.']);
    }
}
