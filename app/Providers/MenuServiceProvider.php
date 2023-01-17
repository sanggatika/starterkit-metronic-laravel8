<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Model Database
use App\Models\V_menuauthorization;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {     
        view()->composer('*', function ($view)
        {
            // Ketika Ada Session User Login
            if(Auth::check())
            {
                // dd(Auth::user()->role_id);
                // Get Data Menu Sesuai Dengan Role Session
                $ms_menu = V_menuauthorization::where('id_role', Auth::user()->role_id)->where('menu_status', 1)->where('menu_visible', 1)->where('authorization_status', 1)->orderBy('menu_sort', 'asc')->get();
                
                // Active Menu Sesuai Dengan URL Route
                $active_menu = $ms_menu->where('menu_routename', Route::currentRouteName())->first();

                // Menampung Data Menu
                $data_menu = [
                    'ms_menu' => $ms_menu,
                    'active_menu' => $active_menu
                ];

                \View::share('menuData',[$data_menu]);
            }                      
        });
    }
}
