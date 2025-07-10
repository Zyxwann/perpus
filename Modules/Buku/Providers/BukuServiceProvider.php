<?php

namespace Modules\Buku\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class BukuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register Web Routes
        $this->registerRoutes();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load views from module
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'buku');

        // Load migrations from module
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the module's routes.
     */
    protected function registerRoutes(): void
    {
        // Web routes
        Route::middleware('web')
            ->namespace('Modules\Buku\Http\Controllers')
            ->group(__DIR__ . '/../Routes/web.php');

        // API routes (optional)
        if (file_exists(__DIR__ . '/../Routes/api.php')) {
            Route::prefix('api')
                ->middleware('api')
                ->namespace('Modules\Buku\Http\Controllers')
                ->group(__DIR__ . '/../Routes/api.php');
        }
    }
}
