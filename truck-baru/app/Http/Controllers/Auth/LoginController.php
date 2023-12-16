<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
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
    // protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo()
    {
        $roles = Auth::user()->roles_id;
        switch ($roles) {
            case 1:
                Session::put('email', Auth::user()->email);
                return route('home');
                break;
            case 2:
                alert('Selamat Datang ' . Auth::user()->email);
                Session::put('email', Auth::user()->email);
                return route('home');
                break;
            case 3:
                alert('Selamat Datang ' . Auth::user()->email);
                Session::put('email', Auth::user()->email);
                return route('home');
                break;
            case 4:
                alert('Selamat Datang ' . Auth::user()->email);
                Session::put('email', Auth::user()->email);
                return route('home');
                break;
            case 5:
                alert('Selamat Datang ' . Auth::user()->email);
                Session::put('email', Auth::user()->email);
                return route('home');
                break;
            case 6:
                alert('Selamat Datang ' . Auth::user()->email);
                Session::put('email', Auth::user()->email);
                return route('home');
                break;
            default:
                return redirect()->route('login');
                break;
        }

    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
