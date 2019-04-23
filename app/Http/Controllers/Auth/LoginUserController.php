<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'login';
    }

    public function showLoginForm()
    {
        return view('auth.login_client');
    }

    public function login(Request $request)
    {
        $login = $request->login;

        $user = User::where('login', $login)->first();

        if (!$user || !($user->hasRole('user'))) {
            return redirect()->back()->withInput($request->only('login'))->withErrors([
                'login' => 'Не правильный логин',
            ]);
        }

        Auth::login($user);
        return redirect('/');
    }
}
