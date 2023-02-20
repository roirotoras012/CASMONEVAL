<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StrategicMeasure;
use App\Models\AnnualTarget;
use App\Models\Opcr;
class RegionalPlanningOfficerController extends Controller
{
    public function index()
    {
        return view('rpo.dashboard');
    }
    public function opcr_target() {
        $labels = StrategicMeasure::join('strategic_objectives', 'strategic_measures.strategic_objective_ID', '=', 'strategic_objectives.strategic_objective_ID')
                            ->where('type', '=', 'DIRECT')
                            ->orWhere('type', '=', 'DIRECT MAIN')
                            ->get(["strategic_objectives.strategic_objective","strategic_measures.strategic_measure", "strategic_measures.strategic_objective_ID", "strategic_measures.strategic_measure_ID", "strategic_measures.strategic_objective_ID", "strategic_measures.division_ID", "strategic_measures.type"]);
       
        return view("rpo.addtarget", compact('labels'));
    }
    public function add_targets(Request $request){
        $annual_targets = $request->data;
        $opcr = new Opcr;
        $opcr->save();
   
        if($opcr->id){

            foreach ($annual_targets as $annual_target){
                if($annual_target['BUK']){
                   
                   
                        $buk_target =  $annual_target['BUK'];
                        $buk_strategic_objective =  $annual_target['strategic_objective'];           
                        $buk_strategic_measure =  $annual_target['strategic_measure'];
                        $target = new AnnualTarget;     
                        try{
                           
                            if($annual_target['type'] == "DIRECT MAIN"){
                                $measure = DB::table('strategic_measures')
                                            ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                            ->get();
                                            
                                            foreach ($measure as $measure1)
                                                {
                                                
                                                        // var_dump($measure1->division_ID);
                                                        $target = new AnnualTarget;     
                                                        $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                                        $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                                        $target->annual_target = $buk_target;
                                                       
                                                        $target->province_ID = 1;
                                                        $target->division_ID = $measure1->division_ID;
                                                        $target->opcr_id = $opcr->id;
                                                        $target->save();
                                                      
                                                    
                                                    
                                                }
                                            
                            }
                            else{
                                $target = new AnnualTarget;     
                                $target->strategic_measures_ID = $buk_strategic_measure;
                                $target->strategic_objectives_ID = $buk_strategic_objective;
                                $target->annual_target = $buk_target;
                                                       
                                $target->province_ID = 1;
                                $target->division_ID = $annual_target['division_ID'];
                                $target->opcr_id = $opcr->id;
                                $target->save();
                            }
                            
                          
                           
                           
                        } 
                        catch(Exception $e){
                        
        
                        }   
                    
                    
    
                }
                if($annual_target['CAM']){
                    $cam_target =  $annual_target['CAM'];
                    $cam_strategic_objective =  $annual_target['strategic_objective'];           
                    $cam_strategic_measure =  $annual_target['strategic_measure'];
                    
                    $target = new AnnualTarget;     
                    try{
                        if($annual_target['type'] == "DIRECT MAIN"){
                            $measure = DB::table('strategic_measures')
                                        ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                        ->get();
                                        
                                        foreach ($measure as $measure1)
                                            {
                                            
                                                    // var_dump($measure1->division_ID);
                                                    $target = new AnnualTarget;     
                                                    $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                                    $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                                    $target->annual_target = $cam_target;
                                                   
                                                    $target->province_ID = 5;
                                                    $target->division_ID = $measure1->division_ID;
                                                    $target->opcr_id = $opcr->id;
                                                    $target->save();
                                                  
                                                
                                                
                                            }
                                        
                        }
                        else{
                            $target = new AnnualTarget;     
                            $target->strategic_measures_ID = $cam_strategic_measure;
                            $target->strategic_objectives_ID = $cam_strategic_objective;
                            $target->annual_target = $cam_target;
                                                   
                            $target->province_ID = 5;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->id;
                            $target->save();
                        }
                     
                    } 
                    catch(Exception $e){
                     
    
                    }   
    
                    
    
                }
                if($annual_target['LDN']){
                    $ldn_target =  $annual_target['LDN'];
                    $ldn_strategic_objective =  $annual_target['strategic_objective'];           
                    $ldn_strategic_measure =  $annual_target['strategic_measure'];
                    $target = new AnnualTarget;     
                    try{
                        if($annual_target['type'] == "DIRECT MAIN"){
                            $measure = DB::table('strategic_measures')
                                        ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                        ->get();
                                        
                                        foreach ($measure as $measure1)
                                            {
                                            
                                                    // var_dump($measure1->division_ID);
                                                    $target = new AnnualTarget;     
                                                    $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                                    $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                                    $target->annual_target = $ldn_target;
                                                   
                                                    $target->province_ID = 2;
                                                    $target->division_ID = $measure1->division_ID;
                                                    $target->opcr_id = $opcr->id;
                                                    $target->save();
                                                  
                                                
                                                
                                            }
                                        
                        }
                        else{
                            $target = new AnnualTarget;     
                            $target->strategic_measures_ID = $ldn_strategic_measure;
                            $target->strategic_objectives_ID = $ldn_strategic_objective;
                            $target->annual_target = $ldn_target;
                                                   
                            $target->province_ID = 2;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->id;
                            $target->save();
                        }
                        
                    } 
                    catch(Exception $e){
                        
    
                    }   
    
                    
    
                }
                if($annual_target['MISOR']){
                    $misor_target =  $annual_target['MISOR'];
                    $misor_strategic_objective =  $annual_target['strategic_objective'];           
                    $misor_strategic_measure =  $annual_target['strategic_measure'];
                    $target = new AnnualTarget;     
                    try{
                        if($annual_target['type'] == "DIRECT MAIN"){
                            $measure = DB::table('strategic_measures')
                                        ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                        ->get();
                                        
                                        foreach ($measure as $measure1)
                                            {
                                            
                                                    // var_dump($measure1->division_ID);
                                                    $target = new AnnualTarget;     
                                                    $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                                    $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                                    $target->annual_target = $misor_target;
                                                   
                                                    $target->province_ID = 3;
                                                    $target->division_ID = $measure1->division_ID;
                                                    $target->opcr_id = $opcr->id;
                                                    $target->save();
                                                  
                                                
                                                
                                            }
                                        
                        }
                        else{
                            $target = new AnnualTarget;     
                            $target->strategic_measures_ID = $misor_strategic_measure;
                            $target->strategic_objectives_ID = $misor_strategic_objective;
                            $target->annual_target = $misor_target;
                                                   
                            $target->province_ID = 3;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->id;
                            $target->save();
                        }
                       
                    } 
                    catch(Exception $e){
                      
    
                    }   
    
    
                }
                if($annual_target['MISOC']){
                    $misoc_target =  $annual_target['MISOC'];
                    $misoc_strategic_objective =  $annual_target['strategic_objective'];           
                    $misoc_strategic_measure =  $annual_target['strategic_measure'];
                    $target = new AnnualTarget;     
                    try{
                        if($annual_target['type'] == "DIRECT MAIN"){
                            $measure = DB::table('strategic_measures')
                                        ->where('strategic_measure', '=', $annual_target['strategic_measurez'])
                                        ->get();
                                        
                                        foreach ($measure as $measure1)
                                            {
                                            
                                                    // var_dump($measure1->division_ID);
                                                    $target = new AnnualTarget;     
                                                    $target->strategic_measures_ID = $measure1->strategic_measure_ID;
                                                    $target->strategic_objectives_ID = $measure1->strategic_objective_ID;
                                                    $target->annual_target = $misoc_target;
                                                   
                                                    $target->province_ID = 4;
                                                    $target->division_ID = $measure1->division_ID;
                                                    $target->opcr_id = $opcr->id;
                                                    $target->save();
                                                  
                                                
                                                
                                            }
                                        
                        }
                        else{
                            $target = new AnnualTarget;     
                            $target->strategic_measures_ID = $misoc_strategic_measure;
                            $target->strategic_objectives_ID = $misoc_strategic_objective;
                            $target->annual_target = $misoc_target;
                                                   
                            $target->province_ID = 4;
                            $target->division_ID = $annual_target['division_ID'];
                            $target->opcr_id = $opcr->id;
                            $target->save();
                        }
                      
                    }
                    catch(Exception $e){
                      
    
                    }   
    
    
                }
          
                
            }   

        }

       
        // return redirect()->route('rpo.opcr_target')->with('success','Targets Added Successfully.');
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
        return view('rpo.savetarget');
    }
}
