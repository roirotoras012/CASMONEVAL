<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StrategicMeasure;
use App\Models\AnnualTarget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class RegionalDirector extends Controller
{
    public function index()
    {
        // $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
        //                     ->get(["strategic_objectives.strategic_objective","strategic_measures.strategic_measure", "strategic_measures.strategic_objective_ID", "strategic_measures.strategic_measure_ID", "strategic_measures.strategic_objective_ID", "strategic_measures.division_ID"]);

        return view('rd.dashboard');
    }

    public function opcr_target()
    {
        $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
            // ->where('type', '=', 'DIRECT')
            ->get(['strategic_objectives.strategic_objective', 'strategic_measures.strategic_measure', 'strategic_measures.strategic_objective_ID', 'strategic_measures.strategic_measure_ID', 'strategic_measures.strategic_objective_ID', 'strategic_measures.division_ID']);

        return view('rd.opcr-target', compact('labels'));
    }
    public function updateEmailHandler(Request $request)
    {
        $userType = auth()->user()->user_type_ID;
        $userPass = auth()->user()->password;

        $user = Auth::user();

        $validatedData = $request->validate([
            'current_password' => 'required',
            'email' => 'required|email',
            'new_password' => 'nullable|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
        ]);

        if (Hash::check($request->current_password, $userPass)) {
            $user->email = $validatedData['email'];
            if (!empty($validatedData['new_password'])) {
                $user->password = Hash::make($validatedData['new_password']);
            }
            $user->save();
            return redirect()
                ->back()
                ->with('success', 'Email updated successfully.');
        } else {
            // Show an error message
            return redirect()
                ->back()
                ->with('error', 'Invalid Password');
        }
    }
    public function updatePasswordHandler(Request $request)
    {
        $userType = auth()->user()->user_type_ID;
        $userPass = auth()->user()->password;
        $user = Auth::user();
        if (Hash::check($request->current_password, $userPass)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()
                ->back()
                ->with('update-pass-success', 'Password updated successfully.');
        } else {
            return redirect()
                ->back()
                ->with('update-pass-error', ' Invalid Password');
        }
    }
    public function add_targets(Request $request)
    {
        $annual_targets = $request->data;
        foreach ($annual_targets as $annual_target) {
            if ($annual_target['BUK']) {
                $buk_target = $annual_target['BUK'];
                $buk_strategic_objective = $annual_target['strategic_objective'];
                $buk_strategic_measure = $annual_target['strategic_measure'];
                $target = new AnnualTarget();
                try {
                    $target->strategic_measures_ID = $buk_strategic_measure;
                    $target->strategic_objectives_ID = $buk_strategic_objective;
                    $target->annual_target = $buk_target;
                    $target->division_ID = $annual_target['division_ID'];
                    $target->province_ID = 1;
                    $target->save();
                } catch (Exception $e) {
                }
            }
            if ($annual_target['CAM']) {
                $cam_target = $annual_target['CAM'];
                $cam_strategic_objective = $annual_target['strategic_objective'];
                $cam_strategic_measure = $annual_target['strategic_measure'];

                $target = new AnnualTarget();
                try {
                    $target->strategic_measures_ID = $cam_strategic_measure;
                    $target->strategic_objectives_ID = $cam_strategic_objective;
                    $target->annual_target = $cam_target;
                    $target->division_ID = $annual_target['division_ID'];
                    $target->province_ID = 5;
                    $target->save();
                } catch (Exception $e) {
                }
            }
            if ($annual_target['LDN']) {
                $ldn_target = $annual_target['LDN'];
                $ldn_strategic_objective = $annual_target['strategic_objective'];
                $ldn_strategic_measure = $annual_target['strategic_measure'];
                $target = new AnnualTarget();
                try {
                    $target->strategic_measures_ID = $ldn_strategic_measure;
                    $target->strategic_objectives_ID = $ldn_strategic_objective;
                    $target->annual_target = $ldn_target;
                    $target->division_ID = $annual_target['division_ID'];
                    $target->province_ID = 2;
                    $target->save();
                } catch (Exception $e) {
                }
            }
            if ($annual_target['MISOR']) {
                $misor_target = $annual_target['MISOR'];
                $misor_strategic_objective = $annual_target['strategic_objective'];
                $misor_strategic_measure = $annual_target['strategic_measure'];
                $target = new AnnualTarget();
                try {
                    $target->strategic_measures_ID = $misor_strategic_measure;
                    $target->strategic_objectives_ID = $misor_strategic_objective;
                    $target->annual_target = $misor_target;
                    $target->province_ID = 3;
                    $target->division_ID = $annual_target['division_ID'];
                    $target->save();
                } catch (Exception $e) {
                }
            }
            if ($annual_target['MISOC']) {
                $misoc_target = $annual_target['MISOC'];
                $misoc_strategic_objective = $annual_target['strategic_objective'];
                $misoc_strategic_measure = $annual_target['strategic_measure'];
                $target = new AnnualTarget();
                try {
                    $target->strategic_measures_ID = $misoc_strategic_measure;
                    $target->strategic_objectives_ID = $misoc_strategic_objective;
                    $target->annual_target = $misoc_target;
                    $target->province_ID = 4;
                    $target->division_ID = $annual_target['division_ID'];
                    $target->save();
                } catch (Exception $e) {
                }
            }
        }

        return redirect()
            ->route('rd.index')
            ->with('success', 'Targets Added Successfully.');
        // return $request->data;
    }

    public function assessment()
    {
        return view('rd.assessment');
    }

    public function profile()
    {
        return view('rd.profile');
    }
    public function logout()
    {
        return view('rd.logout');
    }
}
