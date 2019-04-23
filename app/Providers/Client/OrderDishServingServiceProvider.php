<?php

namespace App\Providers\Client;

use Illuminate\Support\ServiceProvider;

class OrderDishServingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('KitchenODS', 'App\Services\Client\OrderDishServings');
    }
}