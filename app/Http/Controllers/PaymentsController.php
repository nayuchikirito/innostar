<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        
        return view('admin.payments.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $reservation = \App\Reservation::find($id);
        // return view('admin.payments.pay')
        // ->with('reservation', $reservation);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'amount' => 'required|numeric',
            'details' => 'required|string',
        ]);
         // try{


            DB::beginTransaction();

                $payment = new \App\Payment;
                $payment->details    = $request->get('details');
                $payment->amount     = $request->get('amount');
                $payment->type      = $request->get('type');
                $payment->status    = 'confirm';
                $payment->date_of_payment        = $request->get('date_of_payment');
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
        $payment = \App\Payment::find($id);
        // return response()->json($payment);
        return view('admin.payments.show')->with('payment', $payment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = \App\Payment::find($id);
        return view('admin.payments.edit')
        ->with('payment', $payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = request()->validate([
            'amount' => 'required|numeric',
            'details' => 'required|string',
        ]);

         try{

            DB::beginTransaction();

                $payment = \App\Payment::find($id);
                $oldAmount = $payment->amount;
                $payment->details    = $request->get('details');
                $payment->amount     = $request->get('amount');
                $payment->type      = $request->get('type');
                $payment->reservation_id     = $request->get('reservation_id');
                $payment->save();

                $reservation = \App\Reservation::find($payment->reservation->id);
                $reservation->balance = $reservation->balance+$oldAmount-$request->get('amount');
                if($reservation->balance <= $reservation->package->price-($reservation->package->price * .2)){
                        $reservation->status = 'blocked';
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();
            $payment = \App\Payment::find($id);
            $oldAmount = $payment->amount;

            $reservation = \App\Reservation::find($payment->reservation->id);
            $reservation->balance = $reservation->balance+$oldAmount;
            $reservation->save();
            DB::commit();


            $status = \App\Payment::destroy($id); 
            if($status){
                return response()->json(['success' => true, 'msg' => 'Data Successfully deleted!']);
            }else{
                return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
            }
        }catch(\Illuminate\Database\QueryException $e){
            return response()->json(['success' => false, 'msg' => 'Cannot delete. Client has transactions']);
        }
    }

    public function pay($id)
    {
        $reservation = \App\Reservation::find($id);
        return view('admin.payments.pay')
        ->with('reservation', $reservation);
    }


    public function all(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\Payment::where('status', 'confirm');

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('actions', function($column){
              
                return '
                            <button class="btn-sm btn btn-info show-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-id-card-o"></i> View
                            </button>
                            <button class="btn-sm btn btn-warning edit-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn-sm btn btn-danger delete-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-trash-o"></i> Delete
                            </button> 
                        ';
            }) 
            ->rawColumns(['actions'])
            ->make(true);    
    }

    public function requests()
    {
        return view('admin.payments.requests');
    } 

    public function requests_coord()
    {
        return view('admin.payments.requests_coord');
    } 

    public function all_requests(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\Payment::where('status', 'pending');

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('name', function($column){
               return $column->reservation->client->user->lname.', '.$column->reservation->client->user->fname.' '.substr($column->reservation->client->user->midname, 0, 1).'. | Res. No: '.$column->reservation->id;
            })
            ->AddColumn('date_of_payment', function($column){
               return date('M d, Y | h:i A', strtotime($column->date_of_payment));
            })
            ->AddColumn('actions', function($column){
              
                return '
                            <button class="btn-sm btn btn-info confirm-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-id-card-o"></i> Confirm
                            </button>
                            <button class="btn-sm btn btn-danger decline-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-trash-o"></i> Decline
                            </button> 
                        ';
            }) 
            ->rawColumns(['actions'])
            ->make(true);    
    }

    public function all_requests_coord(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\PaymentCoordination::where('status', 'pending');

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('name', function($column){
               return $column->coordination->client->user->lname.', '.$column->coordination->client->user->fname.' '.substr($column->coordination->client->user->midname, 0, 1).'. | Res. No: '.$column->coordination->id;
            })
            ->AddColumn('date_of_payment', function($column){
               return date('M d, Y | h:i A', strtotime($column->date_of_payment));
            })
            ->AddColumn('actions', function($column){
              
                return '
                            <button class="btn-sm btn btn-info confirm-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-id-card-o"></i> Confirm
                            </button>
                            <button class="btn-sm btn btn-danger decline-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-trash-o"></i> Decline
                            </button> 
                        ';
            }) 
            ->rawColumns(['actions'])
            ->make(true);    
    }

    public function requests_confirm($id)
    {
        try{

            DB::beginTransaction();

                $payment = \App\Payment::find($id);
                $payment->status = 'confirm';
                $payment->save();

             DB::commit();

            return response()->json(['success' => true, 'msg' => 'Confirmed Payment Details']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while confirming data!']);
            } 
    }

    public function requests_confirm_coord($id)
    {
        try{

            DB::beginTransaction();

                $payment = \App\PaymentCoordination::find($id);
                $payment->status = 'confirm';
                $payment->save();

             DB::commit();

            return response()->json(['success' => true, 'msg' => 'Confirmed Payment Details']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while confirming data!']);
            } 
    }

    public function requests_decline($id)
    {
        try{

            DB::beginTransaction();

                $payment = \App\Payment::find($id);
                $payment->status = 'decline';
                $payment->save();

                $reservation = \App\Reservation::find($payment->reservation->id);
                $reservation->balance = $reservation->balance+$payment->amount;
                $reservation->save();

             DB::commit();

            return response()->json(['success' => true, 'msg' => 'Declined Payment Details']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while declining data!']);
            } 
    }

    public function requests_decline_coord($id)
    {
        try{

            DB::beginTransaction();

                $payment = \App\PaymentCoordination::find($id);
                $payment->status = 'decline';
                $payment->save();

                $coordination = \App\Coordination::find($payment->coordination->id);
                $coordination->balance = $coordination->balance+$payment->amount;
                $coordination->save();

             DB::commit();

            return response()->json(['success' => true, 'msg' => 'Declined Payment Details']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while declining data!']);
            } 
    }

    
}
