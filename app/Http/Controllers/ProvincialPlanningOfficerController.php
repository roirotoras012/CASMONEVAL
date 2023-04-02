<?php

namespace App\Http\Controllers;
use DB;
use Async;
use App\Models\Opcr;
use App\Models\User;
use App\Models\Driver;
use App\Models\Division;
use App\Models\Province;
use App\Models\Evaluation;
use App\Models\AnnualTarget;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\MonthlyTarget;
use App\Models\StrategicMeasure;
use App\Models\StrategicObjective;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProvincialPlanningOfficerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', '=', 1)
            ->get();

        $objectivesact = StrategicObjective::where('is_active', 1)
                                           ->get();
        
        $objectives = StrategicObjective::where('is_active', 1)
                                        ->get();

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
                ->where('province_ID', '=', $user->province_ID)
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
        $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
            ->where('monthly_accomplishment', '!=', null)
            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['annual_target_ID']);

        foreach ($monthly_targets as $monthly_target) {
            // echo "annual target ID: {$annual_target_ID}<br>";
            $annual_accom = 0;
            $validated = true;
            foreach ($monthly_target as $target) {
                $annual_accom = intval($target->monthly_accomplishment) + intval($annual_accom);
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

            // echo $monthly_target->annual_accom;
        }

        // dd($monthly_targets);
        return view('ppo.dashboard', compact('objectives', 'objectivesact', 'measures', 'provinces', 'annual_targets', 'divisions', 'opcrs', 'opcrs_active', 'driversact', 'user', 'monthly_targets'));
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
    public function opcr()
    {
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', '=', 1)
            ->get();

        $objectivesact = StrategicObjective::where('is_active', 1)
                                           ->get();
        
        $objectives = StrategicObjective::where('is_active', 1)
                                        ->get();

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
                ->where('province_ID', '=', $user->province_ID)
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
        $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
            ->where('monthly_accomplishment', '!=', null)
            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['annual_target_ID']);

        foreach ($monthly_targets as $monthly_target) {
            // echo "annual target ID: {$annual_target_ID}<br>";
            $annual_accom = 0;
            $validated = true;
            foreach ($monthly_target as $target) {
                $annual_accom = intval($target->monthly_accomplishment) + intval($annual_accom);
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

            // echo $monthly_target->annual_accom;
        }
        
        // $notification = Notification::where('opcr_ID', '=', $opcrs_active[0]->opcr_ID)
        //     ->where(function($query) {
        //         $query->where('division_ID', 1)
        //             ->orWhere('division_ID', 2)
        //             ->orWhere('division_ID', 3);
        //     })
        //     ->where('province_ID', '=', $user->province_ID)
        //     ->get();

        if ($opcrs_active->isNotEmpty()) {
            $notification = Notification::where('opcr_ID', '=', $opcrs_active[0]->opcr_ID)
                ->where(function($query) {
                    $query->where('division_ID', 1)
                        ->orWhere('division_ID', 2)
                        ->orWhere('division_ID', 3);
                })
                ->where('province_ID', '=', $user->province_ID)
                ->get();
        } else {
            $notification = null;
        }
        
        
        // dd($notification);
        // dd($monthly_targets);
        return view('ppo.opcr', compact('objectives', 'objectivesact', 'measures', 'provinces', 'annual_targets', 'divisions', 'opcrs', 'opcrs_active', 'driversact', 'user', 'monthly_targets', 'notification'));
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

        // Redirect to the measure index page
        return redirect()
            ->route('manage')
            ->with('success', 'driver has been updated successfully!');
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
        // Redirect to the objectives index page
        return redirect()
            ->route('add-driver')
            ->with('success', 'driver created successfully!');
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

        return redirect()
            ->route('opcr')
            ->with('success', 'OPCR has been submitted to Division successfully!');
    }

    public function bdd()
    {
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', '=', 1)
            ->get();
        $objectivesact = StrategicObjective::where('is_active', 1)
            ->get();

       
        if (count($opcrs_active) > 0) {
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
            ->get('annual_targets.*', 'divisions.code','divisions.division_ID')
            ->groupBy(['strategic_objectives_ID']);

            
            // dd($annual_targets2);
           
            foreach ($annual_targets2 as $key => $value) {
                // echo $key;
                $objective = StrategicObjective::where('strategic_objective_ID', $key)->first();
             if($objective){
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
                $annual_accom = intval($target->monthly_accomplishment) + intval($annual_accom);

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

            $monthly_target->annual_accom = $annual_accom;
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
            ->get('annual_targets.*', 'divisions.code','divisions.division_ID')
            ->groupBy(['strategic_objectives_ID']);
            // dd($annual_targets2);
            
            // dd($annual_targets2);
            foreach ($annual_targets2 as $key => $value) {
                // echo $key;
                $objective = StrategicObjective::where('strategic_objective_ID', $key)->first();
             if($objective){
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
                $annual_accom = intval($target->monthly_accomplishment) + intval($annual_accom);
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
            $monthly_target->annual_accom = $annual_accom;
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
            ->get('annual_targets.*', 'divisions.code','divisions.division_ID')
            ->groupBy(['strategic_objectives_ID']);

            
            // dd($annual_targets2);
            foreach ($annual_targets2 as $key => $value) {
                // echo $key;
                $objective = StrategicObjective::where('strategic_objective_ID', $key)->first();
             if($objective){
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
                $annual_accom = intval($target->monthly_accomplishment) + intval($annual_accom);
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
            $monthly_target->annual_accom = $annual_accom;
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

        return redirect()
            ->back()
            ->with('update', 'Validation updated successfully.');
    }

    
}
