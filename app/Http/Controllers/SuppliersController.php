<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use Hash;
use Auth;
class SuppliersController extends Controller
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
    public function home()
    {
        return view('client.suppliers.index');
    }

    public function index()
    {
        return view('admin.suppliers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.suppliers.create');
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
            'name' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
            'fname' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
            'lname' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
            'midname' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
            'location' => 'required',
            'contact' => 'required|max:11|regex:/(09)[0-9]/',
            'user_type' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|same:password_confirm',
            'type' => 'required'
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

                $supplier = new \App\Supplier;
                $supplier->type     = $request->get('type');
                $supplier->name     = $request->get('name');
                $supplier->user_id  = $user->id;
                $supplier->save();

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
        return view('admin.suppliers.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = \App\User::find($id);
        return view('admin.suppliers.edit')->with('supplier', $supplier);
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
            'name' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
            'fname' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
            'lname' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
            'midname' => 'required|string|max:30|regex:/^[a-zA-Z ]+$/u',
            'location' => 'required',
            'contact' => 'required|max:11|regex:/(09)[0-9]{9}/',
            'user_type' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'required|string|min:6|same:password_confirm',
            'type' => 'required'
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

                $supplier = \App\Supplier::find($user->supplier->id);
                $supplier->type     = $request->get('type');
                $supplier->name     = $request->get('name');
                $supplier->user_id  = $user->id;
                $supplier->save();

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
            $status = \App\Supplier::destroy($user->supplier->id);
            $status2 = \App\User::destroy($id);
            if($status && $status2){
                return response()->json(['success' => true, 'msg' => 'Data Successfully deleted!']);
            }else{
                return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
            }
        }catch(\Illuminate\Database\QueryException $e){
            return response()->json(['success' => false, 'msg' => 'Cannot delete. Supplier has transactions']);
        }
        
    }

    public function all(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\User::selectRaw('*, @row:=@row+1 as row')->where('user_type', 'suppliers');

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('name', function($column){
               return $column->supplier->name;
            }) 
            ->AddColumn('type', function($column){
               return $column->supplier->type;
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

    public function requests(){
        return view('client.suppliers.requests');
    }

    public function accept_request($id){
            
        //check if request has already supplier
            //if true
                //notification only marked as "closed" and notify supplier that reservation detail has already a supplier
            //if false
                //notification only marked as "accepted" and notify supplier that "You are now the supplier of the reservation..." 

        $notification = \App\SupplierNotification::find($id); 
        if($notification->reservation_detail->supplier_id){
            $sn = \App\SupplierNotification::where('reservation_detail_id', $notification->reservation_detail->id)
                                             ->where('status', '!=', 'accepted')
                                             ->update(['status' => 'closed']);
            return response()->json(['success' => false, 'msg' => 'Sorry! The reservation has already a supplier!']);
        }else{
            $sn = \App\SupplierNotification::find($id);
            $sn->status = 'accepted'; 
            $sn->seen = 1; 
            $sn->save();
            $sn2 = \App\SupplierNotification::where('reservation_detail_id', $notification->reservation_detail->id)
                                             ->where('status', '!=', 'accepted')
                                             ->update(['status' => 'closed']);

            $res_d = \App\ReservationDetail::find($notification->reservation_detail->id);
            $res_d->supplier_id = $notification->supplier_id;
            $stat = $res_d->save();

            $naay_sud = \App\ReservationDetail::where('reservation_id', $notification->reservation_detail->reservation_id)->whereNull('supplier_id')->get(); 

            if(sizeof($naay_sud) == 0){
                $res = \App\Reservation::find($notification->reservation_detail->reservation_id);
                $res->assigned = 1;
                $res->save();
            }
            if($stat){
                return response()->json(['success' => true, 'msg' => 'You are now the supplier of this request!']);
            }else{
                return response()->json(['success' => false, 'msg' => 'An error occurred please try again later.']);
            }
        } 
    }

    public function decline_request($id){
            $sn = \App\SupplierNotification::find($id);
            $sn->status = 'declined'; 
            $sn->save();
            
            if($res_d->save()){
                return response()->json(['success' => true, 'msg' => 'You declined this request!']);
            }else{
                return response()->json(['success' => false, 'msg' => 'An error occurred please try again later.']);
            }
    }
    public function seen_request($id){
            $sn = \App\SupplierNotification::find($id);
            $sn->status = 'ignored'; 
            $sn->seen = 1; 
            $sn->save();
            
            if($res_d->save()){
                return response()->json(['success' => true, 'msg' => 'You mark this request as seen!']);
            }else{
                return response()->json(['success' => false, 'msg' => 'An error occurred please try again later.']);
            }
    }


    public function changepassword(){
        return view('client.users.c_changepass');
    }


    public function saveChangePassword(Request $request){

        $data = request()->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:5|same:confirm_password',
            'confirm_password' => 'required|string|min:5',
        ]); 
        if(Hash::check($request->old_password, Auth::user()->password)){
            $user = \App\User::findOrFail(Auth::user()->id); 
            $user->password = $request->new_password;
            if($user->save()){
                return response()->json(['success' => true, 'msg' => 'Password Successfully changed!']);                
            }else{
                return response()->json(['success' => false, 'msg' => 'An error occurred while changing password!']);   
            }
        }else{
            return response()->json(['success' => false, 'msg' => 'Old Password does not match!']);
        }
    }
}

