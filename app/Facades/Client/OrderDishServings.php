<?php

namespace App\Facades\Client;

use Illuminate\Support\Facades\Facade;

class OrderDishServings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'KitchenODS';
    }
}