@extends('layouts.app')
@section('title')
    {{ 'Division Manage Measures and Drivers' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
          </div>
        <div class="container-fluid px-4 py-5">
            @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
            @endif
        <div class="card mb-4 m-4">
            {{-- {{dd($notification)}} --}}
            @if (count($notification) > 0)
            <form method="POST" action="{{ route('dc.add_driver') }}">
                @csrf
                {{-- {{var_dump(Session::all())}} --}}
                <div class="card-header">
                    <div class="table-title">
                        <div class="row d-flex align-items-center">
                            
                              
                            <div class="text-left d-flex justify-content-between align-items-center">
                                <h6 class="m-0">Manage <b>Measures & Drivers</b></h6>
                               
                    
                            </div>
                            
                        </div>
                    </div>
                </div>
    
        
                
    
                
                <div class="d-flex align-items-top gap-3">
                    <div class="d-flex align-items-center flex-column p-2 border">
                        <div>
                            <label for="driver">New Driver</label>
                            <input type="text" name="driver" id="driver_input" class="w-100" required>
                        </div>
                        <div class="text-center w-100">
                            <span>or</span>
                           <select name="driver_ID" id="driver_select" required>
                            <option value="">CHOOSE DRIVER</option>
                            @foreach ($drivers as $driver)
                            <option value="{{ $driver->driver_ID }}">{{ $driver->driver }}</option>
                            @endforeach
    
                           </select>
                          
                        </div>
                       
    
    
                    </div>
                    {{-- <div>
                        <span class="fs-5"><i class="fa-solid fa-arrow-right" style="color: #0d6efd;"></i></span>
    
                    </div> --}}
                    <div class="w-100 border">
                        <div class="d-flex justify-content-between align-items-center flex-column p-2">
                            <button type="button" id="addInputField">Add Input Field</button>
                            <div id="inputFieldsContainer" class="w-100 border p-2 my-2">
                                {{-- <div class="input-field d-flex align-items-center gap-1">
                                    <label for="measure">New Measure</label>
                                    <textarea type="text" name="add[0][measure]" class="measure_input w-100" placeholder="Enter value" id="measure_textare"></textarea>
                                    <div>
                                        <label for="measure">Annual Target</label>
                                        <input type="text" name="add[0][target]">
                                        <label for="measure">Type</label>
                                        <select name="add[0][type]" id="measure_select">
                                            <option value="">select</option>
                                            <option value="INDIRECT">INDIRECT</option>
                                            <option value="MANDATORY">MANDATORY</option>
                                         
                    
                                        </select>
                                    </div>
                                    
                                    <button class="removeInputField">Remove</button>
                                </div> --}}
                                
                            </div>
                            <div class="w-100">
                                <span>or <b> CHOOSE MEASURE</b></span>
                                
                                
                                @foreach ($measures as $measure)
                                @if ((isset($annual_targets[$measure->strategic_measure_ID])) || $measure->type == 'INDIRECT' || $measure->type == 'MANDATORY')
                                
                                @if (isset($annual_targets[$measure->strategic_measure_ID]))
                                @if ($annual_targets[$measure->strategic_measure_ID]->first()->driver_ID == null)
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="data[{{$measure->strategic_measure_ID}}][target_ID]" id="option{{$measure->strategic_measure_ID}}" value="{{$annual_targets[$measure->strategic_measure_ID]->first()->annual_target_ID}}">
                                        <label class="form-check-label" for="option{{$measure->strategic_measure_ID}}">
                                            {{$measure->strategic_measure}}
                                                
                                        </label>
                                    </div>
        
        
                                    <div class="form-check">
                                        @if (isset($annual_targets[$measure->strategic_measure_ID]))
                                        
                                        
                                        <input type="text" disabled value="{{$annual_targets[$measure->strategic_measure_ID]->first()->annual_target}}">
                                    
                                        
                                            
                                       
                                        @endif
                                        
                                    </div>
                                </div>
                                @endif
    
                               
                                    
                                @else
                               
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="data[{{$measure->strategic_measure_ID}}][measure_ID]" id="option{{$measure->strategic_measure_ID}}" value="{{$measure->strategic_measure_ID}}" onclick="setRequired(this)">
                                        <label class="form-check-label" for="option{{$measure->strategic_measure_ID}}">
                                            {{$measure->strategic_measure}}
                                                
                                        </label>
                                    </div>
        
        
                                    <div class="form-check">
                                        <input type="text" placeholder="set annual target" name="data[{{$measure->strategic_measure_ID}}][target]" id="target{{$measure->strategic_measure_ID}}">
                                        
                                    </div>
                                </div>
                               
                               
                                @endif
                               
                                @else
                                    
                                @endif
                               
                                
                                @endforeach
        
                               </select>
                              
                            </div>
                           
        
        
                        </div>
                        {{-- @foreach ($measures as $measure)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="measures[]" id="option{{$measure->strategic_measure_ID}}" value="{{$measure->strategic_measure_ID}}">
                            <label class="form-check-label" for="option1">
                                {{$measure->strategic_measure}}
                            </label>
                        </div>
                        @endforeach --}}
                        
                          
                    
    
                    </div>
    
    
    
    
                  
                </div>
    
                <div class="text-right">
                    <input type="submit" name="" id="">
                </div>
           
            </form>

           
                
            @else
            <h1 style="color:red" >NO OPCR SUBMITTED AT THE MOMENT</h1>
            
            @endif

           
        </div>




        </div>
    </x-user-sidebar>
    <script>
        var driverInput = document.querySelector('#driver_input');
        var driverSelect = document.querySelector('#driver_select');
        var measureInput = document.querySelector('#measure_textare');
        var measureSelect = document.querySelector('#measure_select');
        // measureInput.addEventListener('input', function(event) {
            
        // if (measureInput.value) {
        //     measureSelect.required = true;
        // } else {
        //     measureSelect.required = false;
        //     // There is no input in the input element
        // }
      
        // });


        console.log(driverInput)
        driverInput.addEventListener('input', function(event) {
            console.log(driverInput.value)
        if (driverInput.value) {
            driverSelect.disabled = true;
            driverSelect.required = false;
        } else {
            driverSelect.disabled = false;
            driverSelect.required = true;
            // There is no input in the input element
        }
      
        });
        driverSelect.addEventListener('input', function(event) {
        if (driverSelect.value) {
            driverInput.disabled = true;
            driverInput.required = false;
        } else {
            driverInput.disabled = false;
            driverInput.required = true;
            // There is no input in the input element
        }
        if(driverSelect.value && driverInput.value){
            driverInput.required = true;

        }
        });
    
        


        $(document).ready(function() {
            var counter = 0;
        $("#addInputField").click(function() {
            var newField = `<div class="input-field d-flex align-items-center gap-1">
                                <label for="measure">New Measure</label>
                                <textarea type="text" name="add[`+counter+`][measure]" class="measure_input w-100" placeholder="Enter value" required></textarea>
                                <div>
                                    <label for="measure">Annual Target</label>
                                    <input type="text" name="add[`+counter+`][target]" required>
                                    <label for="measure">Type</label>
                                    <select name="add[`+counter+`][type]" id="" required>
                                        <option value="">select</option>
                                        <option value="INDIRECT">INDIRECT</option>
                                        <option value="MANDATORY">MANDATORY</option>
                                     
                
                                    </select>
                                </div>
                                
                                <button class="removeInputField">Remove</button>
                            </div>`;
            $("#inputFieldsContainer").append(newField);
            counter++;
        });

        // Remove input field
        $(document).on("click", ".removeInputField", function() {
            $(this).parent(".input-field").remove();
        });
        });




        function setRequired(checkbox) {
            var input = document.getElementById('target'+ checkbox.value);
            input.required = checkbox.checked;
        }
    </script>   
@endsection
