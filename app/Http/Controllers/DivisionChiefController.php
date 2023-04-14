<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Opcr;
use App\Models\Notification;
use App\Models\Driver;
use App\Models\Province;
use App\Models\Evaluation;
use App\Models\AnnualTarget;
use Illuminate\Http\Request;
use App\Models\MonthlyTarget;
use App\Models\StrategicMeasure;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DivisionChiefController extends Controller
{
    public function index()
    {
        $divisionID = auth()->user()->division_ID;
        $provinceID = auth()->user()->province_ID;
        $annualTargetNumber = AnnualTarget::where('division_ID', $divisionID)
            ->where('province_ID', $provinceID)
            ->count();
        // $annualTarget = AnnualTarget::find($validatedData['annual_target_ID']);
        return view('dc.dashboard', ['division_ID' => $divisionID, 'annual_target_number' => $annualTargetNumber]);
    }

    public function getNotifications(Request $request)
    {
        $userTypeID = auth()->user()->user_type_ID;
        $divisionID = auth()->user()->division_ID;
        $provinceID = auth()->user()->province_ID;
        $userID = auth()->user()->user_ID;

        $notifications = Notification::where('user_type_ID', $userTypeID)
            ->where(function ($query) use ($divisionID) {
                $query->where('division_ID', $divisionID)->orWhereNull('division_ID');
            })

            ->where('province_ID', $provinceID)
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['notifications' => $notifications]);
    }

    public function markNotificationsAsRead(Request $request)
    {
        $userTypeID = auth()->user()->user_type_ID;
        $divisionID = auth()->user()->division_ID;
        $provinceID = auth()->user()->province_ID;

        Notification::where('province_ID', $provinceID)
            ->where('division_ID', $divisionID)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function markAsRead(Request $request)
    {
        $notificationId = $request->input('notification_id');
        $notification = Notification::findOrFail($notificationId);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        // dd($request);
        // $monthly_target_id = $request->input('monthly_target_ID');
        $validatedData = $request->validate([
          
            'monthly_target' => 'required',
            'annual_target_ID' => 'required',
            'division_ID' => 'required',
            'month' => 'required',
        ]);

        // Get the annual target for the given annual_target_ID
        $annualTarget = AnnualTarget::find($validatedData['annual_target_ID']);

        // Get the sum of monthly targets for the given annual_target_ID
        $monthlyTargetSum = MonthlyTarget::where('annual_target_ID', $validatedData['annual_target_ID'])->sum('monthly_target');

        // Check if the sum of monthly targets and the new monthly target exceeds the annual target
        if ($monthlyTargetSum + $validatedData['monthly_target'] > $annualTarget->annual_target) {
            return redirect()
                ->back()
                ->with('alert', 'Monthly target exceeds the annual target.');
                
                
        }
        // Create the monthly target
        $monthlyTarget = new MonthlyTarget();
     
        $monthlyTarget->monthly_target = $validatedData['monthly_target'];
        $monthlyTarget->annual_target_ID = $validatedData['annual_target_ID'];
        $monthlyTarget->division_ID = $validatedData['division_ID'];
        $monthlyTarget->month = $validatedData['month'];
      
        $monthlyTarget->save();
       

        return redirect()
            ->route('dc.bukidnunBddIndex')
            ->with('success', 'Annual Target successfully!');
    }

    public function updateTar(Request $request) {
        $validatedData = $request->validate([
            'monthly_target_ID' => 'required',
            'monthly_target' => 'required',
            'annual_target_ID' => 'required',
            'division_ID' => 'required',
            'month' => 'required',
        ]);
    
        // Get the monthly target for the given monthly_target_ID
        $monthlyTarget = MonthlyTarget::find($validatedData['monthly_target_ID']);
    
        // Get the annual target for the given annual_target_ID
        $annualTarget = AnnualTarget::find($validatedData['annual_target_ID']);
    
        // Get the sum of monthly targets for the given annual_target_ID
        $monthlyTargetSum = MonthlyTarget::where('annual_target_ID', $validatedData['annual_target_ID'])->where('monthly_target_ID', '<>', $validatedData['monthly_target_ID'])->sum('monthly_target');
    
        // Check if the sum of monthly targets and the new monthly target exceeds the annual target
        if ($monthlyTargetSum + $validatedData['monthly_target'] > $annualTarget->annual_target) {
            return redirect()
                ->back()
                ->with('alert', 'Monthly target exceeds the annual target.');
        }
    
        // Update the monthly target
        $monthlyTarget->monthly_target = $validatedData['monthly_target'];
        $monthlyTarget->division_ID = $validatedData['division_ID'];
        $monthlyTarget->month = $validatedData['month'];
        //   dd($monthlyTarget);
        $monthlyTarget->update();
    
        return redirect()
            ->route('dc.bukidnunBddIndex')
            ->with('success', 'Monthly Target successfully updated!');
    }
    

    public function storeAccom(Request $request)
    {
        $validatedData = $request->validate([
            'monthly_accom' => 'required',
            'monthly_target_ID' => 'required',
        ]);

        $monthly_target_id = $request->input('monthly_target_ID');
        $monthly_target = MonthlyTarget::find($monthly_target_id);
        $monthly_target->monthly_accomplishment = $request->input('monthly_accom');
        $monthly_target->save();

        $accom = MonthlyTarget::find($monthly_target_id);

        $eval = ($accom->monthly_accomplishment / $accom->monthly_target) * 100;
        $monthly_target_data = $monthly_target;

        if ($eval < 90) {
            $user = Auth::user();
            $evaluation = new Evaluation();
            $evaluation->user_ID = $user->user_ID;
            $evaluation->strategic_measure = $request->input('strategic_measure');
            $evaluation->monthly_target = $accom->monthly_target;
            $evaluation->monthly_accomplishment = $accom->monthly_accomplishment;
            $evaluation->month = $request->input('month');
            // dd($evaluation);
            $evaluation->save();

            $userName = auth()->user()->first_name;
            $provinceID = auth()->user()->province_ID;
            $divisionID = auth()->user()->division_ID;
            $userTypeID = auth()->user()->user_type_ID;
            // $opcr_id = $request->input('opcr_id');
            // $opcr = Opcr::find($opcr_id);
            $accom = MonthlyTarget::find($monthly_target_id);
            $accom = $request->input('month');

            // $data = $userName . ' has updated monthly accomplishment for the month of ' . $accom;
            $data = $userName . ' has failed to achieved the target';

            $user_ID = Auth::id();

            $divisionID = '';
            switch (auth()->user()->division_ID) {
                case 1:
                    $divisionID = 'BDD';
                    break;
                case 2:
                    $divisionID = 'CPD';
                    break;
                case 3:
                    $divisionID = 'FAD';
                    break;
                default:
                    $divisionID = ''; // or you can set a default value if needed
            }

            $notification = new Notification([
                'user_type_ID' => 4, // Notify to PPO
                'user_ID' => $user_ID,
                // 'division_ID' => $divisionID,
                'province_ID' => $provinceID,
                // 'opcr_ID' => $opcr_id,
                // 'year' => $opcr->year,
                'type' => $divisionID,
                'data' => $data,
            ]);

            //  dd($notification);
            $notification->save();

            return redirect()
                ->route('dc.accomplishments')
                ->with('alert', 'You haven\'t achieved your target. Fill up the evaluation form');
        } else {
            $userName = auth()->user()->first_name;
            $provinceID = auth()->user()->province_ID;
            $divisionID = auth()->user()->division_ID;
            $userTypeID = auth()->user()->user_type_ID;
            // $opcr_id = $request->input('opcr_id');
            // $opcr = Opcr::find($opcr_id);
            $accom = MonthlyTarget::find($monthly_target_id);
            $accom = $request->input('month');

            // $data = $userName . ' has updated monthly accomplishment for the month of ' . $accom;
            $data = $userName . ' has updated monthly accomplishment';

            $user_ID = Auth::id();

            $divisionID = '';
            switch (auth()->user()->division_ID) {
                case 1:
                    $divisionID = 'BDD';
                    break;
                case 2:
                    $divisionID = 'CPD';
                    break;
                case 3:
                    $divisionID = 'FAD';
                    break;
                default:
                    $divisionID = ''; // or you can set a default value if needed
            }

            $notification = new Notification([
                'user_type_ID' => 4, // Notify to PPO
                'user_ID' => $user_ID,
                // 'division_ID' => $divisionID,
                'province_ID' => $provinceID,
                // 'opcr_ID' => $opcr_id,
                // 'year' => $opcr->year,
                'type' => $divisionID,
                'data' => $data,
            ]);

            //  dd($notification);
            $notification->save();

            return redirect()
                ->route('dc.accomplishments')
                ->with('success', 'Monthly Target successfully added!');
        }
    }

    public function updateEmailHandler(Request $request)
    {
        // dd($request);
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
    public function jobfam()
    {
        return view('dc.job-fam');
    }
    public function viewTarget()
    {
        return view('dc.view-target');
    }
    public function accomplishment()
    {
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', 1)
            ->where('is_submitted_division', 1)
            ->get();
        $provinces = Province::select('province_ID', 'province')
            ->orderBy('province_ID')
            ->get();

        $driversact = Driver::join('divisions', 'divisions.division_ID', '=', 'drivers.division_ID')
            ->whereHas('opcr', function ($query) use ($opcrs_active) {
                $query->whereIn('opcr_ID', $opcrs_active->pluck('opcr_ID'));
            })
            ->get(['drivers.*', 'divisions.division']);
        $measures = StrategicMeasure::join('divisions', 'strategic_measures.division_ID', '=', 'divisions.division_ID')
            ->select('strategic_measures.*', 'divisions.division')
            ->get();
        $user = Auth::user();
        $measures_list = StrategicMeasure::where('division_ID', $user->division_ID)
            ->get()
            ->groupBy(['strategic_measure_ID']);
        if (count($opcrs_active) != 0) {
            $annual_targets = DB::table('annual_targets')
                ->where('opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('province_ID', '=', $user->province_ID)
                ->get()
                ->groupBy(['strategic_measures_ID', 'province_ID']);
        } else {
            $annual_targets = null;
        }

        // dd($measures);
        $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['month', 'annual_target_ID']);
            $notification = null;
            if (count($opcrs_active) > 0) {
                $notification = Notification::where('opcr_ID', '=', $opcrs_active[0]->opcr_ID)
                    ->where('division_ID', '=', $user->division_ID)
                    ->where('province_ID', '=', $user->province_ID)
                    ->get();
            }
            
        return view('dc.accomplishment', compact('measures', 'provinces', 'annual_targets', 'driversact', 'monthly_targets', 'user', 'measures_list', 'notification','opcrs_active'));
    }

    public function profile()
    {
        return view('dc.profile');
    }

    public function coaching()
    {
        $user = Auth::user();
        $eval = Evaluation::select('*')
            ->where('user_id', $user->user_ID)
            ->get();
        // dd($eval);

        return view('dc.coaching', compact('eval'));
    }

    

    public function bukidnunBddIndex()
    {
        $user = Auth::user();

        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', 1)
            ->where('is_submitted_division', 1)
            ->get();

        $provinces = Province::select('province_ID', 'province')
            ->orderBy('province_ID')
            ->get();

        $driversact = Driver::join('divisions', 'divisions.division_ID', '=', 'drivers.division_ID')
            ->whereHas('opcr', function ($query) use ($opcrs_active) {
                $query->whereIn('opcr_ID', $opcrs_active->pluck('opcr_ID'));
            })
            ->get(['drivers.*', 'divisions.division']);

        $measures_list = StrategicMeasure::where('division_ID', $user->division_ID)
            ->get()
            ->groupBy(['strategic_measure_ID']);

        if (count($opcrs_active) != 0) {
            $annual_targets = DB::table('annual_targets')
                ->where('opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('province_ID', '=', $user->province_ID)
                ->get()
                ->groupBy(['strategic_measures_ID', 'province_ID']);
        } else {
            $annual_targets = null;
        }

        if (count($opcrs_active) != 0) {
            $notification = Notification::where('opcr_ID', '=', $opcrs_active[0]->opcr_ID)
                ->where('division_ID', '=', $user->division_ID)
                ->where('province_ID', '=', $user->province_ID)
                ->get();
        } else {
            $notification = null;
        }

        $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['month', 'annual_target_ID']);

        return view('dc.view-target', compact('provinces', 'annual_targets', 'driversact', 'monthly_targets', 'measures_list', 'user', 'notification', 'opcrs_active'));
    }

    

    public function manage()
    {
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', 1)
            ->where('is_submitted_division', 1)
            ->get();
        $opcr_id = isset($opcrs_active[0]) ? $opcrs_active[0]->opcr_ID : null;
        $drivers = Driver::where('opcr_ID', '=', $opcr_id)
            ->where('division_ID', '=', $user->division_ID)
            ->get();
        $measures = StrategicMeasure::where('strategic_measures.division_ID', $user->division_ID)
            ->where(function ($query) {
                $query
                    ->where('strategic_measures.type', 'DIRECT')
                    ->orWhere('strategic_measures.type', 'DIRECT COMMON')
                    ->orWhere('strategic_measures.type', 'DIRECT MAIN')
                    ->orWhere('strategic_measures.type', 'INDIRECT')
                    ->orWhere('strategic_measures.type', 'MANDATORY');
            })
            ->where(function ($query) use ($opcr_id) {
                $query
                    ->whereNull('strategic_measures.opcr_ID')
                    ->orWhere('strategic_measures.opcr_ID', 0)
                    ->orWhere('strategic_measures.opcr_ID', $opcr_id);
            })
            ->get(['strategic_measures.*']);

        $annual_targets = AnnualTarget::where('opcr_ID', '=', $opcr_id)
            ->where('division_ID', '=', $user->division_ID)
            ->where('province_ID', '=', $user->province_ID)
            ->get()
            ->groupBy(['strategic_measures_ID']);
        $notification = Notification::where('opcr_ID', '=', $opcr_id)
            ->where('division_ID', '=', $user->division_ID)
            ->where('province_ID', '=', $user->province_ID)
            ->get();

        return view('dc.manage', compact('drivers', 'measures', 'annual_targets', 'user', 'notification'));
    }

    public function add_driver(Request $request)
    {
        // dd($request->data);
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', 1)
            ->where('is_submitted_division', 1)
            ->get();
        $new_driver = $request->driver;
        $new_driver_letter = $request->number_driver;
        $select_driver = $request->driver_ID;
        // echo $request->driver;
        // echo $request->driver_ID;
        // var_dump($request->data);
        $add_group = $request->add;
        $group = $request->data;
        // dd( $group);
        $driver_use = null;
        if ($new_driver) {
            $driver = new Driver();
            $driver->driver = $new_driver;
            $driver->opcr_ID = $opcrs_active[0]->opcr_ID;
            $driver->division_ID = $user->division_ID;
            $driver->number_driver = $new_driver_letter;
            $driver->save();
            $driver_use = $driver->driver_ID;
        } elseif ($select_driver) {
            $driver_use = $select_driver;
        }
        if ($add_group) {
            foreach ($add_group as $add_key) {
                # code...
                // echo $add_key['measure']."  ";
                // echo $add_key['target']."  ";
                // echo $add_key['type']."  ";
                if ($add_key['measure'] != null) {
                    $strategic_measure = new StrategicMeasure();
                    $strategic_measure->strategic_measure = $add_key['measure'];
                    $strategic_measure->type = $add_key['type'];
                    $strategic_measure->division_ID = $user->division_ID;
                    $strategic_measure->strategic_objective_ID = 0;
                    $strategic_measure->save();
                    if ($strategic_measure->strategic_measure_ID) {
                        if (isset($add_key['target'])) {
                            $annual_target = new AnnualTarget();
                            $annual_target->strategic_measures_ID = $strategic_measure->strategic_measure_ID;
                            $annual_target->strategic_objectives_ID = 0;
                            $annual_target->province_ID = $user->province_ID;
                            $annual_target->division_ID = $user->division_ID;
                            $annual_target->annual_target = $add_key['target'];
                            $annual_target->opcr_ID = $opcrs_active[0]->opcr_ID;
                            $annual_target->driver_ID = $driver_use;
                        } else {
                            $annual_target = new AnnualTarget();
                            $annual_target->strategic_measures_ID = $strategic_measure->strategic_measure_ID;
                            $annual_target->strategic_objectives_ID = 0;
                            $annual_target->province_ID = $user->province_ID;
                            $annual_target->division_ID = $user->division_ID;
                            $annual_target->annual_target = 0;
                            $annual_target->opcr_ID = $opcrs_active[0]->opcr_ID;
                            $annual_target->driver_ID = $driver_use;
                        }
                        $annual_target->save();
                    }
                }
            }
        }

        if ($group) {
            foreach ($group as $group_key) {
                # code...

                if (isset($group_key['target_ID'])) {
                    $annual_target = AnnualTarget::find($group_key['target_ID']);
                    $annual_target->driver_ID = $driver_use;
                    $annual_target->save();
                }
                if (isset($group_key['measure_ID']) && isset($group_key['target'])) {
                    $annual_target = new AnnualTarget();
                    $annual_target->strategic_measures_ID = $group_key['measure_ID'];
                    $annual_target->strategic_objectives_ID = 0;
                    $annual_target->province_ID = $user->province_ID;
                    $annual_target->division_ID = $user->division_ID;
                    $annual_target->annual_target = $group_key['target'];
                    $annual_target->opcr_ID = $opcrs_active[0]->opcr_ID;
                    $annual_target->driver_ID = $driver_use;
                    $annual_target->save();
                }
            }
        }

        session()->flash('success', 'Transaction Completed');
        return redirect()
            ->route('dc.manage')
            ->with('success', 'Transaction Completed');
    }
}
