@extends('layouts.app')
@section('title')
    {{ 'Provincial Planning Officer BDD' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
          </div>
        <div class="container-fluid px-4 py-5">
                
            <ol class="breadcrumb mb-4">
            
                {{-- <li class="breadcrumb-item active"><h1>Manage Drivers</h1></li> --}}
            
            </ol>
                @if ($annual_targets)
                <div class="container">
                  
                  
            
                <h1 class="province-name bg-danger text-white text-uppercase mb-5 rounded">BDD division level view</h1>
                <table class="table table-bordered ppo-table shadow">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th rowspan="2" class="text-center align-middle">Drivers</th>
                            <th rowspan="2" class="text-center align-middle">Measure</th>
                            <th colspan="1" class="text-center align-middle">Annual Target</th>
                            <th colspan="12" class="text-center align-middle bg-success">Accomplished</th>
                            <th rowspan="2" class="text-center align-middle bg-success">Total</th>
                        </tr>
                        <tr>
                            @foreach ($provinces as $province)
                            @if ($province->province_ID == $user->province_ID)
                            <th class="text-center align-middle">{{ $province->province }}</th>
                            
                            <th class="text-center align-middle">Jan</th>
                            <th class="text-center align-middle">Feb</th>
                            <th class="text-center align-middle">Mar</th>
                            <th class="text-center align-middle">Apr</th>
                            <th class="text-center align-middle">May</th>
                            <th class="text-center align-middle">Jun</th>
                            <th class="text-center align-middle">Jul</th>
                            <th class="text-center align-middle">Aug</th>
                            <th class="text-center align-middle">Sep</th>
                            <th class="text-center align-middle">Oct</th>
                            <th class="text-center align-middle">Nov</th>
                            <th class="text-center align-middle">Dec</th>
                            @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($driversact as $driver)
                        {{-- {{dd($driver->measures)}}     --}}
                        @if ($driver->code == "BDD")
                        
                        <tr>
                            <td rowspan="{{ $driver->measures->count() + 1 }}" class="text-center align-middle">
                                {{ $driver->driver }}</td>
                            @foreach ($driver->measures as $measure)
                        <tr>
                        
                            <td class="text-center align-middle">{{ $measure->strategic_measure }}</td>
                        
                                <td class="text-center align-middle">
                                    @if (isset($annual_targets[$measure->strategic_measure_ID][$user->province_ID]))
                                     
                                            {{ $annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target }}
                                            
                                     
                                    @else
                                        N/A
                                    @endif
                                </td>
                                @php
                                    if(isset($monthly_targets[$annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID]))
                                {
                                   $accoms = $monthly_targets[$annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID];
                                  
                                }
                                else{

                                    $accoms = null;
                                }
                                @endphp
                              
                                @php
                                
                               
                                     
                                    
                                for($i = 0; $i < 12; $i++) {
                                  

                                    echo "<td class=\"text-center align-middle\">";
                                    
                                  

                                    if(isset($accoms)){
                                        for($j = 0; $j < count($accoms); $j++) {
                                        if($accoms[$j]->month_code == $i){
                                            echo $accoms[$j]->monthly_accomplishment;
                                        }
                                        
                                    
                                    
                                    }
                                    
                                    }
                                  
                         
                                    
                                    
                                    echo "</td>";
                                }
                                  
                               @endphp
                              
                               <td class="text-center align-middle"> 
                                @if (isset($accoms->annual_accom))
                                    {{ $accoms->annual_accom }}
                                @else
                                        
                                @endif
                               </td>    


                              

                        </tr>
                    @endforeach
                    </tr>
                        @endif
                        
                        @endforeach
                    </tbody>
                </table>
                   
                    
                </div>
                @else
                <h1 style="color:red" >NO OPCR SUBMITTED AT THE MOMENT</h1>
                @endif
        
        </div>

    </x-user-sidebar>
@endsection