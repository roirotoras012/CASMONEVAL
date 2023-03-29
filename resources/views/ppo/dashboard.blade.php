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

          </div>
         
          <div class="container-fluid px-4 py-5">
            <ol class="breadcrumb mb-4">
            
              <li class="breadcrumb-item active">
                    <h1 class="text-uppercase lead bg-primary text-white p-2 rounded">Provincial Planning Officer Dashboard</h1>


                </li>
            </ol>
            
        
        </div>
        

    </x-user-sidebar>
@endsection
