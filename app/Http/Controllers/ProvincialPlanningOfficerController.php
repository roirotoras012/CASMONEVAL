<?php

namespace App\Http\Controllers;
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

    public function addtarget()
    {

        $opcrs_active = Opcr::where('is_active', 1)
                        ->where('is_submitted', '=',  1)         
                        ->get();

        $objectivesact = StrategicObjective::all();

        $objectives = StrategicObjective::all();

        $measures = StrategicMeasure::join('divisions', 'strategic_measures.division_ID', '=', 'divisions.division_ID')
            ->select('strategic_measures.*', 'divisions.division')
            ->get();
    
            // dd($measures);
        $provinces = Province::select('province_ID', 'province')
            ->orderBy('province_ID')
            ->get();
    
        // $annual_targets = AnnualTarget::all()
        //     ->where(['opcr_id', '=', $opcrs_active[0]->opcr_ID])
        //     ->groupBy(['strategic_measures_ID', 'province_ID']);

        if(count($opcrs_active) != 0){

            $annual_targets = DB::table('annual_targets')
            ->where('opcr_id', '=',  $opcrs_active[0]->opcr_ID)
            ->get()
            ->groupBy(['strategic_measures_ID', 'province_ID']);
        }
        else{
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
                ->get(['drivers.*', 'divisions.division']);
        
        return view('ppo.addtarget', compact('objectives','objectivesact', 'measures', 'provinces', 'annual_targets', 'divisions', 'opcrs', 'opcrs_active','driversact'));
      
    }

    public function savetarget()
    {
        return view('ppo.savetarget');
    }

    public function accomplishment()
    {
        return view('ppo.accomplishment');
    }
}
