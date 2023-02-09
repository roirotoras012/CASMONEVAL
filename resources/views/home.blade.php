@extends('layouts.app')

@section('content')

<x-sidebar>
  

<main>
    <div>
        <div class="card">
            {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}
            {{-- <div class="card-body"> --}}
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
               
                {{-- {{ __('You are logged in!') }} --}}
                
            {{-- </div> --}}
        </div>
    </div>
        <div class="container-fluid px-4">
         
            <ol class="breadcrumb mb-4">
               
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Total Departments</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                           <h2>2</h2>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Total Employee</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>12</h2>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Total Tasks</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>2</h2>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Total Designations</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>6</h2>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Total Evaluators</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>20</h2>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Total Users</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h2>14</h2>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Area Chart Example
                        </div>
                        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Bar Chart Example
                        </div>
                        <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    DataTable Example
                </div>
                <div class="card-body">
                   <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th></th>
                            <th>Email</th>
                            <th>Lastname</th>
                            <th>Firstname</th>
                            <th>Middlename</th>
                            <th>Extension Name</th>
                            <th>Birthday</th>
                            <th>User Type ID</th>
                           
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users ?? [] as $user)
                            <tr>
                                <th></th>
                                <td>{{ $user->user_ID }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->middle_name }}</td>
                                <td>{{ $user->extension_name }}</td>
                                <td>{{ $user->birthday }}</td>
                                <td>{{ $user->user_type_ID }}</td>
                              
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </main>
</x-sidebar>
@endsection
