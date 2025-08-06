<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data statistik untuk user
        $totalOrders = $user->orders()->count();
        
        // Ambil 3 pesanan terbaru
        $recentOrders = $user->orders()->latest()->take(3)->get();

        return view('dashboard', [
            'totalOrders' => $totalOrders,
            'recentOrders' => $recentOrders,
        ]);
    }
}