<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StrategicMeasure;

class RegionalDirector extends Controller
{
    public function index()
    {   
        $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
                            ->get(["strategic_measures.strategic_measure", "strategic_objectives.strategic_objective"]);
       
        return view("rd.dashboard", compact('labels'));
    }
}
