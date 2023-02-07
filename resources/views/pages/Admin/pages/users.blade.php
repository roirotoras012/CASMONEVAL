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
                    <a href="#addEmployeeModal" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-success" data-toggle="modal"><i class="fa-solid fa-plus"></i><span class="p-1 d-inline-block">Add New Employee</span></a>
                    <a href="#deleteEmployeeModal"  class="btn btn-danger" data-toggle="modal"><i class="fa-solid fa-trash"></i><span class="p-1 d-inline-block">Delete</span></a>						
                </div>
            </div>
        </div>
    </div>
   
    <div class="card-body p-5">
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
                    <td>{{$user->user_ID }}</td>
                    <td>{{$user->username }}</td>
                    <td>{{$user->email }}</td>
                    <td>{{$user->last_name }}</td>
                    <td>{{$user->first_name }}</td>
                    <td>{{$user->middle_name }}</td>
                    <td>{{$user->extension_name }}</td>
                 
                    <td>{{$user->birthday}}</td>
                    <td>{{$user->user_type_ID}}</td>
                    <td>
                        <a href="#editEmployeeModal" class="edit mr-2" data-toggle="modal"><i class="fa-solid fa-pen text-warning"></i></a>
                        <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="fa-solid fa-trash text-danger"></i></a>
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
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                              </span>
                                            </div>
                                            <input value="{{old('first_name')}}" placeholder="Firstname" id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{old('first_name')}}" name="first_name" autocomplete="first_name" autofocus>
                                            @error('first_name')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                            @enderror
                                          </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                              </span>
                                            </div>
                                            <input value="{{old('last_name')}}" placeholder="Lastname" id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{old('last_name')}}"" autocomplete="last_name" autofocus>
                                            @error('last_name')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                            @enderror
                                          </div>
                                    </div>
                                  </div>
                                {{-- <div class="row mb-3">
                                  
                                </div>
                                <div class="row mb-3">
                                   
                                </div> --}}
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                            </span>
                                            </div>
                                            <input value="{{old('middle_name')}}" placeholder="Middlename" id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{old('middle_name')}}"""  name="middle_name" autocomplete="middle_name" autofocus>
                                            @error('middle_name')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                              <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                              </span>
                                            </div>
                                            <input value="{{old('extension_name')}}" placeholder="Extension name" id="extension_name" type="text" class="form-control @error('extension_name') is-invalid @enderror" name="extension_name" name="extension_name" autocomplete="extension_name" autofocus>
                                            @error('extension_name')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                            @enderror
                                          </div>
                                    </div>
                                </div>
                             
                                <div class="row mb-3">
                                  <label style="color:#505050f5;">Birthday</label>
                                    <div class="input-group-sm">
                                        <div class="input-group-prepend">
                                          <div class="input-group date" id="datepicker">
                                              <div class="input-group-prepend">
                                                  <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                                  </span>
                                              </div>
                                              
                                              <input value="{{old('date')}}" type="date" name='birthday' class="form-control @error('birthday') is-invalid @enderror" id="entry_date"  />
                                              @error('birthday')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                              @enderror
                                          </div>
                                        </div>
                                      </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-at"></i>
                                          </span>
                                        </div>
                                        <input value="{{old('email')}}"" placeholder="Email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="email">
                                        @error('email')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                      </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-users"></i>
                                          </span>
                                        </div>
                                        <select name="user_type_ID" class="form-select">
                                            <option selected>Select Role</option>
                                            <option name="1" {{ old('user_type_ID') == '1' ? 'selected' : '' }} value="1">Regional Director</option>
                                            <option name="2" {{ old('user_type_ID') == '2' ? 'selected' : '' }} value="2">Regional Planning Officer</option>
                                            <option name="3" {{ old('user_type_ID') == '3' ? 'selected' : '' }} value="3">Provincial Director</option>
                                            <option name="4" {{ old('user_type_ID') == '4' ? 'selected' : '' }} value="4">Provincial Planning Officer</option>
                                            <option name="5" {{ old('user_type_ID') == '5' ? 'selected' : '' }} value="5">Division Chief</option>
                                          </select>
                                      </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-lock"></i>
                                          </span>
                                        </div>
                                        <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                        @error('password')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                      </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-lock-open"></i></i>
                                          </span>
                                        </div>
                                        <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                       
                                      </div>
                                </div>
                               
                                {{-- <div class="row mb-0">
                                    <div class="d-block">
                                        <button type="submit" class="btn btn-primary d-block w-100">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div> --}}
                            </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"> {{ __('Register') }}</button>
                        </div>
                    </div>
                    </div>
                </div>
</div>
</x-sidebar>
@endsection
