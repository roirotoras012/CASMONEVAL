<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationKey;

class RegistrationKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("auth.registerKey");
    }
    public function error()
    {
        return view("auth.register-error");
    }
    public function checkKey(Request $request)
    {
        $user_key = $request['registration_key'];
        // $user_type_id = RegistrationKey::where('registration_key',  $user_key)->first()->user_type_ID;
        if (RegistrationKey::where('registration_key',  $user_key)->exists()) {
            return redirect()->route('registerUser.index')->with('validated', "User Validated Successfully");
        }
        if(!RegistrationKey::where('registration_key',  $user_key)->exists()) {
            return redirect()->route('registerUser.error')->with('error', "Invalid User Keys");
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        // dd($request);
        $request->validate([
            'user_type_ID' => 'required|string|max:255',
            'input_userkey' => 'required',
        ]);
        RegistrationKey::create([
            'user_type_ID' => (int) $request['user_type_ID'],
            'province_ID' => (int) $request['user_province_ID'],
            'division_ID' => (int) $request['user_division_ID'],
            'Status' => 'Good',
            'registration_key' => $request['input_userkey'],
        ]);
        // User::create([$request->all()]);
        return redirect()
            ->route('users.adminView')
            ->with('success', 'User created successfully.');
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
        //
    }
}
