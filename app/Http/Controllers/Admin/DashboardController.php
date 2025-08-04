<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data statistik
        $userCount = User::count();
        $menuCount = Menu::count();
        $orderCount = Order::count();
        // STATISTIK BARU: Total Pendapatan dari pesanan yang 'completed'
        $totalRevenue = Order::where('status', 'completed')->sum('total_harga');
        
        // Ambil data aktivitas terbaru
        $recentUsers = User::latest()->take(5)->get();
        $recentMenus = Menu::latest()->take(5)->get();

        // Siapkan data untuk GRAFIK PENDAPATAN 7 hari terakhir
        $revenueChartData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('sum(total_harga) as revenue') // Ganti count(*) menjadi sum(total_harga)
            )
            ->where('status', 'completed') // Hanya hitung pendapatan dari pesanan yang selesai
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
            $chartLabels[] = Carbon::parse($date)->format('D, d M');
            $order = $revenueChartData->firstWhere('date', $date);
            $chartData[] = $order ? $order->revenue : 0;
        }
        
        // Kirim semua data ke view
        return view('admin.dashboard', [
            'userCount' => $userCount,
            'menuCount' => $menuCount,
            'orderCount' => $orderCount,
            'totalRevenue' => $totalRevenue, // Kirim data pendapatan
            'recentUsers' => $recentUsers,
            'recentMenus' => $recentMenus,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
    }
}
