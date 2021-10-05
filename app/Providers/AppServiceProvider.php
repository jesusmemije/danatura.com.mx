<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Productos;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        $productos=Productos::all();
        View::share('productos', $productos);
    }
}
