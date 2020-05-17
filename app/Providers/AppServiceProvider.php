<?php

namespace App\Providers;

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
        $this->app->instance('App\Interfaces\IViewedProductProvider', new \App\Extensions\CookieViewedProvider);
        $this->app->instance('App\Interfaces\IComparisonProvider', new \App\Extensions\CookieComparisonProvider);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
