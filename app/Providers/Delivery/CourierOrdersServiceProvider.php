<?php

namespace App\Providers\Delivery;

use Illuminate\Support\ServiceProvider;

class CourierOrdersServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('CourierOrders', 'App\Services\Delivery\CourierOrders');
    }
}