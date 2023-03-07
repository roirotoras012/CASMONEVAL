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
       
        return view('auth.registerKey');
    }
    public function error()
    {
        return view('auth.register-error');
    }
    public function checkKey(Request $request)
    {
        $user_key = $request['registration_key'];
        $registration_key = RegistrationKey::where('registration_key', $user_key)->first();
        // $division_ID = RegistrationKey::where('registration_key', $user_key)->first();
       
        $division_id = $registration_key->division_ID ?? null;
        $province_id = $registration_key->province_ID ?? null;
        // dd($division_id);
        if (!$registration_key) {
            return redirect()
                ->route('registerUser.error')
                ->with('error', 'Invalid User Keys');
        }
       
        if ($registration_key->Status === 'Taken') {
            return redirect()
                ->route('registerUser.error')
                ->with('error', 'Registration key already used');
        }
        $user_type_id = $registration_key->user_type_ID;
        $division_id = $registration_key->division_ID;

        if (!$division_id) {
            return redirect()
            ->route('registerUser.index', ['user-id' => $user_type_id, 'registration-key' => $user_key , 'division-id' => $division_id , "province-id" => $province_id])
            ->with('validated', 'User Validated Successfully');
        }
        return redirect()
            ->route('registerUser.index', ['user-id' => $user_type_id, 'registration-key' => $user_key , 'division-id' => $division_id])
            ->with('validated', 'User Validated Successfully');
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
