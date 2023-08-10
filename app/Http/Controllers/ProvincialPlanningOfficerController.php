<?php

namespace App\Http\Controllers;
use DB;
use Async;
use App\Models\Opcr;
use App\Models\User;
use App\Models\Driver;
use App\Models\Division;
use App\Models\Pgs;
use App\Models\Province;
use App\Models\Evaluation;
use App\Models\AnnualTarget;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\MonthlyTarget;
use App\Models\StrategicMeasure;
use App\Models\StrategicObjective;
use App\Models\ScoreCard;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProvincialPlanningOfficerController extends Controller
{
    // public function dashboard(){
    //     return view('ppo.dashboard');
    // }
    public function dashboard()
    {
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', '=', 1)
            ->get();
        
        

        $objectivesact = StrategicObjective::where('is_active', 1)
            ->orderBy('objective_letter', 'ASC')
            ->get();

        $objectives = StrategicObjective::where('is_active', 1)->get();

        $measures = StrategicMeasure::join('divisions', 'strategic_measures.division_ID', '=', 'divisions.division_ID')
            ->select('strategic_measures.*', 'divisions.division', 'divisions.code')
            ->get();

        // dd($measures);
        $provinces = Province::select('province_ID', 'province')

            ->orderBy('province_ID')
            ->get();

        if (count($opcrs_active) != 0) {

            // SCORECARD
            $scorecard = ScoreCard::where('opcr_ID', $opcrs_active[0]->opcr_ID)
                ->where('province_ID', $user->province_ID)->first();

            // dd($scorecard);

            $annual_targets = DB::table('annual_targets')
                ->where('opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('province_ID', '=', $user->province_ID)
                ->get()
                ->groupBy(['strategic_measures_ID', 'province_ID']);
        } else {
            $annual_targets = null;
            $scorecard = null;
        }

        // dd($annual_targets);

        $divisions = Division::all();
        $opcrs = Opcr::all();
        // dd( $opcrs_active);
        $driversact = Driver::join('divisions', 'divisions.division_ID', '=', 'drivers.division_ID')
            ->whereHas('opcr', function ($query) use ($opcrs_active) {
                $query->whereIn('opcr_ID', $opcrs_active->pluck('opcr_ID'));
            })
            ->get(['drivers.*', 'divisions.division', 'divisions.code']);

        // dd($driversact);
        $monthly_targets = [];
        if (count($opcrs_active) > 0 && isset($opcrs_active[0]->opcr_ID)) {
            $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
                ->where('monthly_accomplishment', '!=', null)
                ->where('annual_targets.opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('annual_targets.province_ID', '=', $user->province_ID)
                ->where('monthly_targets.validated', '=', 'Validated')
                ->get(['monthly_targets.*', 'annual_targets.*'])
                ->groupBy(['annual_target_ID']);
        }
        foreach ($monthly_targets as $monthly_target) {
            // echo "annual target ID: {$annual_target_ID}<br>";
            $annual_accom = 0;
            $validated = true;
            foreach ($monthly_target as $target) {
                $annual_accom = floatval($target->monthly_accomplishment) + floatval($annual_accom);
                // echo "{$monthly_target->id} - {$monthly_target->monthly_target}<br>";
                if ($target->validated != 'Validated') {
                    // $validated = false;
                    $monthly_target->validated = false;
                }
            }
            $monthly_target->annual_accom = $annual_accom;
            if ($validated = true) {
                if (count($monthly_target) < 12) {
                    $monthly_target->validated = false;
                }
            } else {
                $monthly_target->validated = false;
            }
            // dd($monthly_targets);
            // echo $monthly_target->annual_accom;
        }

        if ($opcrs_active->isNotEmpty()) {
            $notification = Notification::where('opcr_ID', '=', $opcrs_active[0]->opcr_ID)
                ->where(function ($query) {
                    $query
                        ->where('division_ID', 1)
                        ->orWhere('division_ID', 2)
                        ->orWhere('division_ID', 3);
                })
                ->where('province_ID', '=', $user->province_ID)
                ->get();
        } else {
            $notification = null;
        }

        $commonMeasures = null; // initialize the variable
        if (isset($opcrs_active[0])) {
            $commonMeasures = StrategicMeasure::join('annual_targets', 'annual_targets.strategic_measures_ID', '=', 'strategic_measures.strategic_measure_ID')
                ->where('strategic_measures.type', '=', 'DIRECT COMMON')
                ->where('annual_targets.opcr_ID', '=', $opcrs_active[0]->opcr_ID)
                ->where('annual_targets.province_ID', '=', $user->province_ID)
                ->get()
                ->groupBy(['strategic_measure']);
        } else {
            // handle the case where $opcrs_active is empty or does not have an element at index 0
        }

        if ($commonMeasures !== null) {
            foreach ($commonMeasures as $commonMeasure) {
                $commonMeasure->annual = 0;
                foreach ($commonMeasure as $commonAccom) {
                    # code...

                    if (isset($monthly_targets[$commonAccom->annual_target_ID])) {
                        if (isset($monthly_targets[$commonAccom->annual_target_ID])) {
                            // $annual_accom = $monthly_targets[$commonAccom->annual_target_ID];
                            // echo 'annual_target_id = '.$commonAccom->annual_target_ID;
                            // echo '<br/>';
                            foreach ($monthly_targets[$commonAccom->annual_target_ID] as $monthly_accom) {
                                # code...
                                // echo $monthly_accom->monthly_accomplishment;
                                $commonMeasure->annual = $commonMeasure->annual + $monthly_accom->monthly_accomplishment;
                            }
                            //  echo '<br />';
                        }
                    }
                }
            }
        }
        $valid_meas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $total_number_of_valid_measures = collect();
        if (count($opcrs_active) > 0) {
            $monthly_targets2 = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
                // ->where('monthly_accomplishment', '!=', null)
                // ->where('validated', '=', 'Validated')
                ->where('annual_targets.opcr_ID', '=', $opcrs_active[0]->opcr_ID)
                ->where('annual_targets.province_ID', '=', $user->province_ID)
                ->get(['monthly_targets.*', 'annual_targets.*'])
                ->groupBy(['strategic_measures_ID']);

            //pgs rating
            // dd($monthly_targets2);
            $total_number_of_valid_measures = AnnualTarget::join('strategic_measures', 'annual_targets.strategic_measures_ID', '=', 'strategic_measures.strategic_measure_ID')
                ->where('annual_targets.province_ID', $user->province_ID)
                ->where('annual_targets.opcr_ID', $opcrs_active[0]['opcr_ID'])

                ->where(function ($query) {
                    $query->where('strategic_measures.type', '=', 'DIRECT')->orWhere('strategic_measures.type', '=', 'DIRECT MAIN');
                })
                ->where(function ($query) {
                    $query->whereNull('strategic_measures.is_sub')->orWhere('strategic_measures.is_sub', '!=', 1);
                })
                ->select('annual_targets.*', 'strategic_measures.strategic_measure', DB::raw('(SELECT SUM(monthly_accomplishment) FROM monthly_targets WHERE monthly_targets.annual_target_ID = annual_targets.annual_target_ID && (monthly_targets.validated = "Validated")) AS total_accomplishment'))
                ->having('total_accomplishment', '<>', 0)
                ->get();
            // dd($total_number_of_valid_measures);
            $total_number_of_accomplished_measure = 0;
            // $total_number_of_valid_measures = $total_number_of_valid_measures->merge($annual_targets);
            foreach ($total_number_of_valid_measures as $acc_meas) {
                if (($acc_meas->total_accomplishment / $acc_meas->annual_target) * 100 >= 90) {
                    $total_number_of_accomplished_measure++;
                }
            }

            $pgsratingtext = '';
            $pgsrating = Pgs::where('total_num_of_targeted_measure', $total_number_of_valid_measures->count())
                ->where('actual_num_of_accomplished_measure', $total_number_of_accomplished_measure)
                ->select('numeric')
                ->first();

            if ($pgsrating !== null) {
                if ($pgsrating->numeric == 5.0) {
                    $pgsratingtext = 'Outstanding';
                } elseif ($pgsrating->numeric >= 4.5) {
                    $pgsratingtext = 'Very Satisfactory';
                } elseif ($pgsrating->numeric >= 3.25) {
                    $pgsratingtext = 'Satisfactory';
                } elseif ($pgsrating->numeric >= 2.5) {
                    $pgsratingtext = 'Below Satisfactory';
                } elseif ($pgsrating->numeric < 2.5) {
                    $pgsratingtext = 'Poor';
                }
            }
            $total_number_of_valid_measures2 = MonthlyTarget::join('annual_targets', 'monthly_targets.annual_target_ID', '=', 'annual_targets.annual_target_ID')
                ->join('strategic_measures', 'strategic_measures.strategic_measure_ID', '=', 'annual_targets.strategic_measures_ID')
                ->where('annual_targets.opcr_ID', $opcrs_active[0]['opcr_ID'])
                ->where('annual_targets.province_ID', '=', $user->province_ID)
                ->where(function ($query) {
                    $query->where('strategic_measures.type', '=', 'DIRECT')->orWhere('strategic_measures.type', '=', 'DIRECT MAIN');
                })
                ->where(function ($query) {
                    $query->whereNull('strategic_measures.is_sub')->orWhere('strategic_measures.is_sub', '!=', 1);
                })
                ->select('monthly_targets.*','annual_targets.*', 'strategic_measures.strategic_measure')
                
                ->get()
                ->groupBy('strategic_measures_ID');
                // dd($total_number_of_valid_measures2);
                      $valid_meas[0]  = 0;
                      $valid_meas[1]  = 0;
                      $valid_meas[2]   = 0;
                      $valid_meas[3]  = 0;
                      $valid_meas[4]  = 0;
                      $valid_meas[5]  = 0;
                      $valid_meas[6]  = 0;
                      $valid_meas[7]  = 0;
                      $valid_meas[8]  = 0;
                      $valid_meas[9]  = 0;
                      $valid_meas[10]  = 0;
                      $valid_meas[11]  = 0;
                foreach ($total_number_of_valid_measures2 as $total_number_of_valid_measure2) {

                    
                    foreach ($total_number_of_valid_measure2 as $acc_meas2) {

                        if($acc_meas2->month == 'jan'){
                            $valid_meas[0]++;              
                        }
                        else if($acc_meas2->month == 'feb'){
                            $valid_meas[1]++;
                        }
                        else if($acc_meas2->month == 'mar'){
                            $valid_meas[2]++;
                        }
                        else if($acc_meas2->month == 'apr'){
                            $valid_meas[3]++;
                        }
                        else if($acc_meas2->month == 'may'){
                            $valid_meas[4]++;
                        }
                        else if($acc_meas2->month == 'jun'){
                            $valid_meas[5]++;
                        }
                        else if($acc_meas2->month == 'jul'){
                            $valid_meas[6]++;
                        }
                        else if($acc_meas2->month == 'aug'){
                            $valid_meas[7]++;
                        }
                        else if($acc_meas2->month == 'sep'){
                            $valid_meas[8]++;
                        }
                        else if($acc_meas2->month == 'oct'){
                            $valid_meas[9]++;
                        }
                        else if($acc_meas2->month == 'nov'){
                            $valid_meas[10]++;
                        }
                        else if($acc_meas2->month == 'dec'){
                            $valid_meas[11]++;
                        }


                        
                    }
    
                     
                  
                } 
                // dd($valid_meas);
            // PGS array
            $pgs = [
                'total_number_of_valid_measures' => $total_number_of_valid_measures->count(),
                'total_number_of_accomplished_measure' => $total_number_of_accomplished_measure,
                'numerical_rating' => $pgsrating !== null ? $pgsrating->numeric : null,
                'rating' => $pgsratingtext,
                'monthly_valid' => $valid_meas,
            ];

            // dd($pgs);
        } else {
            $monthly_targets2 = [];
            $pgs = [];
        }
        // $valid_meas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        for ($i=0; $i < count($valid_meas); $i++) { 
            # code...
            $pgsrating2[$i] = Pgs::where('total_num_of_targeted_measure', $valid_meas[$i])

            ->get()
            ->groupBy('actual_num_of_accomplished_measure');
        }
        // dd($pgsrating2);
        foreach ($monthly_targets2 as $monthly_target2) {
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

                if($target2->validated == "Validated"){
                    
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

                $monthly_target2->total_targets = $monthly_target2->total_targets/12;
            $monthly_target2->first_sem = $monthly_target2->first_sem/6;
            $monthly_target2->second_sem = $monthly_target2->second_sem/6;
            $monthly_target2->first_qrtr = $monthly_target2->first_qrtr/3;
            $monthly_target2->second_qrtr = $monthly_target2->third_qrtr/3;
            $monthly_target2->third_qrtr = $monthly_target2->third_qrtr/3;
            $monthly_target2->fourth_qrtr = $monthly_target2->fourth_qrtr/3;

            $monthly_target2->total_accom =  $monthly_target2->total_accom/12;
            $monthly_target2->first_sem_accom =  $monthly_target2->first_sem_accom/6;
            $monthly_target2->second_sem_accom =  $monthly_target2->second_sem_accom/6;
            $monthly_target2->first_qrtr_accom = $monthly_target2->first_qrtr_accom/3;
            $monthly_target2->second_qrtr_accom = $monthly_target2->second_qrtr_accom/3;
            $monthly_target2->third_qrtr_accom = $monthly_target2->third_qrtr_accom/3;
            $monthly_target2->fourth_qrtr_accom = $monthly_target2->fourth_qrtr_accom/3;
            }
        }
        // dd($provinces);

        return view('ppo.dashboard', compact('objectives', 'scorecard', 'objectivesact', 'measures', 'provinces', 'annual_targets', 'divisions', 'opcrs', 'opcrs_active', 'driversact', 'user', 'monthly_targets', 'notification', 'commonMeasures', 'monthly_targets2', 'pgs', 'pgsrating2'));
    
    }

    public function getNotifications(Request $request)
    {
        $userTypeID = auth()->user()->user_type_ID;
        $provinceID = auth()->user()->province_ID;

        $notifications = Notification::where('province_ID', $provinceID)
            ->where('user_type_ID', $userTypeID)
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')

            ->get();

        // Log::debug('Number of notifications: ' . $notifications->count());
        // return response()->json(['notifications' => $notifications]);

        return response()->json(['notifications' => $notifications]);
    }

    public function markNotificationsAsRead(Request $request)
    {
        $userTypeID = auth()->user()->user_type_ID;
        $provinceID = auth()->user()->province_ID;

        Notification::where('user_type_ID', $userTypeID)
            ->where('province_ID', $provinceID)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    // public function markAsRead(Request $request)
    // {
    //     $user = $request->user();

    //     Notification::where('user_ID', $user->id)
    //         ->whereNull('read_at')
    //         ->update(['read_at' => now()]);

    //     return response()->json(['success' => true]);
    // }

    public function markAsRead(Request $request)
    {
        $notificationId = $request->input('notification_id');
        $notification = Notification::findOrFail($notificationId);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function assessment()
    {
        $provincialUser = Auth::user();
        $provinceId = $provincialUser->province_ID;

        $divisionUsers = User::whereNotNull('division_ID')
            ->where('province_ID', $provinceId)
            ->get();

        $divisionUserIds = $divisionUsers->pluck('user_ID');

        // $eval = Evaluation::whereIn('user_id', $divisionUserIds)
        //     ->with('division')
        //     ->get();
        $eval = Evaluation::whereIn('evaluations.user_id', $divisionUserIds)
            ->join('users', 'evaluations.user_id', '=', 'users.user_ID')
            ->leftJoin('divisions', 'users.division_ID', '=', 'divisions.division_ID')
            ->select('evaluations.*', 'divisions.division')
            ->get();

        return view('ppo.assessment', compact('eval'));
    }

    public function profile()
    {
        return view('ppo.profile');
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
            Alert::success('Email updated successfully.');

          

            return redirect()
                ->back();
        } else {
            Alert::error('Invalid Password');

          
            // Show an error message
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
            Alert::success('Password updated successfully.');

          
            return redirect()
                ->back();
        } else {
            Alert::error('Invalid Password');

            return redirect()
                ->back();
        }
    }
    public function opcr()
    {
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', '=', 1)
            ->get();
        
        

        $objectivesact = StrategicObjective::where('is_active', 1)
            ->orderBy('objective_letter', 'ASC')
            ->get();

        $objectives = StrategicObjective::where('is_active', 1)->get();

        $measures = StrategicMeasure::join('divisions', 'strategic_measures.division_ID', '=', 'divisions.division_ID')
            ->select('strategic_measures.*', 'divisions.division', 'divisions.code')
            ->get();

        // dd($measures);
        $provinces = Province::select('province_ID', 'province')

            ->orderBy('province_ID')
            ->get();

        if (count($opcrs_active) != 0) {

            // SCORECARD
            $scorecard = ScoreCard::where('opcr_ID', $opcrs_active[0]->opcr_ID)
                ->where('province_ID', $user->province_ID)->first();

            // dd($scorecard);

            $annual_targets = DB::table('annual_targets')
                ->where('opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('province_ID', '=', $user->province_ID)
                ->get()
                ->groupBy(['strategic_measures_ID', 'province_ID']);
        } else {
            $annual_targets = null;
            $scorecard = null;
        }

        // dd($annual_targets);

        $divisions = Division::all();
        $opcrs = Opcr::all();
        // dd( $opcrs_active);
        $driversact = Driver::join('divisions', 'divisions.division_ID', '=', 'drivers.division_ID')
            ->whereHas('opcr', function ($query) use ($opcrs_active) {
                $query->whereIn('opcr_ID', $opcrs_active->pluck('opcr_ID'));
            })
            ->get(['drivers.*', 'divisions.division', 'divisions.code']);

        // dd($driversact);
        $monthly_targets = [];
        if (count($opcrs_active) > 0 && isset($opcrs_active[0]->opcr_ID)) {
            $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
                ->where('monthly_accomplishment', '!=', null)
                ->where('annual_targets.opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('annual_targets.province_ID', '=', $user->province_ID)
                ->where('monthly_targets.validated', '=', 'Validated')
                ->get(['monthly_targets.*', 'annual_targets.*'])
                ->groupBy(['annual_target_ID']);
        }
        foreach ($monthly_targets as $monthly_target) {
            // echo "annual target ID: {$annual_target_ID}<br>";
            $annual_accom = 0;
            $validated = true;
            foreach ($monthly_target as $target) {
                $annual_accom = floatval($target->monthly_accomplishment) + floatval($annual_accom);
                // echo "{$monthly_target->id} - {$monthly_target->monthly_target}<br>";
                if ($target->validated != 'Validated') {
                    // $validated = false;
                    $monthly_target->validated = false;
                }
            }
            $monthly_target->annual_accom = $annual_accom;
            if ($validated = true) {
                if (count($monthly_target) < 12) {
                    $monthly_target->validated = false;
                }
            } else {
                $monthly_target->validated = false;
            }
            // dd($monthly_targets);
            // echo $monthly_target->annual_accom;
        }

        if ($opcrs_active->isNotEmpty()) {
            $notification = Notification::where('opcr_ID', '=', $opcrs_active[0]->opcr_ID)
                ->where(function ($query) {
                    $query
                        ->where('division_ID', 1)
                        ->orWhere('division_ID', 2)
                        ->orWhere('division_ID', 3);
                })
                ->where('province_ID', '=', $user->province_ID)
                ->get();
        } else {
            $notification = null;
        }

        $commonMeasures = null; // initialize the variable
        if (isset($opcrs_active[0])) {
            $commonMeasures = StrategicMeasure::join('annual_targets', 'annual_targets.strategic_measures_ID', '=', 'strategic_measures.strategic_measure_ID')
                ->where('strategic_measures.type', '=', 'DIRECT COMMON')
                ->where('annual_targets.opcr_ID', '=', $opcrs_active[0]->opcr_ID)
                ->where('annual_targets.province_ID', '=', $user->province_ID)
                ->get()
                ->groupBy(['strategic_measure']);
        } else {
            // handle the case where $opcrs_active is empty or does not have an element at index 0
        }

        if ($commonMeasures !== null) {
            foreach ($commonMeasures as $commonMeasure) {
                $commonMeasure->annual = 0;
                foreach ($commonMeasure as $commonAccom) {
                    # code...

                    if (isset($monthly_targets[$commonAccom->annual_target_ID])) {
                        if (isset($monthly_targets[$commonAccom->annual_target_ID])) {
                            // $annual_accom = $monthly_targets[$commonAccom->annual_target_ID];
                            // echo 'annual_target_id = '.$commonAccom->annual_target_ID;
                            // echo '<br/>';
                            foreach ($monthly_targets[$commonAccom->annual_target_ID] as $monthly_accom) {
                                # code...
                                // echo $monthly_accom->monthly_accomplishment;
                                $commonMeasure->annual = $commonMeasure->annual + $monthly_accom->monthly_accomplishment;
                            }
                            //  echo '<br />';
                        }
                    }
                }
            }
        }
        $valid_meas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $total_number_of_valid_measures = collect();
        if (count($opcrs_active) > 0) {
            $monthly_targets2 = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
                // ->where('monthly_accomplishment', '!=', null)
                // ->where('validated', '=', 'Validated')
                ->where('annual_targets.opcr_ID', '=', $opcrs_active[0]->opcr_ID)
                ->where('annual_targets.province_ID', '=', $user->province_ID)
                ->get(['monthly_targets.*', 'annual_targets.*'])
                ->groupBy(['strategic_measures_ID']);

            //pgs rating
            // dd($monthly_targets2);
            $total_number_of_valid_measures = AnnualTarget::join('strategic_measures', 'annual_targets.strategic_measures_ID', '=', 'strategic_measures.strategic_measure_ID')
                ->where('annual_targets.province_ID', $user->province_ID)
                ->where('annual_targets.opcr_ID', $opcrs_active[0]['opcr_ID'])

                ->where(function ($query) {
                    $query->where('strategic_measures.type', '=', 'DIRECT')->orWhere('strategic_measures.type', '=', 'DIRECT MAIN');
                })
                ->where(function ($query) {
                    $query->whereNull('strategic_measures.is_sub')->orWhere('strategic_measures.is_sub', '!=', 1);
                })
                ->select('annual_targets.*', 'strategic_measures.strategic_measure', DB::raw('(SELECT SUM(monthly_accomplishment) FROM monthly_targets WHERE monthly_targets.annual_target_ID = annual_targets.annual_target_ID && (monthly_targets.validated = "Validated")) AS total_accomplishment'))
                ->having('total_accomplishment', '<>', 0)
                ->get();
            // dd($total_number_of_valid_measures);
            $total_number_of_accomplished_measure = 0;
            // $total_number_of_valid_measures = $total_number_of_valid_measures->merge($annual_targets);
            foreach ($total_number_of_valid_measures as $acc_meas) {
                if (($acc_meas->total_accomplishment / $acc_meas->annual_target) * 100 >= 90) {
                    $total_number_of_accomplished_measure++;
                }
            }

            $pgsratingtext = '';
            $pgsrating = Pgs::where('total_num_of_targeted_measure', $total_number_of_valid_measures->count())
                ->where('actual_num_of_accomplished_measure', $total_number_of_accomplished_measure)
                ->select('numeric')
                ->first();

            if ($pgsrating !== null) {
                if ($pgsrating->numeric == 5.0) {
                    $pgsratingtext = 'Outstanding';
                } elseif ($pgsrating->numeric >= 4.5) {
                    $pgsratingtext = 'Very Satisfactory';
                } elseif ($pgsrating->numeric >= 3.25) {
                    $pgsratingtext = 'Satisfactory';
                } elseif ($pgsrating->numeric >= 2.5) {
                    $pgsratingtext = 'Below Satisfactory';
                } elseif ($pgsrating->numeric < 2.5) {
                    $pgsratingtext = 'Poor';
                }
            }
            $total_number_of_valid_measures2 = MonthlyTarget::join('annual_targets', 'monthly_targets.annual_target_ID', '=', 'annual_targets.annual_target_ID')
                ->join('strategic_measures', 'strategic_measures.strategic_measure_ID', '=', 'annual_targets.strategic_measures_ID')
                ->where('annual_targets.opcr_ID', $opcrs_active[0]['opcr_ID'])
                ->where('annual_targets.province_ID', '=', $user->province_ID)
                ->where(function ($query) {
                    $query->where('strategic_measures.type', '=', 'DIRECT')->orWhere('strategic_measures.type', '=', 'DIRECT MAIN');
                })
                ->where(function ($query) {
                    $query->whereNull('strategic_measures.is_sub')->orWhere('strategic_measures.is_sub', '!=', 1);
                })
                ->select('monthly_targets.*','annual_targets.*', 'strategic_measures.strategic_measure')
                
                ->get()
                ->groupBy('strategic_measures_ID');
                // dd($total_number_of_valid_measures2);
                      $valid_meas[0]  = 0;
                      $valid_meas[1]  = 0;
                      $valid_meas[2]   = 0;
                      $valid_meas[3]  = 0;
                      $valid_meas[4]  = 0;
                      $valid_meas[5]  = 0;
                      $valid_meas[6]  = 0;
                      $valid_meas[7]  = 0;
                      $valid_meas[8]  = 0;
                      $valid_meas[9]  = 0;
                      $valid_meas[10]  = 0;
                      $valid_meas[11]  = 0;
                foreach ($total_number_of_valid_measures2 as $total_number_of_valid_measure2) {

                    
                    foreach ($total_number_of_valid_measure2 as $acc_meas2) {

                        if($acc_meas2->month == 'jan'){
                            $valid_meas[0]++;              
                        }
                        else if($acc_meas2->month == 'feb'){
                            $valid_meas[1]++;
                        }
                        else if($acc_meas2->month == 'mar'){
                            $valid_meas[2]++;
                        }
                        else if($acc_meas2->month == 'apr'){
                            $valid_meas[3]++;
                        }
                        else if($acc_meas2->month == 'may'){
                            $valid_meas[4]++;
                        }
                        else if($acc_meas2->month == 'jun'){
                            $valid_meas[5]++;
                        }
                        else if($acc_meas2->month == 'jul'){
                            $valid_meas[6]++;
                        }
                        else if($acc_meas2->month == 'aug'){
                            $valid_meas[7]++;
                        }
                        else if($acc_meas2->month == 'sep'){
                            $valid_meas[8]++;
                        }
                        else if($acc_meas2->month == 'oct'){
                            $valid_meas[9]++;
                        }
                        else if($acc_meas2->month == 'nov'){
                            $valid_meas[10]++;
                        }
                        else if($acc_meas2->month == 'dec'){
                            $valid_meas[11]++;
                        }


                        
                    }
    
                     
                  
                } 
                // dd($valid_meas);
            // PGS array
            $pgs = [
                'total_number_of_valid_measures' => $total_number_of_valid_measures->count(),
                'total_number_of_accomplished_measure' => $total_number_of_accomplished_measure,
                'numerical_rating' => $pgsrating !== null ? $pgsrating->numeric : null,
                'rating' => $pgsratingtext,
                'monthly_valid' => $valid_meas,
            ];

            // dd($pgs);
        } else {
            $monthly_targets2 = [];
            $pgs = [];
        }
        // $valid_meas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        for ($i=0; $i < count($valid_meas); $i++) { 
            # code...
            $pgsrating2[$i] = Pgs::where('total_num_of_targeted_measure', $valid_meas[$i])

            ->get()
            ->groupBy('actual_num_of_accomplished_measure');
        }
        // dd($pgsrating2);
        foreach ($monthly_targets2 as $monthly_target2) {
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

                if($target2->validated == "Validated"){
                    
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

                $monthly_target2->total_targets = $monthly_target2->total_targets/12;
            $monthly_target2->first_sem = $monthly_target2->first_sem/6;
            $monthly_target2->second_sem = $monthly_target2->second_sem/6;
            $monthly_target2->first_qrtr = $monthly_target2->first_qrtr/3;
            $monthly_target2->second_qrtr = $monthly_target2->third_qrtr/3;
            $monthly_target2->third_qrtr = $monthly_target2->third_qrtr/3;
            $monthly_target2->fourth_qrtr = $monthly_target2->fourth_qrtr/3;

            $monthly_target2->total_accom =  $monthly_target2->total_accom/12;
            $monthly_target2->first_sem_accom =  $monthly_target2->first_sem_accom/6;
            $monthly_target2->second_sem_accom =  $monthly_target2->second_sem_accom/6;
            $monthly_target2->first_qrtr_accom = $monthly_target2->first_qrtr_accom/3;
            $monthly_target2->second_qrtr_accom = $monthly_target2->second_qrtr_accom/3;
            $monthly_target2->third_qrtr_accom = $monthly_target2->third_qrtr_accom/3;
            $monthly_target2->fourth_qrtr_accom = $monthly_target2->fourth_qrtr_accom/3;
            }
        }
        // dd($monthly_targets2);

        return view('ppo.opcr', compact('objectives', 'scorecard', 'objectivesact', 'measures', 'provinces', 'annual_targets', 'divisions', 'opcrs', 'opcrs_active', 'driversact', 'user', 'monthly_targets', 'notification', 'commonMeasures', 'monthly_targets2', 'pgs', 'pgsrating2'));
    }

    public function savetarget()
    {
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', '=', 1)
            ->get();

        $objectivesact = StrategicObjective::all();

        $objectives = StrategicObjective::all();

        $measures = StrategicMeasure::join('divisions', 'strategic_measures.division_ID', '=', 'divisions.division_ID')
            ->select('strategic_measures.*', 'divisions.division', 'divisions.code')
            ->get();

        // dd($measures);
        $provinces = Province::select('province_ID', 'province')
            ->orderBy('province_ID')
            ->get();

        // $annual_targets = AnnualTarget::all()
        //     ->where(['opcr_id', '=', $opcrs_active[0]->opcr_ID])
        //     ->groupBy(['strategic_measures_ID', 'province_ID']);

        if (count($opcrs_active) != 0) {
            $annual_targets = DB::table('annual_targets')
                ->where('opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->get()
                ->groupBy(['strategic_measures_ID', 'province_ID']);
        } else {
            $annual_targets = null;
        }

        // dd($annual_targets);

        $divisions = Division::all();
        $opcrs = Opcr::all();
        // dd( $opcrs_active);
        $driversact = Driver::join('divisions', 'divisions.division_ID', '=', 'drivers.division_ID')
            ->whereHas('opcr', function ($query) use ($opcrs_active) {
                $query->whereIn('opcr_ID', $opcrs_active->pluck('opcr_ID'));
            })
            ->get(['drivers.*', 'divisions.division', 'divisions.code']);

        // dd($driversact);

        return view('ppo.savetarget', compact('objectives', 'objectivesact', 'measures', 'provinces', 'annual_targets', 'divisions', 'opcrs', 'opcrs_active', 'driversact'));
        // return view('ppo.savetarget');
    }

    public function manage()
    {
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', '=', 1)
            ->get();

        // $objectivesact = StrategicObjective::all();

        // $objectives = StrategicObjective::all();

        $measures = StrategicMeasure::join('divisions', 'strategic_measures.division_ID', '=', 'divisions.division_ID')
            ->select('strategic_measures.*', 'divisions.division', 'divisions.code')
            ->get();
        // dd($measures);
        foreach ($measures as $measure) {
            if ($measure->driver_ID != null) {
                $driver_data = DB::table('drivers')
                    ->where('drivers.driver_ID', '=', $measure->driver_ID)
                    ->get();

                // if ($driver_data[0]->opcr_ID == $opcrs_active[0]->opcr_ID) {
                if (count($driver_data) > 0 && $driver_data[0]->opcr_ID == $opcrs_active[0]->opcr_ID) {
                    $measure['show'] = false;
                } else {
                    $measure['show'] = true;
                }
            } else {
                $measure['show'] = true;
            }
        }

        $provinces = Province::select('province_ID', 'province')
            ->orderBy('province_ID')
            ->get();

        // $annual_targets = AnnualTarget::all()
        //     ->where(['opcr_id', '=', $opcrs_active[0]->opcr_ID])
        //     ->groupBy(['strategic_measures_ID', 'province_ID']);

        if (count($opcrs_active) != 0) {
            $annual_targets = DB::table('annual_targets')
                ->where('opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('province_ID', '=', $user->province_ID)
                ->get()
                ->groupBy(['strategic_measures_ID', 'province_ID']);
        } else {
            $annual_targets = null;
        }

        // dd($annual_targets);

        // $divisions = Division::all();
        // $opcrs = Opcr::all();
        // dd( $opcrs_active);
        $driversact = Driver::join('divisions', 'divisions.division_ID', '=', 'drivers.division_ID')
            ->whereHas('opcr', function ($query) use ($opcrs_active) {
                $query->whereIn('opcr_ID', $opcrs_active->pluck('opcr_ID'));
            })
            ->get(['drivers.*', 'divisions.division', 'divisions.code']);

        // dd($driversact);
        // dd("weqwe");
        return view('ppo.manage', compact('measures', 'provinces', 'annual_targets', 'opcrs_active', 'driversact', 'user'));
        // return view('ppo.savetarget');
        // return view('ppo.accomplishment');
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
    public function measure_update(Request $request)
    {
        $validatedData = $request->validate([
            'driver_ID' => 'required',
            'measure_ID' => 'required',
        ]);

        // update
        $measure_id_array = $request->input('measure_ID');
        foreach ($measure_id_array as $measure_id) {
            $measure = StrategicMeasure::find($measure_id);
            $measure->driver_ID = $request->input('driver_ID');
            $measure->save();
        }
        Alert::success('Driver has been updated successfully!');

        // Redirect to the measure index page
        return redirect()
            ->route('manage');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'driver' => 'required',
            'opcr_ID' => 'required',
            'division_ID' => 'required',
        ]);
        // Create the objective
        $driver = new Driver();
        $driver->driver = $validatedData['driver'];
        $driver->opcr_ID = $validatedData['opcr_ID'];
        $driver->division_ID = $validatedData['division_ID'];
        $driver->save();
        Alert::success('Driver created successfully!');

        return redirect()
            ->route('add-driver');
    }

    public function submit_to_division(Request $request)
    {
        DB::table('opcr')
            ->where('opcr_ID', $request->opcr_id)
            ->update(['is_submitted_division' => true]);

        // dd($request->all());
        $userName = auth()->user()->username;
        $provinceID = auth()->user()->province_ID;
        $opcr_id = $request->input('opcr_id');

        // dd($provinceID);

        // Determine division IDs based on province ID
        switch ($provinceID) {
            case 1: // Bukidnon
                $division_IDs = [1, 2, 3]; // BDD, CPD, FAD
                break;
            case 2: // Lanao
                $division_IDs = [1, 2, 3]; // BDD, CPD, FAD
                break;
            case 3: // Misamis Oriental
                $division_IDs = [1, 2, 3]; // BDD, CPD, FAD
                break;
            case 4: // Misamis Occidental
                $division_IDs = [1, 2, 3]; // BDD, CPD, FAD
                break;
            case 5: // Camiguin
                $division_IDs = [1, 2, 3]; // BDD, CPD, FAD
                break;
            default:
                $division_IDs = [];
        }

        // Send notification to DC for each division ID

        foreach ($division_IDs as $division_ID) {
            $data = $userName . ' has submitted target for OPCR #' . $opcr_id;
            $opcr = Opcr::find($opcr_id);
            $notification = new Notification([
                'user_type_ID' => 5, // DC usertype ID
                'user_ID' => auth()->id(),
                'division_ID' => $division_ID,
                'province_ID' => $provinceID,
                'opcr_ID' => $opcr_id,
                'year' => $opcr->year,
                'type' => 'OPCR Submitted',
                'data' => $data,
            ]);

            // dd($notification);
            $notification->save();
        }
        Alert::success('OPCR has been submitted to Division successfully!');

        return redirect()
            ->route('opcr');
    }

    public function bdd()
    {
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', '=', 1)
            ->get();
        $objectivesact = StrategicObjective::where('is_active', 1)->get();

        if (count($opcrs_active) > 0) {
            $measures = StrategicMeasure::join('divisions', 'strategic_measures.division_ID', '=', 'divisions.division_ID')
                ->where('type', '=', 'DIRECT')
                ->orWhere('type', '=', 'DIRECT MAIN')
                ->orWhere('type', '=', 'DIRECT COMMON')
                ->select('strategic_measures.*', 'divisions.division', 'divisions.code')
                ->get();
            foreach ($measures as $measure) {
                if ($measure->driver_ID != null) {
                    $driver_data = DB::table('drivers')
                        ->where('drivers.driver_ID', '=', $measure->driver_ID)
                        ->get();

                    // if ($driver_data[0]->opcr_ID == $opcrs_active[0]->opcr_ID) {
                    if (count($driver_data) > 0 && $driver_data[0]->opcr_ID == $opcrs_active[0]->opcr_ID) {
                        $measure['show'] = false;
                    } else {
                        $measure['show'] = true;
                    }
                } else {
                    $measure['show'] = true;
                }
            }
            //   dd($measure);
        } else {
            $measures = null;
        }

        $provinces = Province::select('province_ID', 'province')
            ->orderBy('province_ID')
            ->get();

        // $annual_targets = AnnualTarget::all()
        //     ->where(['opcr_id', '=', $opcrs_active[0]->opcr_ID])
        //     ->groupBy(['strategic_measures_ID', 'province_ID']);
        $objectives = [];
        if (count($opcrs_active) != 0) {
            $annual_targets = DB::table('annual_targets')
                ->where('opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('province_ID', '=', $user->province_ID)
                ->get()
                ->groupBy(['strategic_measures_ID', 'province_ID']);
            // dd($annual_targets);

            $annual_targets2 = DB::table('annual_targets')
                ->join('divisions', 'annual_targets.division_ID', '=', 'divisions.division_ID')
                ->where('annual_targets.opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('annual_targets.province_ID', '=', $user->province_ID)
                ->where('divisions.code', '=', 'BDD')
                ->where('annual_targets.strategic_objectives_ID', '!=', 0)
                ->get('annual_targets.*', 'divisions.code', 'divisions.division_ID')
                ->groupBy(['strategic_objectives_ID']);

            // dd($annual_targets2);

            foreach ($annual_targets2 as $key => $value) {
                // echo $key;
                $objective = StrategicObjective::where('strategic_objective_ID', $key)->first();
                if ($objective) {
                    $objectives[] = $objective;
                }
            }
            // dd("asd");
            // dd($objectives);
        } else {
            $annual_targets = null;
        }

        // dd($annual_targets);

        // $divisions = Division::all();
        // $opcrs = Opcr::all();
        // dd( $opcrs_active);
        $driversact = Driver::join('divisions', 'divisions.division_ID', '=', 'drivers.division_ID')
            ->whereHas('opcr', function ($query) use ($opcrs_active) {
                $query->whereIn('opcr_ID', $opcrs_active->pluck('opcr_ID'));
            })
            ->get(['drivers.*', 'divisions.division', 'divisions.code']);

        // dd($driversact);
        // dd("weqwe");
        $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
            ->where('monthly_accomplishment', '!=', null)
            ->where('annual_targets.province_ID', '=', $user->province_ID)
            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['annual_target_ID']);
        // dd($monthly_targets);
        foreach ($monthly_targets as $monthly_target) {
            // echo "annual target ID: {$annual_target_ID}<br>";
            $annual_accom = 0;
            $validated = true;
            foreach ($monthly_target as $target) {
                
                $annual_accom = floatval($target->monthly_accomplishment) + floatval($annual_accom);

                if ($target->validated != 'Validated') {
                    $validated = false;
                }

                if ($target->month == 'jan') {
                    $target->month_code = 0;
                } elseif ($target->month == 'feb') {
                    $target->month_code = 1;
                } elseif ($target->month == 'mar') {
                    $target->month_code = 2;
                } elseif ($target->month == 'apr') {
                    $target->month_code = 3;
                } elseif ($target->month == 'may') {
                    $target->month_code = 4;
                } elseif ($target->month == 'jun') {
                    $target->month_code = 5;
                } elseif ($target->month == 'jul') {
                    $target->month_code = 6;
                } elseif ($target->month == 'aug') {
                    $target->month_code = 7;
                } elseif ($target->month == 'sept') {
                    $target->month_code = 8;
                } elseif ($target->month == 'oct') {
                    $target->month_code = 9;
                } elseif ($target->month == 'nov') {
                    $target->month_code = 10;
                } elseif ($target->month == 'dec') {
                    $target->month_code = 11;
                }
            }

            if($monthly_target->first()->type == 'PERCENTAGE'){
                $monthly_target->annual_accom = number_format($annual_accom  /  count($monthly_target), 2);
                $monthly_target->type = 'PERCENTAGE';

            }
            else{
                $monthly_target->annual_accom = $annual_accom;
            }
            
            if ($validated = true) {
                if (count($monthly_target) < 12) {
                    $monthly_target->validated = false;
                }
            } else {
                $monthly_target->validated = false;
            }

            //    dd($monthly_targets);
            // echo $monthly_target->annual_accom;
        }
        return view('ppo.bdd', compact('measures', 'provinces', 'annual_targets', 'opcrs_active', 'driversact', 'user', 'monthly_targets', 'objectivesact', 'objectives'));
        // return view('ppo.savetarget');
        // return view('ppo.accomplishment');
    }
    public function cpd()
    {
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', '=', 1)
            ->get();

        // $objectivesact = StrategicObjective::all();

        // $objectives = StrategicObjective::all();
        if (count($opcrs_active) != 0) {
            $measures = StrategicMeasure::join('divisions', 'strategic_measures.division_ID', '=', 'divisions.division_ID')
                ->select('strategic_measures.*', 'divisions.division', 'divisions.code')
                ->get();
            foreach ($measures as $measure) {
                if ($measure->driver_ID != null) {
                    $driver_data = DB::table('drivers')
                        ->where('drivers.driver_ID', '=', $measure->driver_ID)
                        ->get();

                    // if ($driver_data[0]->opcr_ID == $opcrs_active[0]->opcr_ID) {
                    if (count($driver_data) > 0 && $driver_data[0]->opcr_ID == $opcrs_active[0]->opcr_ID) {
                        $measure['show'] = false;
                    } else {
                        $measure['show'] = true;
                    }
                } else {
                    $measure['show'] = true;
                }
            }
        } else {
            $measures = null;
        }

        // dd($measures);
        $provinces = Province::select('province_ID', 'province')
            ->orderBy('province_ID')
            ->get();

        // $annual_targets = AnnualTarget::all()
        //     ->where(['opcr_id', '=', $opcrs_active[0]->opcr_ID])
        //     ->groupBy(['strategic_measures_ID', 'province_ID']);

        $annual_targets2 = null;
        $objectives = [];

        if (count($opcrs_active) != 0) {
            $annual_targets = DB::table('annual_targets')
                ->where('opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('province_ID', '=', $user->province_ID)
                ->get()
                ->groupBy(['strategic_measures_ID', 'province_ID']);

            $annual_targets2 = DB::table('annual_targets')
                ->join('divisions', 'annual_targets.division_ID', '=', 'divisions.division_ID')
                ->where('annual_targets.opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('annual_targets.province_ID', '=', $user->province_ID)
                ->where('divisions.code', '=', 'CPD')
                ->where('annual_targets.strategic_objectives_ID', '!=', 0)
                ->get('annual_targets.*', 'divisions.code', 'divisions.division_ID')
                ->groupBy(['strategic_objectives_ID']);
            // dd($annual_targets2);

            // dd($annual_targets2);
            foreach ($annual_targets2 as $key => $value) {
                // echo $key;
                $objective = StrategicObjective::where('strategic_objective_ID', $key)->first();
                if ($objective) {
                    $objectives[] = $objective;
                }
            }
            // dd($objectives);
        } else {
            $annual_targets = null;
        }

        // dd($annual_targets);

        // $divisions = Division::all();
        // $opcrs = Opcr::all();
        // dd( $opcrs_active);
        $driversact = Driver::join('divisions', 'divisions.division_ID', '=', 'drivers.division_ID')
            ->whereHas('opcr', function ($query) use ($opcrs_active) {
                $query->whereIn('opcr_ID', $opcrs_active->pluck('opcr_ID'));
            })
            ->get(['drivers.*', 'divisions.division', 'divisions.code']);

        // dd($driversact);
        // dd("weqwe");
        $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
            ->where('monthly_accomplishment', '!=', null)
            ->where('annual_targets.province_ID', '=', $user->province_ID)
            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['annual_target_ID']);

        foreach ($monthly_targets as $monthly_target) {
            // echo "annual target ID: {$annual_target_ID}<br>";
            $annual_accom = 0;
            $validated = true;
            foreach ($monthly_target as $target) {
                $annual_accom = floatval($target->monthly_accomplishment) + floatval($annual_accom);
                // echo "{$monthly_target->id} - {$monthly_target->monthly_target}<br>";
                if ($target->validated != 'Validated') {
                    $validated = false;
                }
                if ($target->month == 'jan') {
                    $target->month_code = 0;
                } elseif ($target->month == 'feb') {
                    $target->month_code = 1;
                } elseif ($target->month == 'mar') {
                    $target->month_code = 2;
                } elseif ($target->month == 'apr') {
                    $target->month_code = 3;
                } elseif ($target->month == 'may') {
                    $target->month_code = 4;
                } elseif ($target->month == 'jun') {
                    $target->month_code = 5;
                } elseif ($target->month == 'jul') {
                    $target->month_code = 6;
                } elseif ($target->month == 'aug') {
                    $target->month_code = 7;
                } elseif ($target->month == 'sep') {
                    $target->month_code = 8;
                } elseif ($target->month == 'oct') {
                    $target->month_code = 9;
                } elseif ($target->month == 'nov') {
                    $target->month_code = 10;
                } elseif ($target->month == 'dec') {
                    $target->month_code = 11;
                }
            }
            if($monthly_target->first()->type == 'PERCENTAGE'){
                $monthly_target->annual_accom = number_format($annual_accom  /  count($monthly_target), 2);
                $monthly_target->type = 'PERCENTAGE';

            }
            else{
                $monthly_target->annual_accom = $annual_accom;
            }
            if ($validated = true) {
                if (count($monthly_target) < 12) {
                    $monthly_target->validated = false;
                }
            } else {
                $monthly_target->validated = false;
            }

            // echo $monthly_target->annual_accom;
        }

        // dd($monthly_targets);
        return view('ppo.cpd', compact('measures', 'provinces', 'annual_targets', 'opcrs_active', 'driversact', 'user', 'monthly_targets', 'annual_targets2', 'objectives'));
        // return view('ppo.savetarget');
        // return view('ppo.accomplishment');
    }
    public function fad()
    {
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', '=', 1)
            ->get();

        // $objectivesact = StrategicObjective::all();

        // $objectives = StrategicObjective::all();
        if (count($opcrs_active) != 0) {
            $measures = StrategicMeasure::join('divisions', 'strategic_measures.division_ID', '=', 'divisions.division_ID')
                ->select('strategic_measures.*', 'divisions.division', 'divisions.code')
                ->get();
            foreach ($measures as $measure) {
                if ($measure->driver_ID != null) {
                    $driver_data = DB::table('drivers')
                        ->where('drivers.driver_ID', '=', $measure->driver_ID)
                        ->get();

                    // if ($driver_data[0]->opcr_ID == $opcrs_active[0]->opcr_ID) {
                    if (count($driver_data) > 0 && $driver_data[0]->opcr_ID == $opcrs_active[0]->opcr_ID) {
                        $measure['show'] = false;
                    } else {
                        $measure['show'] = true;
                    }
                } else {
                    $measure['show'] = true;
                }
            }
        } else {
            $measures = null;
        }

        // dd($measures);
        $provinces = Province::select('province_ID', 'province')
            ->orderBy('province_ID')
            ->get();

        // $annual_targets = AnnualTarget::all()
        //     ->where(['opcr_id', '=', $opcrs_active[0]->opcr_ID])
        //     ->groupBy(['strategic_measures_ID', 'province_ID']);

        $annual_targets2 = null;
        $objectives = [];

        if (count($opcrs_active) != 0) {
            $annual_targets = DB::table('annual_targets')
                ->where('opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('province_ID', '=', $user->province_ID)
                ->get()
                ->groupBy(['strategic_measures_ID', 'province_ID']);

            $annual_targets2 = DB::table('annual_targets')
                ->join('divisions', 'annual_targets.division_ID', '=', 'divisions.division_ID')
                ->where('annual_targets.opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('annual_targets.province_ID', '=', $user->province_ID)
                ->where('divisions.code', '=', 'FAD')
                ->where('annual_targets.strategic_objectives_ID', '!=', 0)
                ->get('annual_targets.*', 'divisions.code', 'divisions.division_ID')
                ->groupBy(['strategic_objectives_ID']);

            // dd($annual_targets2);
            foreach ($annual_targets2 as $key => $value) {
                // echo $key;
                $objective = StrategicObjective::where('strategic_objective_ID', $key)->first();
                if ($objective) {
                    $objectives[] = $objective;
                }
            }
        } else {
            $annual_targets = null;
        }

        // dd($annual_targets);

        // $divisions = Division::all();
        // $opcrs = Opcr::all();
        // dd( $opcrs_active);
        $driversact = Driver::join('divisions', 'divisions.division_ID', '=', 'drivers.division_ID')
            ->whereHas('opcr', function ($query) use ($opcrs_active) {
                $query->whereIn('opcr_ID', $opcrs_active->pluck('opcr_ID'));
            })
            ->get(['drivers.*', 'divisions.division', 'divisions.code']);

        // dd($driversact);
        // dd("weqwe");
        $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
            ->where('monthly_accomplishment', '!=', null)
            ->where('annual_targets.province_ID', '=', $user->province_ID)
            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['annual_target_ID']);

        foreach ($monthly_targets as $monthly_target) {
            // echo "annual target ID: {$annual_target_ID}<br>";
            $annual_accom = 0;
            $validated = true;
            foreach ($monthly_target as $target) {
                $annual_accom = floatval($target->monthly_accomplishment) + floatval($annual_accom);
                // echo "{$monthly_target->id} - {$monthly_target->monthly_target}<br>";
                if ($target->validated != 'Validated') {
                    $validated = false;
                }

                if ($target->month == 'jan') {
                    $target->month_code = 0;
                } elseif ($target->month == 'feb') {
                    $target->month_code = 1;
                } elseif ($target->month == 'mar') {
                    $target->month_code = 2;
                } elseif ($target->month == 'apr') {
                    $target->month_code = 3;
                } elseif ($target->month == 'may') {
                    $target->month_code = 4;
                } elseif ($target->month == 'jun') {
                    $target->month_code = 5;
                } elseif ($target->month == 'jul') {
                    $target->month_code = 6;
                } elseif ($target->month == 'aug') {
                    $target->month_code = 7;
                } elseif ($target->month == 'sept') {
                    $target->month_code = 8;
                } elseif ($target->month == 'oct') {
                    $target->month_code = 9;
                } elseif ($target->month == 'nov') {
                    $target->month_code = 10;
                } elseif ($target->month == 'dec') {
                    $target->month_code = 11;
                }
            }
            if($monthly_target->first()->type == 'PERCENTAGE'){
                $monthly_target->annual_accom = number_format($annual_accom  /  count($monthly_target), 2);
                $monthly_target->type = 'PERCENTAGE';

            }
            else{
                $monthly_target->annual_accom = $annual_accom;
            }
            if ($validated = true) {
                if (count($monthly_target) < 12) {
                    $monthly_target->validated = false;
                }
            } else {
                $monthly_target->validated = false;
            }

            // echo $monthly_target->annual_accom;
        }

        return view('ppo.fad', compact('measures', 'provinces', 'annual_targets', 'opcrs_active', 'driversact', 'user', 'monthly_targets', 'annual_targets2', 'objectives'));
        // return view('ppo.savetarget');
        // return view('ppo.accomplishment');
    }

    public function validateMonthlyTarget(Request $request)
    {
        $monthly_target = MonthlyTarget::find($request->input('monthly_target_ID'));
        $monthly_target->validated = $request->input('validated');
        $monthly_target->save();
        Alert::success('Validation updated successfully.');
        return redirect()
            ->back();
    }


    public function approved_opcr(Request $request) {
        $opcr_id = $request->input('opcr_id');
        DB::table('opcr')
        ->where('opcr_ID', $opcr_id)
        ->update(['opcr_status' => 'approved']);
        Alert::success('OPCR Approved!');
        return redirect()
        ->back();
    }


    public function prepared_by(Request $request) {
        $opcr_id = $request->input('opcr_id');
        $user = auth()->user();
        $FName = $user->first_name;
        $LName = $user->last_name;
        $provinceID = $user->province_ID;

        $scorecard = ScoreCard::where('opcr_ID', $opcr_id)->where('province_ID', $provinceID)->first();

        if ($scorecard) {
            $scorecard->update([
                'prepared_by' => "$FName $LName",
                'province_ID' => $provinceID, // Add this line to update province_ID
            ]);
            Alert::success('OPCR Successfully Approved!');
        } else {
            $newScoreCard = new ScoreCard();
            $newScoreCard->opcr_ID = $opcr_id;
            $newScoreCard->province_ID = $provinceID;
            $newScoreCard->prepared_by = "$FName $LName";
            $newScoreCard->save();
            Alert::success('ScoreCard successfully added!');
        }

        return redirect()->back();
    }




}
