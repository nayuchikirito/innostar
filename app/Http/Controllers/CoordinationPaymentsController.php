<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class CoordinationPaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.payments.index_coord');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

                $payment = new \App\PaymentCoordination;
                $payment->details    = $request->get('details');
                $payment->date_of_payment = \Carbon\Carbon::now();
                $payment->amount     = $request->get('amount');
                $payment->type      = $request->get('type');
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
                }else{
                    $coordination->balance = $coordination->balance+$request->get('amount');
                    $coordination->save();
                    return response()->json(['success' => false, 'msg' => 'The downpayment must atleast be 5000 pesos']);
                }
                $coordination->save();

                DB::commit();

                return response()->json(['success' => true, 'msg' => 'Payment Details Recorded Successfully!']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while recording payment details!']);
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
        $payment = \App\PaymentCoordination::find($id);
        return view('admin.payments.show_coord')->with('payment', $payment);
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
        return view('admin.payments.edit_coord')
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

                $payment = \App\PaymentCoordination::find($id);
                $oldAmount = $payment->amount;
                $payment->details    = $request->get('details');
                $payment->date_of_payment = \Carbon\Carbon::now();
                $payment->amount     = $request->get('amount');
                $payment->type      = $request->get('type');
                $payment->coordination_id     = $request->get('coordination_id');
                $payment->save();

                $coordination = \App\Coordination::find($payment->coordination->id);
                $coordination->balance = $coordination->balance+$oldAmount-$request->get('amount');
                if($coordination->balance < 0){
                    $coordination->balance = $coordination->balance+$request->get('amount');
                    $coordination->save();
                    return response()->json(['success' => false, 'msg' => 'Payment is greater than the remaining balance.']);
                }else if($coordination->balance <= 10000){
                        $coordination->status = 'blocked';
                }else{
                    $coordination->balance = $coordination->balance+$request->get('amount');
                    $coordination->save();
                    return response()->json(['success' => false, 'msg' => 'The downpayment must atleast be 5000 pesos']);
                }
                $coordination->save();

                DB::commit();

                return response()->json(['success' => true, 'msg' => 'Payment Details Recorded Successfully!']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while recording payment details!']);
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
            $payment = \App\PaymentCoordination::find($id);
            $oldAmount = $payment->amount;

            $coordination = \App\Coordination::find($payment->coordination->id);
            $coordination->balance = $coordination->balance+$oldAmount;
            $coordination->save();
            DB::commit();


            $status = \App\PaymentCoordination::destroy($id); 
            if($status){
                return response()->json(['success' => true, 'msg' => 'Data Successfully deleted!']);
            }else{
                return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
            }
        }catch(\Illuminate\Database\QueryException $e){
            return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
        }
    }

    public function all(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\PaymentCoordination::where('status', 'confirm');

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
            // ->sortBy('row', 'descending')
            ->rawColumns(['actions'])
            ->make(true);    
    }

    public function pay($id)
    {
        $coordination = \App\Coordination::find($id);
        return view('admin.payments.pay_coordination')
        ->with('coordination', $coordination);
    }
}
