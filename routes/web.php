<?php

use App\Http\Controllers\MenuController; 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Menu;

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
    // Nama lengkap route ini sekarang adalah 'admin.dashboard'
});

require __DIR__.'/auth.php';
