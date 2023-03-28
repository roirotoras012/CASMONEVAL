<head>
    <link rel="stylesheet" href="{{ URL::asset('css/rd.css') }}" />
</head>
@extends('layouts.app')
@section('title')
    {{ 'RPO Add Target' }}
@endsection
@section('content')
<x-user-sidebar>
    <div class="loading-screen">
        <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
      </div>
        <div class="container-fluid px-4 py-5">
                
            <div class="card mb-4 m-4">
                <div class="card-header">
                    <div class="table-title">
                        <div class="row d-flex align-items-center">
                           
                              
                            <div class="col-sm-6 text-left">
                                <h6 class="m-0">Generate <b>OPCR</b></h6>
                            </div>
                            
                        </div>
                    </div>
                </div>
    
                
    
           
           
            </div>
            <div class="opcr-container">
                

                <div class="opcr-table">




                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p class="m-0">{{ $message }}</p>
                        </div>
                    @endif


                    <form action="{{ route('add_targets') }}" method="post">
                        
                        <table class="table table-bordered ppo-table shadow">
                            <thead class="bg-primary text-white text-center">
                                <tr>

                                    <th class="p-3">Strategic Objectives</th>
                                    <th class="p-3">Strategic Measures</th>
                                    <th class="p-3">REGION 10</th>
                                    <th class="p-3">BUK</th>
                                    <th class="p-3">CAM</th>
                                    <th class="p-3">LDN</th>
                                    <th class="p-3">MISOR</th>
                                    <th class="p-3">MISOC</th>
                                </tr>
                            </thead>

                            <tbody>



                                @csrf
                                @php
                                $current_objective = '';
                                    $ctr = 0;
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
                                        <td><input type="text" name="data[{{ $ctr }}][BUK]"></td>
                                        <td><input type="text" name="data[{{ $ctr }}][CAM]"></td>
                                        <td><input type="text" name="data[{{ $ctr }}][LDN]"></td>
                                        <td><input type="text" name="data[{{ $ctr }}][MISOR]"></td>
                                        <td><input type="text" name="data[{{ $ctr }}][MISOC]"></td>

                                    </tr>

                                    @php
                                        $ctr++;
                                        $current_objective = $label->strategic_objective;
                                    @endphp
                                   
                                @endforeach





                                {{-- <input type="submit" value="ADD" class="btn btn-success"> --}}
                                <div class="pb-3 opcr-btn">
                                    <button type="submit" class="btn btn-primary" value="ADD">
                                        Add OPCR
                                    </button>
                                    <button type="button" class="btn btn-success">
                                        <a style="text-decoration: none; color:white;" href="{{ url('rpo/savedtarget') }}">View OPCR</a> 
                                    </button>
                                </div>



                          <div class="form-group">
                            <label for="year">Year:</label>
                            <input type="text" name="year" class="form-control" id="usr" required>
                          </div>
                          <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea type="password" name="description" class="form-control" id="pwd" required></textarea>
                          </div>
                            </tbody>

                        </table>
                    </form>

                </div>


            </div>
        
        </div>

    </x-user-sidebar>
@endsection