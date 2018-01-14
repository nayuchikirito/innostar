<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class ReservationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.reservations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = \App\Service::all();
        $client = Auth::user();
        return view('admin.reservations.create', compact('services', 'client'));
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
            'datetime' => 'required|date',
            'status' => 'required',
            'balance' => 'required',
            'client_id' => 'required',
            'package_id' => 'required',
        ]);
        // if($data['password']){
        //     $data['password'] = bcrypt($data['password']);          
        // }

         // try{

            DB::beginTransaction();

                $reservation = new \App\Reservation;
                $reservation->date        = $request->get('datetime');
                $reservation->status        = $request->get('status');
                $reservation->balance      = $request->get('balance');
                $reservation->client_id     = $request->get('client_id');
                $reservation->package_id      = $request->get('package_id');
                $reservation->save();

                DB::commit();

                return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);

            // }catch(\Exception $e){
            //     DB::rollback();
            //     return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
            // } 
        // $status = \App\Reservation::create($data); 
        // if($status){
        //     return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);
        // }else{
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
    public function update(Request $request, $id)
    {
        //
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

    public function all(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\Reservation::selectRaw('*, @row:=@row+1 as row');

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('date', function($column){
               return date('M d, Y | h:i A', strtotime($column->date));
            })
            ->AddColumn('client', function($column){
               return $column->client->user->lname.', '.$column->client->user->fname.' '.$column->client->user->midname;
            }) 
            ->AddColumn('service', function($column){
               return $column->package->service->name;
            }) 
            ->AddColumn('actions', function($column){
              
                return '
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
