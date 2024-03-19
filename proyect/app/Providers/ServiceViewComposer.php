<?php

namespace App\Providers;

use App\Http\Controllers\ItemController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ServiceViewComposer extends ServiceProvider
{
    public $navs;           
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $item = new ItemController();
        $this->navs = $item->setNav();

        View::composer('layouts.app', function ($view) {
            $view->with(['navs' => $this->navs]);
        });
    }
}
