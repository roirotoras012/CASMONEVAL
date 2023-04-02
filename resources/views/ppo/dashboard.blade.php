@extends('layouts.app')
@section('title')
    {{ 'Provincial Planning Officer Dashboard' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div>


        <div class="container-fluid px-4 py-5">

            <div class="text-uppercase lead bg-success text-white p-2 rounded d-inline-block mb-5">Provincial Planning Officer Dashboard</div>
            <div class="text-uppercase lead bg-primary text-white p-2 rounded d-inline-block mb-5">
                {{ match ($userDetails->province_ID) {
                    1 => 'Bukidnon',
                    2 => 'Lanao Del Norte',
                    3 => 'Misamis Oriental',
                    4 => 'Misamis Occidental',
                    5 => 'Camiguin',
                    default => 'other',
                } }}
            </div>

            @if ($annual_targets)
                <div class="container">
                    <h1 class="province-name bg-primary text-white text-uppercase mb-5 rounded">Provincial view of OPCR</h1>
                    <x-opcr_table :provinces=$provinces :objectivesact=$objectivesact :measures=$measures :annual_targets=$annual_targets :user=$user :monthly_targets=$monthly_targets/>
                    
                    {{-- <div class="row">
                        <div class="col-6 mx-auto">
                            <x-add_driver_form :opcrs=$opcrs :divisions=$divisions />
                        </div>
                        <div class="col-12 d-flex">
                            <x-group_driver_form :measures=$measures :drivers=$driversact />
                        </div>
                    </div> --}}
            
                    {{-- <x-opcr_table_driver :provinces=$provinces :driversact=$driversact :measures=$measures :annual_targets=$annual_targets/> --}}
                {{-- <form method="POST" action="{{ route('submit_to_division') }}" class="">
                        {{ csrf_field() }}
                        <input type="hidden" name="opcr_id" value={{$opcrs_active[0]->opcr_ID}}>
                        
                       @if ($opcrs_active[0]->is_submitted_division == true)
                       <button class="btn btn-primary" disabled type="submit">{{ __('Already Submitted to Division') }}</button>
                       @else
                       <button class="btn btn-primary" type="submit">{{ __('Submit to Division') }}</button>
                       @endif
                            
                       
                    
                </form> --}}
                </div>
                @else
                <h1 style="color:red" >NO OPCR SUBMITTED AT THE MOMENT</h1>
                @endif
        </div>


    </x-user-sidebar>
@endsection
