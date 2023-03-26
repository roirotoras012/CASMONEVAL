<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluationController extends Controller
{
    function evaluation() {
        return view('dc/evaluation');
    }

    function addReason(Request $request) {

        $evaluation = Evaluation::find($request->input('evaluation_ID'));
        if($request->input('reason') !== null){
            $evaluation->reason = $request->input('reason');
            $evaluation->save();
    

            return redirect()
                ->back()
                ->with('update', 'Reason added successfully.');
        }
        if($request->input('remark') !== null){
            $evaluation->remark = $request->input('remark');
            $evaluation->save();
    

            return redirect()
                ->back()
                ->with('update', 'Remark added successfully.');
        }
        
        
    }
}
