<?php

namespace App\Http\Controllers;
use DB;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\StrategicMeasure;
use App\Models\StrategicObjective;
use App\Models\AnnualTarget;
use App\Models\Opcr;
use App\Models\User;
use App\Models\RegistrationKey;
use App\Models\MonthlyTarget;
use App\Models\Division;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegionalPlanningOfficerController extends Controller
{
    public function index(Request $request)
    {
        $userDetails = $request->input('userDetails');
        $users = User::all();
        $user_rd = User::where('user_type_ID', '1');
        $user_rpo = User::where('user_type_ID', '2');
        $user_pd = User::where('user_type_ID', '3');
        $user_ppo = User::where('user_type_ID', '4');
        $user_dc = User::where('user_type_ID', '5');
        $totalUsers = $users->count();
        $totalUsersRD = $user_rd->count();
        $totalUsersRPO = $user_rpo->count();
        $totalUsersPD = $user_pd->count();
        $totalUsersPPO = $user_ppo->count();
        $totalUsersDC = $user_dc->count();
        return view('rpo.dashboard', ['users' => $users , 'totalUsers' => $totalUsers ,'totalUsersRD' => $totalUsersRD,
        'totalUsersRPO' => $totalUsersRPO,'totalUsersPD' => $totalUsersPD,'totalUsersPPO' => $totalUsersPPO,'totalUsersDC' => $totalUsersDC]);
    }
    public function users()
    {
        $users = User::all();
        return view('rpo.manage-users', ['users' => $users]);
    }

    // public function adminView()
    // {
    //     $users = User::all();
    //     $totalUsers = $users->count();
    //     return view('rpo.dashboard', ['users' => $users , 'totalUsers' => $totalUsers]);
    // }
    public function updateEmailHandler(Request $request)
    {
       
        $userType = auth()->user()->user_type_ID;
        $userPass = auth()->user()->password;

        $user = Auth::user();

        $validatedData = $request->validate([
            'current_password' => 'required',
            'email' => 'required|email',
            'new_password' => 'nullable|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/'
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
            ->where('strategic_objectives.is_active', '=', true)
            ->where('type', '=', 'DIRECT')
            ->orWhere('type', '=', 'DIRECT MAIN')
            ->orderBy('strategic_measures.strategic_objective_ID', 'ASC')
            ->get(['strategic_objectives.strategic_objective', 'strategic_measures.strategic_measure', 'strategic_measures.strategic_objective_ID', 'strategic_measures.strategic_measure_ID', 'strategic_measures.strategic_objective_ID', 'strategic_measures.division_ID', 'strategic_measures.type']);
        // dd($labels);

        

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
        // dd($request);
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'extension_name' => "nullable",
            'birthday' => 'required',
            'email' => 'required',
            // 'user_type_ID' => 'required',
            'password' => 'required',
            'user_ID' => 'required',
            // 'province_ID' => 'nullable',
            // 'division_ID' => 'nullable',
        ]);
        // dd($validatedData);
        $attributes = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'extension_name' => $request->extension_name,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type_ID' => (int) $request->user_type_ID,
            'province_ID' => (int) $request->province_ID ?? null,
            'division_ID' => (int) $request->division_ID ?? null,
        ];
        // dd($attributes);
        // DB::table('users')->where('user_ID', $request->user_ID)->update($attributes) ;
        $user = User::find($request->user_ID);

        
        $user->update($attributes);
        return redirect()
            ->route('rpo.users')
            ->with('success', 'User updated successfully');
            
      
    }

    public function add_targets(Request $request)
    {
        $annual_targets = $request->data;
        $opcr = new Opcr();
        $opcr->year = $request->year;
        $opcr->description = $request->description;
        $opcr->status = 'INCOMPLETE';
      
        $opcr->save();

        if ($opcr->opcr_ID) {
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
                                $target->opcr_id = $opcr->opcr_ID;
                                $target->save();
                            }
                        } else {
                            $target = new AnnualTarget();
                            $target->strategic_measures_ID = $buk_strategic_measure;
                            $target->strategic_objectives_ID = $buk_strategic_objective;
                            $target->annual_target = $buk_target;

                            $target->province_ID = 1;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->opcr_ID;
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
                                $target->opcr_id = $opcr->opcr_ID;
                                $target->save();
                            }
                        } else {
                            $target = new AnnualTarget();
                            $target->strategic_measures_ID = $cam_strategic_measure;
                            $target->strategic_objectives_ID = $cam_strategic_objective;
                            $target->annual_target = $cam_target;

                            $target->province_ID = 5;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->opcr_ID;
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
                                $target->opcr_id = $opcr->opcr_ID;
                                $target->save();
                            }
                        } else {
                            $target = new AnnualTarget();
                            $target->strategic_measures_ID = $ldn_strategic_measure;
                            $target->strategic_objectives_ID = $ldn_strategic_objective;
                            $target->annual_target = $ldn_target;

                            $target->province_ID = 2;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->opcr_ID;
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
                                $target->opcr_id = $opcr->opcr_ID;
                                $target->save();
                            }
                        } else {
                            $target = new AnnualTarget();
                            $target->strategic_measures_ID = $misor_strategic_measure;
                            $target->strategic_objectives_ID = $misor_strategic_objective;
                            $target->annual_target = $misor_target;

                            $target->province_ID = 3;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->opcr_ID;
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
                                $target->opcr_id = $opcr->opcr_ID;
                                $target->save();
                            }
                        } else {
                            $target = new AnnualTarget();
                            $target->strategic_measures_ID = $misoc_strategic_measure;
                            $target->strategic_objectives_ID = $misoc_strategic_objective;
                            $target->annual_target = $misoc_target;

                            $target->province_ID = 4;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->opcr_ID;
                            $target->save();
                        }
                    } catch (Exception $e) {
                    }
                }
            }

            $max = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
                ->where('type', '=', 'DIRECT')
                ->orWhere('type', '=', 'DIRECT MAIN')
                ->orWhere('type', '=', 'DIRECT COMMON')
                ->get();

            $updated_targets = DB::table('annual_targets')
                ->where('opcr_id', '=', $opcr->opcr_ID)
                ->get();
            if (count($max) * 5 > count($updated_targets)) {
                DB::table('opcr')
                    ->where('opcr_ID', $opcr->opcr_ID)
                    ->update(['status' => 'INCOMPLETE']);
            } else {
                DB::table('opcr')
                    ->where('opcr_ID', $opcr->opcr_ID)
                    ->update(['status' => 'COMPLETE']);
            }
        }

        return redirect()
            ->route('rpo.show', $opcr->opcr_ID)
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
        $user = Auth::user();
        $opcr_id = $id;
        $targets = DB::table('annual_targets')
            ->where('opcr_id', '=', $opcr_id)
            ->get();
        $opcr = DB::table('opcr')
            ->where('opcr_ID', '=', $opcr_id)
            ->get();

        $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
            ->where('strategic_objectives.is_active', '=', true)        
            ->where('type', '=', 'DIRECT')
            ->orWhere('type', '=', 'DIRECT MAIN')
            ->orderBy('strategic_measures.strategic_objective_ID', 'ASC')
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
                        $label['BUK_target'] = $target->annual_target_ID;
                    }
                    if ($target->province_ID == 2) {
                        $label['LDN'] = $target->annual_target;
                        $label['LDN_target'] = $target->annual_target_ID;
                    }
                    if ($target->province_ID == 3) {
                        $label['MISOR'] = $target->annual_target;
                        $label['MISOR_target'] = $target->annual_target_ID;
                    }
                    if ($target->province_ID == 4) {
                        $label['MISOC'] = $target->annual_target;
                        $label['MISOC_target'] = $target->annual_target_ID;
                    }
                    if ($target->province_ID == 5) {
                        $label['CAM'] = $target->annual_target;
                        $label['CAM_target'] = $target->annual_target_ID;
                    }
                } else {
                }
            }
        }
    
        // var_dump($labels);
        if($opcr[0]->status == 'VALIDATED' || $opcr[0]->status == 'DONE' || $opcr[0]->status == 'COMPLETE'){
            $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
            ->where('monthly_accomplishment', '!=' ,null)
            ->where('annual_targets.opcr_ID', '=' , $opcr_id)
            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['annual_target_ID']);
            foreach($monthly_targets as $monthly_target) {
                // echo "annual target ID: {$annual_target_ID}<br>";
                $annual_accom = 0;
                $validated = true;
                if(count($monthly_targets) == 12){
                    $validated = true;
                }
                else{
                    $validated = false;
                }
                foreach($monthly_target as $target) {
                    $annual_accom = intval($target->monthly_accomplishment) + intval($annual_accom);
                    if($target->validated == 'Not Validated'){
                        $validated = false;
                    }
                }

                $monthly_target->annual_accom = $annual_accom;
                $monthly_target->validated = $validated;
               
               
            }
           
        }
        else{

            $monthly_targets = null;
        }
        // dd($monthly_targets);
        // dd($monthly_targets);
        return view('rpo.opcr', compact('targets', 'labels', 'opcr_id', 'opcr', 'monthly_targets'));
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
                ->update(['is_submitted' => true, 'is_active' => true]);

                // Send notification to all 5 PPOs
            $userName = auth()->user()->username;
            $opcr = Opcr::find($opcr_id);
            $data = $userName . ' has submitted OPCR #' . $opcr_id;
            $year = $opcr->year;
            $description = $opcr->description;
            $user_ID = Auth::id();
           

            $notificationData = [
                [
                    'province_ID' => 1, // PPo Bukidnon
                    'user_type_ID' => 4, // PPO usertype ID
                    'user_ID' => $user_ID,
                    'opcr_ID' => $opcr_id,
                    'year' => $year,
                    'type' => $description,
                    'data' => $data,
                ],
                [
                    'province_ID' => 2, // PPo Lanao
                    'user_type_ID' => 4, // PPO usertype ID
                    'user_ID' => $user_ID,
                    'opcr_ID' => $opcr_id,
                    'year' => $year,
                    'type' => $description,
                    'data' => $data,
                ],
                [
                    'province_ID' => 3, // PPo MisOr
                    'user_type_ID' => 4, // PPO usertype ID
                    'user_ID' => $user_ID,
                    'opcr_ID' => $opcr_id,
                    'year' => $year,
                    'type' => $description,
                    'data' => $data,
                ],
                [
                    'province_ID' => 4, // PPo Misoc
                    'user_type_ID' => 4, // PPO usertype ID
                    'user_ID' => $user_ID,
                    'opcr_ID' => $opcr_id,
                    'year' => $year,
                    'type' => $description,
                    'data' => $data,
                ],
                [
                    'province_ID' => 5, // PPo Camiguin
                    'user_type_ID' => 4, // PPO usertype ID
                    'user_ID' => $user_ID,
                    'opcr_ID' => $opcr_id,
                    'year' => $year,
                    'type' => $description,
                    'data' => $data,
                ],
            ];

            foreach ($notificationData as $notification) {
                $newNotification = new Notification($notification);
                // dd($newNotification);
                $newNotification->save();
            }
                
                
            return redirect()
                ->route('rpo.show', $opcr_id)
                ->with('success', 'Targets Submitted Successfully.');
        }
        elseif ($request->submit == 'done') {
            DB::table('opcr')
                ->where('opcr_ID', $opcr_id)
                ->update(['is_active' => false, 'status' => 'DONE']);
                
                
                
            return redirect()
                ->route('rpo.show', $opcr_id)
                ->with('success', 'OPCR successfully marked as done');
        }
    }

    public function measures(){
        $objectives = StrategicObjective::where('is_active', '=', true)
                                        ->get();
        $divisions = Division::all();
     

        $measures = StrategicMeasure::join('strategic_objectives', 'strategic_objectives.strategic_objective_ID', '=', 'strategic_measures.strategic_objective_ID')
            ->where('strategic_measures.type', '=', 'DIRECT')
            ->orWhere('strategic_measures.type', '=', 'DIRECT MAIN')
            ->where('strategic_measures.opcr_ID', '=', null)
            ->orWhere('strategic_measures.opcr_ID', '=', 0)
            ->get(['strategic_measures.*', 'strategic_objectives.*'])
            ->groupBy(['strategic_objective_ID', 'strategic_objectives']);
        // dd($measures);
                            
        return view('rpo.measures', compact('objectives', 'divisions', 'measures')); 
              

    }

    public function add_objective(Request $request){

        $strategic_objective = new StrategicObjective();
        $strategic_objective->strategic_objective = $request->strategic_objective;
        
        $strategic_objective->save();
        session()->flash('success', 'Strategic Objective successfully created');
     
        return redirect()
                ->route('rpo.measures')
                ->with('success', 'Strategic Objective successfully created');
    }

    public function add_measure(Request $request){
        $divisions = $request->get('division');
        $strategic_measure = $request->get('strategic_measure');
       
       
        if($divisions){
           if(count($divisions) > 1){
            $strategic_measure_enity = new StrategicMeasure();
            $strategic_measure_enity->strategic_measure = $strategic_measure;
            $strategic_measure_enity->division_ID = 0;
            $strategic_measure_enity->strategic_objective_ID = $request->strategic_objective_ID;
            $strategic_measure_enity->type = 'DIRECT MAIN';
            $strategic_measure_enity->save();
            foreach ($divisions as $division) {
                $strategic_measure_enity = new StrategicMeasure();
                $strategic_measure_enity->strategic_measure = $strategic_measure;
                $strategic_measure_enity->strategic_objective_ID = $request->strategic_objective_ID;
                $strategic_measure_enity->division_ID = $division;
                $strategic_measure_enity->type = 'DIRECT COMMON';
                $strategic_measure_enity->save();
            }

           }
           if(count($divisions) == 1){
            $strategic_measure_enity = new StrategicMeasure();
            $strategic_measure_enity->strategic_measure = $strategic_measure;
            $strategic_measure_enity->division_ID = $divisions[0];
            $strategic_measure_enity->strategic_objective_ID = $request->strategic_objective_ID;
            $strategic_measure_enity->type = 'DIRECT';
            $strategic_measure_enity->save();
           }
            

        }
        else{
            return redirect()
            ->route('rpo.measures')
            ->with('error', 'No Division Selected');      

        }
        return redirect()
            ->route('rpo.measures')
            ->with('success', 'Strategic Measure successfully created');      
    }


    public function remove_objective(Request $request){
       
        $objective = StrategicObjective::find($request->objective_ID);
        $objective->is_active = false;
        $objective->save();
        return redirect()
            ->route('rpo.measures')
            ->with('success', 'Strategic Objective successfully removed');      

    }

    public function remove_measure(Request $request){

        $measure = StrategicMeasure::find($request->measure_ID);
        $measure->type = '';
        $measure->save();
        return redirect()
            ->route('rpo.measures')
            ->with('success', 'Strategic Measure successfully removed');      

    }
}
