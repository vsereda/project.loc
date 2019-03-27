<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Address::class, function (Faker $faker) {
    return [
        'description' => $faker->address,
    ];
});
