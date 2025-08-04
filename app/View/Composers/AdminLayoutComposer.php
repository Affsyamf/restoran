<?php

namespace App\View\Composers;

use App\Models\Order;
use Illuminate\View\View;

class AdminLayoutComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Hitung jumlah pesanan dengan status 'pending'
        $pendingOrderCount = Order::where('status', 'pending')->count();

        // Kirim data tersebut ke view
        $view->with('pendingOrderCount', $pendingOrderCount);
    }
}
