<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StrategicMeasure;
use App\Models\AnnualTarget;
use App\Models\Opcr;
use App\Models\User;
use App\Models\RegistrationKey;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegionalPlanningOfficerController extends Controller
{
    public function index(Request $request)
    {
        $userDetails = $request->input('userDetails');
        // dd($userDetails);
        $users = User::all();
        return view('rpo.dashboard', ['users' => $users, 'userDetails' => $userDetails]);
    }
    public function users()
    {
        $users = User::all();
        return view('rpo.manage-users', ['users' => $users]);
    }

    public function adminView()
    {
        $users = User::all();
        return view('rpo.dashboard', ['users' => $users]);
    }
    public function updateEmailHandler(Request $request)
    {
        $userType = auth()->user()->user_type_ID;
        $userDetails = auth()->user();
        
        // dd($userDetails->password);
        $user = Auth::user();

        // Check if the entered current password matches the user's password
        if (Hash::check($request->current_password,$userDetails->password)) {
            // Update the email in the database
            // $user->email = $request->email;
            // $user->save();

            
            return redirect()
                ->back()
                ->with('success', 'Email updated successfully.');
        } else {
            // Show an error message
            return redirect()
                ->back()
                ->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    }
    public function store(Request $request)
    {
        //
        // dd($request);
        $request->validate([
            'user_type_ID' => 'required|string|max:255',
            'input_userkey' => 'required',
        ]);
        RegistrationKey::create([
            'user_type_ID' => (int) $request['user_type_ID'],
            'province_ID' => (int) $request['user_province_ID'],
            'division_ID' => (int) $request['user_division_ID'],
            'Status' => 'Good',
            'registration_key' => $request['input_userkey'],
        ]);
        // User::create([$request->all()]);
        return redirect()
            ->route('rpo.users')
            ->with('success', 'User created successfully.');
    }

    public function opcr_target()
    {
        $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
            ->where('type', '=', 'DIRECT')
            ->orWhere('type', '=', 'DIRECT MAIN')
            ->get(['strategic_objectives.strategic_objective', 'strategic_measures.strategic_measure', 'strategic_measures.strategic_objective_ID', 'strategic_measures.strategic_measure_ID', 'strategic_measures.strategic_objective_ID', 'strategic_measures.division_ID', 'strategic_measures.type']);

        return view('rpo.addtarget', compact('labels'));
    }

    // public function users_view()
    // {
    //     $users = User::all();
    //     return view('rpo.index', ['users' => $users]);
    // }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $full_name = $user->first_name . ' ' . $user->last_name;
        return redirect()
            ->route('rpo.users')
            ->with('success', "$full_name  was deleted successfully.");
    }
    public function update(Request $request, User $user)
    {
        //

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            // 'extension_name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'email' => 'required|string|email|max:255',
            'user_type_ID' => 'required|integer',
            'password' => 'required',
        ]);

        $attributes = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'extension_name' => $request->extension_name,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'user_type_ID' => $request->user_type_ID,
            'password' => Hash::make($request->password),
        ];

        $user->update($attributes);

        return redirect()
            ->route('rpo.users')
            ->with('success', 'User updated successfully');
    }

    public function add_targets(Request $request)
    {
        $annual_targets = $request->data;
        $opcr = new Opcr();
        $opcr->save();

        if ($opcr->id) {
            foreach ($annual_targets as $annual_target) {
                if ($annual_target['BUK']) {
                    $buk_target = $annual_target['BUK'];
                    $buk_strategic_objective = $annual_target['strategic_objective'];
                    $buk_strategic_measure = $annual_target['strategic_measure'];
                    $target = new AnnualTarget();
                    try {
                        if ($annual_target['type'] == 'DIRECT MAIN') {
                            $measure = DB::table('strategic_measures')
                                ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                ->get();

                            foreach ($measure as $measure1) {
                                // var_dump($measure1->division_ID);
                                $target = new AnnualTarget();
                                $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                $target->annual_target = $buk_target;

                                $target->province_ID = 1;
                                $target->division_ID = $measure1->division_ID;
                                $target->opcr_id = $opcr->id;
                                $target->save();
                            }
                        } else {
                            $target = new AnnualTarget();
                            $target->strategic_measures_ID = $buk_strategic_measure;
                            $target->strategic_objectives_ID = $buk_strategic_objective;
                            $target->annual_target = $buk_target;

                            $target->province_ID = 1;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->id;
                            $target->save();
                        }
                    } catch (Exception $e) {
                    }
                }
                if ($annual_target['CAM']) {
                    $cam_target = $annual_target['CAM'];
                    $cam_strategic_objective = $annual_target['strategic_objective'];
                    $cam_strategic_measure = $annual_target['strategic_measure'];

                    $target = new AnnualTarget();
                    try {
                        if ($annual_target['type'] == 'DIRECT MAIN') {
                            $measure = DB::table('strategic_measures')
                                ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                ->get();

                            foreach ($measure as $measure1) {
                                // var_dump($measure1->division_ID);
                                $target = new AnnualTarget();
                                $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                $target->annual_target = $cam_target;

                                $target->province_ID = 5;
                                $target->division_ID = $measure1->division_ID;
                                $target->opcr_id = $opcr->id;
                                $target->save();
                            }
                        } else {
                            $target = new AnnualTarget();
                            $target->strategic_measures_ID = $cam_strategic_measure;
                            $target->strategic_objectives_ID = $cam_strategic_objective;
                            $target->annual_target = $cam_target;

                            $target->province_ID = 5;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->id;
                            $target->save();
                        }
                    } catch (Exception $e) {
                    }
                }
                if ($annual_target['LDN']) {
                    $ldn_target = $annual_target['LDN'];
                    $ldn_strategic_objective = $annual_target['strategic_objective'];
                    $ldn_strategic_measure = $annual_target['strategic_measure'];
                    $target = new AnnualTarget();
                    try {
                        if ($annual_target['type'] == 'DIRECT MAIN') {
                            $measure = DB::table('strategic_measures')
                                ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                ->get();

                            foreach ($measure as $measure1) {
                                // var_dump($measure1->division_ID);
                                $target = new AnnualTarget();
                                $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                $target->annual_target = $ldn_target;

                                $target->province_ID = 2;
                                $target->division_ID = $measure1->division_ID;
                                $target->opcr_id = $opcr->id;
                                $target->save();
                            }
                        } else {
                            $target = new AnnualTarget();
                            $target->strategic_measures_ID = $ldn_strategic_measure;
                            $target->strategic_objectives_ID = $ldn_strategic_objective;
                            $target->annual_target = $ldn_target;

                            $target->province_ID = 2;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->id;
                            $target->save();
                        }
                    } catch (Exception $e) {
                    }
                }
                if ($annual_target['MISOR']) {
                    $misor_target = $annual_target['MISOR'];
                    $misor_strategic_objective = $annual_target['strategic_objective'];
                    $misor_strategic_measure = $annual_target['strategic_measure'];
                    $target = new AnnualTarget();
                    try {
                        if ($annual_target['type'] == 'DIRECT MAIN') {
                            $measure = DB::table('strategic_measures')
                                ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                ->get();

                            foreach ($measure as $measure1) {
                                // var_dump($measure1->division_ID);
                                $target = new AnnualTarget();
                                $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                $target->annual_target = $misor_target;

                                $target->province_ID = 3;
                                $target->division_ID = $measure1->division_ID;
                                $target->opcr_id = $opcr->id;
                                $target->save();
                            }
                        } else {
                            $target = new AnnualTarget();
                            $target->strategic_measures_ID = $misor_strategic_measure;
                            $target->strategic_objectives_ID = $misor_strategic_objective;
                            $target->annual_target = $misor_target;

                            $target->province_ID = 3;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->id;
                            $target->save();
                        }
                    } catch (Exception $e) {
                    }
                }
                if ($annual_target['MISOC']) {
                    $misoc_target = $annual_target['MISOC'];
                    $misoc_strategic_objective = $annual_target['strategic_objective'];
                    $misoc_strategic_measure = $annual_target['strategic_measure'];
                    $target = new AnnualTarget();
                    try {
                        if ($annual_target['type'] == 'DIRECT MAIN') {
                            $measure = DB::table('strategic_measures')
                                ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                ->get();

                            foreach ($measure as $measure1) {
                                // var_dump($measure1->division_ID);
                                $target = new AnnualTarget();
                                $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                $target->annual_target = $misoc_target;

                                $target->province_ID = 4;
                                $target->division_ID = $measure1->division_ID;
                                $target->opcr_id = $opcr->id;
                                $target->save();
                            }
                        } else {
                            $target = new AnnualTarget();
                            $target->strategic_measures_ID = $misoc_strategic_measure;
                            $target->strategic_objectives_ID = $misoc_strategic_objective;
                            $target->annual_target = $misoc_target;

                            $target->province_ID = 4;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->id;
                            $target->save();
                        }
                    } catch (Exception $e) {
                    }
                }
            }
        }

        return redirect()
            ->route('rpo.show', $opcr->id)
            ->with('success', 'Targets Added Successfully.');
        // return $request->data;
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
        $opcr = DB::table('opcr')->get();

        return view('rpo.savetarget', compact('opcr'));
    }
    public function show($id)
    {
        $opcr_id = $id;
        $targets = DB::table('annual_targets')
            ->where('opcr_id', '=', $opcr_id)
            ->get();
        $opcr = DB::table('opcr')
            ->where('opcr_ID', '=', $opcr_id)
            ->get();

        $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
            ->where('type', '=', 'DIRECT')
            ->orWhere('type', '=', 'DIRECT MAIN')
            ->get(['strategic_objectives.strategic_objective', 'strategic_measures.strategic_measure', 'strategic_measures.strategic_objective_ID', 'strategic_measures.strategic_measure_ID', 'strategic_measures.strategic_objective_ID', 'strategic_measures.division_ID', 'strategic_measures.type']);

        foreach ($labels as $label) {
            $label['BUK'] = null;
            $label['LDN'] = null;
            $label['MISOR'] = null;
            $label['MISOC'] = null;
            $label['CAM'] = null;
            foreach ($targets as $target) {
                if ($label['strategic_measure_ID'] == $target->strategic_measures_ID) {
                    if ($target->province_ID == 1) {
                        $label['BUK'] = $target->annual_target;
                    }
                    if ($target->province_ID == 2) {
                        $label['LDN'] = $target->annual_target;
                    }
                    if ($target->province_ID == 3) {
                        $label['MISOR'] = $target->annual_target;
                    }
                    if ($target->province_ID == 4) {
                        $label['MISOC'] = $target->annual_target;
                    }
                    if ($target->province_ID == 5) {
                        $label['CAM'] = $target->annual_target;
                    }
                } else {
                }
            }
        }

        // var_dump($labels);

        return view('rpo.opcr', compact('targets', 'labels', 'opcr_id', 'opcr'));
    }
    public function update_targets(Request $request)
    {
        $annual_targets = $request->data;
        $opcr_id = $request->opcr_id;
        // var_dump( $annual_targets);

        if ($request->submit == 'update') {
            if ($opcr_id) {
                var_dump(count($annual_targets));
                foreach ($annual_targets as $annual_target) {
                    if ($annual_target['BUK']) {
                        $buk_target = $annual_target['BUK'];
                        $buk_strategic_objective = $annual_target['strategic_objective'];
                        $buk_strategic_measure = $annual_target['strategic_measure'];
                        $target = new AnnualTarget();
                        try {
                            if ($annual_target['type'] == 'DIRECT MAIN') {
                                $measure = DB::table('strategic_measures')
                                    ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                    ->get();

                                foreach ($measure as $measure1) {
                                    // var_dump($measure1->division_ID);
                                    $target = new AnnualTarget();
                                    $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                    $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                    $target->annual_target = $buk_target;

                                    $target->province_ID = 1;
                                    $target->division_ID = $measure1->division_ID;
                                    $target->opcr_id = $opcr_id;
                                    $target->save();
                                }
                            } else {
                                $target = new AnnualTarget();
                                $target->strategic_measures_ID = $buk_strategic_measure;
                                $target->strategic_objectives_ID = $buk_strategic_objective;
                                $target->annual_target = $buk_target;

                                $target->province_ID = 1;
                                $target->division_ID = $annual_target['division_ID'];
                                $target->opcr_id = $opcr_id;
                                $target->save();
                            }
                        } catch (Exception $e) {
                        }
                    }
                    if ($annual_target['CAM']) {
                        $cam_target = $annual_target['CAM'];
                        $cam_strategic_objective = $annual_target['strategic_objective'];
                        $cam_strategic_measure = $annual_target['strategic_measure'];

                        $target = new AnnualTarget();
                        try {
                            if ($annual_target['type'] == 'DIRECT MAIN') {
                                $measure = DB::table('strategic_measures')
                                    ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                    ->get();

                                foreach ($measure as $measure1) {
                                    // var_dump($measure1->division_ID);
                                    $target = new AnnualTarget();
                                    $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                    $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                    $target->annual_target = $cam_target;

                                    $target->province_ID = 5;
                                    $target->division_ID = $measure1->division_ID;
                                    $target->opcr_id = $opcr_id;
                                    $target->save();
                                }
                            } else {
                                $target = new AnnualTarget();
                                $target->strategic_measures_ID = $cam_strategic_measure;
                                $target->strategic_objectives_ID = $cam_strategic_objective;
                                $target->annual_target = $cam_target;

                                $target->province_ID = 5;
                                $target->division_ID = $annual_target['division_ID'];
                                $target->opcr_id = $opcr_id;
                                $target->save();
                            }
                        } catch (Exception $e) {
                        }
                    }
                    if ($annual_target['LDN']) {
                        $ldn_target = $annual_target['LDN'];
                        $ldn_strategic_objective = $annual_target['strategic_objective'];
                        $ldn_strategic_measure = $annual_target['strategic_measure'];
                        $target = new AnnualTarget();
                        try {
                            if ($annual_target['type'] == 'DIRECT MAIN') {
                                $measure = DB::table('strategic_measures')
                                    ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                    ->get();

                                foreach ($measure as $measure1) {
                                    // var_dump($measure1->division_ID);
                                    $target = new AnnualTarget();
                                    $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                    $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                    $target->annual_target = $ldn_target;

                                    $target->province_ID = 2;
                                    $target->division_ID = $measure1->division_ID;
                                    $target->opcr_id = $opcr_id;
                                    $target->save();
                                }
                            } else {
                                $target = new AnnualTarget();
                                $target->strategic_measures_ID = $ldn_strategic_measure;
                                $target->strategic_objectives_ID = $ldn_strategic_objective;
                                $target->annual_target = $ldn_target;

                                $target->province_ID = 2;
                                $target->division_ID = $annual_target['division_ID'];
                                $target->opcr_id = $opcr_id;
                                $target->save();
                            }
                        } catch (Exception $e) {
                        }
                    }
                    if ($annual_target['MISOR']) {
                        $misor_target = $annual_target['MISOR'];
                        $misor_strategic_objective = $annual_target['strategic_objective'];
                        $misor_strategic_measure = $annual_target['strategic_measure'];
                        $target = new AnnualTarget();
                        try {
                            if ($annual_target['type'] == 'DIRECT MAIN') {
                                $measure = DB::table('strategic_measures')
                                    ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                    ->get();

                                foreach ($measure as $measure1) {
                                    // var_dump($measure1->division_ID);
                                    $target = new AnnualTarget();
                                    $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                    $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                    $target->annual_target = $misor_target;

                                    $target->province_ID = 3;
                                    $target->division_ID = $measure1->division_ID;
                                    $target->opcr_id = $opcr_id;
                                    $target->save();
                                }
                            } else {
                                $target = new AnnualTarget();
                                $target->strategic_measures_ID = $misor_strategic_measure;
                                $target->strategic_objectives_ID = $misor_strategic_objective;
                                $target->annual_target = $misor_target;

                                $target->province_ID = 3;
                                $target->division_ID = $annual_target['division_ID'];
                                $target->opcr_id = $opcr_id;
                                $target->save();
                            }
                        } catch (Exception $e) {
                        }
                    }
                    if ($annual_target['MISOC']) {
                        $misoc_target = $annual_target['MISOC'];
                        $misoc_strategic_objective = $annual_target['strategic_objective'];
                        $misoc_strategic_measure = $annual_target['strategic_measure'];
                        $target = new AnnualTarget();
                        try {
                            if ($annual_target['type'] == 'DIRECT MAIN') {
                                $measure = DB::table('strategic_measures')
                                    ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                    ->get();

                                foreach ($measure as $measure1) {
                                    // var_dump($measure1->division_ID);
                                    $target = new AnnualTarget();
                                    $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                    $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                    $target->annual_target = $misoc_target;

                                    $target->province_ID = 4;
                                    $target->division_ID = $measure1->division_ID;
                                    $target->opcr_id = $opcr_id;
                                    $target->save();
                                }
                            } else {
                                $target = new AnnualTarget();
                                $target->strategic_measures_ID = $misoc_strategic_measure;
                                $target->strategic_objectives_ID = $misoc_strategic_objective;
                                $target->annual_target = $misoc_target;

                                $target->province_ID = 4;
                                $target->division_ID = $annual_target['division_ID'];
                                $target->opcr_id = $opcr_id;
                                $target->save();
                            }
                        } catch (Exception $e) {
                        }
                    }
                }
            }

            $max = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
                ->where('type', '=', 'DIRECT')
                ->orWhere('type', '=', 'DIRECT MAIN')
                ->orWhere('type', '=', 'DIRECT COMMON')
                ->get();

            $updated_targets = DB::table('annual_targets')
                ->where('opcr_id', '=', $opcr_id)
                ->get();
            if (count($max) * 5 > count($updated_targets)) {
                DB::table('opcr')
                    ->where('opcr_ID', $opcr_id)
                    ->update(['status' => 'INCOMPLETE']);
            } else {
                DB::table('opcr')
                    ->where('opcr_ID', $opcr_id)
                    ->update(['status' => 'COMPLETE']);
            }

            return redirect()
                ->route('rpo.show', $opcr_id)
                ->with('success', 'Targets Updated Successfully.');
        } elseif ($request->submit == 'submit') {
            DB::table('opcr')
                ->where('opcr_ID', $opcr_id)
                ->update(['is_submitted' => true]);
            return redirect()
                ->route('rpo.show', $opcr_id)
                ->with('success', 'Targets Submitted Successfully.');
        }
    }
}
