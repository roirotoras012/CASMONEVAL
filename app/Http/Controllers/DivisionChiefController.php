<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DivisionChiefController extends Controller
{
    public function index()
    {
        return view('dc.dashboard');
    }

    public function jobfam()
    {
        return view('dc.job-fam');
    }

    public function accomplishment()
    {
        return view('dc.accomplishment');
    }

    public function profile()
    {
        return view('dc.profile');
    }

    public function coaching()
    {
        return view('dc.coaching');
    }
}
