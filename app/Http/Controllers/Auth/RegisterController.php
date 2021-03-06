<?php

namespace App\Http\Controllers\Auth;

use App\Address;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/products';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
//        $this->redirectTo = url()->previous();
//        $this->redirectTo = url()->previous();
//        $this->redirectTo = back();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
            'login' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|unique:users|digits:10',
            'address' => 'required|string|min:8',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = new User([
            'name' => $data['name'],
//            'email' => $data['email'],
            'login' => $data['login'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'password' => bcrypt($data['password']),
        ]);
        $user->save();
        $user->addresses()->save(new Address(['description'=>$data['address']]));
        $user->attachRole('user');
        return $user;
    }

    /**
     * Redirect users back after registration.
     */
//    protected function redirectTo()
//    {
////        if (session()->get('order_back_url')) {
//            return session()->pull('register_back_url') ?? $this->redirectTo;
////        }
////        return $this->redirectTo;
//    }
}
