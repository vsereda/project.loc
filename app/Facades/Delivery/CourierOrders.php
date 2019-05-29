<?php

namespace App\Facades\Delivery;

use Illuminate\Support\Facades\Facade;

class CourierOrders extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CourierOrders';
    }
}