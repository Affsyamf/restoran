<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Menampilkan halaman daftar menu dengan fitur pencarian dan filter.
     */
    public function index(Request $request)
    {
        // Ambil semua kategori unik untuk tombol filter
        $categories = Menu::select('kategori')->distinct()->pluck('kategori');

        // Mulai query builder, dan hitung total penjualan untuk setiap menu
        $query = Menu::withCount(['orderItems as total_sold' => function ($query) {
            $query->select(DB::raw('sum(jumlah)'));
        }])
         ->withAvg('reviews', 'rating');

        // Terapkan filter pencarian jika ada
        $query->when($request->search, function ($q, $search) {
            return $q->where('nama_menu', 'like', "%{$search}%");
        });

        // Terapkan filter kategori jika ada
        $query->when($request->category, function ($q, $category) {
            return $q->where('kategori', $category);
        });

        // Terapkan filter harga minimum jika ada
        $query->when($request->min_price, function ($q, $min_price) {
            return $q->where('harga', '>=', $min_price);
        });

        // Terapkan filter harga maksimum jika ada
        $query->when($request->max_price, function ($q, $max_price) {
            return $q->where('harga', '<=', $max_price);
        });

        // Terapkan penyortiran (diperbarui)
        $sort = $request->input('sort');
        switch ($sort) {
            case 'latest':
                $query->latest();
                break;
            case 'bestseller':
                $query->orderBy('total_sold', 'desc');
                break;
            default:
                // Tidak ada urutan spesifik, ini adalah opsi "standar"
                break;
        }

        // Ambil hasil akhir dengan paginasi
        $menus = $query->paginate(12)->withQueryString();

        return view('menu.index', [
            'menus' => $menus,
            'categories' => $categories,
        ]);
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
