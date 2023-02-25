@extends('layouts.app')
@section('title')
    {{ 'RPO Dashboard' }}
@endsection
@section('content')
    <x-sidebars.rpo-sidebar>
        <div class="card mb-4 m-4">
            <div class="card-header">
                <div class="table-title">
                    <div class="row d-flex align-items-center">
                        <div class="col-sm-6 text-left">
                            <h6 class="m-0">Manage <b>Employees</b></h6>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="card-body p-2">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p class="m-0">{{ $message }}</p>
                    </div>
                @endif
                <table id="datatablesSimple">
                    <thead>
                        <tr>

                            <th>IDs</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Lastname</th>
                            <th>Firstname</th>
                            <th>Middlename</th>
                            <th>Extension Name</th>
                            <th>Birthday</th>
                            <th>User Type ID</th>
                            <th>Division ID</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users ?? [] as $user)
                            <tr>
                                <td>{{ $user->user_ID }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->middle_name }}</td>
                                <td>{{ $user->extension_name }}</td>
                                <td>{{ $user->birthday }}</td>
                                <td>{{ $user->user_type_ID }}</td>
                                <td>{{ $user->division_ID }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            
        </div>


   


    </x-sidebars.rpo-sidebar>
@endsection