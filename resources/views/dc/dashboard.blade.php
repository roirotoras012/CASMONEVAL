@extends('layouts.app')
@section('title')
    {{ 'Division Chief Dashboard' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
          </div>
        <div class="container-fluid px-4 py-5">
                
            <ol class="breadcrumb mb-4">
            
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">Number of Targets</div>
                    <div class="card-body">
                      <h5 class="card-title">1</h5>
                
                    </div>
                  </div>
              
            </ol>
    
        
        </div>

    </x-user-sidebar>
@endsection