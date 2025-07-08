<?php

namespace Modules\Member\Providers;

use Illuminate\Support\ServiceProvider;

class MemberServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Load route file untuk modul ini
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        // Load view (kalau pakai Blade)
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'member');
    }

    public function boot()
    {
        //
    }
}
        