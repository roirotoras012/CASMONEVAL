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
            @if (count($notification) > 0)
            <form method="POST" action="{{ route('dc.add_driver') }}">
                @csrf

                <div class="card-header bg-primary text-white p-3">
                    <div class="table-title">
                        <div class="row d-flex align-items-center">
                            
                              
                            <div class="text-left d-flex justify-content-between align-items-center">
                                <h6 class="m-0">Manage <b>Measures & Drivers</b></h6>
                               
                    
                            </div>
                            
                        </div>
                    </div>
                </div>

                {{-- add driver --}}
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-center p-2">
                        <div><h3>Select a Operational Driver</h3></div>
                        <div>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addKpi">
                            <i class="fas fa-plus"></i> Add Operational Driver
                        </button>
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editDriver">
                            <i class="fas fa-edit"></i> Edit Operational Driver
                        </button>
                    </div>
                    </div>

                    
                    
                </div>

                {{-- select driver --}}
                <div class="px-3">
                    <select name="driver_ID" required class="form-select">
                        <option value="">CHOOSE DRIVER</option>
                        @foreach ($drivers->sortBy('driver') as $driver)
                            <option value="{{ $driver->driver_ID }}">{{ $driver->driver }}</option>
                        @endforeach
                    </select>
                    

                </div>

                

                {{-- measures --}}
                <div class="p-3">
                    <h3>Strategic measure</h3>
                    
                    {{-- @foreach ($measures as $measure)
                    
                        @if (isset($annual_targets[$measure->strategic_measure_ID]) || $measure->type == 'INDIRECT' || $measure->type == 'MANDATORY')
                            
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
                                            
                                            
                                            <input type="text" disabled value="{{$annual_targets[$measure->strategic_measure_ID]->first()->annual_target}}" class="form-control">
                                        
                                            
                                                
                                        
                                            @endif
                                            
                                        </div>
                                    </div>

                                @endif
                            @endif

                        @endif

                    @endforeach --}}

                    @foreach ($measures as $measure)
                        @if ((isset($annual_targets[$measure->strategic_measure_ID])) )
                        
                            @if (isset($annual_targets[$measure->strategic_measure_ID]))
                                @if ($annual_targets[$measure->strategic_measure_ID]->first()->driver_ID == null)
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="data[{{$measure->strategic_measure_ID}}][target_ID]" id="option{{$measure->strategic_measure_ID}}" value="{{$annual_targets[$measure->strategic_measure_ID]->first()->annual_target_ID}}" required>
                                        <label class="form-check-label" for="option{{$measure->strategic_measure_ID}}">
                                            {{$measure->strategic_measure}}
                                                
                                        </label>
                                    </div>


                                    <div class="form-check">
                                        @if (isset($annual_targets[$measure->strategic_measure_ID]))
                                        
                                        
                                        <input type="text" disabled value="{{$annual_targets[$measure->strategic_measure_ID]->first()->annual_target}}" class="form-control">
                                    
                                        
                                            
                                        
                                        @endif
                                        
                                    </div>
                                </div>
                                @endif
                            @endif
                            
                        @endif
                    @endforeach

                </div>

                {{-- indirect measures --}}
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-center p-2">
                        <h3>Indirect measure</h3>
                        <button class="btn btn-primary" type="button" class="btn btn-primary" data-toggle="modal" data-target="#addIndirect">Add Indirect measure</button>
                    </div>

                    {{-- @foreach ($measures as $measure)
                        @if ($measure->type == 'INDIRECT')
                        
                        <div class="d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="data[{{$measure->strategic_measure_ID}}][measure_ID]" id="option{{$measure->strategic_measure_ID}}" value="{{$measure->strategic_measure_ID}}" onclick="setRequired(this)">
                                <label class="form-check-label" for="option{{$measure->strategic_measure_ID}}">
                                    {{$measure->strategic_measure}}
                                        
                                </label>
                            </div>


                            <div class="form-check">
                                <input type="text" class="form-control" placeholder="set annual target" name="data[{{$measure->strategic_measure_ID}}][target]" id="target{{$measure->strategic_measure_ID}}">
                                
                            </div>
                        </div>

                        @endif
                    @endforeach --}}

                    @foreach ($measures as $measure)
                        @if($measure->type == 'INDIRECT')
                            @if ((isset($annual_targets[$measure->strategic_measure_ID])) )
                            
                                
                            @else
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="data[{{$measure->strategic_measure_ID}}][measure_ID]" id="option{{$measure->strategic_measure_ID}}" value="{{$measure->strategic_measure_ID}}" onclick="setRequired(this)" >
                                        <label class="form-check-label" for="option{{$measure->strategic_measure_ID}}">
                                            {{$measure->strategic_measure}}
                                                
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input pattern='^[0-9]+$' type="text" class="form-control" placeholder="set annual target" name="data[{{$measure->strategic_measure_ID}}][target]" id="target{{$measure->strategic_measure_ID}}">
                                        
                                    </div>
                            </div>
                            @endif

                        
                        @endif
                    @endforeach

                    

                    

                </div>

                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-center p-2">
                        <h3>Mandatory measure</h3>
                        <button class="btn btn-primary" type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMandatory">Add Mandatory measure</button>
                    </div>
                    
                    @foreach ($measures as $measure)
                        @if ($measure->type == 'MANDATORY')
                            
                            @if ((isset($annual_targets[$measure->strategic_measure_ID])) )
                               
                               
                               
                                    
                            @else
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="data[{{$measure->strategic_measure_ID}}][measure_ID]" id="option{{$measure->strategic_measure_ID}}" value="{{$measure->strategic_measure_ID}}" onclick="setRequired(this)">
                                        <label class="form-check-label" for="option{{$measure->strategic_measure_ID}}">
                                            {{$measure->strategic_measure}}
                                                
                                        </label>
                                    </div>


                                    <div class="form-check">
                                        <input type="text" class="form-control" placeholder="set annual target" name="data[{{$measure->strategic_measure_ID}}][target]" id="target{{$measure->strategic_measure_ID}}">
                                        
                                    </div>
                                </div>
                            @endif

                        @endif
                    @endforeach
                    

                </div>

                <div class="d-flex align-items-top gap-3 p-3 text-right pr-3" >
                    <input type="submit" name="" id="" class="btn btn-primary mb-3">
                </div>

            </form>
            @endif
            
        </div>
{{-- -------------------------------------------------------------------------------------------------------------------- --}}
        

<x-add_driver_form />
{{-- <x-edit_driver_form :drivers="$drivers->sortByDesc('driver_ID')" :selectedDriverId="$driver->driver_ID" :selectedDriver="$driver->driver" /> --}}
<x-edit_driver_form :drivers="$drivers->sortByDesc('driver_ID')" :selectedDriverId="$driver->driver_ID ?? null" :selectedDriver="$driver->driver ?? 'Driver Name'" />

<x-add_indirect_measure_form />
<x-add_mandatory_measure_form />

        </div>
    </x-user-sidebar>
    <script>
        var driverInput = document.querySelector('#driver_input');
        var driverSelect = document.querySelector('#driver_select');
        var measureInput = document.querySelector('#measure_textare');
        var measureSelect = document.querySelector('#measure_select');

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
