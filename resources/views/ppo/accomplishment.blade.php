@extends('layouts.app')
@section('title')
    {{ 'Provincial Planning Officer Add Accomplishment' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="container-fluid px-4 py-5">
                
            <ol class="breadcrumb mb-4">
            
                <li class="breadcrumb-item active"><h1>Manage Drivers</h1></li>
            
            </ol>
            @if ($annual_targets)
                <div class="container">
                  
                    {{-- <x-opcr_table :provinces=$provinces :objectivesact=$objectivesact :measures=$measures :annual_targets=$annual_targets/> --}}
                    
                    <div class="row">
                        {{-- <div class="col-6 mx-auto">
                            <x-add_driver_form :opcrs=$opcrs :divisions=$divisions />
                        </div> --}}
                        @if ($opcrs_active[0]->is_submitted_division == false)
                        <div class="col-12 d-flex">
                            <x-group_driver_form :measures=$measures :drivers=$driversact :opcrs_active=$opcrs_active />
                        </div>
                       
                        @endif
                       
                    </div>
            
                    <x-opcr_table_driver :provinces=$provinces :driversact=$driversact :measures=$measures :annual_targets=$annual_targets :opcrs_active=$opcrs_active/>
                    <form method="POST" action="{{ route('submit_to_division') }}" class="card text-bg-dark px-5 py-2 mx-auto my-3">
                        {{ csrf_field() }}
                        <input type="hidden" name="opcr_id" value={{$opcrs_active[0]->opcr_ID}}>
                        
                       @if ($opcrs_active[0]->is_submitted_division == true)
                       <button class="btn btn-primary" disabled type="submit">{{ __('Already Submitted to Division') }}</button>
                       @else
                       <button class="btn btn-primary" type="submit">{{ __('Submit to Division') }}</button>
                       @endif
                            
                       
                    
                </form>
                    
                </div>
                @else
                <h1 style="color:red" >NO OPCR SUBMITTED AT THE MOMENT</h1>
                @endif
        
        </div>

    </x-user-sidebar>
@endsection