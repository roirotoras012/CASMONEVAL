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

            return redirect()
                ->back()
                ->with('update', 'Reason added successfully.');
        }
    }

    function addRemark(Request $request)
    {
        $evaluation = Evaluation::find($request->input('evaluation_ID'));

        if ($request->input('remark') !== null) {
            $evaluation->remark = $request->input('remark');
            $evaluation->save();

            // $userName = auth()->user()->first_name;
            // $provinceID = auth()->user()->province_ID;
            // $userTypeID = auth()->user()->user_type_ID;
            // $opcr_id = $request->input('opcr_id');
            // $opcr = Opcr::find($opcr_id);

            // $data = $userName . ' has added remarks';

            // $user_ID = Auth::id();

            // // Define an array of division IDs and corresponding division names
            // $divisions = [
            //     1 => 'BDD',
            //     2 => 'CPD',
            //     3 => 'FAD',
            // ];

            // // Loop through the division IDs and create a notification for each division
            // foreach ($divisions as $divisionID => $divisionName) {
            //     $notification = new Notification([
            //         'user_type_ID' => 5, // Notify to DC
            //         'user_ID' => $user_ID,
            //         'division_ID' => $divisionID,
            //         'province_ID' => $provinceID,
            //         // 'opcr_ID' => $opcr_id,
            //         'type' => 'Division Chief Evaluation',
            //         'data' => $data,
            //     ]);

            //     // Add the division name to the notification message
            //     $message = $data . ' for ' . $divisionName;
            //     $notification->data = $message;
            //     dd($notification);
            //     $notification->save();
            // }

            return redirect()
                ->back()
                ->with('update', 'Remark added successfully.');
        }
    }
}
