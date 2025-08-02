<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Menampilkan halaman daftar menu untuk pelanggan.
     */
    public function index()
    {
        $menus = Menu::latest()->paginate(12);
        return view('menu.index', ['menus' => $menus]);
    }

    /**
     * Menambahkan item menu ke dalam keranjang (session).
     */
    public function store(Request $request, Menu $menu)
    {
        // 1. Ambil keranjang yang ada dari session, atau buat array kosong jika belum ada
        $cart = $request->session()->get('cart', []);

        // 2. Cek apakah menu sudah ada di keranjang
        if (isset($cart[$menu->id])) {
            // Jika sudah ada, tambahkan jumlahnya
            $cart[$menu->id]['jumlah']++;
        } else {
            // Jika belum ada, tambahkan sebagai item baru
            $cart[$menu->id] = [
                "nama_menu" => $menu->nama_menu,
                "jumlah" => 1,
                "harga" => $menu->harga,
                "gambar" => $menu->gambar
            ];
        }

        // 3. Simpan kembali keranjang yang sudah diperbarui ke dalam session
        $request->session()->put('cart', $cart);

        // 4. Redirect kembali ke halaman menu dengan pesan sukses
        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }
}
