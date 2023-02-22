@extends('layouts.app')

@section('content')
    <x-sidebar>
        <div class="card mb-4 m-4">
            <div class="card-header">
                <div class="table-title">
                    <div class="row d-flex align-items-center">
                        <div class="col-sm-6 text-left">
                            <h6 class="m-0">Manage <b>Employees</b></h6>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="#addEmployeeModal" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                class="btn btn-success" data-toggle="modal"><i class="fa-solid fa-plus"></i><span
                                    class="p-1 d-inline-block">Add New Employee</span></a>
                            {{-- <a href="#deleteEmployeeModal"  class="btn btn-danger" data-toggle="modal"><i class="fa-solid fa-trash"></i><span class="p-1 d-inline-block">Delete</span></a>						 --}}
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

                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Lastname</th>
                            <th>Firstname</th>
                            <th>Middlename</th>
                            <th>Extension Name</th>
                            <th>Birthday</th>
                            <th>User Type ID</th>
                            <th>Division ID</th>
                            <th>Action</th>
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
                                <td>
                                    <div class="form-container d-flex">
                                        <form action="{{ route('users.update', $user->user_ID) }}" class="mr-2"
                                            method="post">
                                            @csrf
                                            @method('put')
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#updatemodal-{{ $user->user_ID }}">
                                                <i class="fa-solid fa-pen t text-white"></i>
                                            </button>
                                            <x-modal-update :users='$user' />
                                        </form>
                                        <form action="{{ route('users.destroy', $user->user_ID) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#deletemodal-{{ $user->user_ID }}">
                                                <i class="fa-solid fa-trash text-white"></i>
                                            </button>
                                            <x-modal-delete :users='$user' />
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-5">
                            <form method="POST" action="{{ route('registerUser.create') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="input-group input-group-sm mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                    class="p-1 fa-solid fa-user"></i>
                                            </span>
                                        </div>

                                        <select name="user_type_ID" class="form-select" id="role">
                                            <option selected disabled>Select Role</option>
                                            <option name="1" value="1">Regional Director</option>
                                            <option name="2" {{ old('user_type_ID') == '2' ? 'selected' : '' }}
                                                value="2">Regional Planning Officer</option>
                                            <option name="3" {{ old('user_type_ID') == '3' ? 'selected' : '' }}
                                                value="3">Provincial Director</option>
                                            <option name="4" {{ old('user_type_ID') == '4' ? 'selected' : '' }}
                                                value="4">Provincial Planning Officer</option>
                                            <option name="5" {{ old('user_type_ID') == '5' ? 'selected' : '' }}
                                                value="5">Division Chief</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm" id="province_planning">
                                        <div class="input-group-prepend">
                                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                    class="p-1 fa-solid fa-user"></i>
                                            </span>
                                        </div>
                                        <select name="user_province_ID" class="form-select">
                                            <option selected disabled>Select Province</option>
                                            <option name="1" value="1" {{ old('user_province_ID') == '1' ? 'selected' : '' }}>Bukidnon</option>
                                            <option name="2" value="2" {{ old('user_province_ID') == '2' ? 'selected' : '' }}>Lanao Del Norte</option>
                                            <option name="3" value="3" {{ old('user_province_ID') == '3' ? 'selected' : '' }}>Misamis Oriental</option>
                                            <option name="4" value="4" {{ old('user_province_ID ') == '4' ? 'selected' : '' }}>Misamis Occidental</option>
                                            <option name="5" value="5" {{ old('user_province_ID ') == '5' ? 'selected' : '' }}>Camiguin</option>
                                        </select>
                                       
                                    </div>
                                    <div class="input-group input-group-sm mt-2" id="division_chief">
                                        <div class="input-group-prepend">
                                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                    class="p-1 fa-solid fa-user"></i>
                                            </span>
                                        </div>
                                        <select name="user_division_ID" class="form-select">
                                            <option selected disabled>Select Type</option>
                                            <option name="1" value="1" {{ old('user_division_ID') == '1' ? 'selected' : '' }}>Business Development Division</option>
                                            <option name="2" value="2" {{ old('user_division_ID') == '2' ? 'selected' : '' }}>Consumer Protection Division</option>
                                            <option name="3" value="3" {{ old('user_division_ID') == '3' ? 'selected' : '' }}>Finance Administrative Division</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                <div class="input-group" id='input-userkey-container'>
                                    <input type="text" id='input-userkey' name='input_userkey' class="form-control" placeholder="User Key">
                                    <span class="input-group-btn">
                                        <span class="input-group-btn">
                                            <input type="button" id='btn-generate' class="btn btn-primary h-100"
                                                value="{{ __('Generate') }}">
                                        </span>

                                </div>

                                <button type="submit" id='btn-add' class="btn btn-primary mt-2 d-block w-100">
                                    {{ __('Add User') }}</button>
                                    </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </x-sidebar>
@endsection
