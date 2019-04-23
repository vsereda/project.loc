<?php

namespace App\Providers\Kitchen;

use Illuminate\Support\ServiceProvider;

class KitchenOrdersServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('KitchenOrders', 'App\Services\Kitchen\KitchenOrders');
    }
}