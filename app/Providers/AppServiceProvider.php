<?php

namespace App\Providers;

use App\Models\Logo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layout_admin.slidebar','layout_admin.master'], function ($view) {
        $logo = Logo::first();
        $view->with(['logo' => $logo]);
        });
        Schema::defaultStringLength(191);
    }
}
