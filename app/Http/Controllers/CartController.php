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
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['jumlah']++;
        } else {
            $cart[$menu->id] = [
                "nama_menu" => $menu->nama_menu,
                "jumlah" => 1,
                "harga" => $menu->harga,
                "gambar" => $menu->gambar
            ];
        }

        $request->session()->put('cart', $cart);

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function show(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        return view('cart.index', ['cart' => $cart]);
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function destroy(Request $request, Menu $menu)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$menu->id])) {
            unset($cart[$menu->id]);
        }

        $request->session()->put('cart', $cart);

        return redirect()->route('cart.show')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
