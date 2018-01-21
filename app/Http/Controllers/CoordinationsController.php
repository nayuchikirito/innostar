<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CoordinationDateRequest;
use DataTables;
use DB;


class CoordinationsController extends Controller
{

    public function index()
    {
        return view('admin.coordinations.index');
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
    public function store(CoordinationDateRequest $request)
    {
        // $data = request()->validate([
        //     // 'date' => 'required',
            
        // ]);
        // if($data['password']){
        //     $data['password'] = bcrypt($data['password']);          
        // }
        $dateCount = \App\Reservation::whereDate('date', $request->get('date'))->count();
        $dateCountCoord = \App\Coordination::whereDate('date', $request->get('date'))->count();
        // return response()->json($dateCount);
        if(($dateCount > 0 AND $dateCountCoord > 1) OR ($dateCount > 1) OR ($dateCountCoord > 2))
            {
                return response()->json(['success' => false, 'msg' => 'Cannot reserve date, fully booked.']);
            }else{
                 try{

                    DB::beginTransaction();

                        $reservation = new \App\Coordination;
                        $reservation->date        = $request->get('date').' '.$request->get('time').':00';
                        $reservation->status        = $request->get('status');
                        $reservation->balance      = $request->get('balance');
                        $reservation->client_id     = $request->get('client_id');
                        $reservation->service_id      = $request->get('service_id');
                        $reservation->save();

                        DB::commit();

                        return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);

                    }catch(\Exception $e){
                        DB::rollback();
                        return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
                    } 
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
        $coordination = \App\Coordination::find($id);
        return view('admin.coordinations.show')->with('coordination', $coordination);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $services = \App\Service::all();
        $coordination = \App\Coordination::find($id);
        return view('admin.coordinations.edit')
        ->with('coordination', $coordination)
        ->with('services', $services);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CoordinationDateRequest $request, $id)
    {
        // $data = request()->validate([
        //     // 'date' => 'required',
        //     'time' => 'required',
        //     'status' => 'required',
        //     'balance' => 'required|numeric',
        //     'client_id' => 'required',
        //     'service_id' => 'required',
        // ]);

        // if($data['password']){
        //     $data['password'] = bcrypt($data['password']);          
        // }
        $dateCount = \App\Reservation::whereDate('date', $request->get('date'))->count();
        $dateCountCoord = \App\Coordination::whereDate('date', $request->get('date'))->count();
        // return response()->json($dateCount);
        if(($dateCount > 0 AND $dateCountCoord > 1) OR ($dateCount > 1) OR ($dateCountCoord > 2))
            {
                return response()->json(['success' => false, 'msg' => 'Cannot reserve date, fully booked.']);
            }else{
                 try{

                    DB::beginTransaction();

                        $reservation = \App\Coordination::find($id);
                        $reservation->date        = $request->get('date').' '.$request->get('time').':00';
                        $reservation->status        = $request->get('status');
                        $reservation->balance      = $request->get('balance');
                        $reservation->client_id     = $request->get('client_id');
                        $reservation->service_id      = $request->get('service_id');
                        $reservation->save();

                        DB::commit();

                        return response()->json(['success' => true, 'msg' => 'Data Successfully edited!']);

                    }catch(\Exception $e){
                        DB::rollback();
                        return response()->json(['success' => false, 'msg' => 'An error occured while editing data!']);
                    } 
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
        //
    }

    public function all(){
        DB::statement(DB::raw('set @row:=0'));
        $data = \App\Coordination::all();

         return DataTables::of($data)
            ->AddColumn('row', function($column){
               return $column->id;
            })
            ->AddColumn('date', function($column){
               return date('M d, Y | h:i A', strtotime($column->date));
            })
            ->AddColumn('client', function($column){
               return $column->client->user->lname.', '.$column->client->user->fname.' '.substr($column->client->user->midname, 0, 1).'.';
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
}
