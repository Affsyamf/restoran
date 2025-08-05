<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class WelcomePageComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Ambil semua setting dan kirim ke view sebagai variabel $settings
        $settings = Setting::pluck('value', 'key')->all();
        $view->with('settings', $settings);
    }
}
