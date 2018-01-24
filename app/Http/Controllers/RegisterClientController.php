<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.clients.create');
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
        //
    }
}
