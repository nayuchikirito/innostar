<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

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
        return view('admin.includes.home');
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
}
