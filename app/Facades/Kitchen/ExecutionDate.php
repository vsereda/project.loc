<?php

namespace App\Facades\Kitchen;

use Illuminate\Support\Facades\Facade;

class ExecutionDate extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'getExecutionDate';
    }
}