<?php

namespace App\Providers\Kitchen;

use Illuminate\Support\ServiceProvider;

class ExecutionDateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('getExecutionDate', 'App\Services\Kitchen\ExecutionDate');
    }
}