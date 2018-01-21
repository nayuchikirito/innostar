<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

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
    

    
    public function authenticated()
    {
        switch (Auth::user()->user_type) {
            case 'Admin':
                return redirect("/admin/home");
                break;
            
            case 'Secretary':
                return redirect("/admin/home");
                break;
            
            case 'Supplier':
                return redirect("/admin/home");
                break;
            
            case 'Client':
                return redirect("/client/home");
                break;

            default:
                return redirect("/404");
                break;
        }
    }

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
}
