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
use Darryldecode\Cart\Facades\CartFacade as Cart;

class TestController extends Controller
{
    public function test1()
    {
        dd(Address::all()->random()->id);
return view('home');
    }

    public function test2()
    {
        dump(Cart::getContent());
    }
}
