<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('editable_order', function ($order) {
            return ((Auth::user()->hasRole('user') && $order->status == 1 && (
                        (now() < Carbon::today()->addHours(config('deadline.deadline')))
                        || (now() >= Carbon::today()->addHours(config('deadline.deadline'))
                            && $order->created_at > Carbon::today()->addHours(config('deadline.deadline')))
                    ))
                || (Auth::user()->hasRole('kitchener')
                    && (now() >= Carbon::today()->addHours(config('deadline.deadline')))
                )
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
