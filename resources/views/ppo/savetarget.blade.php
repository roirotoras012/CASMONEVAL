@extends('layouts.app')
@section('title')
    {{ 'Provincial Planning Officer Save Target' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
          </div>
        <div class="container-fluid px-4 py-5">
                
            <ol class="breadcrumb mb-4">
            
                {{-- <li class="breadcrumb-item active"><h1>PPO Save Target</h1></li> --}}
           
            </ol>
            @if ($annual_targets)
            <div class="container">
                <h1 class="province-name bg-primary text-white text-uppercase mb-5 rounded">Add Drivers</h1>
               
                
                <div class="row">
                    <div class="col-6 mx-auto">
                        <x-add_driver_form :opcrs=$opcrs :divisions=$divisions />
                    </div>
                   
                </div>
        
               
            </div>
            @else
            <h1 style="color:red" >NO OPCR SUBMITTED AT THE MOMENT</h1>
            @endif
        </div>

    </x-user-sidebar>
@endsection