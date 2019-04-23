<?php

namespace App\Providers\Client;

use Illuminate\Support\ServiceProvider;

class TotalCostServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('TotalCost', 'App\Services\Client\TotalCost');
    }
}