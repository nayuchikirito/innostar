<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.clients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    public function reserve($id)
    {   
        $services = \App\Service::has('package')->get();
        $client = \App\Client::where('user_id', $id)->first();
        // return response()->json($client);
        return view('admin.clients.reserve', compact(['services', 'client']));
        // ->with('services', $services)
        // ->with('client', $client);
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
        'fname' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
        'lname' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
        'midname' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
        'location' => 'required',
        'contact' => 'required|max:11|regex:/(09)[0-9]/',
        'user_type' => 'required',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|same:password_confirm',
        ]);

        try{

            DB::beginTransaction();

                $user = new \App\User;
                $user->fname        = $request->get('fname');
                $user->lname        = $request->get('lname');
                $user->midname      = $request->get('midname');
                $user->location     = $request->get('location');
                $user->contact      = $request->get('contact');
                $user->user_type    = $request->get('user_type');
                $user->email        = $request->get('email');
                $user->password     = $request->get('password');
                $user->save();

                $client = new \App\Client;
                $client->user_id  = $user->id;
                $client->save();

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
        $user = \App\User::find($id);
        return view('admin.clients.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = \App\User::find($id);
        return view('admin.clients.edit')->with('client', $client);
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
            'fname' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
            'lname' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
            'midname' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
            'location' => 'required',
            'contact' => 'required|max:11|regex:/(09)[0-9]/',
            'user_type' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|same:password_confirm',
        ]);

        try{

            DB::beginTransaction();

                $user = \App\User::find($id);
                $user->fname        = $request->get('fname');
                $user->lname        = $request->get('lname');
                $user->midname      = $request->get('midname');
                $user->location     = $request->get('location');
                $user->contact      = $request->get('contact');
                $user->user_type    = $request->get('user_type');
                $user->email        = $request->get('email');
                $user->password     = $request->get('password');
                $user->save();

               /* $client = \App\Client::find($user->client->id);//kani<------------------ Gi comment sa nako ang try catch para
                $client->user_id  = $user->id;                  //makit-an ang error
                $client->save();
*/
                DB::commit();

                return response()->json(['success' => true, 'msg' => 'Data Successfully updated!']);

            }catch(\Exception $e){
                DB::rollback();
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
            $user = \App\User::find($id); 
            $status = \App\Client::destroy($user->client->id);
            $status2 = \App\User::destroy($id);
            if($status && $status2){
                return response()->json(['success' => true, 'msg' => 'Data Successfully deleted!']);
            }else{
                return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
            }
        }catch(\Illuminate\Database\QueryException $e){
            return response()->json(['success' => false, 'msg' => 'Cannot delete. Client has transactions']);
        }
    }

    public function all(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\User::selectRaw('*, @row:=@row+1 as row')->where('user_type', 'client');

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('name', function($column){
               return $column->lname.', '.$column->fname.' '.substr($column->midname, 0, 1).'.';
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

    public function all_display(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\User::selectRaw('*, @row:=@row+1 as row')->where('user_type', 'client');

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('name', function($column){
               return $column->lname.', '.$column->fname.' '.substr($column->midname, 0, 1).'.';
            }) 
            ->AddColumn('actions', function($column){
              
                return '    
                            <button class="btn-sm btn btn-success reserve-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-plus"></i> Reserve
                            </button>
                        ';
            }) 
            ->rawColumns(['actions'])
            ->make(true);    
    }

    public function choose()
    {
        return view('admin.clients.choose');
    }

    public function display()
    {
        return view('admin.clients.display');
    }

}
