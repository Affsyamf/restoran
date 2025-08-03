<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    /**
     * Menampilkan riwayat pesanan milik pengguna yang sedang login.
     */
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil semua pesanan milik user tersebut, urutkan dari yang terbaru
        // Gunakan 'with' untuk mengambil item dan menu terkait secara efisien
        $orders = $user->orders()->with('items.menu')->latest()->paginate(10);

        return view('my-orders.index', ['orders' => $orders]);
    }
}
