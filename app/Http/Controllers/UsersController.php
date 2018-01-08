<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class UsersController extends Controller
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
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'fname' => 'required',
            'lname' => 'required',
            'midname' => 'required',
            'location' => 'required',
            'contact' => 'required',
            'user_type' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|same:password_confirm'
        ]);
        // if($data['password']){
        //     $data['password'] = bcrypt($data['password']);          
        // }

        $status = \App\User::create($data); 
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
        $user = \App\User::find($id);
        return view('admin.users.edit')->with('user', $user);
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
            'fname' => 'required',
            'lname' => 'required',
            'midname' => 'required',
            'location' => 'required',
            'contact' => 'required',
            'user_type' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:6|same:password_confirm'
        ]);
        
        $user = \App\User::find($id); 
        $user->fname = $request->get('fname');
        $user->lname = $request->get('lname');
        $user->midname = $request->get('midname');
        $user->location = $request->get('location');
        $user->contact = $request->get('contact');
        $user->user_type = $request->get('user_type');
        if($request->get('password')){
            $user->password     = bcrypt($request->get('password'));
        }
 
        if($user->save()){
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
        $status = \App\User::destroy($id); 
        if($status){
            return response()->json(['success' => true, 'msg' => 'Data Successfully deleted!']);
        }else{
            return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
        }
    }

    public function all(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\User::selectRaw('*, @row:=@row+1 as row');

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('name', function($column){
               return $column->fname.' '.$column->midname.' '.$column->lname;
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
