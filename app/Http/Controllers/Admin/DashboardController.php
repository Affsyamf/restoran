<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $menuCount = Menu::count();
        $orderCount = Order::count(); // Assuming you have an Order model, you can count orders similarly

        $recentUsers = User::latest()->take(5)->get();
        $recentMenus = Menu::latest()->take(5)->get();

         $ordersChartData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

            $chartLabels = [];
            $chartData = [];
            $dateRange = collect();

            for ($i = 6; $i >= 0; $i--) {
            $dateRange->push(Carbon::now()->subDays($i)->format('Y-m-d'));
        }

         foreach ($dateRange as $date) {
            $chartLabels[] = Carbon::parse($date)->format('D, d M'); // Format: Mon, 01 Aug
            $order = $ordersChartData->firstWhere('date', $date);
            $chartData[] = $order ? $order->count : 0;
        }

        return view('admin.dashboard', [
            'userCount' => $userCount,
            'menuCount' => $menuCount,
            'orderCount' => $orderCount,
            'recentUsers' => $recentUsers,
            'recentMenus' => $recentMenus,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);

    }
}