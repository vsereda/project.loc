<?php

namespace App\Http\Controllers;

use App\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        switch (true) {
            case (!Auth::user()):
                return redirect()->route('home.show');
            case (Auth::user()->hasRole('kitchener|courier')):
                return redirect()->route('orders.index');
            case (Auth::user()->hasRole('user')):
                return redirect()->route('products.index');
            default:
                return redirect()->route('logout');
        }
    }

    public function show()
    {
        if (!Auth::user() || (Auth::user() && Auth::user()->hasRole('user'))) {
            return view('home')->with([
//            'page_title' => 'Меню',
                'dishes' => Dish::where('active', true)->get(),
            ]);
        } else {
            return redirect()->route('home');
        }
    }
}
