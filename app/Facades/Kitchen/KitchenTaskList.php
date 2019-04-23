<?php

namespace App\Facades\Kitchen;

use Illuminate\Support\Facades\Facade;

class KitchenTaskList extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'getTaskList';
    }
}