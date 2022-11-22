<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // If the user is an administrator redirect him to the dashboard, otherwise the user home page
    protected function authenticated(Request $request, $user)
    {
        if($user->is_admin == 1) {
            return redirect()->route('admin.index');
        }
        return redirect()->route('home');
    }

    // Allowed the user to Login with an email or phone number
    public function username()
    {
        // get input value
        $loginValue = request('email');
        // check if it's an email or just a text
        $this->value = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email': 'phone_number';
        // merge value
        request()->merge([$this->value => $loginValue]);
        // return log in type
        return property_exists($this, 'value') ? $this->value : 'email';
    }
}
