<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Opcr;
use App\Models\Driver;
use App\Models\StrategicMeasure;
use App\Models\AnnualTarget;
use App\Models\MonthlyTarget;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DivisionChiefController extends Controller
{
    public function index()
    {
        return view('dc.dashboard');
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
        return view('dc.accomplishment');
    }

    public function profile()
    {
        return view('dc.profile');
    }

    public function coaching()
    {
        return view('dc.coaching');
    }

    public function bukidnunBddIndex()
    {
        $opcrs_active = Opcr::where('is_active', 1)->get();
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
          
        $annual_targets = AnnualTarget::whereIn('strategic_measures_ID', $measures->pluck('strategic_measure_ID'))
            ->whereIn('province_ID', $provinces->pluck('province_ID'))
            ->get()
            ->groupBy(['strategic_measure_ID', 'province_ID']);
            // dd($measures);
        $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['month', 'annual_target_ID']);
       
        return view('dc.view-target', compact('measures', 'provinces', 'annual_targets', 'driversact', 'monthly_targets'));
    }
}
