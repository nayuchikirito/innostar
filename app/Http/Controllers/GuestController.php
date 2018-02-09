<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationDateRequest;
use App\Http\Requests\DateRequest1;
use DataTables;
use DB;
use Auth;
use Hash;

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
        $reservations = Auth::user()->client->reservation;
        $coordinations = Auth::user()->client->coordination;
        return view('client.clients.reservations', compact('reservations', 'coordinations'));
    }

    public function my_reservations()
    {
        $reservations = Auth::user()->client->reservation;
        $coordinations = Auth::user()->client->coordination;
        return view('client.clients.my_reservations', compact('reservations', 'coordinations'));
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

    public function pay_coord($id)
    {
        $coordination = \App\Coordination::find($id);
        return view('client.clients.bank_coord')
        ->with('coordination', $coordination);
    }

    public function payment(Request $request)
    {
        $data = request()->validate([
            'amount' => 'required|numeric',
            'details' => 'required|string',
            'date' => 'required',
            'time' => 'required',
        ]);
         try{

            DB::beginTransaction();

                $payment = new \App\Payment;
                $payment->details    = $request->get('details');
                $payment->amount     = $request->get('amount');
                $payment->type      = $request->get('type');
                $payment->date_of_payment        = $request->get('date').' '.$request->get('time').':00';
                $payment->reservation_id     = $request->get('reservation_id');
                $payment->save();

                $reservation = \App\Reservation::find($payment->reservation->id);
                $reservation->balance = $reservation->balance-$request->get('amount');
                if($reservation->balance < 0){
                    $reservation->balance = $reservation->balance+$request->get('amount');
                    $reservation->save();
                    return response()->json(['success' => false, 'msg' => 'Payment is greater than the remaining balance.']);
                }else if($reservation->balance <= $reservation->package->price-($reservation->package->price * .2)){
                        $reservation->status = 'blocked';

                        foreach($reservation->details as $detail){
                            if($detail->supplier_id == NULL){
                                $suppliers = \App\Supplier::where('type', $detail->package_detail->package_description->name)->get();
                                foreach($suppliers as $supplier){
                                    $supplier_notiff = new \App\SupplierNotification;
                                    $supplier_notiff->supplier_id            = $supplier->id;
                                    $supplier_notiff->reservation_detail_id  = $detail->id;
                                    $supplier_notiff->status                 = 'pending';
                                    $supplier_notiff->seen                   = 0;
                                    $supplier_notiff->save();
                                }
                            }
                        }
                }else{
                    $reservation->balance = $reservation->balance+$request->get('amount');
                    $reservation->save();
                    return response()->json(['success' => false, 'msg' => 'The downpayment must atleast be '.  $reservation->package->price * .2 .' pesos']);
                }
                $reservation->save();

                DB::commit();

                return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
            } 
    }

    public function custom_reservations(){
        $services = \App\Service::all();
        $user = Auth::user();
        $client = \App\Client::find($user->client->id);
        return view('client.reservation.custom', compact('services', 'client'));
    }
    public function save_custom_reservations(ReservationDateRequest $request){
        

        $dateCount = \App\Reservation::whereDate('date', $request->get('date'))->count();
        $dateCountCoord = \App\Coordination::whereDate('date', $request->get('date'))->count();

        if(($dateCount > 0 AND $dateCountCoord > 1) OR ($dateCount > 1) OR ($dateCountCoord > 2))
        {
            return response()->json(['success' => false, 'msg' => 'Cannot reserve date, fully booked.']);
        }else{
            try{

                DB::beginTransaction();

                $reservation = new \App\Reservation;
                $reservation->date        = $request->get('date').' '.$request->get('time').':00';
                $reservation->status        = $request->get('status');
                $reservation->balance      = $request->get('balance');
                $reservation->assigned      = $request->get('assigned');
                $reservation->client_id     = $request->get('client_id');
                $reservation->package_id      = $request->get('package_id');
                $reservation->reservation_type      = 'custom';
                $reservation->save();

                for($i = 0 ; $i < sizeof($request->get('detail')) ; $i++){
                    $r = \App\PackageDetail::find($request->get('detail')[$i]);
                    $res_detail = new \App\ReservationDetail;
                    $res_detail->reservation_id  = $reservation->id;
                    $res_detail->package_detail_id   = $r->id;
                    $res_detail->price = $r->price;
                    $res_detail->save();                    
                }
                DB::commit();
                DB::rollback();

                return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);

            }catch(\Exception $e){
                return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
            }
        }
    }

    public function get_package_details($id){
        $details = \App\PackageDetail::where('package_id', $id)->get();
        return view('client.reservation.package_detail')->with('details', $details);
    }

    public function payment_coord(Request $request)
    {
        $data = request()->validate([
            'amount' => 'required|numeric',
            'details' => 'required|string',
        ]);
         try{

            DB::beginTransaction();

                $payment = new \App\PaymentCoordination;
                $payment->details    = $request->get('details');
                $payment->amount     = $request->get('amount');
                $payment->type      = $request->get('type');
                $payment->date_of_payment        = $request->get('date').' '.$request->get('time').':00';
                $payment->coordination_id     = $request->get('coordination_id');
                $payment->save();

                $coordination = \App\Coordination::find($payment->coordination->id);
                $coordination->balance = $coordination->balance-$request->get('amount');
                if($coordination->balance < 0){
                    $coordination->balance = $coordination->balance+$request->get('amount');
                    $coordination->save();
                    return response()->json(['success' => false, 'msg' => 'Payment is greater than the remaining balance.']);
                }else if($coordination->balance <= 10000){
                        $coordination->status = 'blocked';

                        // foreach($reservation->details as $detail){
                        //     if($detail->supplier_id == NULL){
                        //         $suppliers = \App\Supplier::where('type', $detail->package_detail->package_description->name)->get();
                        //         foreach($suppliers as $supplier){
                        //             $supplier_notiff = new \App\SupplierNotification;
                        //             $supplier_notiff->supplier_id            = $supplier->id;
                        //             $supplier_notiff->reservation_detail_id  = $detail->id;
                        //             $supplier_notiff->status                 = 'pending';
                        //             $supplier_notiff->seen                   = 0;
                        //             $supplier_notiff->save();
                        //         }
                        //     }
                        // }
                }else{
                    $coordination->balance = $coordination->balance+$request->get('amount');
                    $coordination->save();
                    return response()->json(['success' => false, 'msg' => 'The downpayment must atleast be 5000 pesos']);
                }
                $coordination->save();

                DB::commit();

                return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
            } 
    }

    public function request_cancel($id)
    {
        try{
            
            DB::beginTransaction();
            $reservation = \App\Reservation::find($id);

            $client_notif = new \App\ClientNotification;
            $client_notif->reservation_id = $reservation->id;
            $client_notif->status = 'pending';
            $client_notif->type = 'cancellation';
            $client_notif->save();

            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Request Successfully Sent!']);

        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'An error occured while sending request!']);
        } 

    }

    public function request_cancel_coord($id)
    {
        // try{
            
            DB::beginTransaction();
            $coordination = \App\Coordination::find($id);

            $client_notif = new \App\ClientNotificationCoord;
            $client_notif->coordination_id = $coordination->id;
            $client_notif->status = 'pending';
            $client_notif->type = 'cancellation';
            $client_notif->save();

            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Request Successfully Sent!']);

        // }catch(\Exception $e){
        //     DB::rollback();
        //     return response()->json(['success' => false, 'msg' => 'An error occured while sending request!']);
        // } 

    }

    public function change($id)
    {
        $reservation = \App\Reservation::find($id);
        return view('client.clients.change', compact('reservation'));
    }

    public function change_coord($id)
    {
        $coordination = \App\Coordination::find($id);
        return view('client.clients.change_coord', compact('coordination'));
    }

    public function change_send(Request $request)
    {

        $dateCount = \App\Reservation::whereDate('date', $request->get('date'))->count();
        $dateCountCoord = \App\Coordination::whereDate('date', $request->get('date'))->count();
        if(($dateCount > 0 AND $dateCountCoord > 1) OR ($dateCount > 1) OR ($dateCountCoord > 2))
            {
                return response()->json(['success' => false, 'msg' => 'Cannot reserve date, fully booked.']);
            }else{
                try{
                    
                    DB::beginTransaction();

                    $client_notif = new \App\ClientNotification;
                    $client_notif->change_date = $request->get('date').' '.$request->get('time').':00';
                    $client_notif->reservation_id = $request->get('reservation_id');
                    $client_notif->status = 'pending';
                    $client_notif->type = 'change';
                    $client_notif->save();

                    DB::commit();

                    return response()->json(['success' => true, 'msg' => 'Request Successfully Sent!']);

                }catch(\Exception $e){
                    DB::rollback();
                    return response()->json(['success' => false, 'msg' => 'An error occured while sending request!']);
                } 
            }
    }

    public function change_send_coord(Request $request)
    {

        $dateCount = \App\Reservation::whereDate('date', $request->get('date'))->count();
        $dateCountCoord = \App\Coordination::whereDate('date', $request->get('date'))->count();
        if(($dateCount > 0 AND $dateCountCoord > 1) OR ($dateCount > 1) OR ($dateCountCoord > 2))
            {
                return response()->json(['success' => false, 'msg' => 'Cannot reserve date, fully booked.']);
            }else{
                try{
                    
                    DB::beginTransaction();

                    $client_notif = new \App\ClientNotificationCoord;
                    $client_notif->change_date = $request->get('date').' '.$request->get('time').':00';
                    $client_notif->coordination_id = $request->get('coordination_id');
                    $client_notif->status = 'pending';
                    $client_notif->type = 'change';
                    $client_notif->save();

                    DB::commit();

                    return response()->json(['success' => true, 'msg' => 'Request Successfully Sent!']);

                }catch(\Exception $e){
                    DB::rollback();
                    return response()->json(['success' => false, 'msg' => 'An error occured while sending request!']);
                } 
            }
    }

    public function changepassword(){
        return view('client.users.changepass');
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
}
