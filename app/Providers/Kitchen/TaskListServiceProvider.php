<?php

namespace App\Providers\Kitchen;

use Illuminate\Support\ServiceProvider;

class TaskListServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('getTaskList', 'App\Services\Kitchen\KitchenTaskList');
    }
}