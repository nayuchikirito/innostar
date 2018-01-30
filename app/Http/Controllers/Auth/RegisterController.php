<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use DataTables;
use DB;

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
    // protected $redirectTo = '/';
    protected function redirectTo()
    {
        switch (Auth::user()->user_type) {
            case 'Admin':
                return redirect("/admin/home");
                break;
            
            case 'Secretary':
                return redirect("/secretary/home");
                break;
            
            case 'Suppliers':
                return redirect("/supplier/home");
                break;
            
            case 'Client':
                return redirect("/client/home");
                break;

            default:
                return redirect("/404");
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => 'required',
            'lname' => 'required',
            'midname' => 'required',
            'location' => 'required',
            'contact' => 'required',
            'user_type' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|same:password_confirm',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'fname' => $data['fname'], 
            'lname' => $data['lname'],
            'midname' => $data['midname'],
            'location' => $data['location'],
            'contact' => $data['contact'],
            'user_type' => $data['user_type'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $user->client = Client::create([
            'user_id' => $user->id,
        ]);

        return $user;
    }

    

}
