    <?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Menu;
    use Illuminate\Http\Request;

    class CartController extends Controller
    {
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

            // Kembalikan jumlah item di keranjang dalam format JSON
            return response()->json([
                'cartCount' => count($cart),
                'message' => 'Menu berhasil ditambahkan!'
            ]);
        }
    }
    