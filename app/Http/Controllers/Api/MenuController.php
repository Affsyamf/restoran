<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::query()
            ->withCount(['orderItems as total_sold' => function ($query) {
                $query->select(DB::raw('sum(jumlah)'));
            }])
            ->withAvg('reviews', 'rating')
             ->withCount('reviews');

        // Terapkan semua filter seperti sebelumnya
        $query->when($request->search, function ($q, $search) {
            return $q->where('nama_menu', 'like', "%{$search}%");
        });

        $query->when($request->category, function ($q, $category) {
            return $q->where('kategori', $category);
        });

        $query->when($request->min_price, function ($q, $min_price) {
            return $q->where('harga', '>=', $min_price);
        });

        $query->when($request->max_price, function ($q, $max_price) {
            return $q->where('harga', '<=', $max_price);
        });

        $sort = $request->input('sort');
        switch ($sort) {
            case 'latest':
                $query->latest();
                break;
            case 'bestseller':
                $query->orderBy('total_sold', 'desc');
                break;
        }

        $menus = $query->paginate(12)->withQueryString();

        // Kembalikan data dalam format JSON
        return response()->json($menus);
    }
}
