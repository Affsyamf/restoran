<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promoCodes = PromoCode::latest()->paginate(15);
        return view('admin.promo-codes.index', ['promoCodes' => $promoCodes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.promo-codes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:promo_codes,code',
            'type' => ['required', Rule::in(['fixed', 'percent'])],
            'value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        PromoCode::create($validated);

        return redirect()->route('admin.promo-codes.index')->with('success', 'Kode promo baru berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PromoCode $promoCode)
    {
        return view('admin.promo-codes.edit', ['promoCode' => $promoCode]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PromoCode $promoCode)
    {
        $validated = $request->validate([
            // Pastikan kode unik, kecuali untuk dirinya sendiri
            'code' => ['required', 'string', Rule::unique('promo_codes')->ignore($promoCode->id)],
            'type' => ['required', Rule::in(['fixed', 'percent'])],
            'value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $promoCode->update($validated);

        return redirect()->route('admin.promo-codes.index')->with('success', 'Kode promo berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();
        return back()->with('success', 'Kode promo berhasil dihapus.');
    }
}
