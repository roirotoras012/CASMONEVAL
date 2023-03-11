@extends('layouts.app')
@section('title')
    {{ 'RPO Dashboard' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
          </div>
        <div class="container-fluid px-4 py-5">

            <ol class="breadcrumb mb-4">


                <li class="breadcrumb-item active">
                    <h1>Regional Planning Officer Dashboard</h1>


                </li>

            </ol>
            <div class="alert alert-warning d-inline-block px-4" role="alert">
                Welcome, {{ $userDetails->first_name . " ". $userDetails->last_name}}!
                               Passowrord, {{ $userDetails->password}}!

            </div>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">View OPCR</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>2</h2>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">View Provincial Accomplishment</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>12</h2>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Evaluation</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>2</h2>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </x-user-sidebar>
  
@endsection
