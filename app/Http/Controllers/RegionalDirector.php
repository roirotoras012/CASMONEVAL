<?php

namespace App\Http\Controllers;
use DB;
use App\Models\StrategicMeasure;
use App\Models\StrategicObjective;
use App\Models\AnnualTarget;
use App\Models\Pgs;
use App\Models\Opcr;
use App\Models\MonthlyTarget;
use App\Models\Division;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Evaluation;
use App\Models\User;
class RegionalDirector extends Controller
{
    public function index()
    {
        // $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
        //                     ->get(["strategic_objectives.strategic_objective","strategic_measures.strategic_measure", "strategic_measures.strategic_objective_ID", "strategic_measures.strategic_measure_ID", "strategic_measures.strategic_objective_ID", "strategic_measures.division_ID"]);

        return view('rd.dashboard');
    }

    public function opcr_target()
    {
        $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
            // ->where('type', '=', 'DIRECT')
            ->get(['strategic_objectives.strategic_objective', 'strategic_measures.strategic_measure', 'strategic_measures.strategic_objective_ID', 'strategic_measures.strategic_measure_ID', 'strategic_measures.strategic_objective_ID', 'strategic_measures.division_ID']);

        return view('rd.opcr-target', compact('labels'));
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
    public function add_targets(Request $request)
    {
        $annual_targets = $request->data;
        foreach ($annual_targets as $annual_target) {
            if ($annual_target['BUK']) {
                $buk_target = $annual_target['BUK'];
                $buk_strategic_objective = $annual_target['strategic_objective'];
                $buk_strategic_measure = $annual_target['strategic_measure'];
                $target = new AnnualTarget();
                try {
                    $target->strategic_measures_ID = $buk_strategic_measure;
                    $target->strategic_objectives_ID = $buk_strategic_objective;
                    $target->annual_target = $buk_target;
                    $target->division_ID = $annual_target['division_ID'];
                    $target->province_ID = 1;
                    $target->save();
                } catch (Exception $e) {
                }
            }
            if ($annual_target['CAM']) {
                $cam_target = $annual_target['CAM'];
                $cam_strategic_objective = $annual_target['strategic_objective'];
                $cam_strategic_measure = $annual_target['strategic_measure'];

                $target = new AnnualTarget();
                try {
                    $target->strategic_measures_ID = $cam_strategic_measure;
                    $target->strategic_objectives_ID = $cam_strategic_objective;
                    $target->annual_target = $cam_target;
                    $target->division_ID = $annual_target['division_ID'];
                    $target->province_ID = 5;
                    $target->save();
                } catch (Exception $e) {
                }
            }
            if ($annual_target['LDN']) {
                $ldn_target = $annual_target['LDN'];
                $ldn_strategic_objective = $annual_target['strategic_objective'];
                $ldn_strategic_measure = $annual_target['strategic_measure'];
                $target = new AnnualTarget();
                try {
                    $target->strategic_measures_ID = $ldn_strategic_measure;
                    $target->strategic_objectives_ID = $ldn_strategic_objective;
                    $target->annual_target = $ldn_target;
                    $target->division_ID = $annual_target['division_ID'];
                    $target->province_ID = 2;
                    $target->save();
                } catch (Exception $e) {
                }
            }
            if ($annual_target['MISOR']) {
                $misor_target = $annual_target['MISOR'];
                $misor_strategic_objective = $annual_target['strategic_objective'];
                $misor_strategic_measure = $annual_target['strategic_measure'];
                $target = new AnnualTarget();
                try {
                    $target->strategic_measures_ID = $misor_strategic_measure;
                    $target->strategic_objectives_ID = $misor_strategic_objective;
                    $target->annual_target = $misor_target;
                    $target->province_ID = 3;
                    $target->division_ID = $annual_target['division_ID'];
                    $target->save();
                } catch (Exception $e) {
                }
            }
            if ($annual_target['MISOC']) {
                $misoc_target = $annual_target['MISOC'];
                $misoc_strategic_objective = $annual_target['strategic_objective'];
                $misoc_strategic_measure = $annual_target['strategic_measure'];
                $target = new AnnualTarget();
                try {
                    $target->strategic_measures_ID = $misoc_strategic_measure;
                    $target->strategic_objectives_ID = $misoc_strategic_objective;
                    $target->annual_target = $misoc_target;
                    $target->province_ID = 4;
                    $target->division_ID = $annual_target['division_ID'];
                    $target->save();
                } catch (Exception $e) {
                }
            }
        }

        return redirect()
            ->route('rd.index')
            ->with('success', 'Targets Added Successfully.');
        // return $request->data;
    }


    public function savetarget()
    {
        $opcr = DB::table('opcr')->get();

        return view('rd.savetarget', compact('opcr'));
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

        $file = null;
        if($opcr[0]->status == 'DONE'){
          
            $file = FileUpload::where('opcr_ID', '=', $opcr_id)
                            ->get()->first();
           
        }

        $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
            ->where('strategic_objectives.is_active', '=', true)        
            ->where('type', '=', 'DIRECT')
            ->orWhere('type', '=', 'DIRECT MAIN')
            ->orderBy('strategic_objectives.objective_letter', 'ASC')
            ->orderBy('strategic_measures.number_measure', 'ASC')
            ->get(['strategic_objectives.objective_letter','strategic_objectives.strategic_objective', 'strategic_measures.strategic_measure', 'strategic_measures.strategic_objective_ID', 'strategic_measures.strategic_measure_ID', 'strategic_measures.strategic_objective_ID', 'strategic_measures.division_ID', 'strategic_measures.type','strategic_measures.number_measure']);

        if($opcr[0]->status == 'VALIDATED' || $opcr[0]->status == 'DONE' || $opcr[0]->status == 'COMPLETE'){
            $monthly_targets = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
            ->where('monthly_accomplishment', '!=' ,null)
            ->where('annual_targets.opcr_ID', '=' , $opcr_id)
            ->where('monthly_targets.validated', '=' , 'Validated')
            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['annual_target_ID']);
            foreach($monthly_targets as $monthly_target) {
                // echo "annual target ID: {$annual_target_ID}<br>";
                if($monthly_target){



                }
               
                $annual_accom = 0;
                $validated = true;
               
            
                foreach($monthly_target as $target) {
                    $annual_accom = intval($target->monthly_accomplishment) + intval($annual_accom);
                  

                    


                    
                }

                $monthly_target->annual_accom = $annual_accom;
                $monthly_target->validated = $validated;
               
                
            }
           
        }
        else{

            $monthly_targets = null;
        }
        // dd($monthly_targets);



        
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


            if($label->division_ID == 0){
                $measure_for_common = StrategicMeasure::join('annual_targets', 'annual_targets.strategic_measures_ID', '=', 'strategic_measures.strategic_measure_ID')
                ->where('annual_targets.opcr_id', '=', $opcr_id)
                ->where('annual_targets.strategic_objectives_ID', '=', $label->strategic_objective_ID)
                ->where('type', '=', 'DIRECT COMMON')
                ->where('strategic_measure', '=', $label->strategic_measure)
                ->get()
                ->groupBy('province_ID');
          

                // dd($measure_for_common );
            // dd($measure_for_common[2]);
            if(!isset($label['BUK_accom']) && isset($measure_for_common[1])){
                
                foreach ($measure_for_common[1] as $by_province) {
                    # code...  
                    // dd($by_province);
                    $label['BUK_accom_validated'] = true;
                        // dd(count($measure_for_common[1]));
                        if(isset($monthly_targets[$by_province->annual_target_ID])){
                          
                            $label['BUK_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;
                            // dd($monthly_targets[$by_province->annual_target_ID]->validated);
                        
                            if( ($monthly_targets[$by_province->annual_target_ID]->validated == false)){
                                $label['BUK_accom_validated'] = false;

                            }
                            
                        }
                        else{

                            $label['BUK_accom_validated'] = false;
                        }
                        
    
                   }
                  
            }
            if(isset($label['BUK_accom']) && $label['BUK_accom_validated']){
                $label['BUK_accom'] = $label['BUK_accom']/count($measure_for_common[1]);
            }

         
            if(!isset($label['LDN_accom']) && isset($measure_for_common[2])){
                foreach ($measure_for_common[2] as $by_province) {
                    # code...
                    if(isset($monthly_targets[$by_province->annual_target_ID])){
                        $label['LDN_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;

                        if( ($monthly_targets[$by_province->annual_target_ID]->validated == true)){
                            $label['LDN_accom_validated'] = true;

                        }
                        if( ($monthly_targets[$by_province->annual_target_ID]->validated == false)){
                            $label['LDN_accom_validated'] = false;

                        }
                    }
    
                   }
            } 
            if(isset($label['LDN_accom']) && $label['LDN_accom_validated']){
                $label['LDN_accom'] = $label['LDN_accom']/3;
            } 
            if(!isset($label['MISOR_accom']) && isset($measure_for_common[3])){
                foreach ($measure_for_common[3] as $by_province) {
                    # code...
                    if(isset($monthly_targets[$by_province->annual_target_ID])){
                        $label['MISOR_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;

                        if( ($monthly_targets[$by_province->annual_target_ID]->validated == true)){
                            $label['MISOR_accom_validated'] = true;

                        }
                        if( ($monthly_targets[$by_province->annual_target_ID]->validated == false)){
                            $label['MISOR_accom_validated'] = false;

                        }
                    }
    
                   }
            } 
            if(isset($label['MISOR_accom'])  && $label['MISOR_accom_validated']){
                $label['MISOR_accom'] = $label['MISOR_accom']/3;
            } 


            if(!isset($label['MISOC_accom']) && isset($measure_for_common[4])){
                foreach ($measure_for_common[4] as $by_province) {
                    # code...
                    if(isset($monthly_targets[$by_province->annual_target_ID])){
                        $label['MISOC_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;


                        if( ($monthly_targets[$by_province->annual_target_ID]->validated == true)){
                            $label['MISOC_accom_validated'] = true;

                        }
                        if( ($monthly_targets[$by_province->annual_target_ID]->validated == false)){
                            $label['MISOC_accom_validated'] = false;

                        }
                    }
    
                   }
            } 
            if(isset($label['MISOC_accom']) && $label['MISOC_accom_validated']){
                $label['MISOC_accom'] = $label['MISOC_accom']/3;
            } 
            if(!isset($label['CAM_accom']) && isset($measure_for_common[5])){
                foreach ($measure_for_common[5] as $by_province) {
                    # code...
                    if(isset($monthly_targets[$by_province->annual_target_ID])){
                        $label['CAM_accom'] += $monthly_targets[$by_province->annual_target_ID]->annual_accom;

                        if( ($monthly_targets[$by_province->annual_target_ID]->validated == true)){
                            $label['CAM_accom_validated'] = true;

                        }
                        if( ($monthly_targets[$by_province->annual_target_ID]->validated == false)){
                            $label['CAM_accom_validated'] = false;

                        }
                    }
    
                   }
            } 
            if(isset($label['CAM_accom']) && $label['CAM_accom_validated']){
                $label['CAM_accom'] = $label['CAM_accom']/3;
            }
           
               
              
           
             
              
              
             
               
         

             
            
            
            
            
            }
        }

        $monthly_targets2 = MonthlyTarget::join('annual_targets', 'annual_targets.annual_target_ID', '=', 'monthly_targets.annual_target_ID')
            
            ->where('annual_targets.opcr_ID', '=' , $opcr_id)
           
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
                    $monthly_target2->fourth_qrtr= null;

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
                            
                            if($target2->month == 'jan' || $target2->month == 'feb' || $target2->month == 'mar' || $target2->month == 'apr' || $target2->month == 'may' || $target2->month == 'jun'){
    
                
                                $monthly_target2->first_sem_accom += $target2->monthly_accomplishment;
                                if($target2->month == 'jan' || $target2->month == 'feb' || $target2->month == 'mar'){
                        
                                    $monthly_target2->first_qrtr_accom += $target2->monthly_accomplishment;
                                }
                                if($target2->month == 'apr' || $target2->month == 'may' || $target2->month == 'jun'){
                            
                                    $monthly_target2->second_qrtr_accom += $target2->monthly_accomplishment;
                                }
                            }
                            if($target2->month == 'jul' || $target2->month == 'aug' || $target2->month == 'sep' || $target2->month == 'oct' || $target2->month == 'nov' || $target2->month == 'dec'){
    
                    
                                $monthly_target2->second_sem_accom += $target2->monthly_accomplishment;
                                
                                if($target2->month == 'jul' || $target2->month == 'aug' || $target2->month == 'sep'){
                        
                                    $monthly_target2->third_qrtr_accom += $target2->monthly_accomplishment;
                                }
                                if($target2->month == 'oct' || $target2->month == 'nov' || $target2->month == 'dec'){
                            
                                    $monthly_target2->fourth_qrtr_accom += $target2->monthly_accomplishment;
                                }
                            }   
                       
                        }



                         $monthly_target2->total_targets += $target2->monthly_target;

                            
                            if($target2->month == 'jan' || $target2->month == 'feb' || $target2->month == 'mar' || $target2->month == 'apr' || $target2->month == 'may' || $target2->month == 'jun'){
    
                                $monthly_target2->first_sem += $target2->monthly_target;
                    
                                if($target2->month == 'jan' || $target2->month == 'feb' || $target2->month == 'mar'){
                                    $monthly_target2->first_qrtr += $target2->monthly_target;
                            
                                }
                                if($target2->month == 'apr' || $target2->month == 'may' || $target2->month == 'jun'){
                                    $monthly_target2->second_qrtr += $target2->monthly_target;
                                
                                }
                            }
                            if($target2->month == 'jul' || $target2->month == 'aug' || $target2->month == 'sep' || $target2->month == 'oct' || $target2->month == 'nov' || $target2->month == 'dec'){
    
                                $monthly_target2->second_sem += $target2->monthly_target;
                        
                                
                                if($target2->month == 'jul' || $target2->month == 'aug' || $target2->month == 'sep'){
                                    $monthly_target2->third_qrtr += $target2->monthly_target;
                            
                                }
                                if($target2->month == 'oct' || $target2->month == 'nov' || $target2->month == 'dec'){
                                    $monthly_target2->fourth_qrtr += $target2->monthly_target;
                                
                                }
                            }

                    }
                   

                
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
                ->select('annual_targets.*', 'strategic_measures.strategic_measure', DB::raw('(SELECT SUM(monthly_accomplishment) FROM monthly_targets WHERE monthly_targets.annual_target_ID = annual_targets.annual_target_ID && (monthly_targets.validated = "Validated")) AS total_accomplishment'))
              
                ->get()
                ->groupBy('strategic_measures_ID');
            // dd($total_number_of_valid_measures);
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
                }

                 if (($total_number_of_valid_measure->total_accom / $total_number_of_valid_measure->total_target) * 100 > 90) {
                        $total_number_of_accomplished_measure++;
                    }
              
            }

            $total_number_of_valid_measures2 = MonthlyTarget::join('annual_targets', 'monthly_targets.annual_target_ID', '=', 'annual_targets.annual_target_ID')
                ->join('strategic_measures', 'strategic_measures.strategic_measure_ID', '=', 'annual_targets.strategic_measures_ID')
                ->where('annual_targets.opcr_ID', $opcr_id)
                ->where(function ($query) {
                    $query->where('strategic_measures.type', '=', 'DIRECT')->orWhere('strategic_measures.type', '=', 'DIRECT MAIN');
                })
                ->select('monthly_targets.*','annual_targets.*', 'strategic_measures.strategic_measure')
                
                ->get()
                ->groupBy('strategic_measures_ID');
                
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
            //     dd($total_number_of_valid_measures2);
            //  dd($valid_meas);
            // dd($total_number_of_accomplished_measure);
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

            // PGS array
            $pgs = [
                'total_number_of_valid_measures' => $total_number_of_valid_measures->count(),
                'total_number_of_accomplished_measure' => $total_number_of_accomplished_measure,
                'numerical_rating' => $pgsrating !== null ? $pgsrating->numeric : null,
                'rating' => $pgsratingtext,
                'monthly_valid' => $valid_meas,
            ];
            // dd($pgs);
            for ($i=0; $i < count($valid_meas); $i++) { 
                # code...
                $pgsrating2[$i] = Pgs::where('total_num_of_targeted_measure', $valid_meas[$i])

                ->get()
                ->groupBy('actual_num_of_accomplished_measure');
            }
        //    dd($pgsrating2);
            // dd($pgsrating2);
        
        return view('rd.opcr', compact('targets', 'labels', 'opcr_id', 'opcr', 'monthly_targets', 'file','monthly_targets2', 'pgs', 'pgsrating2'));
    }

    public function assessment()
    {
        return view('rd.assessment');
    }

    public function profile()
    {
        return view('rd.profile');
    }
    public function logout()
    {
        return view('rd.logout');
    }
}
