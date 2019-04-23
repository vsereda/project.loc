<?php

namespace App\Providers\Client;

use Illuminate\Support\ServiceProvider;

class DishServingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('KitchenDS', 'App\Services\Client\DishServings');
    }
}