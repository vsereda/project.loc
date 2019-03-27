<?php

namespace App\Http\Controllers;

use App\Address;
use App\Dish;
use App\DishServing;
use App\Order;
use App\OrderDishServing;
use App\Serving;
use App\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $ds = DishServing::where('dish_id', 2)->first();
//        $a = $u->addresses;
        dump($ds->serving);

        $s = Serving::find(3);
        dump($s->dishServings);
//        $a = Address::find(1);
//        $u = $a->user;
//        dump($u);
    }
}
