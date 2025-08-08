<?php

use App\Http\Controllers\MenuController; 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Api\MenuController as ApiMenuController;
use App\Http\Controllers\CartController as ApiCartController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Api\PromoCodeController as ApiPromoCodeController;

Route::get('/', function () {
    $featuredMenus = Menu::latest()->take(4)->get();
    return view('welcome', [
        'featuredMenus' => $featuredMenus
    ]);
});

// Ini adalah dashboard untuk user biasa (bawaan Breeze)
 Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])->name('dashboard');

// Route ini untuk SEMUA user yang sudah login (admin & biasa)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route ini HANYA untuk ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('menus', MenuController::class);
    Route::resource('users', UserController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('reviews', AdminReviewController::class)->only(['index', 'destroy']);
    Route::resource('promo-codes', PromoCodeController::class);
    // TAMBAHKAN DUA ROUTE INI
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    // Nama lengkap route ini sekarang adalah 'admin.dashboard'
});

//route user
Route::get('/menu', [CartController::class, 'index'])->name('menu.index');

// Route untuk menambahkan item ke keranjang (hanya untuk user yang sudah login)
Route::post('/cart/add/{menu}', [CartController::class, 'store'])->middleware('auth')->name('cart.store');
// Route untuk menampilkan halaman menu kepada semua pengunjung
Route::get('/menu', [CartController::class, 'index'])->name('menu.index');

// ROUTE BARU: Untuk menampilkan detail satu menu
Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');

// Route untuk menambahkan item ke keranjang (hanya untuk user yang sudah login)
Route::post('/cart/add/{menu}', [CartController::class, 'store'])->middleware('auth')->name('cart.store');

// Route untuk menambahkan item ke keranjang
Route::post('/cart/add/{menu}', [CartController::class, 'store'])->middleware('auth')->name('cart.store');

// ROUTE BARU: Menampilkan halaman keranjang belanja
Route::get('/cart', [CartController::class, 'show'])->middleware('auth')->name('cart.show');

// ROUTE BARU: Menghapus item dari keranjang
Route::delete('/cart/remove/{menu}', [CartController::class, 'destroy'])->middleware('auth')->name('cart.destroy');
// ROUTE BARU: Memproses checkout dan menyimpan pesanan
Route::post('/checkout', [CheckoutController::class, 'store'])->middleware('auth')->name('checkout.store');
// ROUTE BARU: Menampilkan riwayat pesanan untuk user yang login
Route::get('/my-orders', [UserOrderController::class, 'index'])->middleware('auth')->name('my-orders.index');

// ROUTE BARU: Menyimpan ulasan baru dari pengguna
Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');

Route::get('/api/menus', [ApiMenuController::class, 'index'])->name('api.menus.index');

// ROUTE BARU UNTUK API MENAMBAH ITEM KE KERANJANG
Route::post('/api/cart/add/{menu}', [ApiCartController::class, 'store'])->middleware('auth')->name('api.cart.store');

Route::post('/api/promo-codes/apply', [ApiPromoCodeController::class, 'apply'])->middleware('auth')->name('api.promo-codes.apply');
Route::post('/api/promo-codes/remove', [ApiPromoCodeController::class, 'remove'])->middleware('auth')->name('api.promo-codes.remove');

Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// route sudebar CMS
 // ROUTE BARU UNTUK PENGATURAN SITUS
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');

// ROUTE BARU UNTUK MENANGANI NOTIFIKASI DARI MIDTRANS
Route::post('/api/midtrans-webhook', [WebhookController::class, 'handle'])->name('midtrans.webhook');

Route::patch('/menus/{menu}/toggle-availability', [MenuController::class, 'toggleAvailability'])->name('admin.menus.toggleAvailability');
require __DIR__.'/auth.php';
