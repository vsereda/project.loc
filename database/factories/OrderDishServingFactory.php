<?php

use App\DishServing;
use Faker\Generator as Faker;

$factory->define(App\OrderDishServing::class, function () {
    return [
        'count' => rand(1, 4),
    ];
});