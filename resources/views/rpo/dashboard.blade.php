@extends('layouts.app')
@section('title')
    {{ 'RPO Dashboard' }}
@endsection
@section('content')
    <x-user-sidebar>
        {{-- <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
          </div> --}}

        <div class="container-fluid content-row px-4 py-5">
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    <h2 class="text-uppercase lead  text-black p-2 rounded">RPO <i class="fa-solid fa-angles-right"></i>
                        Dashboard</h2>
                </li>
            </ol>
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <canvas id="myChartBar"></canvas>
                        </div>
                    </div>

                </div>
            </div>
            {{-- <div class="alert alert-warning d-inline-block px-4" role="alert">
                Welcome, {{ $userDetails->first_name . " ". $userDetails->last_name}}!

            </div> --}}


{{--          


            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card mb-4 shadow" data-toggle="modal" data-target="#dashboard-modal">
                        <div class="card-body bg-primary text-white">Total Number of Users</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>{{ $totalUsers }}</h2>
                            <x-dashboard-modal :user_dashboard_details='$users' :id="6" />
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#dashboard-modal-6">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card mb-4 shadow">
                        <div class="card-body bg-primary text-white">Number of Regional Director</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>{{ $totalUsersRD }}</h2>
                            <x-dashboard-modal :user_dashboard_details='$user_rd_details' :id="1" />
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#dashboard-modal-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card mb-4 shadow" data-toggle="modal" data-target="#dashboard-modal">
                        <div class="card-body bg-primary text-white">Number of Provincial Planning Officer</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>{{ $totalUsersPPO }}</h2>
                            <x-dashboard-modal :user_dashboard_details='$user_ppo_details' :id="2" />
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#dashboard-modal-2">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card mb-4 shadow" data-toggle="modal" data-target="#dashboard-modal">
                        <div class="card-body bg-primary text-white">Number of Provincial Director</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>{{ $totalUsersPD }}</h2>
                            <x-dashboard-modal :user_dashboard_details='$user_pd_details' :id="3" />
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#dashboard-modal-3">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card mb-4 shadow" data-toggle="modal" data-target="#dashboard-modal">
                        <div class="card-body bg-primary text-white">Number of Regional Planning Officer</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>{{ $totalUsersRPO }}</h2>
                            <x-dashboard-modal :user_dashboard_details='$user_rpo_details' :id="4" />
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#dashboard-modal-4">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card mb-4 shadow" data-toggle="modal" data-target="#dashboard-modal">
                        <div class="card-body bg-primary text-white">Number of Division Chief</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>{{ $totalUsersDC }}</h2>
                            <x-dashboard-modal :user_dashboard_details='$user_dc_details' :id="5" />
                            <button type="button" class="btn btn-primary border-0" data-toggle="modal"
                                data-target="#dashboard-modal-5">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>


                    </div>
                </div> --}}
                {{-- <div class="col-xl-3 col-md-6">
                    <div class="card mb-4 shadow">
                        <div class="card-body bg-primary text-white">Number of Admin</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                             <h2>{{ $totalUsersADMIN}}</h2>
                            
                        </div>
                    </div>
                </div> --}}
            {{-- </div> --}}
            
        </div>
        {{-- <div class="container-fluid">
            <x-dashboard-ppo-pd />
        </div> --}}




    </x-user-sidebar>

    <script>
const ctx = document.getElementById('myChart');

var rd_chart_data = {!! json_encode($totalUsersRD) !!};
var ppo_chart_data = {!! json_encode($totalUsersPPO) !!};
var pd_chart_data = {!! json_encode($totalUsersPD) !!};
var rpo_chart_data = {!! json_encode($totalUsersRPO) !!};
var dc_chart_data = {!! json_encode($totalUsersDC) !!};

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [
            'Regional Director',
            'Provincial Planning Officer',
            'Provincial Director',
            'Regional Planning Officer',
            "Division Chief"
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [rd_chart_data, ppo_chart_data,pd_chart_data,rpo_chart_data,dc_chart_data],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(255, 53, 12)',
                'rgb(255, 99, 13)',

            ],
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        // scales: {
        //     y: {
        //         beginAtZero: true
        //     }
        // }
    }
});
const ctxbar = document.getElementById('myChartBar');

new Chart(ctxbar, {
    type: 'bar',
    data: {
        labels: [
            'Regional Director',
            'Provincial Planning Officer',
            'Provincial Director',
            'Regional Planning Officer',
            "Division Chief"
        ],
        datasets: [{
            label: 'Number of Users',
            data: [rd_chart_data, ppo_chart_data,pd_chart_data,rpo_chart_data,dc_chart_data],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(255, 53, 12)',
                'rgb(255, 99, 13)',

            ],
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        // scales: {
        //     y: {
        //         beginAtZero: true
        //     }
        // }
    }
});
    
    </script>
@endsection
