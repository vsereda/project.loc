<?php

namespace App\Providers\Delivery;

use Illuminate\Support\ServiceProvider;

class ShortMessageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
//    public function boot()
//    {
//        //
//    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('SendSMS', 'App\Services\Delivery\ShortMessageService');
    }
}
