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
//        dump(Order::find(5)->orderDishServings->first()->dishserving->price);
//        dump(Order::find(5)->orderDishServings->first());
//        dump('hhh');
//        dump(Order::with('orderDishServings.dishServing')->find(5)->orderDishServings->each(function ($ods) {
//            dump($ods->dishServing);
//            return $ods->dishServing->count;
//        }));

        $multiplied = Order::find(5)->orderDishServings->map(function ($item, $key) {
            return  $item->dishServing->price * $item->count ;
        });
        dump(array_sum($multiplied->toArray()));
//
//        foreach (Order::find(5)->orderDishServings as $ods) {
//            $a[]= ($ods->dishServing->price) * ($ods->count);
//        }
//        dump(array_sum($a));


        /*
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
        */

    }
}
