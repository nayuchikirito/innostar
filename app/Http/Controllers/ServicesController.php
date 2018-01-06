<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.create');
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
            'name' => 'required'
        ]);
        // if($data['password']){
        //     $data['password'] = bcrypt($data['password']);          
        // }

        $status = \App\Service::create($data); 
        if($status){
            return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);
        }else{
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
        $service = \App\Service::find($id);
        return view('admin.services.edit')->with('service', $service);
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
            'name' => 'required',
        ]);
        
        $service = \App\Service::find($id); 
        $service->name = $request->get('name');
 
        if($service->save()){
            return response()->json(['success' => true, 'msg' => 'Data Successfully updated!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while updating data!']);
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
         $status = \App\Service::destroy($id); 
        if($status){
            return response()->json(['success' => true, 'msg' => 'Data Successfully deleted!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
        }
    }

    public function all(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\Service::selectRaw('*, @row:=@row+1 as row');

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->row;
            })
            // ->AddColumn('name', function($column){
            //    return $column->name;
            // }) 
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
