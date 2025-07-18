<?php

namespace Modules\Member\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class MemberServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // Load view Blade: view('member::index')
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'member');

        // Load migration (opsional)
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Load route Web
        Route::middleware('web')
            ->group(__DIR__ . '/../Routes/web.php');

        // Load route API
        Route::prefix('api')
            ->middleware('api')
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
