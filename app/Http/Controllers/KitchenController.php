<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDishServing;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index()
    {
        $orders = Order::where('dinner_time', 1)->get();
//        dd($orders->first());
        return view('home')->with(['orders'=>$orders]);
    }
}
