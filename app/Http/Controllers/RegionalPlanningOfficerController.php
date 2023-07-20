<?php

namespace App\Http\Controllers;
use DB;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Pgs;
use App\Models\StrategicMeasure;
use App\Models\StrategicObjective;
use App\Models\AnnualTarget;
use App\Models\Opcr;
use App\Models\User;
use App\Models\RegistrationKey;
use App\Models\MonthlyTarget;
use App\Models\Division;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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

        
        $user_rd_details = User::where('user_type_ID', 1)->get(['first_name', 'last_name', 'middle_name','birthday','email','username','user_ID']);
        $user_rpo_details =User::where('user_type_ID', 2)->get(['first_name', 'last_name', 'middle_name','birthday','email','username','user_ID']);
        $user_pd_details = User::where('user_type_ID', 3)->get(['first_name', 'last_name', 'middle_name','birthday','email','username','user_ID']);
        $user_ppo_details =User::where('user_type_ID', 4)->get(['first_name', 'last_name', 'middle_name','birthday','email','username','user_ID']);
        $user_dc_details = User::where('user_type_ID', 5)->get(['first_name', 'last_name', 'middle_name','birthday','email','username','user_ID']);

        $totalUsers = $users->count();
        $totalUsersRD = $user_rd->count();
        $totalUsersRPO = $user_rpo->count();
        $totalUsersPD = $user_pd->count();
        $totalUsersPPO = $user_ppo->count();
        $totalUsersDC = $user_dc->count();
        return view('rpo.dashboard', ['users' => $users,'user_dc_details'=> $user_dc_details,'user_pd_details'=> $user_pd_details,'user_rpo_details'=> $user_rpo_details,'user_ppo_details'=> $user_ppo_details, 'user_rd_details'=> $user_rd_details, 'totalUsers' => $totalUsers, 'totalUsersRD' => $totalUsersRD, 'totalUsersRPO' => $totalUsersRPO, 'totalUsersPD' => $totalUsersPD, 'totalUsersPPO' => $totalUsersPPO, 'totalUsersDC' => $totalUsersDC]);
    }
    public function users()
    {
        $users = User::all();
        $userRegistrationKeys = RegistrationKey::all();
        return view('rpo.manage-users', ['users' => $users, 'userRegistrationKeys' => $userRegistrationKeys]);
    }
    public function updateProfileHandler(Request $request) {

      
        $userID = auth()->user()->user_ID;

       
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'extension_name' => 'nullable',
            'birthday' => 'required',
        ]);
        $attributes = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'extension_name' => $request->extension_name,
            'birthday' => $request->birthday,
        ];

      
        $user = User::find($userID);
        $user->update($attributes);
        Alert::success('User profile updated successfully');
        return redirect()->back();

    }
    public function updateEmailHandler(Request $request , User $user)
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
            Alert::success('Email updated successfully');

          
            return redirect()
            ->back();
            // return redirect()
            //     ->back()
            //     ->with('success', 'Email updated successfully.');
        } else {
            // Show an error message
            Alert::error('Invalid Password');

           
            // return redirect()
            // ->back()
            // ->with('error', 'Invalid Password');
            return redirect()
                ->back();
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
            Alert::success('Password updated successfully');

            // toast('Password updated successfully', 'success');
            // return redirect()
            // ->back()
            // ->with('update-pass-success', 'Password updated successfully.');
            return redirect()
                ->back();
        } else {
            Alert::error('Invalid Password');
            // toast('Invalid Password','error');
            // return redirect()
            // ->back()
            // ->with('update-pass-error', ' Invalid Password');
            return redirect()
                ->back();
        }
    }

    public function store(Request $request)
    {
        //
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
        Alert::success('User created successfully');

        // return redirect()
        //     ->route('rpo.users')
        //     ->with('success', 'User created successfully.');
        return redirect()
            ->route('rpo.users');
    }

    public function opcr_target()
    {
        $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
            ->where('strategic_objectives.is_active', '=', true)
            ->where('type', '=', 'DIRECT')
            ->orWhere('type', '=', 'DIRECT MAIN')
            ->orderBy('strategic_objectives.objective_letter', 'ASC')
            ->orderByRaw('CAST(strategic_measures.number_measure AS UNSIGNED) ASC')
            ->orderBy('strategic_measures.created_at', 'ASC')
            ->get(['strategic_measures.is_sub','strategic_measures.sum_of','strategic_objectives.objective_letter', 'strategic_objectives.strategic_objective', 'strategic_measures.strategic_measure', 'strategic_measures.strategic_objective_ID', 'strategic_measures.strategic_measure_ID', 'strategic_measures.strategic_objective_ID', 'strategic_measures.division_ID', 'strategic_measures.type', 'strategic_measures.number_measure']);
        // dd($labels);

        return view('rpo.addtarget', compact('labels'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $full_name = $user->first_name . ' ' . $user->last_name;

        Alert::success("$full_name was Deleted Successfully");
        return redirect()
        ->route('rpo.users');

        // return redirect()
        //     ->route('rpo.users')
        //     ->with('success', "$full_name  was deleted successfully.");
    }

    public function statusupdate(Request $request,User $user)
    {
        //    dd($request);
            $user = User::find($request->user_ID);
            $user->status = $request->statusSelect;
            $user->save();
            Alert::success("User Status Updated Successfully");
            return redirect()
            ->route('rpo.users');
            // return redirect()
            //     ->route('rpo.users')
            //     ->with('success', 'User Disabled successfully');
    }



    public function update(Request $request, User $user)
    {
      
       
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'extension_name' => 'nullable',
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
            'status' => "active"
        ];
    
        //  dd($attributes);
        // DB::table('users')->where('user_ID', $request->user_ID)->update($attributes) ;
        if (!isset($request->province_ID)) {
            $attributes['province_ID'] = null;
        }
        if (!isset($request->division_ID)) {
            $attributes['division_ID'] = null;
        }

        $user = User::find($request->user_ID);

        $user->update($attributes);
        Alert::success('User updated successfully');

        return redirect()
            ->route('rpo.users');
    }

    public function add_targets(Request $request)
    {

        // dd($request->data);
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
                    // dd($annual_target['buk_target_type']);
                    $target_type = isset($annual_target['buk_target_type']) ? 'PERCENTAGE' : null;
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
                                $target->type = $target_type;
                                
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
                            $target->type = $target_type;
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
                    $target_type = isset($annual_target['cam_target_type']) ? 'PERCENTAGE' : null;
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
                                $target->type = $target_type;
                                $target->opcr_id = $opcr->opcr_ID;
                                $target->save();
                            }
                        } else {
                            $target = new AnnualTarget();
                            $target->strategic_measures_ID = $cam_strategic_measure;
                            $target->strategic_objectives_ID = $cam_strategic_objective;
                            $target->annual_target = $cam_target;
                            $target->type = $target_type;
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
                    $target_type = isset($annual_target['ldn_target_type']) ? 'PERCENTAGE' : null;
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
                                $target->type = $target_type;
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
                            $target->type = $target_type;
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
                    $target_type = isset($annual_target['misor_target_type']) ? 'PERCENTAGE' : null;
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
                                $target->type = $target_type;
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
                            $target->type = $target_type;
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
                    $target_type = isset($annual_target['misoc_target_type']) ? 'PERCENTAGE' : null;
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
                                $target->type = $target_type;
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
                            $target->type = $target_type;
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
        Alert::success('Targets Added Successfully.');
        return redirect()
            ->route('rpo.show', $opcr->opcr_ID);
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
        $opcr = DB::table('opcr')
        ->where('deleted_at', null)
        ->get();

        return view('rpo.savetarget', compact('opcr'));
    }

    public function archive()
    {
        $opcr = DB::table('opcr')
        ->where('deleted_at', '!=', null)
        ->get();

        return view('rpo.archive', compact('opcr'));
    }

    public function show($id)
    {

      
        $user = Auth::user();
        $opcr_id = $id;
        $max = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
        ->where('type', '=', 'DIRECT')
        ->orWhere('type', '=', 'DIRECT MAIN')
        ->orWhere('type', '=', 'DIRECT COMMON')
        ->get();

    
        $targets = DB::table('annual_targets')
            ->where('opcr_id', '=', $opcr_id)
            ->get();
        $opcr = DB::table('opcr')
            ->where('opcr_ID', '=', $opcr_id)
            ->get();
     
        $file = null;
        
        if ($opcr[0]->status == 'DONE') {
            $file = FileUpload::where('opcr_ID', '=', $opcr_id)
                ->get()
                ->first();
        }

        $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
            ->where('strategic_objectives.is_active', '=', true)
            ->where('type', '=', 'DIRECT')
            ->orWhere('type', '=', 'DIRECT MAIN')
            ->orderBy('strategic_objectives.objective_letter', 'ASC')
            ->orderByRaw('CAST(strategic_measures.number_measure AS UNSIGNED) ASC')
            ->orderBy('strategic_measures.created_at', 'ASC')
            ->get(['strategic_measures.is_sub','strategic_measures.sum_of','strategic_objectives.objective_letter', 'strategic_objectives.strategic_objective', 'strategic_measures.strategic_measure', 'strategic_measures.strategic_objective_ID', 'strategic_measures.strategic_measure_ID', 'strategic_measures.strategic_objective_ID', 'strategic_measures.division_ID', 'strategic_measures.type', 'strategic_measures.number_measure']);

       
        
        if ($opcr[0]->status == 'VALIDATED' || $opcr[0]->status == 'DONE' || $opcr[0]->status == 'COMPLETE') {
            $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
                ->where('monthly_accomplishment', '!=', null)
                ->where('annual_targets.opcr_ID', '=', $opcr_id)
                ->where('monthly_targets.validated', '=', 'Validated')
                ->get(['monthly_targets.*', 'annual_targets.*'])
                ->groupBy(['annual_target_ID']);
            foreach ($monthly_targets as $monthly_target) {
                // echo "annual target ID: {$annual_target_ID}<br>";
               
                if ($monthly_target) {
                }

                $annual_accom = 0;
                $validated = true;

                foreach ($monthly_target as $target) {
                    $annual_accom = intval($target->monthly_accomplishment) + intval($annual_accom);
                }

                
                
                if($monthly_target->first()->type == 'PERCENTAGE'){
                    $monthly_target->annual_accom = $annual_accom / count($monthly_target);  
                }
                else{
                    $monthly_target->annual_accom = $annual_accom;
                }
                $monthly_target->validated = $validated;
            }
        } else {
            $monthly_targets = null;
        }
        // dd($monthly_targets);


        $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
        ->where('strategic_objectives.is_active', '=', true)
        ->where('type', '=', 'DIRECT')
        ->orWhere('type', '=', 'DIRECT MAIN')
        ->orderBy('strategic_objectives.objective_letter', 'ASC')
        ->orderByRaw('CAST(strategic_measures.number_measure AS UNSIGNED) ASC')
        ->orderBy('strategic_measures.created_at', 'ASC')
        ->get(['strategic_measures.is_sub','strategic_measures.sum_of','strategic_objectives.objective_letter', 'strategic_objectives.strategic_objective', 'strategic_measures.strategic_measure', 'strategic_measures.strategic_objective_ID', 'strategic_measures.strategic_measure_ID', 'strategic_measures.strategic_objective_ID', 'strategic_measures.division_ID', 'strategic_measures.type', 'strategic_measures.number_measure']);
 
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
                        $label['target_type'] = $target->type;

                     
                    }
                    if ($target->province_ID == 2) {
                        $label['LDN'] = $target->annual_target;
                        $label['LDN_target'] = $target->annual_target_ID;
                        $label['target_type'] = $target->type;
                    }
                    if ($target->province_ID == 3) {
                        $label['MISOR'] = $target->annual_target;
                        $label['MISOR_target'] = $target->annual_target_ID;
                        $label['target_type'] = $target->type;
                    }
                    if ($target->province_ID == 4) {
                        $label['MISOC'] = $target->annual_target;
                        $label['MISOC_target'] = $target->annual_target_ID;
                        $label['target_type'] = $target->type;
                    }
                    if ($target->province_ID == 5) {
                        $label['CAM'] = $target->annual_target;
                        $label['CAM_target'] = $target->annual_target_ID;
                        $label['target_type'] = $target->type;
                    }
                } else {
                }
            }

            if ($label->division_ID == 0) {
                $measure_for_common = StrategicMeasure::join('annual_targets', 'annual_targets.strategic_measures_ID', '=', 'strategic_measures.strategic_measure_ID')
                    ->where('annual_targets.opcr_id', '=', $opcr_id)
                    ->where('annual_targets.strategic_objectives_ID', '=', $label->strategic_objective_ID)
                    ->where('type', '=', 'DIRECT COMMON')
                    ->where('strategic_measure', '=', $label->strategic_measure)
                    ->get()
                    ->groupBy('province_ID');

                // dd($measure_for_common );
                // dd($measure_for_common[2]);
                if (!isset($label['BUK_accom']) && isset($measure_for_common[1])) {
                    foreach ($measure_for_common[1] as $by_province) {
                        # code...
                        // dd($by_province);
                        $label['BUK_accom_validated'] = true;
                        // dd(count($measure_for_common[1]));
                        if (isset($monthly_targets[$by_province->annual_target_ID])) {
                            $label['BUK_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;
                            // dd($monthly_targets[$by_province->annual_target_ID]->validated);

                            if ($monthly_targets[$by_province->annual_target_ID]->validated == false) {
                                $label['BUK_accom_validated'] = false;
                            }
                        } else {
                            $label['BUK_accom_validated'] = false;
                        }
                    }
                }
                if (isset($label['BUK_accom']) && $label['BUK_accom_validated']) {
                    $label['BUK_accom'] = $label['BUK_accom'] / count($measure_for_common[1]);
                }

                if (!isset($label['LDN_accom']) && isset($measure_for_common[2])) {
                    foreach ($measure_for_common[2] as $by_province) {
                        # code...
                        if (isset($monthly_targets[$by_province->annual_target_ID])) {
                            $label['LDN_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;

                            if ($monthly_targets[$by_province->annual_target_ID]->validated == true) {
                                $label['LDN_accom_validated'] = true;
                            }
                            if ($monthly_targets[$by_province->annual_target_ID]->validated == false) {
                                $label['LDN_accom_validated'] = false;
                            }
                        }
                    }
                }
                if (isset($label['LDN_accom']) && $label['LDN_accom_validated']) {
                    $label['LDN_accom'] = $label['LDN_accom'] / 3;
                }
                if (!isset($label['MISOR_accom']) && isset($measure_for_common[3])) {
                    foreach ($measure_for_common[3] as $by_province) {
                        # code...
                        if (isset($monthly_targets[$by_province->annual_target_ID])) {
                            $label['MISOR_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;

                            if ($monthly_targets[$by_province->annual_target_ID]->validated == true) {
                                $label['MISOR_accom_validated'] = true;
                            }
                            if ($monthly_targets[$by_province->annual_target_ID]->validated == false) {
                                $label['MISOR_accom_validated'] = false;
                            }
                        }
                    }
                }
                if (isset($label['MISOR_accom']) && $label['MISOR_accom_validated']) {
                    $label['MISOR_accom'] = $label['MISOR_accom'] / 3;
                }

                if (!isset($label['MISOC_accom']) && isset($measure_for_common[4])) {
                    foreach ($measure_for_common[4] as $by_province) {
                        # code...
                        if (isset($monthly_targets[$by_province->annual_target_ID])) {
                            $label['MISOC_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;

                            if ($monthly_targets[$by_province->annual_target_ID]->validated == true) {
                                $label['MISOC_accom_validated'] = true;
                            }
                            if ($monthly_targets[$by_province->annual_target_ID]->validated == false) {
                                $label['MISOC_accom_validated'] = false;
                            }
                        }
                    }
                }
                if (isset($label['MISOC_accom']) && $label['MISOC_accom_validated']) {
                    $label['MISOC_accom'] = $label['MISOC_accom'] / 3;
                }
                if (!isset($label['CAM_accom']) && isset($measure_for_common[5])) {
                    foreach ($measure_for_common[5] as $by_province) {
                        # code...
                        if (isset($monthly_targets[$by_province->annual_target_ID])) {
                            $label['CAM_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;

                            if ($monthly_targets[$by_province->annual_target_ID]->validated == true) {
                                $label['CAM_accom_validated'] = true;
                            }
                            if ($monthly_targets[$by_province->annual_target_ID]->validated == false) {
                                $label['CAM_accom_validated'] = false;
                            }
                        }
                    }
                }
                if (isset($label['CAM_accom']) && $label['CAM_accom_validated']) {
                    $label['CAM_accom'] = $label['CAM_accom'] / 3;
                }
            }
            
           
            if(isset($label->sum_of)){  
                
                $measures_exploded = explode(',', $label->sum_of);
              
                for ($i=1; $i <= 5; $i++) { 
                    $sum = 0;
                    foreach ($measures_exploded as $measure_exploded) {
                        $target_for_exploded = AnnualTarget::where('opcr_ID', '=', $opcr_id)
                        ->where('province_ID', $i)
                        ->where('strategic_measures_ID', $measure_exploded)
                        ->first();

                        if(isset($target_for_exploded)){

                            $sum += $target_for_exploded->annual_target;
                        }
                        // dd($target_for_exploded);
                    }
                
                    $measure_multiple = DB::table('strategic_measures')
                                ->where('strategic_measure', '=', $label->strategic_measure)
                               
                                ->where(function ($query) {
                                    $query->where('type', '=', 'DIRECT COMMON')->orWhere('type', '=', 'DIRECT MAIN')->orWhere('type', '=', 'DIRECT');
                                })
                                ->get();
                              
                    foreach ($measure_multiple as $measure_multiple_items) {
                        if($sum > 0){
                            $target_for_sum1 = AnnualTarget::where('opcr_ID', '=', $opcr_id)
                                                    ->where('province_ID', $i)
                                                    ->where('strategic_measures_ID', $measure_multiple_items->strategic_measure_ID)
                                                    ->first();
                          
    
                                if(!isset($target_for_sum1)){
    
                                    $target = new AnnualTarget();
                                    $target->strategic_measures_ID = $measure_multiple_items->strategic_measure_ID;
                                    $target->strategic_objectives_ID = $measure_multiple_items->strategic_objective_ID;
                                    $target->annual_target = $sum;
                    
                                    $target->province_ID = $i;
                                    $target->division_ID = $measure_multiple_items->division_ID;
                                    
                                                    
                                    $target->opcr_id = $opcr_id;
                                               
                                    $target->save();
                                   
                                }
                                else{
                                   
                                    $target = AnnualTarget::find($target_for_sum1->annual_target_ID);
                                    $target->annual_target = $sum;
                                    $target->save();
                                    // dd($target);
                                }
    
                        
                                if ($i == 1) {
                                    $label['BUK'] = $sum;
                                    $label['BUK_target'] = $target->annual_target_ID;
                                    $label['target_type'] = $target->type;
    
                                 
                                }
                                
                                if ($i == 2) {
                                    $label['LDN'] = $sum;
                                    $label['LDN_target'] = $target->annual_target_ID;
                                    $label['target_type'] = $target->type;
                                  
                                }
                                if ($i == 3) {
                                    $label['MISOR'] = $sum;
                                    $label['MISOR_target'] = $target->annual_target_ID;
                                    $label['target_type'] = $target->type;
                                }
                                if ($i == 4) {
                                    $label['MISOC'] = $sum; 
                                    $label['MISOC_target'] = $target->annual_target_ID;
                                    $label['target_type'] = $target->type;
                                }
                                if ($i == 5) {
                                    $label['CAM'] = $sum;
                                    $label['CAM_target'] = $target->annual_target_ID;
                                    $label['target_type'] = $target->type;
                                }
                      
                                 
                                        
                                   
                                
                        }
                    }           

                
                
                 
                }

              
                

              

            }
        }
        
        $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
        ->where('strategic_objectives.is_active', '=', true)
        ->where('type', '=', 'DIRECT')
        ->orWhere('type', '=', 'DIRECT MAIN')
        ->orderBy('strategic_objectives.objective_letter', 'ASC')
        ->orderByRaw('CAST(strategic_measures.number_measure AS UNSIGNED) ASC')
        ->orderBy('strategic_measures.created_at', 'ASC')
        ->get(['strategic_measures.is_sub','strategic_measures.sum_of','strategic_objectives.objective_letter', 'strategic_objectives.strategic_objective', 'strategic_measures.strategic_measure', 'strategic_measures.strategic_objective_ID', 'strategic_measures.strategic_measure_ID', 'strategic_measures.strategic_objective_ID', 'strategic_measures.division_ID', 'strategic_measures.type', 'strategic_measures.number_measure']);
 
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
                        $label['target_type'] = $target->type;

                     
                    }
                    if ($target->province_ID == 2) {
                        $label['LDN'] = $target->annual_target;
                        $label['LDN_target'] = $target->annual_target_ID;
                        $label['target_type'] = $target->type;
                    }
                    if ($target->province_ID == 3) {
                        $label['MISOR'] = $target->annual_target;
                        $label['MISOR_target'] = $target->annual_target_ID;
                        $label['target_type'] = $target->type;
                    }
                    if ($target->province_ID == 4) {
                        $label['MISOC'] = $target->annual_target;
                        $label['MISOC_target'] = $target->annual_target_ID;
                        $label['target_type'] = $target->type;
                    }
                    if ($target->province_ID == 5) {
                        $label['CAM'] = $target->annual_target;
                        $label['CAM_target'] = $target->annual_target_ID;
                        $label['target_type'] = $target->type;
                    }
                } else {
                }
            }

            if ($label->division_ID == 0) {
                $measure_for_common = StrategicMeasure::join('annual_targets', 'annual_targets.strategic_measures_ID', '=', 'strategic_measures.strategic_measure_ID')
                    ->where('annual_targets.opcr_id', '=', $opcr_id)
                    ->where('annual_targets.strategic_objectives_ID', '=', $label->strategic_objective_ID)
                    ->where('type', '=', 'DIRECT COMMON')
                    ->where('strategic_measure', '=', $label->strategic_measure)
                    ->get()
                    ->groupBy('province_ID');

                // dd($measure_for_common );
                // dd($measure_for_common[2]);
                if (!isset($label['BUK_accom']) && isset($measure_for_common[1])) {
                    foreach ($measure_for_common[1] as $by_province) {
                        # code...
                        // dd($by_province);
                        $label['BUK_accom_validated'] = true;
                        // dd(count($measure_for_common[1]));
                        if (isset($monthly_targets[$by_province->annual_target_ID])) {
                            $label['BUK_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;
                            // dd($monthly_targets[$by_province->annual_target_ID]->validated);

                            if ($monthly_targets[$by_province->annual_target_ID]->validated == false) {
                                $label['BUK_accom_validated'] = false;
                            }
                        } else {
                            $label['BUK_accom_validated'] = false;
                        }
                    }
                }
                if (isset($label['BUK_accom']) && $label['BUK_accom_validated']) {
                    $label['BUK_accom'] = $label['BUK_accom'] / count($measure_for_common[1]);
                }

                if (!isset($label['LDN_accom']) && isset($measure_for_common[2])) {
                    foreach ($measure_for_common[2] as $by_province) {
                        # code...
                        if (isset($monthly_targets[$by_province->annual_target_ID])) {
                            $label['LDN_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;

                            if ($monthly_targets[$by_province->annual_target_ID]->validated == true) {
                                $label['LDN_accom_validated'] = true;
                            }
                            if ($monthly_targets[$by_province->annual_target_ID]->validated == false) {
                                $label['LDN_accom_validated'] = false;
                            }
                        }
                    }
                }
                if (isset($label['LDN_accom']) && $label['LDN_accom_validated']) {
                    $label['LDN_accom'] = $label['LDN_accom'] / 3;
                }
                if (!isset($label['MISOR_accom']) && isset($measure_for_common[3])) {
                    foreach ($measure_for_common[3] as $by_province) {
                        # code...
                        if (isset($monthly_targets[$by_province->annual_target_ID])) {
                            $label['MISOR_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;

                            if ($monthly_targets[$by_province->annual_target_ID]->validated == true) {
                                $label['MISOR_accom_validated'] = true;
                            }
                            if ($monthly_targets[$by_province->annual_target_ID]->validated == false) {
                                $label['MISOR_accom_validated'] = false;
                            }
                        }
                    }
                }
                if (isset($label['MISOR_accom']) && $label['MISOR_accom_validated']) {
                    $label['MISOR_accom'] = $label['MISOR_accom'] / 3;
                }

                if (!isset($label['MISOC_accom']) && isset($measure_for_common[4])) {
                    foreach ($measure_for_common[4] as $by_province) {
                        # code...
                        if (isset($monthly_targets[$by_province->annual_target_ID])) {
                            $label['MISOC_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;

                            if ($monthly_targets[$by_province->annual_target_ID]->validated == true) {
                                $label['MISOC_accom_validated'] = true;
                            }
                            if ($monthly_targets[$by_province->annual_target_ID]->validated == false) {
                                $label['MISOC_accom_validated'] = false;
                            }
                        }
                    }
                }
                if (isset($label['MISOC_accom']) && $label['MISOC_accom_validated']) {
                    $label['MISOC_accom'] = $label['MISOC_accom'] / 3;
                }
                if (!isset($label['CAM_accom']) && isset($measure_for_common[5])) {
                    foreach ($measure_for_common[5] as $by_province) {
                        # code...
                        if (isset($monthly_targets[$by_province->annual_target_ID])) {
                            $label['CAM_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;

                            if ($monthly_targets[$by_province->annual_target_ID]->validated == true) {
                                $label['CAM_accom_validated'] = true;
                            }
                            if ($monthly_targets[$by_province->annual_target_ID]->validated == false) {
                                $label['CAM_accom_validated'] = false;
                            }
                        }
                    }
                }
                if (isset($label['CAM_accom']) && $label['CAM_accom_validated']) {
                    $label['CAM_accom'] = $label['CAM_accom'] / 3;
                }
            }
            
           
            if(isset($label->sum_of)){  
                
                $measures_exploded = explode(',', $label->sum_of);
              
                for ($i=1; $i <= 5; $i++) { 
                    $sum = 0;
                    foreach ($measures_exploded as $measure_exploded) {
                        $target_for_exploded = AnnualTarget::where('opcr_ID', '=', $opcr_id)
                        ->where('province_ID', $i)
                        ->where('strategic_measures_ID', $measure_exploded)
                        ->first();

                        if(isset($target_for_exploded)){

                            $sum += $target_for_exploded->annual_target;
                        }
                        // dd($target_for_exploded);
                    }
                
                    $measure_multiple = DB::table('strategic_measures')
                                ->where('strategic_measure', '=', $label->strategic_measure)
                               
                                ->where(function ($query) {
                                    $query->where('type', '=', 'DIRECT COMMON')->orWhere('type', '=', 'DIRECT MAIN')->orWhere('type', '=', 'DIRECT');
                                })
                                ->get();
                 
                    foreach ($measure_multiple as $measure_multiple_items) {
                        if($sum > 0){
                            $target_for_sum1 = AnnualTarget::where('opcr_ID', '=', $opcr_id)
                                                    ->where('province_ID', $i)
                                                    ->where('strategic_measures_ID', $measure_multiple_items->strategic_measure_ID)
                                                    ->first();
                            // dd( $target_for_sum1);
    
                                if(!isset($target_for_sum1)){
    
                                    $target = new AnnualTarget();
                                    $target->strategic_measures_ID = $measure_multiple_items->strategic_measure_ID;
                                    $target->strategic_objectives_ID = $measure_multiple_items->strategic_objective_ID;
                                    $target->annual_target = $sum;
                    
                                    $target->province_ID = $i;
                                    $target->division_ID = $measure_multiple_items->division_ID;
                                    
                                                    
                                    $target->opcr_id = $opcr_id;
                                               
                                    $target->save();
                                   
                                }
                                else{
                                   
                                    $target = AnnualTarget::find($target_for_sum1->annual_target_ID);
                                    $target->annual_target = $sum;
                                    $target->save();
                                    // dd($target);
                                }
    
                        
                                if ($i == 1) {
                                    $label['BUK'] = $sum;
                                    $label['BUK_target'] = $target->annual_target_ID;
                                    $label['target_type'] = $target->type;
    
                                 
                                }
                                
                                if ($i == 2) {
                                    $label['LDN'] = $sum;
                                    $label['LDN_target'] = $target->annual_target_ID;
                                    $label['target_type'] = $target->type;
                                  
                                }
                                if ($i == 3) {
                                    $label['MISOR'] = $sum;
                                    $label['MISOR_target'] = $target->annual_target_ID;
                                    $label['target_type'] = $target->type;
                                }
                                if ($i == 4) {
                                    $label['MISOC'] = $sum; 
                                    $label['MISOC_target'] = $target->annual_target_ID;
                                    $label['target_type'] = $target->type;
                                }
                                if ($i == 5) {
                                    $label['CAM'] = $sum;
                                    $label['CAM_target'] = $target->annual_target_ID;
                                    $label['target_type'] = $target->type;
                                }
                      
                                 
                                        
                                   
                                
                        }
                    }           

                
                
                 
                }

              
                

              

            }
        }
        

        $monthly_targets2 = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')

            ->where('annual_targets.opcr_ID', '=', $opcr_id)

            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['strategic_measures_ID']);

        foreach ($monthly_targets2 as $monthly_target2) {
            // echo count($monthly_target2);

            $monthly_target2->total_targets = null;
            $monthly_target2->first_sem = null;
            $monthly_target2->second_sem = null;
            $monthly_target2->first_qrtr = null;
            $monthly_target2->second_qrtr = null;
            $monthly_target2->third_qrtr = null;
            $monthly_target2->fourth_qrtr = null;

            $monthly_target2->total_accom = null;
            $monthly_target2->first_sem_accom = null;
            $monthly_target2->second_sem_accom = null;
            $monthly_target2->first_qrtr_accom = null;
            $monthly_target2->second_qrtr_accom = null;
            $monthly_target2->third_qrtr_accom = null;
            $monthly_target2->fourth_qrtr_accom = null;

            $total_accom = null;
            $first_sem_accom = null;
            $second_sem_accom = null;
            $first_qrtr_accom = null;
            $second_qrtr_accom = null;
            $third_qrtr_accom = null;
            $fourth_qrtr_accom = null;

            foreach ($monthly_target2 as $target2) {
                # code...
                if ($target2->validated == 'Validated') {
                    $monthly_target2->total_accom += $target2->monthly_accomplishment;

                    if ($target2->month == 'jan' || $target2->month == 'feb' || $target2->month == 'mar' || $target2->month == 'apr' || $target2->month == 'may' || $target2->month == 'jun') {
                        $monthly_target2->first_sem_accom += $target2->monthly_accomplishment;
                        if ($target2->month == 'jan' || $target2->month == 'feb' || $target2->month == 'mar') {
                            $monthly_target2->first_qrtr_accom += $target2->monthly_accomplishment;
                        }
                        if ($target2->month == 'apr' || $target2->month == 'may' || $target2->month == 'jun') {
                            $monthly_target2->second_qrtr_accom += $target2->monthly_accomplishment;
                        }
                    }
                    if ($target2->month == 'jul' || $target2->month == 'aug' || $target2->month == 'sep' || $target2->month == 'oct' || $target2->month == 'nov' || $target2->month == 'dec') {
                        $monthly_target2->second_sem_accom += $target2->monthly_accomplishment;

                        if ($target2->month == 'jul' || $target2->month == 'aug' || $target2->month == 'sep') {
                            $monthly_target2->third_qrtr_accom += $target2->monthly_accomplishment;
                        }
                        if ($target2->month == 'oct' || $target2->month == 'nov' || $target2->month == 'dec') {
                            $monthly_target2->fourth_qrtr_accom += $target2->monthly_accomplishment;
                        }
                    }
                }

                $monthly_target2->total_targets += $target2->monthly_target;

                if ($target2->month == 'jan' || $target2->month == 'feb' || $target2->month == 'mar' || $target2->month == 'apr' || $target2->month == 'may' || $target2->month == 'jun') {
                    $monthly_target2->first_sem += $target2->monthly_target;

                    if ($target2->month == 'jan' || $target2->month == 'feb' || $target2->month == 'mar') {
                        $monthly_target2->first_qrtr += $target2->monthly_target;
                    }
                    if ($target2->month == 'apr' || $target2->month == 'may' || $target2->month == 'jun') {
                        $monthly_target2->second_qrtr += $target2->monthly_target;
                    }
                }
                if ($target2->month == 'jul' || $target2->month == 'aug' || $target2->month == 'sep' || $target2->month == 'oct' || $target2->month == 'nov' || $target2->month == 'dec') {
                    $monthly_target2->second_sem += $target2->monthly_target;

                    if ($target2->month == 'jul' || $target2->month == 'aug' || $target2->month == 'sep') {
                        $monthly_target2->third_qrtr += $target2->monthly_target;
                    }
                    if ($target2->month == 'oct' || $target2->month == 'nov' || $target2->month == 'dec') {
                        $monthly_target2->fourth_qrtr += $target2->monthly_target;
                    }
                }


            }
            
            if($monthly_target2->first()->type == 'PERCENTAGE'){
           
            $monthly_target2->total_targets = (($monthly_target2->total_targets)/12 )/ 5;
        $monthly_target2->first_sem = ($monthly_target2->first_sem/6) / 5;
        $monthly_target2->second_sem = ($monthly_target2->second_sem/6/5);
        $monthly_target2->first_qrtr = ($monthly_target2->first_qrtr/3)/5;
        $monthly_target2->second_qrtr = ($monthly_target2->third_qrtr/3)/5;
        $monthly_target2->third_qrtr = ($monthly_target2->third_qrtr/3)/5;
        $monthly_target2->fourth_qrtr = ($monthly_target2->fourth_qrtr/3)/5;

        $monthly_target2->total_accom =  ($monthly_target2->total_accom/12)/5;
        $monthly_target2->first_sem_accom =  ($monthly_target2->first_sem_accom/6)/5;
        $monthly_target2->second_sem_accom =  ($monthly_target2->second_sem_accom/6)/5;
        $monthly_target2->first_qrtr_accom = ($monthly_target2->first_qrtr_accom/3)/5;
        $monthly_target2->second_qrtr_accom = ($monthly_target2->second_qrtr_accom/3)/5;
        $monthly_target2->third_qrtr_accom = ($monthly_target2->third_qrtr_accom/3)/5;
        $monthly_target2->fourth_qrtr_accom = ($monthly_target2->fourth_qrtr_accom/3)/5;
        }
            // dd($monthly_target2);
            # code...
        }
        // dd($labels);
        // var_dump($labels);
        // dd($monthly_targets2);
        // dd($monthly_targets);

        //pgs rating

        $total_number_of_valid_measures = AnnualTarget::join('strategic_measures', 'annual_targets.strategic_measures_ID', '=', 'strategic_measures.strategic_measure_ID')
            ->where('annual_targets.opcr_ID', $opcr_id)
           
            ->where(function ($query) {
                $query->where('strategic_measures.type', '=', 'DIRECT')->orWhere('strategic_measures.type', '=', 'DIRECT MAIN');
            })
            ->where(function ($query) {
                $query->whereNull('strategic_measures.is_sub')->orWhere('strategic_measures.is_sub', '!=', 1);
            })
          
            ->select('strategic_measures.is_sub','annual_targets.*', 'strategic_measures.strategic_measure', DB::raw('(SELECT SUM(monthly_accomplishment) FROM monthly_targets WHERE monthly_targets.annual_target_ID = annual_targets.annual_target_ID && (monthly_targets.validated = "Validated")) AS total_accomplishment'))
        
            ->get()
            ->groupBy('strategic_measures_ID');
            
    
        $total_number_of_accomplished_measure = 0;
        foreach ($total_number_of_valid_measures as $total_number_of_valid_measure) {
            $total_number_of_valid_measure->total_accom = 0;
            $total_number_of_valid_measure->total_target = 0;
            foreach ($total_number_of_valid_measure as $acc_meas) {
                
                $total_number_of_valid_measure->total_accom += $acc_meas->total_accomplishment;
                $total_number_of_valid_measure->total_target += $acc_meas->annual_target;
                // if (($acc_meas->total_accomplishment / $acc_meas->annual_target) * 100 > 90) {
                //     $total_number_of_accomplished_measure++;
                // }
              if($acc_meas->type == 'PERCENTAGE'){
                $total_number_of_valid_measure->target_type = 'PERCENTAGE';
              }
              else{
                $total_number_of_valid_measure->target_type = null;
              }
            }
           
            if($total_number_of_valid_measure->target_type == 'PERCENTAGE'){
                
                $total_number_of_valid_measure->total_target = $total_number_of_valid_measure->total_target / count($total_number_of_valid_measure);
                $total_number_of_valid_measure->total_accom = ($total_number_of_valid_measure->total_accom / 12)/count($total_number_of_valid_measure);
            }

            if (($total_number_of_valid_measure->total_accom / $total_number_of_valid_measure->total_target) * 100 >= 90) {
                $total_number_of_accomplished_measure++;
            }
        }
        // dd($total_number_of_valid_measures[495]);    
        $total_number_of_valid_measures2 = MonthlyTarget::join('annual_targets', 'monthly_targets.annual_target_ID', '=', 'annual_targets.annual_target_ID')
            ->join('strategic_measures', 'strategic_measures.strategic_measure_ID', '=', 'annual_targets.strategic_measures_ID')
            ->where('annual_targets.opcr_ID', $opcr_id)

            ->where(function ($query) {
                $query->where('strategic_measures.type', '=', 'DIRECT')->orWhere('strategic_measures.type', '=', 'DIRECT MAIN');
            })
            ->where(function ($query) {
                $query->whereNull('strategic_measures.is_sub')->orWhere('strategic_measures.is_sub', '!=', 1);
            })
            ->select('monthly_targets.*', 'annual_targets.*', 'strategic_measures.strategic_measure')
            
            ->get()
            ->groupBy('strategic_measures_ID');
     
        $valid_meas[0]['val'] = 0;
        
        $valid_meas[1]['val']= 0;
        $valid_meas[2]['val']= 0;
        $valid_meas[3]['val']= 0;
        $valid_meas[4]['val']= 0;
        $valid_meas[5]['val']= 0;
        $valid_meas[6]['val']= 0;
        $valid_meas[7]['val']= 0;
        $valid_meas[8]['val']= 0;
        $valid_meas[9]['val']= 0;
        $valid_meas[10]['val']= 0;
        $valid_meas[11]['val']= 0;
        
      
        // dd($valid_meas);
        foreach ($total_number_of_valid_measures2 as $total_number_of_valid_measure2) {
            $valid_meas[0]['exist'] = false;
            $valid_meas[1]['exist']= false;
            $valid_meas[2]['exist']= false;
            $valid_meas[3]['exist']= false;
            $valid_meas[4]['exist']= false;
            $valid_meas[5]['exist']= false;
            $valid_meas[6]['exist']= false;
            $valid_meas[7]['exist']= false;
            $valid_meas[8]['exist']= false;
            $valid_meas[9]['exist']= false;
            $valid_meas[10]['exist']= false;
            $valid_meas[11]['exist']= false;
            foreach ($total_number_of_valid_measure2 as $acc_meas2) {

                
                
                    if ($acc_meas2->month == 'jan' && !$valid_meas[0]['exist']) {
                        $valid_meas[0]['val']++;
                        $valid_meas[0]['exist'] = true;
                    } elseif ($acc_meas2->month == 'feb' && !$valid_meas[1]['exist']) {
                        $valid_meas[1]['val']++;
                        $valid_meas[1]['exist'] = true;
                    } elseif ($acc_meas2->month == 'mar' && !$valid_meas[2]['exist']) {
                        $valid_meas[2]['val']++;
                        $valid_meas[2]['exist'] = true;
                    } elseif ($acc_meas2->month == 'apr' && !$valid_meas[3]['exist']) {
                        $valid_meas[3]['val']++;
                        $valid_meas[3]['exist'] = true;
                    } elseif ($acc_meas2->month == 'may' && !$valid_meas[4]['exist']) {
                        $valid_meas[4]['val']++;
                        $valid_meas[4]['exist'] = true;
                    } elseif ($acc_meas2->month == 'jun' && !$valid_meas[5]['exist']) {
                        $valid_meas[5]['val']++;
                        $valid_meas[5]['exist'] = true;
                    } elseif ($acc_meas2->month == 'jul' && !$valid_meas[6]['exist']) {
                        $valid_meas[6]['val']++;
                        $valid_meas[6]['exist'] = true;
                    } elseif ($acc_meas2->month == 'aug' && !$valid_meas[7]['exist']) {
                        $valid_meas[7]['val']++;
                        $valid_meas[7]['exist'] = true;
                    } elseif ($acc_meas2->month == 'sep' && !$valid_meas[8]['exist']) {
                        $valid_meas[8]['val']++;
                        $valid_meas[8]['exist'] = true;
                    } elseif ($acc_meas2->month == 'oct' && !$valid_meas[9]['exist']) {
                        $valid_meas[9]['val']++;
                        $valid_meas[9]['exist'] = true;
                    } elseif ($acc_meas2->month == 'nov' && !$valid_meas[10]['exist']) {
                        $valid_meas[10]['val']++;
                        $valid_meas[10]['exist'] = true;
                    } elseif ($acc_meas2->month == 'dec' && !$valid_meas[11]['exist']) {
                        $valid_meas[11]['val']++;
                        $valid_meas[11]['exist'] = true;
                    }
    

                
                

                
            }
        }
        
            // dd($total_number_of_valid_measures2);
        //  dd($valid_meas);
        // dd($total_number_of_accomplished_measure);
        $pgsratingtext = '';
        $rating_bg_color = '';
        $pgsrating = Pgs::where('total_num_of_targeted_measure', $total_number_of_valid_measures->count())
            ->where('actual_num_of_accomplished_measure', $total_number_of_accomplished_measure)
            ->select('numeric')
            ->first();

            if ($pgsrating !== null) {
                if ($pgsrating->numeric == 5.0) {
                    $pgsratingtext = 'Outstanding';
                    $rating_bg_color = '#92d050';
                } elseif ($pgsrating->numeric >= 4.5) {
                    $pgsratingtext = 'Very Satisfactory';
                    $rating_bg_color = '#ffff00';
                } elseif ($pgsrating->numeric >= 3.25) {
                    $pgsratingtext = 'Satisfactory';
                    $rating_bg_color = '#9bc2e6';
                } elseif ($pgsrating->numeric >= 2.5) {
                    $pgsratingtext = 'Below Satisfactory';
                    $rating_bg_color = '#ffa7d3';
                } elseif ($pgsrating->numeric < 2.5) {
                    $pgsratingtext = 'Poor';
                    $rating_bg_color = '#ff0000';
                }
            }

        // PGS array
        $pgs = [
            'total_number_of_valid_measures' => $total_number_of_valid_measures->count(),
            'total_number_of_accomplished_measure' => $total_number_of_accomplished_measure,
            'numerical_rating' => $pgsrating !== null ? $pgsrating->numeric : null,
            'rating' => $pgsratingtext,
            'rating_bg_color' => $rating_bg_color,
            'monthly_valid' => $valid_meas,
        ];
        // dd($pgs);
        for ($i = 0; $i < count($valid_meas); $i++) {
            # code...
            $pgsrating2[$i] = Pgs::where('total_num_of_targeted_measure', $valid_meas[$i])

                ->get()
                ->groupBy('actual_num_of_accomplished_measure');
        }
        //    dd($pgsrating2);
        // dd($pgsrating2);
        // dd($total_number_of_valid_measures2);
        $updated_targets = DB::table('annual_targets')
        ->where('opcr_id', '=', $opcr_id)
        ->get();
        // dd(count($max), count($updated_targets));
       
        if($opcr[0]->status != 'DONE') {
            if (count($max) * 5 > count($updated_targets)) {
                DB::table('opcr')
                    ->where('opcr_ID', $opcr_id)
                    ->update(['status' => 'INCOMPLETE']);
            } else {
                DB::table('opcr')
                    ->where('opcr_ID', $opcr_id)
                    ->update(['status' => 'COMPLETE']);
                    $opcr[0]->status = 'COMPLETE';
                    
            }
        }


        return view('rpo.opcr', compact('targets', 'labels', 'opcr_id', 'opcr', 'monthly_targets', 'file', 'monthly_targets2', 'pgs', 'pgsrating2'));
    }
    public function update_targets(Request $request)
    {
        $annual_targets = $request->data;
        $opcr_id = $request->opcr_id;
        // var_dump( $annual_targets);
        // dd($annual_targets);
        if ($request->submit == 'update') {
            if ($opcr_id) {
                var_dump(count($annual_targets));
                foreach ($annual_targets as $annual_target) {
                    if ($annual_target['BUK']) {
                        $buk_target = $annual_target['BUK'];
                        $buk_strategic_objective = $annual_target['strategic_objective'];
                        $buk_strategic_measure = $annual_target['strategic_measure'];
                        $target_type = isset($annual_target['buk_target_type']) ? 'PERCENTAGE' : null;
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
                                    $target->type = $target_type;
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
                                $target->type = $target_type;
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
                        $target_type = isset($annual_target['cam_target_type']) ? 'PERCENTAGE' : null;
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
                                    $target->type = $target_type;
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
                                $target->type = $target_type;
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
                        $target_type = isset($annual_target['ldn_target_type']) ? 'PERCENTAGE' : null;
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
                                    $target->type = $target_type;
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
                                $target->type = $target_type;
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
                        $target_type = isset($annual_target['misor_target_type']) ? 'PERCENTAGE' : null;
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
                                    $target->type = $target_type;
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
                                $target->type = $target_type;
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
                        $target_type = isset($annual_target['misoc_target_type']) ? 'PERCENTAGE' : null;
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
                                    $target->type = $target_type;
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
                                $target->type = $target_type;
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
            Alert::success('Targets Updated Successfully.');
            return redirect()
                ->route('rpo.show', $opcr_id);
        } elseif ($request->submit == 'submit') {
            $opcrExists = DB::table('opcr')
                ->where('is_active', true)
                ->exists();
            if ($opcrExists) {
                Alert::error('OPCR cannot be submitted. An active OPCR already exists.');
                return redirect()->back();
                // return redirect()
                //     ->route('rpo.show', $opcr_id)
                //     ->with('error', 'OPCR cannot be submitted. An active OPCR already exists.');
            } else {
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
        } elseif ($request->submit == 'done') {
            DB::table('opcr')
                ->where('opcr_ID', $opcr_id)
                ->update(['is_active' => false, 'status' => 'DONE']);
            Alert::success('OPCR successfully marked as done');

            // return redirect()
            //     ->route('rpo.show', $opcr_id)
            //     ->with('success', 'OPCR successfully marked as done');
                
            return redirect()
            ->route('rpo.show', $opcr_id);
        }
        else if($request->submit == 'update_target'){
            // dd($request);
        
            $validatedData = $request->validate([
                'new_target' => 'required',
                'target_id' => 'required',
            ]);
        
            // Find the AnnualTarget based on the prov_target value
            $annualTarget = AnnualTarget::find($validatedData['target_id']);
        
            // Check if the target exists
            if (!$annualTarget) {
                Alert::error('Annual Target not found!');

                // return redirect()->back()->with('error', 'Annual Target not found!');
                return redirect()->back();
            }
        
            // Update the annual_target column
            $annualTarget->type = $request->target_type == 'on' ? 'PERCENTAGE' : null;
            $annualTarget->annual_target = $validatedData['new_target'];
            $annualTarget->save();
            Alert::success('Annual Target successfully updated!');
            return redirect()
            ->route('rpo.show', $annualTarget->opcr_id);
        }
    }

    public function measures()
    {
        $opcrs = Opcr::where('is_active', 1)
            ->where('is_submitted', '=', 1)
            ->get();
        if (count($opcrs) > 0) {
            $opcr_gotActive = true;
        } else {
            $opcr_gotActive = false;
        }
        $objectives = StrategicObjective::where('is_active', '=', true)
            ->orderBy('objective_letter', 'asc')
            ->get();
        $divisions = Division::all();

        $measures = StrategicMeasure::join('strategic_objectives', 'strategic_objectives.strategic_objective_ID', '=', 'strategic_measures.strategic_objective_ID')
            ->where('strategic_measures.type', '=', 'DIRECT')
            ->orWhere('strategic_measures.type', '=', 'DIRECT MAIN')
            ->where('strategic_measures.opcr_ID', '=', null)
            ->orWhere('strategic_measures.opcr_ID', '=', 0)
            ->orderByRaw('CAST(strategic_measures.number_measure AS UNSIGNED) ASC')
            ->orderBy('strategic_measures.created_at', 'ASC')
            ->get(['strategic_measures.*', 'strategic_objectives.*'])
            ->groupBy(['strategic_objective_ID', 'strategic_objectives']);
        // dd($measures);

        return view('rpo.measures', compact('objectives', 'divisions', 'measures', 'opcr_gotActive', 'opcrs'));
    }

    public function add_objective(Request $request)
    {
        $strategic_objective = new StrategicObjective();
        $strategic_objective->strategic_objective = $request->strategic_objective;
        $strategic_objective->objective_letter = $request->objective_letter;
        $strategic_objective->save();
        session()->flash('success', 'Strategic Objective successfully created');
        Alert::success('Strategic Objective successfully created');

        return redirect()
            ->route('rpo.measures');
    }

    public function add_measure(Request $request)
    {
        $divisions = $request->get('division');
        $strategic_measure = $request->get('strategic_measure');
        $number_measure = $request->get('number_measure');
        if($request->get('sub_measure') == 'on'){
        $is_sub = 1;
        }
        else{
            $is_sub = null;
        }
       
        // dd($request->accountable_division);
        if ($divisions) {
            if (count($divisions) > 1) {
                // $strategic_measure_enity = new StrategicMeasure();
                // $strategic_measure_enity->strategic_measure = $strategic_measure;
                // $strategic_measure_enity->division_ID = 0;
                // $strategic_measure_enity->strategic_objective_ID = $request->strategic_objective_ID;
                // $strategic_measure_enity->type = 'DIRECT MAIN';
                // $strategic_measure_enity->save();
                foreach ($divisions as $division) {
                    // dd($division);
                    $strategic_measure_enity = new StrategicMeasure();
                    $strategic_measure_enity->strategic_measure = $strategic_measure;
                    $strategic_measure_enity->strategic_objective_ID = $request->strategic_objective_ID;
                    $strategic_measure_enity->division_ID = $division;
                    $strategic_measure_enity->number_measure = $number_measure;
                    $strategic_measure_enity->is_sub = $is_sub;
                    if ($request->accountable_division == $division) {
                        $strategic_measure_enity->type = 'DIRECT MAIN';
                    } else {
                        $strategic_measure_enity->type = 'DIRECT COMMON';
                    }

                    $strategic_measure_enity->save();
                }
            }
            if (count($divisions) == 1) {
                $strategic_measure_enity = new StrategicMeasure();
                $strategic_measure_enity->strategic_measure = $strategic_measure;
                $strategic_measure_enity->division_ID = $divisions[0];
                $strategic_measure_enity->strategic_objective_ID = $request->strategic_objective_ID;
                $strategic_measure_enity->type = 'DIRECT';
                $strategic_measure_enity->number_measure = $number_measure;
                $strategic_measure_enity->is_sub = $is_sub;
                $strategic_measure_enity->save();
            }
        } else {
            Alert::warning('No Division Selected');

            return redirect()
                ->route('rpo.measures');
        }
        Alert::success('Strategic Measure successfully created');

        // return redirect()
        //     ->route('rpo.measures')
        //     ->with('success', 'Strategic Measure successfully created');
         return redirect()
            ->route('rpo.measures');
        
    }

    public function remove_objective(Request $request)
    {
        DB::transaction(function () use ($request) {
            $objective = StrategicObjective::find($request->objective_ID);
            $objective->is_active = false;
    
            $measures = StrategicMeasure::where('strategic_objective_ID', $request->objective_ID)->get();
    
            foreach($measures as $measure) {
                // Delete the measures related to the objective
                $measure->type = null;
                $measure->save();
            }
    
            $objective->save();
        });
        Alert::success('Strategic Objective successfully removed');

        // return redirect()
        //     ->route('rpo.measures')
        //     ->with('success', 'Strategic Objective successfully removed');
            return redirect()
            ->route('rpo.measures');
    }

    public function remove_measure(Request $request)
    {   
        
        if($request->submit == 'trigger'){
            

            if(isset($request->measures)){

                $stringified_measures = implode(", ", $request->measures);
            
               
            }
            else{
                $stringified_measures = null;

            }
            $measure = StrategicMeasure::find($request->measure_ID);
            
            $measure->sum_of = $stringified_measures; // Replace "column_name" with the actual column you want to update
            $measure->save();
            Alert::success('Strategic Measure successfully updated');

            return redirect()
            ->route('rpo.measures');

        }
        else{
            $measure = StrategicMeasure::find($request->measure_ID);
            $measure->type = '';
            $measure->save();

            Alert::success('Strategic Measure successfully removed');

            return redirect()
                ->route('rpo.measures');

        }
        
    }

    public function upload_opcr(Request $request)
    {
        // dd($request->opcr_id);
        // dd($request->hasFile('opcr_file'));
        if ($request->hasFile('opcr_file')) {
            $file = $request->file('opcr_file');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $file = new FileUpload();
            $file->opcr_ID = $request->opcr_id;
            $file->file_name = $filename;
            $file->type = 'REGIONAL OPCR';
            $file->save();
            DB::table('opcr')
                ->where('opcr_ID', $request->opcr_id)
                ->update(['is_active' => false, 'status' => 'DONE']);
            Alert::success('OPCR successfully marked as done');

            return redirect()
                ->route('rpo.show', $request->opcr_id);
                // return redirect()
                // ->route('rpo.show', $request->opcr_id)
                // ->with('success', 'OPCR successfully marked as done');
        } else {
            Alert::error('OPCR upload error');

            return redirect()
                ->route('rpo.show', $request->opcr_id);
        }
    }

    private function setAccomZero($opcr_id, $month)
    {
        $monthly_targets = MonthlyTarget::join('annual_targets', 'monthly_targets.annual_target_ID', '=', 'annual_targets.annual_target_ID')
                                        ->where('annual_targets.opcr_id', $opcr_id)
                                        ->where('monthly_targets.month', $month)
                                        ->where('monthly_targets.monthly_target', null)
                                        ->where('monthly_targets.monthly_target', '!=', null)
                                        ->get();
                                    
        foreach ($monthly_targets as $monthly_target) {
            # code...
            $monthly_target->monthly_accomplishment = 0;
            $monthly_target->save();
        }

    

    }

    public function cutOff(Request $request)
    {
        // dd($request->submit);

        DB::transaction(function () use ($request) {
            $month = $request->month;
            $opcr = Opcr::where('opcr_ID', $request->opcr_id)
                ->get()
                ->first();
    
            $cutoff_status = $opcr->cutoff_status;
            $obj = new RegionalPlanningOfficerController();
            if ($request->submit == 'cutoff') {
                if ($month == 'jan') {
                    $newStatus = substr_replace($cutoff_status, '1', 0, 1);
                    $obj->setAccomZero($request->opcr_id, 'jan');
                } elseif ($month == 'feb') {
                    $newStatus = substr_replace($cutoff_status, '1', 1, 1);
                    $obj->setAccomZero($request->opcr_id, 'feb');
                } elseif ($month == 'mar') {
                    $newStatus = substr_replace($cutoff_status, '1', 2, 1);
                    $obj->setAccomZero($request->opcr_id, 'mar');
                } elseif ($month == 'apr') {
                    $newStatus = substr_replace($cutoff_status, '1', 3, 1);
                    $obj->setAccomZero($request->opcr_id, 'apr');
                } elseif ($month == 'may') {
                    $newStatus = substr_replace($cutoff_status, '1', 4, 1);
                    $obj->setAccomZero($request->opcr_id, 'may');
                } elseif ($month == 'jun') {
                    $newStatus = substr_replace($cutoff_status, '1', 5, 1);
                    $obj->setAccomZero($request->opcr_id, 'jun');
                } elseif ($month == 'jul') {
                    $newStatus = substr_replace($cutoff_status, '1', 6, 1);
                    $obj->setAccomZero($request->opcr_id, 'jul');
                } elseif ($month == 'aug') {
                    $newStatus = substr_replace($cutoff_status, '1', 7, 1);
                    $obj->setAccomZero($request->opcr_id, 'aug');
                } elseif ($month == 'sep') {
                    $newStatus = substr_replace($cutoff_status, '1', 8, 1);
                    $obj->setAccomZero($request->opcr_id, 'sep');
                } elseif ($month == 'oct') {
                    $newStatus = substr_replace($cutoff_status, '1', 9, 1);
                    $obj->setAccomZero($request->opcr_id, 'oct');
                } elseif ($month == 'nov') {
                    $newStatus = substr_replace($cutoff_status, '1', 10, 1);
                    $obj->setAccomZero($request->opcr_id, 'nov');
                } elseif ($month == 'dec') {
                    $newStatus = substr_replace($cutoff_status, '1', 11, 1);
                    $obj->setAccomZero($request->opcr_id, 'dec');
                }
            } elseif ($request->submit == 'reopen') {
                if ($month == 'jan') {
                    $newStatus = substr_replace($cutoff_status, '0', 0, 1);
                } elseif ($month == 'feb') {
                    $newStatus = substr_replace($cutoff_status, '0', 1, 1);
                } elseif ($month == 'mar') {
                    $newStatus = substr_replace($cutoff_status, '0', 2, 1);
                } elseif ($month == 'apr') {
                    $newStatus = substr_replace($cutoff_status, '0', 3, 1);
                } elseif ($month == 'may') {
                    $newStatus = substr_replace($cutoff_status, '0', 4, 1);
                } elseif ($month == 'jun') {
                    $newStatus = substr_replace($cutoff_status, '0', 5, 1);
                } elseif ($month == 'jul') {
                    $newStatus = substr_replace($cutoff_status, '0', 6, 1);
                } elseif ($month == 'aug') {
                    $newStatus = substr_replace($cutoff_status, '0', 7, 1);
                } elseif ($month == 'sep') {
                    $newStatus = substr_replace($cutoff_status, '0', 8, 1);
                } elseif ($month == 'oct') {
                    $newStatus = substr_replace($cutoff_status, '0', 9, 1);
                } elseif ($month == 'nov') {
                    $newStatus = substr_replace($cutoff_status, '0', 10, 1);
                } elseif ($month == 'dec') {
                    $newStatus = substr_replace($cutoff_status, '0', 11, 1);
                }
            }
            
            $opcr->cutoff_status = $newStatus;
            $opcr->save();





            
        });
       
        Alert::alert('Monthly cutoff successfully');

        return redirect()
            ->route('rpo.show', $request->opcr_id);
    }

    public function remove_opcr(Request $request){

        $opcrID = $request->opcr_ID;
    
        // Query the OPCR by opcr_ID
        $opcr = Opcr::find($opcrID);
    
        // Check if OPCR exists
        if ($opcr && $opcr->is_active !== 1) {
            // Update the deleted_at column
            $opcr->deleted_at = now();
            $opcr->save();
          
            Alert::success('OPCR removed');

            return redirect()
                ->route('rpo.savetarget');
        } else {
            // OPCR not found or is_active is 1
            Alert::error('OPCR cannot be removed');

            return redirect()
                ->route('rpo.savetarget');
        }
    }

    public function recover_opcr(Request $request){

        $opcrID = $request->opcr_ID;
    
        // Query the OPCR by opcr_ID
        $opcr = Opcr::find($opcrID);
    
        // Check if OPCR exists
        if ($opcr && $opcr->is_active !== 1) {
            // Update the deleted_at column
            $opcr->deleted_at = null;
            $opcr->save();
          
            Alert::success('OPCR Successfully Recovered!');

            return redirect()
                ->route('rpo.savetarget');
        } else {
            // OPCR not found or is_active is 1
            Alert::error('OPCR cannot be Recovered!');

            return redirect()
                ->route('rpo.archive');
        }
    }
   
   


    public function updateAnnual(Request $request)
    {

        $validatedData = $request->validate([
            'prov_val' => 'required',
            'prov_target' => 'required',
        ]);
    
        // Find the AnnualTarget based on the prov_target value
        $annualTarget = AnnualTarget::find($validatedData['prov_target']);
    
        // Check if the target exists
        if (!$annualTarget) {
            Alert::error('Annual Target not found!');
            return redirect()->back();
            // return redirect()->back()->with('error', 'Annual Target not found!');
        }
    
        // Update the annual_target column
        $annualTarget->annual_target = $validatedData['prov_val'];
        $annualTarget->save();
        Alert::success('Annual Target successfully updated!');
        // return redirect()
        // ->route('rpo.show', $annualTarget->opcr_id) // Replace 'rpo.show' with the correct route name
        // ->with('success', 'Annual Target successfully updated!');
        return redirect()
        ->route('rpo.show', $annualTarget->opcr_id);
    }
    
    
    

    
   
}