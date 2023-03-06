@extends('layouts.app')
@section('title')
    {{ 'Provincial Planning Officer Add Target' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="container-fluid px-4 py-5">
                
            <ol class="breadcrumb mb-4">
            
                <li class="breadcrumb-item active"><h1>PPO Add Target</h1></li>
              
            </ol>
    
          

                @if ($annual_targets)
                <div class="container">
                    <h1>Provincial view of OPCR</h1>
                    <x-opcr_table :provinces=$provinces :objectivesact=$objectivesact :measures=$measures :annual_targets=$annual_targets/>
                    
                    {{-- <div class="row">
                        <div class="col-6 mx-auto">
                            <x-add_driver_form :opcrs=$opcrs :divisions=$divisions />
                        </div>
                        <div class="col-12 d-flex">
                            <x-group_driver_form :measures=$measures :drivers=$driversact />
                        </div>
                    </div> --}}
            
                    {{-- <x-opcr_table_driver :provinces=$provinces :driversact=$driversact :measures=$measures :annual_targets=$annual_targets/> --}}
                </div>
                @else
                <h1 style="color:red" >NO OPCR SUBMITTED AT THE MOMENT</h1>
                @endif
           
        </div>

    </x-user-sidebar>
@endsection