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
                        <p>{{ $message }}</p>
                    </div>
                @endif
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
                            <th>Action</th>
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
                                <td>
                                    <div class="form-container d-flex">
                                        <form action="{{ route('users.destroy', $user->user_ID) }}" class="mr-2"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#deletemodal">
                                                <i class="fa-solid fa-trash text-white"></i>
                                            </button>
                                            {{-- MODAL POP UP --}}
                                            <x-modal />
                                            {{-- MODAL POP UP --}}
                                            {{-- <button type="submit" class="edit mr-2 border-0 "><i class="fa-solid fa-trash text-danger"></i></button> --}}
                                        </form>
                                        <form action="{{ route('users.destroy', $user->user_ID) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#updatemodal">
                                                <i class="fa-solid fa-pen t text-white">
                                            </button>
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
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-5">
                            <form method="POST" action="{{ route('users.store') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                    class="p-1 fa-solid fa-user"></i>
                                            </span>
                                        </div>

                                        <select name="user_type_ID" class="form-select">
                                            <option selected>Select Role</option>
                                            <option name="1" {{ old('user_type_ID') == '1' ? 'selected' : '' }}
                                                value="1">Regional Director</option>
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
                                </div>


                                {{-- <div class="row mb-0">
                                    <div class="d-block">
                                        <button type="submit" class="btn btn-primary d-block w-100">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div> --}}
                                <button type="submit" class="btn btn-primary"> {{ __('Generate user keys') }}</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- DELETE MODAL --}}
        <!-- Modal HTML -->

        {{-- UPDATE MODAL --}}
        <div class="modal fade" id="updatemodal" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal1Label">Modal 1</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Modal 1 content
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>













    </x-sidebar>
@endsection
