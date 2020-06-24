<?php

namespace App\Providers;

use App\Order;
use App\Pinquiry;
use App\Setting;
use App\Shipping;
use App\User;
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
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('Admin.section.sidebar', function($view){

            $user = auth()->user();

            foreach ($user->roles as $r)
            {
                $role = $r['label'];
            }

            $view->with(compact('role'));
        });

        view()->composer('Admin.section.sidebar', function($view){

            $orderStatusQueue = Order::where('status',0)->count();

            $view->with(compact('orderStatusQueue'));
        });

        view()->composer('Admin.section.sidebar', function($view){

            $pinquiryStatusQueue = Pinquiry::where('status',0)->count();

            $view->with(compact('pinquiryStatusQueue'));
        });

        view()->composer('Admin.section.sidebar', function($view){

            $shippingStatusQueue = Shipping::where('shipping_number','=',null)->count();

            $view->with(compact('shippingStatusQueue'));
        });

        view()->composer('User.sidebar', function($view){

            $user  = User::where('id', auth()->user()->id)->first();

            $checkProfile = true;

            if($user->email == ''){
                $checkProfile = false;
            }

            $view->with(compact('checkProfile'));
        });

        view()->composer('User.add_ship', function($view){

            $user  = User::where('id', auth()->user()->id)->first();

            $checkProfile = true;

            if($user->email == ''){
                $checkProfile = false;
            }

            $view->with(compact('checkProfile'));
        });

        view()->composer('layouts.app', function($view){

            $settings = Setting::latest()->first();

            $view->with(compact('settings'));
        });

        view()->composer('Admin.settings.rule', function($view){

            $settings = Setting::latest()->first();

            $view->with(compact('settings'));
        });
    }
}
