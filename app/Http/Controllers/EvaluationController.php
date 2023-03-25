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

        $validatedData = $request->validate([
            'reason' => 'required',
        ]);

        $evaluation = Evaluation::find($request->input('evaluation_ID'));
        $evaluation->reason = $request->input('reason');
        $evaluation->save();
        return redirect()
                ->back()
                ->with('update', 'Reason added successfully.');
    }
}
