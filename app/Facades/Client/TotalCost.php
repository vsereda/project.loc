<?php

namespace App\Facades\Client;

use Illuminate\Support\Facades\Facade;

class TotalCost extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'TotalCost';
    }
}