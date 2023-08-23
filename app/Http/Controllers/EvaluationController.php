<?php

namespace App\Http\Controllers;
use App\Models\Division;
use App\Models\Evaluation;
use App\Models\Opcr;
use App\Models\Notification;
use App\Models\Driver;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
class EvaluationController extends Controller
{
    function evaluation()
    {
        return view('dc/evaluation');
    }

    function addReason(Request $request)
    {
        $evaluation = Evaluation::find($request->input('evaluation_ID'));
        if ($request->input('reason') !== null) {
            $evaluation->reason = $request->input('reason');
            $evaluation->save();

            $userName = auth()->user()->first_name;
            $provinceID = auth()->user()->province_ID;
            $divisionID = auth()->user()->division_ID;
            $userTypeID = auth()->user()->user_type_ID;
            $opcr_id = $request->input('opcr_id');
            $opcr = Opcr::find($opcr_id);

            $data = $userName . ' has added reason for not hitting the target';

            $user_ID = Auth::id();

            $notification = new Notification([
                'user_type_ID' => 3, // Notify to PD
                'user_ID' => $user_ID,
                // 'division_ID' => $divisionID,
                'province_ID' => $provinceID,
                'opcr_ID' => $opcr_id,
                // 'year' => $opcr->year,
                'type' => 'Division Chief Evaluation',
                'data' => $data,
            ]);

            //  dd($notification);
            $notification->save();

            Alert::success('Reason updated successfully.');

            return redirect()->back();

            // return redirect()
            //     ->back()
            //     ->with('update', 'Reason added successfully.');
        }
    }
    

    function addRemark(Request $request)
    {
        $evaluation = Evaluation::find($request->input('evaluation_ID'));

        if ($request->input('remark') !== null) {
            $evaluation->remark = $request->input('remark');
            $evaluation->comment = $request->input('comment');

            $userName = auth()->user()->first_name;
            $provinceID = auth()->user()->province_ID;
            $userTypeID = auth()->user()->user_type_ID;

            $data = $userName . ' has added remarks';

            $user_ID = Auth::id();

            $divisionName = $request->input('division');
            $divisionMap = [
                'Business Development Division' => 'BDD',
                'Consumer Protective Division' => 'CPD',
                'Finance Administrative Division' => 'FAD',
            ];
            $division = Division::where('division', $divisionName)->first();

            if ($division) {
                $divisionNameAcronym = $divisionMap[$division->division] ?? $division->division;
                $evalDiv = [
                    'division' => $divisionNameAcronym,
                ];

                // Set division_ID based on divisionNameAcronym value
                $divisionID = null;
                switch ($divisionNameAcronym) {
                    case 'BDD':
                        $divisionID = 1;
                        break;
                    case 'CPD':
                        $divisionID = 2;
                        break;
                    case 'FAD':
                        $divisionID = 3;
                        break;
                }
            } else {
                // Handle the case where the Division model with the given division name does not exist
            }

            $notification = new Notification([
                'user_type_ID' => 5, // Notify to DC
                'user_ID' => $user_ID,
                'division_ID' => $divisionID,
                'province_ID' => $provinceID,
                // 'opcr_ID' => $opcr_id,
                'type' => $divisionNameAcronym,
                'data' => $data,
            ]);

            // dd($notification);
            // dd($evaluation);
            $notification->save();

            $evaluation->save();

            return redirect()
                ->back()
                ->with('update', 'Remark added successfully.');
        }
    }
}
