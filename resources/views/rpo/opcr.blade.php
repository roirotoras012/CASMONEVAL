
<head>
    <link rel="stylesheet" href="{{ URL::asset('css/rd.css') }}" />
</head>
@extends('layouts.app')
@section('title')
    {{ 'RPO Save Target' }}
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
            <div class="opcr-container">


                <div class="opcr-table">




                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p class="m-0">{{ $message }}</p>
                        </div>
                    @endif


                    <form action="{{ route('update_targets') }}" method="post">
                        <input type="hidden" name="opcr_id"
                                                value="{{ $opcr_id }}">
                        <table class="table table-bordered ppo-table shadow">
                            <thead class="bg-primary text-white">
                                <tr>

                                    <th>Strategic Objectives</th>
                                    <th>Strategic Measures</th>
                                    <th>REGION 10</th>
                                    <th>BUK</th>
                                    <th>CAM</th>
                                    <th>LDN</th>
                                    <th>MISOR</th>
                                    <th>MISOC</th>
                                </tr>
                            </thead>

                            <tbody>



                                @csrf
                                @php
                                $current_objective = '';
                                    $ctr = 0;
                                    $is_edit = false;
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
                                        {{ $label->strategic_objective }}
                                    
                                        </td>
                                        @endif
                                       
                                       
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
                                     
                                        <td><input type="hidden" name="data[{{ $ctr }}][total_targets]"></td>
                                        <td>
                                            <input type="hidden" name="data[{{ $ctr }}][BUK]" value="">
                                            <input <?php if ($label->BUK != '' && ($is_edit == false)){ ?> disabled style="font-weight: bold;"<?php   } ?> type="number" name="data[{{ $ctr }}][BUK]" value="{{$label->BUK}}">
                                        </td>
                                        <td>
                                            <input type="hidden" name="data[{{ $ctr }}][CAM]" value="">
                                            <input <?php if ($label->CAM != '' && ($is_edit == false)){ ?> disabled style="font-weight: bold;"<?php   } ?> type="number" name="data[{{ $ctr }}][CAM]" value="{{$label->CAM}}">
                                        </td>
                                        <td>
                                            <input type="hidden" name="data[{{ $ctr }}][LDN]" value="">
                                            <input <?php if ($label->LDN != '' && ($is_edit == false)){ ?> disabled style="font-weight: bold;"<?php   } ?> type="number" name="data[{{ $ctr }}][LDN]" value="{{$label->LDN}}">
                                        </td>
                                        <td>
                                            <input type="hidden" name="data[{{ $ctr }}][MISOR]" value="">
                                            <input <?php if ($label->MISOR != '' && ($is_edit == false)){ ?> disabled style="font-weight: bold;"<?php   } ?> type="number" name="data[{{ $ctr }}][MISOR]" value="{{$label->MISOR}}">
                                        </td>
                                        <td>
                                            <input type="hidden" name="data[{{ $ctr }}][MISOC]" value="">
                                            <input <?php if ($label->MISOC != '' && ($is_edit == false)){ ?> disabled style="font-weight: bold;"<?php   } ?> type="number" name="data[{{ $ctr }}][MISOC]" value="{{$label->MISOC}}">
                                        </td>

                                    </tr>

                                    @php
                                        $ctr++;
                                        $current_objective = $label->strategic_objective;
                                    @endphp
                                   
                                @endforeach





                                {{-- <input type="submit" value="ADD" class="btn btn-success"> --}}
                                <div class="pb-3 opcr-btn">
                                    <button <?php if ($opcr[0]->is_submitted == true){ ?> disabled <?php   } ?> type="submit" name="submit" class="btn btn-primary" value="update">
                                        Update OPCR
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="edit()">
                                        Edit OPCR
                                    </button>
                                    <button <?php if ($opcr[0]->status == 'INCOMPLETE' || $opcr[0]->is_submitted == true){ ?> disabled <?php   } ?> type="submit" value="submit" name="submit" class="btn btn-success">
                                        Submit OPCR
                                    </button>
                                   
                                </div>
                                @if ($opcr[0]->is_submitted == true)
                                <div class="alert alert-success">
                                    <p class="m-0">OPCR is already submitted.</p>
                                </div>
                                @endif
                                <script>
                                 
                                </script>


                            </tbody>

                        </table>
                    </form>

                </div>


            </div>
        
        </div>

    </x-user-sidebar>
@endsection