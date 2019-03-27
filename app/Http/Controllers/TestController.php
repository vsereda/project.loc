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
        dump('DishServing-OrderDishServing:');
        $ds = DishServing::where('dish_id', 4)->first();
        dump($ds);
        dump($ds->orderDishServings);
        dump('----------------------');
        $ods = OrderDishServing::where('dish_id', 2)->where('serving_id', 2)->first();
        dump($ods);
        dump($ods->dishServing);

        dump('DishServing-Serving, DishServing-Dish:');
        dump($ds);
        dump($ds->serving);
        dump($ds->dish);
        $d = Dish::find(2);
        dump($d);
        dump($d->dishServings);
        $s = Serving::find(1);
        dump($s);
        dump($s->dishServings);

        dump('Dish-Serving:');
        $d = Dish::find(3);
        dump($d);
        dump($d->servings);
        $s = Serving::find(4);
        dump($s);
        dump($s->dishes->first());
        dump($s->dishes->first()->pivot);
        dump('----------------------');
        dump($d);
        dump($d->servings->first()->pivot);

    }
}
