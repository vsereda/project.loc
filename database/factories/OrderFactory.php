<?php

use App\Address;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;

$factory->define(App\Order::class, function (Faker $faker) {
    $minusHours = rand(0, 24) * 3600;
    return [
//        'address_id' => Address::all()->random()->id,
        'user_id' => User::all()->random()->id,
        'dinner_time' => rand(1, 3),
        'status' => rand(1, 4),
        'created_at' => time() - $minusHours,
//        'updated_at' => time() - $minusHours,
        'execution' => Carbon::today(),
    ];
});