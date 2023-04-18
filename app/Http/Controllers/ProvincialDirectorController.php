<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Notification;

use App\Models\StrategicMeasure;
use App\Models\StrategicObjective;
use App\Models\AnnualTarget;
use App\Models\Opcr;
use App\Models\MonthlyTarget;
use App\Models\Division;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Evaluation;
use App\Models\User;
class ProvincialDirectorController extends Controller
{
    public function index()
    {
        $provincialUser = Auth::user();
        $provinceId = $provincialUser->province_ID;
        $divisionUsers = User::whereNotNull('division_ID')
            ->where('province_ID', $provinceId)
            ->get();
        $divisionUserIds = $divisionUsers->pluck('user_ID');
        $eval = Evaluation::whereIn('evaluations.user_id', $divisionUserIds)
                  ->join('users', 'evaluations.user_id', '=', 'users.user_ID')
                  ->leftJoin('divisions', 'users.division_ID', '=', 'divisions.division_ID')
                  ->select('evaluations.*', 'divisions.division')
                  ->get();
        return view('pd.dashboard', compact('eval'));
        // return view('pd.dashboard');
    }

    public function getNotifications(Request $request)
    {
        $userTypeID = auth()->user()->user_type_ID;
        $provinceID = auth()->user()->province_ID;
        $userID = auth()->user()->user_ID;

        $notifications = Notification::where('province_ID', $provinceID)
            ->where('user_type_ID', $userTypeID)
         
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')

            ->get();

        // Log::debug('Number of notifications: ' . $notifications->count());
        

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

    public function markAsRead(Request $request)
    {
        $notificationId = $request->input('notification_id');
        $notification = Notification::findOrFail($notificationId);
        $notification->markAsRead();

        return response()->json(['success' => true]);
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
    public function assessment()
    {
        $provincialUser = Auth::user();
        $provinceId = $provincialUser->province_ID;
        $divisionUsers = User::whereNotNull('division_ID')
            ->where('province_ID', $provinceId)
            ->get();
        $divisionUserIds = $divisionUsers->pluck('user_ID');
        $eval = Evaluation::whereIn('evaluations.user_id', $divisionUserIds)
                  ->join('users', 'evaluations.user_id', '=', 'users.user_ID')
                  ->leftJoin('divisions', 'users.division_ID', '=', 'divisions.division_ID')
                  ->select('evaluations.*', 'divisions.division')
                  ->get();
        return view('pd.assessment', compact('eval'));
    }

    public function profile()
    {
        return view('pd.profile');
    }

    public function addtarget()
    {
        return view('pd.addtarget');
    }

    public function savetarget()
    {
        $opcr = DB::table('opcr')->get();

        return view('pd.savetarget', compact('opcr'));
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
            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['annual_target_ID']);
            foreach($monthly_targets as $monthly_target) {
                // echo "annual target ID: {$annual_target_ID}<br>";
                if($monthly_target){



                }
               
                $annual_accom = 0;
                $validated = true;
                if(!(count($monthly_target) >= 12)){
                    $validated = false;
                }
              
            
                foreach($monthly_target as $target) {
                    $annual_accom = intval($target->monthly_accomplishment) + intval($annual_accom);
                    if($target->validated != 'Validated'){
                        $validated = false;
                    }

                    


                    
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
            ->where('monthly_accomplishment', '!=' ,null)
            ->where('annual_targets.opcr_ID', '=' , $opcr_id)
            ->get(['monthly_targets.*', 'annual_targets.*'])
            ->groupBy(['strategic_measures_ID']);

            foreach ($monthly_targets2 as $monthly_target2) {
                // echo count($monthly_target2);
                if(count($monthly_target2) >= 60){
                    $monthly_target2->total_targets = 0;
                    $monthly_target2->first_sem = 0;
                    $monthly_target2->second_sem = 0;
                    $monthly_target2->first_qrtr = 0;
                    $monthly_target2->second_qrtr = 0;
                    $monthly_target2->third_qrtr = 0;
                    $monthly_target2->fourth_qrtr= 0;

                    $monthly_target2->total_accom = 0;
                    $monthly_target2->first_sem_accom = 0;
                    $monthly_target2->second_sem_accom = 0;
                    $monthly_target2->first_qrtr_accom = 0;
                    $monthly_target2->second_qrtr_accom = 0;
                    $monthly_target2->third_qrtr_accom = 0;
                    $monthly_target2->fourth_qrtr_accom = 0;

                    $total_accom = null;
                    $first_sem_accom = null;
                    $second_sem_accom = null;
                    $first_qrtr_accom = null;
                    $second_qrtr_accom = null;
                    $third_qrtr_accom = null;
                    $fourth_qrtr_accom = null;
                    
                    foreach ($monthly_target2 as $target2) {
                        # code...
                        $monthly_target2->total_targets += $target2->monthly_target;
                        $monthly_target2->total_accom += $target2->monthly_accomplishment;
                        if($target2->month == 'jan' || $target2->month == 'feb' || $target2->month == 'mar' || $target2->month == 'apr' || $target2->month == 'may' || $target2->month == 'jun'){

                            $monthly_target2->first_sem += $target2->monthly_target;
                            $monthly_target2->first_sem_accom += $target2->monthly_accomplishment;
                            if($target2->month == 'jan' || $target2->month == 'feb' || $target2->month == 'mar'){
                                $monthly_target2->first_qrtr += $target2->monthly_target;
                                $monthly_target2->first_qrtr_accom += $target2->monthly_accomplishment;
                            }
                            if($target2->month == 'apr' || $target2->month == 'may' || $target2->month == 'jun'){
                                $monthly_target2->second_qrtr += $target2->monthly_target;
                                $monthly_target2->second_qrtr_accom += $target2->monthly_accomplishment;
                            }
                        }
                        if($target2->month == 'jul' || $target2->month == 'aug' || $target2->month == 'sep' || $target2->month == 'oct' || $target2->month == 'nov' || $target2->month == 'dec'){

                            $monthly_target2->second_sem += $target2->monthly_target;
                            $monthly_target2->second_sem_accom += $target2->monthly_accomplishment;
                            
                            if($target2->month == 'jul' || $target2->month == 'aug' || $target2->month == 'sep'){
                                $monthly_target2->third_qrtr += $target2->monthly_target;
                                $monthly_target2->third_qrtr_accom += $target2->monthly_accomplishment;
                            }
                            if($target2->month == 'oct' || $target2->month == 'nov' || $target2->month == 'dec'){
                                $monthly_target2->fourth_qrtr += $target2->monthly_target;
                                $monthly_target2->fourth_qrtr_accom += $target2->monthly_accomplishment;
                            }
                        }

                    }
                   

                }
                # code...
            }
        // dd($labels);
        // var_dump($labels);
        // dd($monthly_targets2);
        // dd($monthly_targets);
        return view('pd.opcr', compact('targets', 'labels', 'opcr_id', 'opcr', 'monthly_targets', 'file','monthly_targets2'));
    }

    public function accomplishment()
    {
        return view('pd.accomplishment');
    }
    public function logout()
    {
        return view('components.logout');
    }
}
