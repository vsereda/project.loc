<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Home_Controller extends Controller
{
    public function index()
    {
        if (!Auth::user()) {
            return redirect()->route('products.index');
        } elseif (Auth::user()->hasRole('kitchener')) {
            return redirect()->route('orders.index');
        }elseif (Auth::user()->hasRole('user')) {
            return redirect()->route('products.index');
        }


        return view('home');
    }
}
