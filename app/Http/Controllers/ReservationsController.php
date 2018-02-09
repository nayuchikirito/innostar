<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationDateRequest;
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
    public function store(ReservationDateRequest $request)
    {
        // $data = request()->validate([
        //     'date' => 'required',
        //     'time' => 'required',

        // ]);
        // if($data['password']){
        //     $data['password'] = bcrypt($data['password']);
        // // }
        $dateCount = \App\Reservation::whereDate('date', $request->get('date'))->count();
        $dateCountCoord = \App\Coordination::whereDate('date', $request->get('date'))->count();
        // return response()->json($dateCount);
        if(($dateCount > 0 AND $dateCountCoord > 1) OR ($dateCount > 1) OR ($dateCountCoord > 2))
            {
                return response()->json(['success' => false, 'msg' => 'Cannot reserve date, fully booked.']);
            }else{
                 try{

                    DB::beginTransaction();

                        $reservation = new \App\Reservation;
                        $reservation->date        = $request->get('date').' '.$request->get('time').':00';
                        $reservation->status        = $request->get('status');
                        $reservation->balance      = $request->get('balance');
                        $reservation->assigned      = $request->get('assigned');
                        $reservation->client_id     = $request->get('client_id');
                        $reservation->package_id      = $request->get('package_id');
                        $reservation->save();

                        for($i = 0 ; $i < sizeof($request->get('detail')) ; $i++){
                            $r = \App\PackageDetail::find($request->get('detail')[$i]);
                            $res_detail = new \App\ReservationDetail;
                            $res_detail->reservation_id  = $reservation->id;
                            $res_detail->package_detail_id   = $r->id;
                            $res_detail->price = $r->price;
                            $res_detail->save();                    
                        }
                        DB::commit();

                        return response()->json(['success' => true, 'msg' => 'Data Successfully added!']);

                    }catch(\Exception $e){
                        DB::rollback();
                        return response()->json(['success' => false, 'msg' => 'An error occured while adding data!']);
                    }
        }
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
        $reservation = \App\Reservation::find($id);
        return view('admin.reservations.show')->with('reservation', $reservation);
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
        $reservation = \App\Reservation::find($id);
        return view('admin.reservations.edit')
        ->with('reservation', $reservation)
        ->with('services', $services);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationDateRequest $request, $id)
    {
        $dateCount = \App\Reservation::whereDate('date', $request->get('date'))->count();
        $dateCountCoord = \App\Coordination::whereDate('date', $request->get('date'))->count();
        // return response()->json($dateCount);
        if(($dateCount > 0 AND $dateCountCoord > 1) OR ($dateCount > 1) OR ($dateCountCoord > 2))
            {
                return response()->json(['success' => false, 'msg' => 'Cannot reserve date, fully booked.']);
            }else{
                 try{

                    DB::beginTransaction();

                        $reservation = \App\Reservation::find($id);
                        $reservation->date        = $request->get('date').' '.$request->get('time').':00';
                        $reservation->status        = $request->get('status');
                        $reservation->balance      = $request->get('balance');
                        $reservation->client_id     = $request->get('client_id');
                        $reservation->package_id      = $request->get('package_id');
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
        try{
            $status = \App\Reservation::destroy($id);
            if($status){
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
        $data = \App\Reservation::all();

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
               return $column->package->service->name;
            })
            ->AddColumn('actions', function($column){

                return '
                            <button class="btn-sm btn btn-success pay-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-money"></i> Pay
                            </button>
                            <button class="btn-sm btn btn-info show-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-id-card-o"></i> View
                            </button>
                            <button class="btn-sm btn btn-warning edit-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn-sm btn btn-danger delete-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-trash-o"></i> Delete
                            </button>
                            <button class="btn-sm btn btn-primary assign-data-btn" data-id="'.$column->id.'">
                                <i class="fa fa-trash-o"></i> Assign
                            </button>
                        ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function assignSuppliers($id)
    {
        $suppliers = ['Florist','Photo & Video','Reception','Souvenir','Invitation'];
        $reservation = \App\Reservation::find($id);
        $suppliersList = collect();
        foreach ($suppliers as $key => $s) {
          // $suppliersQ = \App\Supplier::where('type', $s);
          $suppliersQ = \App\Supplier::whereRaw('type = ?', [$s])->orderBy('created_at')->get();
          $assignedSuppliers = \App\AssignSupplier::where('reservation_id', $id)->get();
          $users = [];
          foreach ($suppliersQ as $supKey => $sup) {
            $user = \App\User::find($sup->user_id);
            $user["supplierId"] = $sup->id;
            foreach($assignedSuppliers as $as){
              if($as->supplier_id == $sup->id){
                $user["assignedSupplierId"] = $as->id;
                $user["assignedPrice"] = $as->price;
                $user["assignedStatus"] = $as->status;
              }
            }
            array_push($users, $user);
          }
          $suppliersList[$s] = $users;
        }
        // var_dump($suppliersList);return;
        return view('admin.reservations.assign-suppliers')
        ->with('reservation', $reservation)
        ->with('suppliers', $suppliers)
        ->with('suppliersList', $suppliersList)
        ->with('reservationId', $id);
    }
}
