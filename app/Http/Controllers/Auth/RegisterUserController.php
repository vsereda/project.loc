<?php

namespace App\Http\Controllers\Auth;

use App\Address;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterUserController extends Controller
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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register')->with(['addresses' => Address::all()]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = ['login' => 'Хуйэ'];

        return Validator::make($data, [
            'name' => 'required|alpha|min:3|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
            'login' => 'required|alpha_dash|min:4|max:255|unique:users',
//            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|unique:users|digits:10',
            'address' => 'required|alpha_dash|max:255',
        ],
            [
                'name.required' => 'Поле не должно быть пустым',
                'name.alpha' => 'Имя должно состоять исключительно из буквенных символов.',
                'name.min' => 'Имя должно содержать минимум 3 символа.',
                'name.max' => 'Имя должно содержать максимум 255 символов.',

                'login.required' => 'Поле не должно быть пустым',
                'login.alpha_dash' => 'Поле должно содержать nолько буквенно-цифровые символы, а также тире и подчеркивания.',
                'login.min' => 'Используйте минимум 4 символа',
                'login.max' => 'Используйте максимум 255 символов',
                'login.unique' => 'Такой пользователь уже существует',

                'phone.required' => 'Поле не должно быть пустым',
                'phone.unique' => 'Такой телефон уже используется',
                'phone.digits' => 'Телефон должен содержать 10 цифер',

                'address.required' => 'Поле не должно быть пустым',
                'address.alpha_dash' => 'Поле должно содержать только буквенно-цифровые символы, а также тире и подчеркивания.',
                'address.min' => 'Адрес должен содержать минимум 6 символов',
                'address.max' => 'Адрес должен содержать максимум 255 символов',
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
            'address_id' => $data['address'],
//            'password' => bcrypt(config($data['password'])),
            'password' => bcrypt(config('default_password')),
        ]);
        $user->save();
//        $user->addresses()->save(new Address(['description'=>$data['address']]));
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
