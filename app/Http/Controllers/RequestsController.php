<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class RequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.clients.requests');
    }

    public function index_coord()
    {
        return view('admin.clients.requests_coord');
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
        try{

            $status = \App\Reservation::destroy($id);
            if($status){
                    return response()->json(['success' => true, 'msg' => 'Approved Request!']);
                }else{
                    return response()->json(['success' => false, 'msg' => 'An error occured while sending request!']);
                }
             

        }catch(\Exception $e){
            return response()->json(['success' => false, 'msg' => 'An error occured while sending request!']);
        } 
    }

    public function destroy_coord($id)
    {
        try{

            $status = \App\Coordination::destroy($id);
            if($status){
                    return response()->json(['success' => true, 'msg' => 'Approved Request!']);
                }else{
                    return response()->json(['success' => false, 'msg' => 'An error occured while sending request!']);
                }
             

        }catch(\Exception $e){
            return response()->json(['success' => false, 'msg' => 'An error occured while sending request!']);
        } 
    }

    public function approve($id)
    {
        try{
            
            DB::beginTransaction();
            $client_notif = \App\ClientNotification::find($id);
            $client_notif->status = 'approved';
            $client_notif->save();

            if($client_notif->change_date == null){
                $this->destroy($client_notif->reservation->id);
            }else{
                $reservation = \App\Reservation::find($client_notif->reservation->id);
                $reservation->date = $client_notif->change_date;
                $reservation->save();
            }
            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Approved Request!']);

         }catch(\Exception $e){
            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'An error occured while sending request!']);
        } 
    }

    public function approve_coord($id)
    {
        try{
            
            DB::beginTransaction();
            $client_notif = \App\ClientNotificationCoord::find($id);
            $client_notif->status = 'approved';
            $client_notif->save();

            if($client_notif->change_date == null){
                $this->destroy_coord($client_notif->coordination->id);
            }else{
                $coordination = \App\Coordination::find($client_notif->coordination->id);
                $coordination->date = $client_notif->change_date;
                $coordination->save();
            }
            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Approved Request!']);

         }catch(\Exception $e){
            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'An error occured while sending request!']);
        } 
    }

    public function all(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\ClientNotification::where('status', 'pending');

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('name', function($column){
               return $column->reservation->client->user->lname.', '.$column->reservation->client->user->fname.' '.substr($column->reservation->client->user->midname, 0, 1).'. | Res. No: '.$column->reservation->id;
            })
            ->AddColumn('orig_date', function($column){
               return date('M d, Y | h:i A', strtotime($column->reservation->date));
            })
            ->AddColumn('change_date', function($column){
                if(empty($column->change_date)){
                    return 'No date';
                }else{
                    return date('M d, Y | h:i A', strtotime($column->change_date));
                }
            })
            ->AddColumn('actions', function($column){
              
                return '
                            <button class="btn-sm btn btn-info approve-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-id-card-o"></i> Approve
                            </button>
                            <button class="btn-sm btn btn-danger decline-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-trash-o"></i> Decline
                            </button> 
                        ';
            }) 
            ->rawColumns(['actions'])
            ->make(true);    
    }

    public function all_coord(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\ClientNotificationCoord::where('status', 'pending');

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('name', function($column){
               return $column->coordination->client->user->lname.', '.$column->coordination->client->user->fname.' '.substr($column->coordination->client->user->midname, 0, 1).'. | Res. No: '.$column->coordination->id;
            })
            ->AddColumn('orig_date', function($column){
               return date('M d, Y | h:i A', strtotime($column->coordination->date));
            })
            ->AddColumn('change_date', function($column){
                if(empty($column->change_date)){
                    return 'No date';
                }else{
                    return date('M d, Y | h:i A', strtotime($column->change_date));
                }
            })
            ->AddColumn('actions', function($column){
              
                return '
                            <button class="btn-sm btn btn-info approve-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-id-card-o"></i> Approve
                            </button>
                            <button class="btn-sm btn btn-danger decline-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-trash-o"></i> Decline
                            </button> 
                        ';
            }) 
            ->rawColumns(['actions'])
            ->make(true);    
    }

    public function decline($id)
    {
        try{
            
            DB::beginTransaction();
            $client_notif = \App\ClientNotification::find($id);
            $client_notif->status = 'declined';
            $client_notif->save();

            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Approved Request!']);

         }catch(\Exception $e){
            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'An error occured while sending request!']);
        } 
    }

    public function decline_coord($id)
    {
        try{
            
            DB::beginTransaction();
            $client_notif = \App\ClientNotificationCoord::find($id);
            $client_notif->status = 'declined';
            $client_notif->save();

            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Approved Request!']);

         }catch(\Exception $e){
            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'An error occured while sending request!']);
        } 
    }
}
