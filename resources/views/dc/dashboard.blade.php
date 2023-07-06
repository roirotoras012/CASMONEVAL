@extends('layouts.app')
@section('title')
    {{ 'Division Chief Dashboard' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div>
        <div class="container-fluid">
            <div class="text-uppercase lead bg-success text-white p-2 rounded d-inline-block mb-5">Division Chief Dashboard</div>
                <div class="text-uppercase lead bg-primary text-white p-2 rounded d-inline-block mb-5"> {{ $userDetails->first_name }} -  {{ match ($userDetails->province_ID) {
                1 => 'Bukidnon BDD Division',
                2 => 'Lanao Del Norte',
                3 => 'Misamis Oriental',
                4 => 'Misamis Occidental',
                5 => 'Camiguin',
                default => 'other',
            } }} 
            </div>
            <div class="text-uppercase lead bg-primary text-white p-2 rounded d-inline-block mb-5">
                 {{
                 match ($userDetails->division_ID) {
                                    1 => 'Business Development Division',
                                    2 => 'Consumer Protection Division',
                                    3 => 'Finance Administrative Division',
                                    default => 'other',
                                };
                     }}
                </div>
            {{-- <div  class="text-uppercase lead bg-success text-white p-2 rounded d-inline-block mb-5">
                Welcome, {{ $userDetails->first_name . ' ' . $userDetails->last_name }} !

            </div> --}}
            
            {{-- @foreach ($annual_target as $target)
                <p>{{ $target->division_ID === $division_ID && $target->division_ID }}</p>
             
                <!-- ... -->
            @endforeach --}}
           
        </div>
  <div class="container-fluid">
  <x-dashboard-ppo-pd/>
  </div>
   <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card mb-4 shadow">
                        <div class="card-body bg-primary text-white">Total Number of Targets</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>{{ $annual_target_number }}</h2>
                        </div>
                    </div>
                </div>
            </div>
    </x-user-sidebar>
@endsection
