<?php

use App\Address;
use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'address_id' => Address::all()->random()->id,
        'dinner_time' => rand(1, 3),
    ];
});