<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\AssignSupplier;
use App\Reservation;
use App\Supplier;

class AssignSuppliersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function assign(Request $request){
      $obj = new AssignSupplier;

      if(!empty($request->assignSupplierId)){
        $obj = AssignSupplier::find($request->assignSupplierId);
      }

      $obj->price = $request->price;
      $obj->status = $request->status;
      $obj->reservation_id = intval($request->reservationId);
      $obj->supplier_id = intval($request->supplierId);
      var_dump($obj);
      $obj->save();

      return response()->json($obj);
    }
}
