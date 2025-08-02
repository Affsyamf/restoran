<?php

use App\Http\Controllers\MenuController; 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    $featuredMenus = Menu::latest()->take(4)->get();
    return view('welcome', [
        'featuredMenus' => $featuredMenus
    ]);
});

// Ini adalah dashboard untuk user biasa (bawaan Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
require __DIR__.'/auth.php';
