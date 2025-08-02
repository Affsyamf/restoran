<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user dan menu yang ada
        $users = User::all();
        $menus = Menu::all();

        // Pastikan ada user dan menu sebelum membuat pesanan
        if ($users->isEmpty() || $menus->isEmpty()) {
            $this->command->info('Tidak dapat membuat pesanan karena tidak ada user atau menu.');
            return;
        }

        // Buat 25 pesanan palsu
        Order::factory(25)->create()->each(function ($order) use ($menus) {
            // Untuk setiap pesanan, tambahkan 1 sampai 5 item menu acak
            $orderItems = [];
            $totalHarga = 0;

            $randomMenus = $menus->random(rand(1, 5));

            foreach ($randomMenus as $menu) {
                $jumlah = rand(1, 3);
                $harga = $menu->harga;
                $totalHarga += $harga * $jumlah;

                $orderItems[] = [
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Simpan semua item pesanan ke database
            OrderItem::insert($orderItems);

            // Update total harga pada pesanan
            $order->update(['total_harga' => $totalHarga]);
        });
    }
}
