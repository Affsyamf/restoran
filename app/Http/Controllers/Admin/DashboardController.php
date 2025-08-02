<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $menuCount = Menu::count();
        $orderCount = 0; // Assuming you have an Order model, you can count orders similarly

        $recentUsers = User::latest()->take(5)->get();
        $recentMenus = Menu::latest()->take(5)->get();
        return view('admin.dashboard', [
            'userCount' => $userCount,
            'menuCount' => $menuCount,
            'orderCount' => $orderCount,
            'recentUsers' => $recentUsers,
            'recentMenus' => $recentMenus,
        ]);

    }
}