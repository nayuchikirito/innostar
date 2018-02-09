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
            'name' => 'required|unique:packages,name,null,null,service_id,'.$request->service_id,
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
        $package = \App\Package::find($id);
        $services = \App\Service::all();
        return view('admin.packages.show')->with('package', $package)->with('services', $services);
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
        try{
            $status = \App\Package::destroy($id); 
            if($status){
                return response()->json(['success' => true, 'msg' => 'Data Successfully deleted!']);
            }else{
                return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
            }
        }catch(\Illuminate\Database\QueryException $e){
            return response()->json(['success' => false, 'msg' => 'Cannot delete. Package is currently being availed.']);
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

    public function details()
    {
        $packages = \App\Package::all();
        $descriptions = \App\PackageDescription::all();
        return view('admin.packages.details', compact('packages', 'descriptions'));
        // ->with('packages', $packages);
    }

    public function details_store(Request $request)
    {

/*      $data = request()->validate([
            'package_id' => 'required',
            'description_id' => 'required',
            'price' => 'required|numeric|min:0',
        ]);
*/

         try{

             DB::beginTransaction();
                $descriptions = \App\PackageDescription::all();
                $packages = \App\PackageDetail::where('package_id', $request->get('package_id'))->get();
                if(sizeof($packages) > 0){
                    foreach($descriptions as $description){ 

                        $package_detail = \App\PackageDetail::where('package_id', $request->get('package_id'))
                                                         ->where('package_description_id', $description->id)
                                                         ->update(['price' => $request->get($description->id)]);
                        
                    }
                }else{
                    foreach($descriptions as $description){ 

                        $package_detail = new \App\PackageDetail;
                        $package_detail->package_id        = $request->get('package_id');
                        $package_detail->package_description_id    = $description->id;
                        $package_detail->price        = $request->get($description->id);
                        $package_detail->save();                    
                        
                    }
                }
                DB::commit();

                return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
            }
    }

    public function getPackageDetail($id){
        $packages = \App\PackageDetail::where('package_id', $id)->get();
        $package = \App\Package::where('id', $id)->first();

        return response()->json(['packages' => $packages,'package' => $package]);
    }

    public function get_package_details($id){
        $details = \App\PackageDetail::where('package_id', $id)->get();
        return view('client.reservation.package_detail')->with('details', $details);
    }
}
