
<head>
    <link rel="stylesheet" href="{{ URL::asset('css/rd.css') }}" />
</head>
@extends('layouts.app')
@section('title')
    {{ 'PD Save Target' }}
@endsection
@section('content')
    @php
        // var_dump($targets);
    
    @endphp
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
          </div>
        
        <div class="container-fluid px-4 py-5">
                
            <ol class="breadcrumb mb-4">
            
                <li class="breadcrumb-item active"><h1 class="province-name bg-primary text-white text-uppercase mb-5 rounded">OPCR #{{$opcr_id}}</h1></li>
              
            </ol>


            @if (($opcr[0]->status == 'DONE') && isset($file))
            {{-- {{public_path()}} --}}
            <iframe style="border: none;" src="/uploads/{{$file->file_name}}" width="100%" height="900px"></iframe>
            @else
            <div class="opcr-container">


                <div class="opcr-table">




                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p class="m-0">{{ $message }}</p>
                        </div>
                    @endif


                    <form action="{{ route('update_targets') }}" method="post" id="opcr_form-{{$opcr_id}}">
                        <input type="hidden" name="opcr_id"
                                                value="{{ $opcr_id }}">
                        <table class="table table-bordered ppo-table shadow" id="table">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th rowspan="2" class="p-3">#</th>
                                    <th rowspan="2">Strategic Objectives</th>
                                    <th rowspan="2" class="p-3">#</th>
                                    <th rowspan="2">Strategic Measures</th>
                                    <th rowspan="2">REGION 10</th>
                                    <th colspan="2">BUK</th>

                                    <th colspan="2">CAM</th>
                                    <th colspan="2">LDN</th>
                                    <th colspan="2">MISOR</th>
                                    <th colspan="2">MISOC</th>
                                    
                                </tr>
                                <tr>
                                    <th>Target</th>
                                    <th>Accom</th>
                                    <th>Target</th>
                                    <th>Accom</th>
                                    <th>Target</th>
                                    <th>Accom</th>
                                    <th>Target</th>
                                    <th>Accom</th>
                                    <th>Target</th>
                                    <th>Accom</th>
                                    

                                </tr>
                            </thead>

                            <tbody>



                                @csrf
                                @php
                                $current_objective = '';
                                    $ctr = 0;
                                    $is_edit = false;
                                    $total = 0;
                                @endphp
                               
                                @foreach ($labels as $label)
                                  
                                    <tr class="table-tr">
                                        
                                        @if ($label->strategic_objective != $current_objective)
                                        
                                        @php
                                        $obj_count = 0;
                                        foreach ($labels as $label2) {
                                            if($label2->strategic_objective_ID == $label->strategic_objective_ID){
                                                $obj_count++;

                                            }
                                        }
                                        @endphp
                                        {{-- <h2>{{$qwe}}</h2> --}}
                                        <td rowspan="{{$obj_count}}">
                                            {{ $label->objective_letter }}
                                            </td>
                                        <td rowspan="{{$obj_count}}">
                                        {{ $label->strategic_objective }}
                                    
                                        </td>
                                        @endif
                                       
                                        <td>
                                            {{ $label->number_measure }}
                                        </td>
                                        <td>{{ $label->strategic_measure }} 
                                            
                                            <input type="hidden"
                                            name="data[{{ $ctr }}][strategic_objective]"
                                            value="{{ $label->strategic_objective_ID }}">
                                            <input type="hidden" name="data[{{ $ctr }}][strategic_measure]"
                                                value="{{ $label->strategic_measure_ID }}">
                                            <input type="hidden" name="data[{{ $ctr }}][strategic_measurez]"
                                                value="{{ $label->strategic_measure }}">
                                            <input type="hidden" name="data[{{ $ctr }}][type]"
                                                value="{{ $label->type }}">
                                            <input type="hidden" name="data[{{ $ctr }}][division_ID]"
                                                value="{{ $label->division_ID }}">

                                        </td>
                                        @php
                                            $total = $label->BUK + $label->CAM + $label->LDN + $label->MISOR + $label->MISOC;
                                        @endphp
                                        <td><input type="hidden" name="data[{{ $ctr }}][total_targets]">
                                        {{$total}}
                                        </td>
                                        <td>

                                            <input type="hidden" name="data[{{ $ctr }}][BUK]" value="">
                                            <input <?php if ($label->BUK != '' && ($is_edit == false)){ ?> disabled style="font-weight: bold;"<?php   } ?> type="text" name="data[{{ $ctr }}][BUK]" value="{{$label->BUK}}">
                                        
                                        </td>
                                        <td>
                                            @if ((isset($monthly_targets[$label->BUK_target])) && $monthly_targets[$label->BUK_target]->validated)
                                               <b>{{ $monthly_targets[$label->BUK_target]->annual_accom }} </b>
                                            @else
                                               @if (isset($label->BUK_accom) && $label->BUK_accom_validated)
                                                   <b>{{ $label->BUK_accom}}</b>
                                               @endif
                                           @endif
                                        </td>
                                        <td>
                                            <input type="hidden" name="data[{{ $ctr }}][CAM]" value="">
                                            <input <?php if ($label->CAM != '' && ($is_edit == false)){ ?> disabled style="font-weight: bold;"<?php   } ?> type="text" name="data[{{ $ctr }}][CAM]" value="{{$label->CAM}}">
                                         
                                        </td>
                                        <td>
                                            @if ((isset($monthly_targets[$label->CAM_target])) && $monthly_targets[$label->CAM_target]->validated)
                                               <b>{{ $monthly_targets[$label->CAM_target]->annual_accom }}</b>
                                            @else
                                            @if (isset($label->CAM_accom) && $label->CAM_accom_validated)
                                            <b>{{ $label->CAM_accom}}</b>
                                            @endif
                                           @endif
                                        </td>
                                        <td>
                                            <input type="hidden" name="data[{{ $ctr }}][LDN]" value="">
                                            <input <?php if ($label->LDN != '' && ($is_edit == false)){ ?> disabled style="font-weight: bold;"<?php   } ?> type="text" name="data[{{ $ctr }}][LDN]" value="{{$label->LDN}}">
                                         
                                        </td>
                                        <td>
                                            @if ((isset($monthly_targets[$label->LDN_target])) && $monthly_targets[$label->LDN_target]->validated)
                                               <b>{{ $monthly_targets[$label->LDN_target]->annual_accom }}</b>
                                              
                                               @else
                                               @if (isset($label->LDN_accom)  && $label->LDN_accom_validated)
                                                   <b>{{ $label->LDN_accom}}</b>
                                               @endif
                                           @endif
                                        </td>
                                        <td>
                                            <input type="hidden" name="data[{{ $ctr }}][MISOR]" value="">
                                            <input <?php if ($label->MISOR != '' && ($is_edit == false)){ ?> disabled style="font-weight: bold;"<?php   } ?> type="text" name="data[{{ $ctr }}][MISOR]" value="{{$label->MISOR}}">
                                          
                                        </td>
                                        <td>
                                            @if ((isset($monthly_targets[$label->MISOR_target])) && $monthly_targets[$label->MISOR_target]->validated)
                                               <b>{{ $monthly_targets[$label->MISOR_target]->annual_accom }}</b>
                                               @else
                                               @if (isset($label->MISOR_accom)  && $label->MISOR_accom_validated)
                                               <b>{{ $label->MISOR_accom}}</b>
                                           @endif
                                           @endif
                                        </td>
                                        <td>
                                            <input type="hidden" name="data[{{ $ctr }}][MISOC]" value="">
                                            <input <?php if ($label->MISOC != '' && ($is_edit == false)){ ?> disabled style="font-weight: bold;"<?php   } ?> type="text" name="data[{{ $ctr }}][MISOC]" value="{{$label->MISOC}}">
                                           
                                        </td>
                                        <td>
                                            @if ((isset($monthly_targets[$label->MISOC_target])) && $monthly_targets[$label->MISOC_target]->validated)
                                               <b>{{ $monthly_targets[$label->MISOC_target]->annual_accom }}</b>
                                               @else
                                               {{-- @if (isset($label->MISOC_accom)  && $label->MISOC_accom_validated)
                                                   <b>{{ $label->MISOC_accom}}</b>
                                               @endif --}}
                                           @endif
                                        </td>

                                    </tr>

                                    @php
                                        $ctr++;
                                        $current_objective = $label->strategic_objective;
                                    @endphp
                                   
                                @endforeach





                                {{-- <input type="submit" value="ADD" class="btn btn-success"> --}}
                                <div class="pb-3 opcr-btn">
                                    <button style="display: none" type="button" class="btn btn-primary my-2" data-file-name="opcr-{{$opcr_id}}_{{$opcr[0]->year}}" id="print-button">Scorecard</button>

                                    <button type="button" class="btn btn-primary my-2" data-file-name="opcr-{{$opcr_id}}_{{$opcr[0]->year}}" id="print-scoreCard">Scorecard</button>
                                </div>
                                @if ($opcr[0]->is_submitted == true)
                                <div class="alert alert-success">
                                    <p class="m-0">OPCR is already submitted.</p>
                                </div>
                                @endif
                                <script>
                                 
                                </script>

                                <h5><b>Year: {{ $opcr[0]->year }}</b> </h5>
                                <h5><b>Description: {{ $opcr[0]->description }}</b> </h5>
                            </tbody>

                        </table>
                    </form>
                    <x-mark_as_done_modal :opcr_id=$opcr_id />
                </div>


            </div>
            @endif

            <table class="table table-bordered ppo-table shadow d-none" id="rpo_scoreCard">
                <thead class="bg-primary text-white">
                    <tr>
                        <th rowspan="2" class="p-3">#</th>
                        {{-- <th rowspan="2">Strategic Objectives</th> --}}
                        <th rowspan="2" class="p-3">#</th>
                        <th rowspan="2">Strategic Measures</th>
                        <th rowspan="2">Annual Target</th>
                        <th colspan="7">TARGET</th>
                        <th colspan="7">ACCOMPLISHMENT</th>
                        <th rowspan="2">Accom Rate</th>
                        <th colspan="2">JAN</th>
                        <th colspan="2">FEB</th>
                        <th colspan="2">MAR</th>
                        <th colspan="2">APR</th>
                        <th colspan="2">MAY</th>
                        <th colspan="2">JUN</th>
                        <th colspan="2">JUL</th>
                        <th colspan="2">AUG</th>
                        <th colspan="2">SEPT</th>
                        <th colspan="2">OCT</th>
                        <th colspan="2">NOV</th>
                        <th colspan="2">DEC</th>     
                    </tr>
                    <tr>
                        <th>To Date</th>
                        <th>1st Qrtr</th>
                        <th>2nd Qrtr</th>
                        <th>1st Sem</th>
                        <th>3rd Qrtr</th>
                        <th>4th Qrtr</th>
                        <th>2nd Sem</th>   
                        
                        <th>To Date</th>
                        <th>1st Qrtr</th>
                        <th>2nd Qrtr</th>
                        <th>1st Sem</th>
                        <th>3rd Qrtr</th>
                        <th>4th Qrtr</th>
                        <th>2nd Sem</th>  


                        <th>Target</th>
                        <th>Accom</th>
                        <th>Target</th>
                        <th>Accom</th>
                        <th>Target</th>
                        <th>Accom</th>
                        <th>Target</th>
                        <th>Accom</th>
                        <th>Target</th>
                        <th>Accom</th>
                        <th>Target</th>
                        <th>Accom</th>
                        <th>Target</th>
                        <th>Accom</th>
                        <th>Target</th>
                        <th>Accom</th>
                        <th>Target</th>
                        <th>Accom</th>
                        <th>Target</th>
                        <th>Accom</th>
                        <th>Target</th>
                        <th>Accom</th>
                        <th>Target</th>
                        <th>Accom</th>
                    </tr>
                </thead>
    
                <tbody>
                    @php
                    $current_objective = '';
                        $ctr = 0;
                        $is_edit = false;
                        $total = 0;
                    @endphp
                   @foreach ($labels as $label)
                    <tr>
                        @if ($label->strategic_objective != $current_objective)
                                        
                        @php
                        $obj_count = 0;
                        foreach ($labels as $label2) {
                            if($label2->strategic_objective_ID == $label->strategic_objective_ID){
                                $obj_count++;

                            }
                        }
                        @endphp
                        {{-- <h2>{{$qwe}}</h2> --}}
                        <td rowspan="{{$obj_count}}">
                            {{ $label->objective_letter }}
                            </td>
                       
                        @endif
                        <td>{{$label->number_measure}}</td>
                        <td>{{$label->strategic_measure}}</td>
                        @php
                        $total = $label->BUK + $label->CAM + $label->LDN + $label->MISOR + $label->MISOC;
                        @endphp
                        <td><input type="hidden" name="data[{{ $ctr }}][total_targets]">
                        {{$total}}
                        </td>

                    
                        
                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->total_targets))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->total_targets}}</td>
                       
                            
                        @else
                        <td></td>  
                       
                        @endif
                        
                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->first_qrtr))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->first_qrtr}}</td>
                        @else
                        <td></td>  
                        @endif

                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->second_qrtr))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->second_qrtr}}</td>
                        @else
                        <td></td>  
                        @endif

                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->first_sem))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->first_sem}}</td>
                        @else
                        <td></td>  
                        @endif
                       
                        
                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->third_qrtr))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->third_qrtr}}</td>
                        @else
                        <td></td>  
                        @endif

                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->fourth_qrtr))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->fourth_qrtr}}</td>
                        @else
                        <td></td>  
                        @endif

                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->second_sem))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->second_sem}}</td>
                        @else
                        <td></td>  
                        @endif


                       {{-- accom --}}
                       
                       @if (isset($monthly_targets2[$label->strategic_measure_ID]->total_accom))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->total_accom}}</td>
                       
                            
                        @else
                        <td></td>  
                       
                        @endif
                        
                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->first_qrtr_accom))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->first_qrtr_accom}}</td>
                        @else
                        <td></td>  
                        @endif

                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->second_qrtr_accom))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->second_qrtr_accom}}</td>
                        @else
                        <td></td>  
                        @endif

                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->first_sem_accom))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->first_sem_accom}}</td>
                        @else
                        <td></td>  
                        @endif
                       
                        
                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->third_qrtr_accom))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->third_qrtr_accom}}</td>
                        @else
                        <td></td>  
                        @endif

                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->fourth_qrtr_accom))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->fourth_qrtr_accom}}</td>
                        @else
                        <td></td>  
                        @endif

                        @if (isset($monthly_targets2[$label->strategic_measure_ID]->second_sem_accom))
                        <td>{{$monthly_targets2[$label->strategic_measure_ID]->second_sem_accom}}</td>
                        @else
                        <td></td>  
                        @endif


                        {{-- accom end --}}
                        
                        <td>
                            @if ((isset($monthly_targets2[$label->strategic_measure_ID]->total_accom)) && isset($total))
                                {{ number_format((($monthly_targets2[$label->strategic_measure_ID]->total_accom/$total)*100), 2)}}%    
                            @endif
                        </td>
                        @php
                        $jan_total= null;
                        $feb_total= null;
                        $mar_total= null;
                        $apr_total= null;
                        $may_total= null;
                        $jun_total= null;
                        $jul_total= null;
                        $aug_total= null;
                        $sep_total= null;
                        $oct_total= null;
                        $nov_total= null;
                        $dec_total= null;

                        $jan_target= null;
                        $feb_target= null;
                        $mar_target= null;
                        $apr_target= null;
                        $may_target= null;
                        $jun_target= null;
                        $jul_target= null;
                        $aug_target= null;
                        $sep_target= null;
                        $oct_target= null;
                        $nov_target= null;
                        $dec_target= null;
                            if (isset($monthly_targets2[$label->strategic_measure_ID])) {
                                
                                foreach ($monthly_targets2[$label->strategic_measure_ID] as $measure_target) {
                                    if($measure_target->month == 'jan'){
                                        $jan_total += $measure_target->monthly_accomplishment;
                                        $jan_target += $measure_target->monthly_target;
                                    }
                                    if($measure_target->month == 'feb'){
                                        $feb_total += $measure_target->monthly_accomplishment;
                                        $feb_target += $measure_target->monthly_target;
                                    }
                                    if($measure_target->month == 'mar'){
                                        $mar_total += $measure_target->monthly_accomplishment;
                                        $mar_target += $measure_target->monthly_target;
                                    }
                                    if($measure_target->month == 'apr'){
                                        $apr_total += $measure_target->monthly_accomplishment;
                                        $apr_target += $measure_target->monthly_target;

                                    }
                                    if($measure_target->month == 'may'){
                                        $may_total += $measure_target->monthly_accomplishment;
                                        $may_target += $measure_target->monthly_target;
                                    }
                                    if($measure_target->month == 'jun'){
                                        $jun_total += $measure_target->monthly_accomplishment;
                                        $jun_target += $measure_target->monthly_target;
                                    }
                                    if($measure_target->month == 'jul'){
                                        $jul_total += $measure_target->monthly_accomplishment;
                                        $jul_target += $measure_target->monthly_target;
                                    }
                                    if($measure_target->month == 'aug'){
                                        $aug_total += $measure_target->monthly_accomplishment;
                                        $aug_target += $measure_target->monthly_target;
                                    }
                                    if($measure_target->month == 'sep'){
                                        $sep_total += $measure_target->monthly_accomplishment;
                                        $sep_target += $measure_target->monthly_target;
                                    }
                                    if($measure_target->month == 'oct'){
                                        $oct_total += $measure_target->monthly_accomplishment;
                                        $oct_target += $measure_target->monthly_target;
                                    }
                                    if($measure_target->month == 'nov'){
                                        $nov_total += $measure_target->monthly_accomplishment;
                                        $nov_target += $measure_target->monthly_target;
                                    }
                                    if($measure_target->month == 'dec'){
                                        $dec_total += $measure_target->monthly_accomplishment;
                                        $dec_target += $measure_target->monthly_target;
                                    }
                                 
                                }
                            }
                        @endphp
                      
                        <td>
                        @if (isset($jan_target))
                            {{$jan_target}}
                        @endif    
                        </td>
                        <td>
                        @if (isset($jan_total))
                            {{$jan_total}}
                        @endif    
                        </td>


                        <td>
                        @if (isset($feb_target))
                            {{$feb_target}}
                        @endif    
                        </td>
                        <td>
                        @if (isset($feb_total))
                            {{$feb_total}}
                        @endif    
                        </td>



                        <td>
                        @if (isset($mar_target))
                            {{$mar_target}}
                        @endif    
                        </td>
                        <td>
                        @if (isset($mar_total))
                            {{$mar_total}}
                        @endif    
                        </td>



                        <td>
                        @if (isset($apr_target))
                            {{$apr_target}}
                        @endif    
                        </td>
                        <td>
                        @if (isset($apr_total))
                            {{$apr_total}}
                        @endif    
                        </td>



                        <td>
                        @if (isset($may_target))
                            {{$may_target}}
                        @endif    
                        </td>
                        <td>
                        @if (isset($may_total))
                            {{$may_total}}
                        @endif    
                        </td>



                        <td>
                        @if (isset($jun_target))
                            {{$jun_target}}
                        @endif    
                        </td>
                        <td>
                        @if (isset($jun_total))
                            {{$jun_total}}
                        @endif    
                        </td>



                        <td>
                        @if (isset($jul_target))
                            {{$jul_target}}
                        @endif    
                        </td>
                        <td>
                        @if (isset($jul_total))
                            {{$jul_total}}
                        @endif    
                        </td>



                        <td>
                        @if (isset($aug_target))
                            {{$aug_target}}
                        @endif    
                        </td>
                        <td>
                        @if (isset($aug_total))
                            {{$aug_total}}
                        @endif    
                        </td>



                        <td>
                        @if (isset($sep_target))
                            {{$sep_target}}
                        @endif    
                        </td>
                        <td>
                        @if (isset($sep_total))
                            {{$sep_total}}
                        @endif    
                        </td>

                        

                        <td>
                        @if (isset($oct_target))
                            {{$oct_target}}
                        @endif    
                        </td>
                        <td>
                        @if (isset($oct_total))
                            {{$oct_total}}
                        @endif    
                        </td>



                        <td>
                        @if (isset($nov_target))
                            {{$nov_target}}
                        @endif    
                        </td>
                        <td>
                        @if (isset($nov_total))
                            {{$nov_total}}
                        @endif    
                        </td>


                        
                        <td>
                        @if (isset($dec_target))
                            {{$dec_target}}
                        @endif    
                        </td>
                        <td>
                        @if (isset($dec_total))
                            {{$dec_total}}
                        @endif    
                        </td>

            

                   
                
                    </tr>
                    @php
                    $ctr++;
                    $current_objective = $label->strategic_objective;
                @endphp
                  @endforeach
                </tbody>
    
            </table>
            
        </div>




        
    </x-user-sidebar>

    <script>
        
$(document).ready(function() {
  
//   var opcr_form = document.getElementById('opcr_form-{{$opcr_id}}');

//   opcr_form.addEventListener('submit', (event) => {
//     console.log("WEW");
//         // Prevent the form from submitting normally
//       event.preventDefault();
     
//       // Disable the submit button
//       const button = event.submitter;
//       button.disabled = true;
//       if (button.name === 'update') {
//       console.log('Button 1 was clicked');
//         } else if (button.name === 'button2') {
//         console.log('Button 2 was clicked');
//         }
      
//       event.target.submit();
//     });



  // your code goes here
});
    </script>
@endsection