<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Ambil ID user yang sedang login dari request
        $userId = $request->user()->id;

        // 2. Cek apakah user sudah pernah mereview menu ini
        $existingReview = Review::where('user_id', $userId) // <-- Diperbaiki
                                ->where('menu_id', $validated['menu_id'])
                                ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah pernah memberikan ulasan untuk menu ini.');
        }

        // 3. Tambahkan user_id ke data yang divalidasi
        $validated['user_id'] = $userId; // <-- Diperbaiki

        // 4. Buat ulasan baru
        Review::create($validated);

        // 5. Redirect kembali dengan pesan sukses
        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
