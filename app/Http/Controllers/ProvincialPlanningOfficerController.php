<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProvincialPlanningOfficerController extends Controller
{
    public function index()
    {
        return view('ppo.dashboard');
    }

    public function assessment()
    {
        return view('ppo.assessment');
    }

    public function profile()
    {
        return view('ppo.profile');
    }

    public function addtarget()
    {
        return view('ppo.addtarget');
    }

    public function savetarget()
    {
        return view('ppo.savetarget');
    }

    public function accomplishment()
    {
        return view('ppo.accomplishment');
    }
}
