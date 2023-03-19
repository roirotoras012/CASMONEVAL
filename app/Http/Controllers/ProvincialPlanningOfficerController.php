<?php

namespace App\Http\Controllers;
use Async;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Opcr;
use App\Models\StrategicObjective;
use App\Models\StrategicMeasure;
use App\Models\Province;
use App\Models\AnnualTarget;
use App\Models\Division;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProvincialPlanningOfficerController extends Controller
{
    public function index()
    {
        return view('ppo.dashboard');
    }

    public function assessment()
    {
        return view('ppo.assessment');
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

        return view('ppo.opcr', compact('objectives', 'objectivesact', 'measures', 'provinces', 'annual_targets', 'divisions', 'opcrs', 'opcrs_active', 'driversact', 'user'));
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

    public function accomplishment()
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
            foreach($measures as $measure)   {
                if($measure->driver_ID != null){
                    $driver_data = DB::table('drivers')
                    ->where('drivers.driver_ID', '=', $measure->driver_ID)
                    ->get();
    
                    if($driver_data[0]->opcr_ID == $opcrs_active[0]->opcr_ID){
                            $measure['show'] = false;
    
                    }
                    else{
                        $measure['show']  = true;
    
                    }
    
                }
                else{
    
                    $measure['show']  = true;
                }
            } 
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
        return view('ppo.accomplishment', compact( 'measures', 'provinces', 'annual_targets', 'opcrs_active', 'driversact'));
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
        foreach ( $measure_id_array as  $measure_id) {
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
            'division_ID' => 'required'
        ]);
        // Create the objective
        $driver = new Driver;
        $driver->driver = $validatedData['driver'];
        $driver->opcr_ID = $validatedData['opcr_ID'];
        $driver->division_ID = $validatedData['division_ID'];
        $driver->save();
        // Redirect to the objectives index page
        return redirect()->route('add-driver')->with('success', 'driver created successfully!');
    }





    public function submit_to_division(Request $request){
        DB::table('opcr')
        ->where('opcr_ID', $request->opcr_id)
        ->update(['is_submitted_division' => true]);
        return redirect()
        ->route('manage')
        ->with('success', 'OPCR has been submitted to Division successfully!');
    }   
}
