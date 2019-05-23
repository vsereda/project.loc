<?php

use App\Address;
use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    $minusHours = rand(0, 24) * 3600;
    return [
        'address_id' => Address::all()->random()->id,
        'dinner_time' => rand(1, 3),
        'status' => rand(1, 4),
        'created_at' => time() - $minusHours,
//        'updated_at' => time() - $minusHours,
    ];
});