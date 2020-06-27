<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GlobalVariableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \View::share('symbolCurrency', \Currency::getSymbol());

        \View::composer('admin.*', function ($view) {
            $view->with('admin_source', 'adminLTE');
        });

        \View::composer('admin.*', function ($view) {
            $view->with('count_new_chats', app(\App\Services\Chat::class)->getCountNew());
        });
    }
}
