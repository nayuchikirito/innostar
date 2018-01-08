<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class PackagesController extends Controller
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
        return view('admin.packages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = \App\Service::all();
        return view('admin.packages.create')->with('services', $services);
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
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
            'service_id' => 'required',
        ]);

        $status = \App\Package::create($data); 
        if($status){
            return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
        }
        // try{

        //     DB::beginTransaction();

        //         $package = new \App\Package;
        //         $package->name         = $request->get('name');
        //         $package->price        = $request->get('price');
        //         $package->description  = $request->get('description');
        //         $package->service_id   = $request->get('service_id');
        //         $package->save();

        //         DB::commit();

        //         return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);

        //     }catch(\Exception $e){
        //         DB::rollback();
        //         return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
        //     } 

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
        $package = \App\Package::find($id);
        $services = \App\Service::all();
        return view('admin.packages.edit')->with('package', $package)->with('services', $services);
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
            'price' => 'required|numeric|min:0',
            'description' => 'required',
            'service_id' => 'required',
        ]);
        
        $service = \App\Package::find($id); 
        $service->name = $request->get('name');
        $service->price = $request->get('price');
        $service->description = $request->get('description');
        $service->service_id = $request->get('service_id');
 
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
        $status = \App\Package::destroy($id); 
        if($status){
            return response()->json(['success' => true, 'msg' => 'Data Successfully deleted!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
        }
    }

    public function all(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\Package::selectRaw('*, @row:=@row+1 as row');
         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('service', function($column){
               return $column->service->name;
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
