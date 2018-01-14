<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectionController extends Controller
{
    public function selectService(Request $request, $data)
    {
        if($request->ajax())
        {
            $packages = \App\Package::where('service_id', $data)->get();
            return  view('selections.ajax-select', compact('packages'));
        }
    }

    public function selectPackage(Request $request, $data)
    {
        if($request->ajax())
        {
            $package = \App\Package::find($data);
            /*$data = ->render();
            return response()->json(['options'=>$data]);*/
            return  view('selections.ajax-select-package')->with('package', $package);
        }
    }

    public function selectBalance(Request $request, $data)
    {
        if($request->ajax())
        {
            $package = \App\Package::find($data);
            /*$data = ->render();
            return response()->json(['options'=>$data]);*/
            return $package->price;
        }
    }
}
