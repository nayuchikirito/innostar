<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Hash;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { 
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.includes.home1');
    }

    public function deletePending()
    {
        $reservations = \App\Reservation::all();
            foreach($reservations as $reservation)
            {
                if($reservation->created_at->diffInDays(Carbon::now()) > 5 && $reservation->status == 'pending')
                    {
                        $reservation->delete();
                    }
            }

        $coordinations = \App\Coordination::all();
            foreach($coordinations as $coordination)
            {
                if($coordination->created_at->diffInDays(Carbon::now()) > 5 && $coordination->status == 'pending')
                    {
                        $coordination->delete();
                    }
            }
    }

    public function changepassword(){
        return view('admin.users.changepass');
    }


    public function saveChangePassword(Request $request){

        $data = request()->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:5|same:confirm_password',
            'confirm_password' => 'required|string|min:5',
        ]); 
        if(Hash::check($request->old_password, Auth::user()->password)){
            $user = \App\User::findOrFail(Auth::user()->id); 
            $user->password = $request->new_password;
            if($user->save()){
                return response()->json(['success' => true, 'msg' => 'Password Successfully changed!']);                
            }else{
                return response()->json(['success' => false, 'msg' => 'An error occurred while changing password!']);   
            }
        }else{
            return response()->json(['success' => false, 'msg' => 'Old Password does not match!']);
        }
    }

    public function messenger()
    {
        return view('vendor.messenger.messenger');
    }
}
