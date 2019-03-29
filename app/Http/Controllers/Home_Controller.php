<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Home_Controller extends Controller
{
    public function index()
    {
        if (Auth::user() && Auth::user()->hasRole('kitchener')) {
            return redirect()->route('orders.index');
        }

        return view('home');
    }
}
