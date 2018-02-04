<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationDateRequest;
use DataTables;
use DB;
use Auth;

class GuestController extends Controller
{
    public function __construct()
    {
        $this->middleware('client');
    }

    public function index()
    {
        return view('client.clients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = \App\Service::all();
        $user = Auth::user();
        $client = \App\Client::find($user->client->id);
        return view('client.reservation.create', compact('services', 'client'));
    }

    public function coordination()
    {

        $services = \App\Service::all();
        $user = Auth::user();
        $client = \App\Client::find($user->client->id);
        return view('client.reservation.coordination', compact('services', 'client'));
    }

    public function button()
    {
        return view('client.reservation.button');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationDateRequest $request)
    {
        $data = request()->validate([
            // 'date' => 'required',
            'time' => 'required',
            'status' => 'required',
            'balance' => 'required|numeric',
            'client_id' => 'required',
            'package_id' => 'required',
        ]);
        // if($data['password']){
        //     $data['password'] = bcrypt($data['password']);          
        // }

         try{

            DB::beginTransaction();

                $reservation = new \App\Reservation;
                $reservation->date        = $request->get('date').' '.$request->get('time').':00';
                $reservation->status        = $request->get('status');
                $reservation->balance      = $request->get('balance');
                $reservation->assigned      = $request->get('assigned');
                $reservation->client_id     = $request->get('client_id');
                $reservation->package_id      = $request->get('package_id');
                $reservation->save();

                DB::commit();

                return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
            } 
        // }catch(\Exception $e){
        //     DB::rollback();
        //     return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
        // } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationDateRequest $request, $id)
    {
        $data = request()->validate([
            // 'date' => 'required',
            'time' => 'required',
            'status' => 'required',
            'balance' => 'required|numeric',
            'client_id' => 'required',
            'package_id' => 'required',
        ]);

         try{

            DB::beginTransaction();

                $reservation = \App\Reservation::find($id);
                $reservation->date        = $request->get('date').' '.$request->get('time').':00';
                $reservation->status        = $request->get('status');
                $reservation->balance      = $request->get('balance');
                $reservation->client_id     = $request->get('client_id');
                $reservation->package_id      = $request->get('package_id');
                $reservation->save();

                DB::commit();

                return response()->json(['success' => true, 'msg' => 'Data Successfully edited!']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while editing data!']);
            } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reservations()
    {
        return view('client.clients.reservations');
    }

    public function all(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\Reservation::where('client_id', Auth::user()->client->id);

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('date', function($column){
               return date('M d, Y | h:i A', strtotime($column->date));
            })
            ->AddColumn('service', function($column){
               return $column->package->service->name;
            }) 
            ->AddColumn('actions', function($column){
              
                return '
                            <a class="btn-sm btn btn-success pay-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-money"></i> Pay
                            </a> 

                            <button class="btn-sm btn btn-warning request-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-trash-o"></i> Change
                            </button> 

                            <button class="btn-sm btn btn-danger request-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-trash-o"></i> Cancellation
                            </button> 
                        ';
            }) 
            ->rawColumns(['actions', 'requests'])
            ->make(true);    
    }

    public function requestCancel()
    {
        Auth::user()->notify(new UserRequests());
    }

    public function pay($id)
    {
        $reservation = \App\Reservation::find($id);
        return view('client.clients.bank')
        ->with('reservation', $reservation);
    }

    public function payment(Request $request)
    {
        $data = request()->validate([
            'amount' => 'required|numeric',
            'details' => 'required|string',
        ]);
         try{

            DB::beginTransaction();

                $payment = new \App\Payment;
                $payment->details    = $request->get('details');
                $payment->amount     = $request->get('amount');
                $payment->type      = $request->get('type');
                $payment->reservation_id     = $request->get('reservation_id');
                $payment->save();

                $reservation = \App\Reservation::find($payment->reservation->id);
                $reservation->balance = $reservation->balance-$request->get('amount');
                if($reservation->balance <= $reservation->package->price-($reservation->package->price * .2)){
                        $reservation->status = 'blocked';
                    }
                $reservation->save();

                DB::commit();

                return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
            } 
    }
}
