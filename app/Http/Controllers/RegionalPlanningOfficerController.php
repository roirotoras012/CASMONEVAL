<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegionalPlanningOfficerController extends Controller
{
    public function index()
    {
        return view('rpo.dashboard');
    }

    public function assessment()
    {
        return view('rpo.assessment');
    }

    public function profile()
    {
        return view('rpo.profile');
    }

    public function addtarget()
    {
        return view('rpo.addtarget');
    }

    public function savetarget()
    {
        return view('rpo.savetarget');
    }
}
