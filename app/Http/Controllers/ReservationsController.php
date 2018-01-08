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
        $packages = \App\Package::all();
        $services = \App\Service::all();
        return view('admin.reservations.create')
        ->with('services', $services)
        ->with('packages', $packages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
            ->AddColumn('client', function($column){
               return $column->client_id;
            }) 
            ->AddColumn('service', function($column){
               return $column->service_id;
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
