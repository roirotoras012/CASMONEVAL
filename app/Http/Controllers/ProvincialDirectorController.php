<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProvincialDirectorController extends Controller
{
    public function index()
    {
        return view('pd.dashboard');
    }

    public function assessment()
    {
        return view('pd.assessment');
    }

    public function profile()
    {
        return view('pd.profile');
    }

    public function addtarget()
    {
        return view('pd.addtarget');
    }

    public function savetarget()
    {
        return view('pd.savetarget');
    }

    public function accomplishment()
    {
        return view('pd.accomplishment');
    }
}
