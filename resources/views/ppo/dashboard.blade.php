@extends('layouts.app')
@section('title')
    {{ 'Provincial Planning Officer Dashboard' }}
@endsection
@section('content')
    <x-user-sidebar>
        {{-- <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div> --}}

        
        <div class="container-fluid px-4 py-5">
           
            <x-dashboard-ppo-pd/>
          
        </div>

        


    </x-user-sidebar>
@endsection
