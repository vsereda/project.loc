<?php

namespace App\Facades\Kitchen;

use Illuminate\Support\Facades\Facade;

class KitchenOrders extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'KitchenOrders';
    }
}