<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Opcr;
use App\Models\Notification;
use App\Models\Driver;
use App\Models\Pgs;
use App\Models\Province;
use App\Models\Evaluation;
use App\Models\AnnualTarget;
use Illuminate\Http\Request;
use App\Models\MonthlyTarget;
use App\Models\StrategicMeasure;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

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
        $validatedData = $request->validate([
            'monthly_target' => 'required|numeric|min:0',
            'annual_target_ID' => 'required',
            'division_ID' => 'required',
            'month' => 'required',
            'target_type',
        ]);

        // Ensure no letters are present in the monthly target value
        if (preg_match('/[a-zA-Z]/', $validatedData['monthly_target'])) {
            Alert::warning('Invalid input. Monthly target should not contain letters.');

            // return redirect()
            //     ->back()
            //     ->with('alert', 'Invalid input. Monthly target should not contain letters.');
            return redirect()->back();
        }

        // Get the annual target
        $annualTarget = AnnualTarget::find($validatedData['annual_target_ID']);

        // Calculate the total monthly targets for the corresponding annual target
        $totalMonthlyTargets = MonthlyTarget::where('annual_target_ID', $annualTarget->annual_target_ID)->sum('monthly_target');

        // Add the new monthly target to the total
        $newTotalMonthlyTargets = $totalMonthlyTargets + $validatedData['monthly_target'];

        // Check if the new total exceeds the annual target
        if ($annualTarget->type == 'PERCENTAGE') {
            $annualTargetValue = $annualTarget->annual_target / 100; // Convert percentage to decimal
        } else {
            $annualTargetValue = $annualTarget->annual_target;
        }

        // Check if it is the month of December
        if ($validatedData['month'] == 'dec') {
            // Check if the new total is equal to the annual target
            if ($newTotalMonthlyTargets != $annualTargetValue) {
                Alert::success('December monthly target must be equal to the annual target.');

                return redirect()->back();
            }
        } else {
            // For other months, check if the new total exceeds the annual target
            if ($newTotalMonthlyTargets > $annualTargetValue) {
                Alert::warning('Monthly target exceeds the annual target.');

                return redirect()->back();
            }
        }

        // Create the monthly target
        $monthlyTarget = new MonthlyTarget();

        $monthlyTarget->monthly_target = $validatedData['monthly_target'];
        $monthlyTarget->annual_target_ID = $validatedData['annual_target_ID'];
        $monthlyTarget->division_ID = $validatedData['division_ID'];
        $monthlyTarget->month = $validatedData['month'];

        $monthlyTarget->type = isset($validatedData['target_type']) ? $validatedData['target_type'] : null;
        $monthlyTarget->save();
        Alert::success('Annual Target successfully added!');

        // return redirect()
        //     ->route('dc.bukidnunBddIndex')
        //     ->with('success', 'Annual Target successfully added!');
        return redirect()->route('dc.bukidnunBddIndex');
    }

    public function updateTar(Request $request)
    {
        $validatedData = $request->validate([
            'monthly_target_ID' => 'required',
            'monthly_target' => 'required|numeric|min:0',
            'annual_target_ID' => 'required',
            'division_ID' => 'required',
            'month' => 'required',
        ]);

        // Ensure no letters are present in the monthly target value
        if (preg_match('/[a-zA-Z]/', $validatedData['monthly_target'])) {
            Alert::warning('Invalid input. Monthly target should not contain letters.');

            return redirect()->back();

            // return redirect()
            // ->back()
            // ->with('alert', 'Invalid input. Monthly target should not contain letters.');
        }

        // Get the monthly target for the given monthly_target_ID
        $monthlyTarget = MonthlyTarget::find($validatedData['monthly_target_ID']);

        // Get the annual target for the given annual_target_ID
        $annualTarget = AnnualTarget::find($validatedData['annual_target_ID']);

        // Get the sum of monthly targets for the given annual_target_ID
        $monthlyTargetSum = MonthlyTarget::where('annual_target_ID', $validatedData['annual_target_ID'])
            ->where('monthly_target_ID', '<>', $validatedData['monthly_target_ID'])
            ->sum('monthly_target');

        // Calculate the new total monthly targets (excluding the current monthly target being updated)
        $newTotalMonthlyTargets = $monthlyTargetSum + $validatedData['monthly_target'];

        // Check if the new total exceeds the annual target
        if ($annualTarget->type == 'PERCENTAGE') {
            $annualTargetValue = $annualTarget->annual_target / 100; // Convert percentage to decimal
        } else {
            $annualTargetValue = $annualTarget->annual_target;
        }

        // Check if it is the month of December
        if ($validatedData['month'] == 'dec') {
            // Check if the new total is equal to the annual target
            if ($newTotalMonthlyTargets != $annualTargetValue) {
                return redirect()
                    ->back()
                    ->with('alert', 'December monthly target must be equal to the annual target.');
            }
        } else {
            // For other months, check if the new total exceeds the annual target
            if ($newTotalMonthlyTargets > $annualTargetValue) {
                return redirect()
                    ->back()
                    ->with('alert', 'Monthly target exceeds the annual target.');
            }
        }

        // Update the monthly target
        $monthlyTarget->monthly_target = $validatedData['monthly_target'];
        $monthlyTarget->division_ID = $validatedData['division_ID'];
        $monthlyTarget->month = $validatedData['month'];
        $monthlyTarget->update();

        return redirect()
            ->route('dc.bukidnunBddIndex')
            ->with('success', 'Monthly Target successfully updated!');
    }

    public function storeAccom(Request $request)
    {
        $validatedData = $request->validate(
            [
                'monthly_accom' => 'required|numeric|min:0',
                'monthly_target_ID' => 'required',
            ],
            [
                'monthly_accom.required' => 'The monthly accomplishment field is required.',
                'monthly_accom.numeric' => 'The monthly accomplishment must be a numeric value.',
                'monthly_accom.min' => 'The monthly accomplishment must be a non-negative value.',
                'monthly_target_ID.required' => 'The monthly target ID field is required.',
            ],
        );

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
            $evaluation->monthly_target_ID = $request->input('monthly_target_ID');
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
            Alert::success('Email updated successfully.');

            return redirect()->back();
        } else {
            // Show an error message
            Alert::error('Invalid Password');
            return redirect()->back();
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

            return redirect()->back();
        } else {
            Alert::error('Invalid Password');

            return redirect()->back();
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
        $valid_meas2 = [];
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', 1)
            ->where('is_submitted_division', 1)
            ->get();
        $provinces = Province::select('province_ID', 'province')
            ->orderBy('province_ID')
            ->get();

        $driversact = Driver::join('divisions', 'divisions.division_ID', '=', 'drivers.division_ID')->get(['drivers.*', 'divisions.division']);
        $measures = StrategicMeasure::join('divisions', 'strategic_measures.division_ID', '=', 'divisions.division_ID')
            ->select('strategic_measures.*', 'divisions.division')
            ->get();
        $user = Auth::user();
        $measures_list = StrategicMeasure::where('division_ID', $user->division_ID)
            ->get()
            ->groupBy(['strategic_measure_ID']);

        if (count($opcrs_active) != 0) {
            for ($i = 0; $i < 2; $i++) {
                foreach ($measures_list as $measure_list) {
                    $sumTarget = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    $sumAccom = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    $months = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
                    $annual_target = null;
                    if (isset($measure_list->first()->sum_of)) {
                        $annual_target = AnnualTarget::where('province_ID', $user->province_ID)
                            ->where('division_ID', $user->division_ID)
                            ->where('strategic_measures_ID', $measure_list->first()->strategic_measure_ID)
                            ->where('opcr_ID', $opcrs_active->first()->opcr_ID)
                            ->get()
                            ->first();

                        $measures_exploded = explode(',', $measure_list->first()->sum_of);

                        foreach ($months as $monthIndex => $month) {
                            foreach ($measures_exploded as $exploded_measure) {
                                $monthlyTargetforSum = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
                                    ->where('annual_targets.strategic_measures_ID', $exploded_measure)

                                    ->where('month', $month)
                                    ->where('annual_targets.province_ID', $user->province_ID)
                                    ->where('monthly_targets.division_ID', $measure_list->first()->division_ID)
                                    ->where('annual_targets.opcr_ID', $opcrs_active->first()->opcr_ID)
                                    ->select('monthly_targets.*')
                                    ->get()
                                    ->first();

                                if (isset($monthlyTargetforSum)) {
                                    $sumAccom[$monthIndex] += $monthlyTargetforSum->monthly_accomplishment;
                                }
                            }

                            $monthly_target_parent = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
                                ->where('annual_targets.strategic_measures_ID', $measure_list->first()->strategic_measure_ID)
                                ->where('annual_targets.annual_target_ID', $annual_target->annual_target_ID)
                                ->where('month', $month)
                                ->where('monthly_targets.division_ID', $measure_list->first()->division_ID)
                                ->where('annual_targets.opcr_ID', $opcrs_active->first()->opcr_ID)
                                ->select('monthly_targets.*')
                                ->get()
                                ->first();

                            if ($sumAccom[$monthIndex] > 0 && isset($annual_target)) {
                                if (isset($monthly_target_parent)) {
                                    // dd($sumTarget);
                                    // dd($monthly_target_parent , $sumTarget[$monthIndex]);
                                    if ($monthly_target_parent->monthly_accomplishment != $sumAccom[$monthIndex]) {
                                        $monthly_target_parent->monthly_accomplishment = $sumAccom[$monthIndex];

                                        $monthly_target_parent->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (count($opcrs_active) != 0) {
            $annual_targets = DB::table('annual_targets')
                ->where('opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('province_ID', '=', $user->province_ID)
                ->get()
                ->groupBy(['strategic_measures_ID', 'province_ID']);
        } else {
            $annual_targets = null;
        }

        $total_number_of_valid_measures = collect();
        if (count($opcrs_active) > 0) {
            //pgs rating

            $total_number_of_valid_measures = AnnualTarget::join('strategic_measures', 'annual_targets.strategic_measures_ID', '=', 'strategic_measures.strategic_measure_ID')
                ->where('annual_targets.province_ID', $user->province_ID)
                ->where('annual_targets.opcr_ID', $opcrs_active[0]['opcr_ID'])
                ->where('annual_targets.division_ID', $user->division_ID)
                ->where(function ($query) {
                    $query
                        ->where('strategic_measures.type', '=', 'DIRECT')
                        ->orWhere('strategic_measures.type', '=', 'DIRECT MAIN')
                        ->orWhere('strategic_measures.type', '=', 'DIRECT COMMON')
                        ->orWhere('strategic_measures.type', '=', 'MANDATORY')
                        ->orWhere('strategic_measures.type', '=', 'INDIRECT');
                })
                ->where(function ($query) {
                    $query->whereNull('strategic_measures.is_sub')->orWhere('strategic_measures.is_sub', '!=', 1);
                })
                ->select('annual_targets.*', 'strategic_measures.strategic_measure', DB::raw('(SELECT SUM(monthly_accomplishment) FROM monthly_targets WHERE monthly_targets.annual_target_ID = annual_targets.annual_target_ID) AS total_accomplishment'))
                ->having('total_accomplishment', '<>', 0)
                ->get();
            // dd($total_number_of_valid_measures);
            $total_number_of_accomplished_measure = 0;
            foreach ($total_number_of_valid_measures as $acc_meas) {
                if (($acc_meas->total_accomplishment / $acc_meas->annual_target) * 100 >= 90) {
                    $total_number_of_accomplished_measure++;
                }
            }

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
            $valid_meas2 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $total_number_of_valid_measures2 = MonthlyTarget::join('annual_targets', 'monthly_targets.annual_target_ID', '=', 'annual_targets.annual_target_ID')
                ->join('strategic_measures', 'strategic_measures.strategic_measure_ID', '=', 'annual_targets.strategic_measures_ID')
                ->where(function ($query) {
                    $query->whereNull('strategic_measures.is_sub')->orWhere('strategic_measures.is_sub', '!=', 1);
                })
                ->where('annual_targets.province_ID', $user->province_ID)
                ->where('annual_targets.opcr_ID', $opcrs_active[0]['opcr_ID'])
                ->where('annual_targets.division_ID', $user->division_ID)
                ->where('monthly_targets.monthly_target', '!=', null || 0)

                ->get();
            foreach ($total_number_of_valid_measures2 as $item) {
                if ($item->month == 'jan') {
                    $valid_meas2[0]++;
                }
                if ($item->month == 'feb') {
                    $valid_meas2[1]++;
                }
                if ($item->month == 'mar') {
                    $valid_meas2[2]++;
                }
                if ($item->month == 'apr') {
                    $valid_meas2[3]++;
                }
                if ($item->month == 'may') {
                    $valid_meas2[4]++;
                }
                if ($item->month == 'jun') {
                    $valid_meas2[5]++;
                }
                if ($item->month == 'jul') {
                    $valid_meas2[6]++;
                }
                if ($item->month == 'aug') {
                    $valid_meas2[7]++;
                }
                if ($item->month == 'sep') {
                    $valid_meas2[8]++;
                }
                if ($item->month == 'oct') {
                    $valid_meas2[9]++;
                }
                if ($item->month == 'nov') {
                    $valid_meas2[10]++;
                }
                if ($item->month == 'dec') {
                    $valid_meas2[11]++;
                }
            }
            // dd($valid_meas2);
            // PGS array
            $pgs = [
                'total_number_of_valid_measures' => $total_number_of_valid_measures->count(),
                'total_number_of_accomplished_measure' => $total_number_of_accomplished_measure,
                'numerical_rating' => $pgsrating !== null ? $pgsrating->numeric : null,
                'rating' => $pgsratingtext,
                'rating_bg_color' => $rating_bg_color,
            ];
        } else {
            $monthly_targets2 = [];
            $pgs = [];
        }

        $pgsrating2 = Pgs::where('total_num_of_targeted_measure', $total_number_of_valid_measures->count())

            ->get()
            ->groupBy('actual_num_of_accomplished_measure');
        // dd($pgsrating2);
        // dd($measures);
        // $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
        //     ->get(['monthly_targets.*', 'annual_targets.*'])
        //     ->groupBy(['month', 'annual_target_ID']);

        $monthly_targets = MonthlyTarget::with('evaluations')
            ->leftjoin('evaluations', 'evaluations.monthly_target_ID', '=', 'monthly_targets.monthly_target_ID')
            ->join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
            ->get(['monthly_targets.*', 'annual_targets.*', 'evaluations.remark'])
            ->groupBy(['month', 'annual_target_ID']);

        // dd($monthly_targets);

        $notification = null;
        if (count($opcrs_active) > 0) {
            $notification = Notification::where('opcr_ID', '=', $opcrs_active[0]->opcr_ID)
                ->where('division_ID', '=', $user->division_ID)
                ->where('province_ID', '=', $user->province_ID)
                ->get();
        }

        $evaluations = Evaluation::all();

        $remarks = [];

        foreach ($evaluations as $evaluation) {
            $remark = $evaluation->remark;
            $remarks[] = $remark;
        }
        // dd($evaluations);

        $cutoff = [];

        if (count($opcrs_active) != 0) {
            $newStatus = substr($opcrs_active[0]->cutoff_status, 0, 1);

            if (substr($opcrs_active[0]->cutoff_status, 0, 1) == '1') {
                $cutoff[0] = true;
            } else {
                $cutoff[0] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 1, 1) == '1') {
                $cutoff[1] = true;
            } else {
                $cutoff[1] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 2, 1) == '1') {
                $cutoff[2] = true;
            } else {
                $cutoff[2] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 3, 1) == '1') {
                $cutoff[3] = true;
            } else {
                $cutoff[3] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 4, 1) == '1') {
                $cutoff[4] = true;
            } else {
                $cutoff[4] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 5, 1) == '1') {
                $cutoff[5] = true;
            } else {
                $cutoff[5] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 6, 1) == '1') {
                $cutoff[6] = true;
            } else {
                $cutoff[6] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 7, 1) == '1') {
                $cutoff[7] = true;
            } else {
                $cutoff[7] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 8, 1) == '1') {
                $cutoff[8] = true;
            } else {
                $cutoff[8] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 9, 1) == '1') {
                $cutoff[9] = true;
            } else {
                $cutoff[9] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 10, 1) == '1') {
                $cutoff[10] = true;
            } else {
                $cutoff[10] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 11, 1) == '1') {
                $cutoff[11] = true;
            } else {
                $cutoff[11] = false;
            }

            // dd($cutoff);
        }

        return view('dc.accomplishment', compact('measures', 'evaluations', 'remarks', 'cutoff', 'provinces', 'annual_targets', 'driversact', 'monthly_targets', 'user', 'measures_list', 'notification', 'opcrs_active', 'pgsrating2', 'pgs', 'valid_meas2'));
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

        $measures_list = StrategicMeasure::where('division_ID', $user->division_ID)

            ->get()

            ->groupBy(['strategic_measure_ID']);
        $driversact = null;

        if (count($opcrs_active) != 0) {
            for ($i = 0; $i < 2; $i++) {
                foreach ($measures_list as $measure_list) {
                    $sumTarget = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    $sumAccom = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    $months = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
                    $annual_target = null;
                    if (isset($measure_list->first()->sum_of)) {
                        $annual_target = AnnualTarget::where('province_ID', $user->province_ID)
                            ->where('division_ID', $user->division_ID)
                            ->where('strategic_measures_ID', $measure_list->first()->strategic_measure_ID)
                            ->where('opcr_ID', $opcrs_active->first()->opcr_ID)
                            ->get()
                            ->first();

                        $measures_exploded = explode(',', $measure_list->first()->sum_of);

                        foreach ($months as $monthIndex => $month) {
                            foreach ($measures_exploded as $exploded_measure) {
                                $monthlyTargetforSum = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
                                    ->where('annual_targets.strategic_measures_ID', $exploded_measure)

                                    ->where('month', $month)
                                    ->where('annual_targets.province_ID', $user->province_ID)
                                    ->where('monthly_targets.division_ID', $measure_list->first()->division_ID)
                                    ->where('annual_targets.opcr_ID', $opcrs_active->first()->opcr_ID)
                                    ->select('monthly_targets.*')
                                    ->get()
                                    ->first();

                                if (isset($monthlyTargetforSum)) {
                                    $sumTarget[$monthIndex] += $monthlyTargetforSum->monthly_target;
                                }
                            }

                            $monthly_target_parent = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
                                ->where('annual_targets.strategic_measures_ID', $measure_list->first()->strategic_measure_ID)
                                ->where('annual_targets.annual_target_ID', $annual_target->annual_target_ID)
                                ->where('month', $month)
                                ->where('monthly_targets.division_ID', $measure_list->first()->division_ID)
                                ->where('annual_targets.opcr_ID', $opcrs_active->first()->opcr_ID)
                                ->select('monthly_targets.*')
                                ->get()
                                ->first();

                            if ($sumTarget[$monthIndex] > 0 && isset($annual_target)) {
                                if (isset($monthly_target_parent)) {
                                    // dd($sumTarget);
                                    // dd($monthly_target_parent , $sumTarget[$monthIndex]);
                                    if ($monthly_target_parent->monthly_target != $sumTarget[$monthIndex]) {
                                        $monthly_target_parent->monthly_target = $sumTarget[$monthIndex];

                                        $monthly_target_parent->save();
                                    }
                                } else {
                                    // dd($monthly_target_parent);
                                    $new_Mtarget = new MonthlyTarget();
                                    $new_Mtarget->month = $month;
                                    $new_Mtarget->monthly_target = $sumTarget[$monthIndex];
                                    $new_Mtarget->division_ID = $measure_list->first()->division_ID;
                                    $new_Mtarget->annual_target_ID = $annual_target->annual_target_ID;
                                    $new_Mtarget->save();
                                }
                            }
                        }
                    }
                }
            }
        }

        if (count($opcrs_active) != 0) {
            $driversact = Driver::join('divisions', 'divisions.division_ID', '=', 'drivers.division_ID')
                ->join('annual_targets', 'annual_targets.driver_ID', '=', 'drivers.driver_ID')
                ->where('annual_targets.opcr_id', $opcrs_active[0]->opcr_ID)
                ->distinct()
                ->get(['drivers.*', 'divisions.division']);
            // dd($driversact);
            $annual_targets = DB::table('annual_targets')
                ->join('strategic_measures', 'annual_targets.strategic_measures_ID', '=', 'strategic_measures.strategic_measure_ID')
                ->where('annual_targets.opcr_id', '=', $opcrs_active[0]->opcr_ID)
                ->where('annual_targets.province_ID', '=', $user->province_ID)
                ->select('annual_targets.*', 'strategic_measures.sum_of')
                ->get()
                ->groupBy(['strategic_measures_ID', 'province_ID']);
            // dd($annual_targets);

            foreach ($annual_targets as $annual_target) {
                foreach ($annual_target as $provincesss) {
                    # code...

                    if (isset($provincesss->first()->sum_of)) {
                        $measures_exploded = explode(',', $provincesss->first()->sum_of);
                    }
                }
                # code...
            }
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

        $cutoff = [];

        if (count($opcrs_active) != 0) {
            $newStatus = substr($opcrs_active[0]->cutoff_status, 0, 1);

            if (substr($opcrs_active[0]->cutoff_status, 0, 1) == '1') {
                $cutoff[0] = true;
            } else {
                $cutoff[0] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 1, 1) == '1') {
                $cutoff[1] = true;
            } else {
                $cutoff[1] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 2, 1) == '1') {
                $cutoff[2] = true;
            } else {
                $cutoff[2] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 3, 1) == '1') {
                $cutoff[3] = true;
            } else {
                $cutoff[3] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 4, 1) == '1') {
                $cutoff[4] = true;
            } else {
                $cutoff[4] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 5, 1) == '1') {
                $cutoff[5] = true;
            } else {
                $cutoff[5] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 6, 1) == '1') {
                $cutoff[6] = true;
            } else {
                $cutoff[6] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 7, 1) == '1') {
                $cutoff[7] = true;
            } else {
                $cutoff[7] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 8, 1) == '1') {
                $cutoff[8] = true;
            } else {
                $cutoff[8] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 9, 1) == '1') {
                $cutoff[9] = true;
            } else {
                $cutoff[9] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 10, 1) == '1') {
                $cutoff[10] = true;
            } else {
                $cutoff[10] = false;
            }

            if (substr($opcrs_active[0]->cutoff_status, 11, 1) == '1') {
                $cutoff[11] = true;
            } else {
                $cutoff[11] = false;
            }

            // dd($cutoff);
        }

        return view('dc.view-target', compact('provinces', 'cutoff', 'annual_targets', 'driversact', 'monthly_targets', 'measures_list', 'user', 'notification', 'opcrs_active'));
    }

    public function manage()
    {
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', 1)
            ->where('is_submitted_division', 1)
            ->get();
        $opcr_id = isset($opcrs_active[0]) ? $opcrs_active[0]->opcr_ID : null;
        $drivers = Driver::where('division_ID', '=', $user->division_ID)->get();
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
            ->orderBy('strategic_objective_ID', 'ASC')
            ->orderByRaw('CAST(number_measure AS UNSIGNED) ASC')
            ->orderBy('created_at', 'ASC')
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

        // Validate if no measures selected
        $missingMeasures = [];
    if (empty($group)) {
        $missingMeasures[] = 'Please select a measure.';
    } else {
        $selectedMeasures = array_filter($group, function ($group_key) {
            return isset($group_key['measure_ID']);
        });

        if (count($selectedMeasures) === 0) {
            $missingMeasures[] = 'Please select a measure for the target.';
        }
    }

    if (!empty($missingMeasures)) {
        return redirect()
            ->back()
            ->with('error', $missingMeasures[0]) // Return only the first error message
            ->withInput();
    }

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

    public function add_driver_only(Request $request)
    {
        // dd($request->driver);
        $user = Auth::user();
        $opcrs_active = Opcr::where('is_active', 1)
            ->where('is_submitted', 1)
            ->where('is_submitted_division', 1)
            ->get();
        $driver = new Driver();
        $driver->driver = $request->driver;
        $driver->opcr_ID = $opcrs_active[0]->opcr_ID;
        $driver->division_ID = $user->division_ID;
        $driver->save();
        Alert::success('Driver successfully Added');
        return redirect()->route('dc.manage');
        // return redirect()
        //     ->route('dc.manage')
        //     ->with('success', 'Driver successfully Added');
    }

    public function delete_driver_only(Request $request)
    {
        $driverId = $request->input('driver_ID');

        $driver = Driver::find($driverId);

        if ($driver) {
            $driver->delete();
            Alert::success('Driver deleted successfully');

            return redirect()->back();
            dd($driver);
        }
        Alert::error('Driver not found');

        return redirect()->back();
    }

    public function edit_driver(Request $request)
    {
        $driverId = $request->input('driver_ID');

        $driver = Driver::find($driverId);

        if ($driver) {
            $driver->driver = $request->input('driver');
            // dd($driver);
            $driver->save();

            Alert::success('Driver updated successfully');

            return redirect()->back();
        }
        Alert::error('Driver not found');

        return redirect()->back();
    }

    public function add_indirect_measure(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'strategic_measure' => 'required',
        ]);

        $strategicMeasure = new StrategicMeasure();
        $strategicMeasure->strategic_measure = $request->strategic_measure;
        $strategicMeasure->type = 'INDIRECT';
        $strategicMeasure->division_id = $user->division_ID;
        $strategicMeasure->strategic_objective_id = 0;

        $strategicMeasure->save();

        Alert::success('Transaction Completed');

        return redirect()->route('dc.manage');
    }

    public function add_mandatory_measure(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'strategic_measure' => 'required',
        ]);

        $strategicMeasure = new StrategicMeasure();
        $strategicMeasure->strategic_measure = $request->strategic_measure;
        $strategicMeasure->type = 'MANDATORY';
        $strategicMeasure->division_id = $user->division_ID;
        $strategicMeasure->strategic_objective_id = 0;

        $strategicMeasure->save();
        Alert::success('Transaction Completed');

        return redirect()->route('dc.manage');
        // return redirect()
        // ->route('dc.manage')
        // ->with('success', 'Transaction Completed');
    }
}
