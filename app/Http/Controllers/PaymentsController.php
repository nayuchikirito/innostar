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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = \App\Payment::find($id);
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

    public function pay_coord($id)
    {
        $coordination = \App\Coordination::find($id);
        return view('admin.payments.pay_coordination')
        ->with('coordination', $coordination);
    }

     public function coord_store(Request $request)
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
                $payment->coordination_id     = $request->get('coordination_id');
                $payment->save();

                $coordination = \App\Coordination::find($payment->coordination->id);
                $coordination->balance = $coordination->balance-$request->get('amount');
                if($coordination->balance <= 10000){
                        $coordination->status = 'blocked';
                    }
                $coordination->save();

                DB::commit();

                return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
            } 
    }


    public function all(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\Payment::all();

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
}
