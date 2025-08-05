<?php

namespace App\Providers;

use App\View\Composers\AdminLayoutComposer;
use App\View\Composers\WelcomePageComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       // Menjalankan AdminLayoutComposer setiap kali view 'components.layouts.admin' dipanggil
        View::composer('components.layouts.admin', AdminLayoutComposer::class);

        // Menjalankan WelcomePageComposer setiap kali view 'welcome' dipanggil
        View::composer('welcome', WelcomePageComposer::class);
    }
}
