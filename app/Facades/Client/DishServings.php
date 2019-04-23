<?php

namespace App\Facades\Client;

use Illuminate\Support\Facades\Facade;

class DishServings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'KitchenDS';
    }
}