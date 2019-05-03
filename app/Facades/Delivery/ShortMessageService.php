<?php

namespace App\Facades\Delivery;

use Illuminate\Support\Facades\Facade;

class ShortMessageService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SendSMS';
    }
}