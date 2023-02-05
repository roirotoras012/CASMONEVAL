@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-5">
            <div class="card">
                {{-- <div class="text-center bg-primary text-white card-header">{{ __('Register') }}</div> --}}

                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img style="height:100px;width: auto" src="{{url('/images/dti-logo.png')}}"/>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="col">
                          <div class="input-group input-group-sm">
                              <div class="input-group-prepend">
                                <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                </span>
                              </div>
                              <input placeholder="Username" id="username" type="text" class="form-control @error('username') is-invalid @enderror" value="{{old('username')}}" name="username" required autocomplete="username" autofocus>
                              @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                      </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                      <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                      </span>
                                    </div>
                                    <input placeholder="Firstname" id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{old('first_name')}}" name="first_name" required autocomplete="first_name" autofocus>
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
                                    <input placeholder="Lastname" id="last_name" type="text" class="form-control" name="last_name" required autocomplete="last_name" autofocus>
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
                                    <input placeholder="Middlename" id="middle_name" type="text" class="form-control" name="middle_name" required autocomplete="middle_name" autofocus>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                      <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                      </span>
                                    </div>
                                    <input placeholder="Extension name" id="extension_name" type="text" class="form-control" name="extension_name" required autocomplete="extension_name" autofocus>
                                  </div>
                            </div>
                        </div>
                     
                        <div class="row mb-3">
                            <div class="input-group input-group-sm">
                               
                                <div class="input-group-prepend">
                                
                                  <div class="input-group date" id="datepicker">
                                    <div class="input-group-prepend">
                                        <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                        </span>
                                      </div>
                                      <input type="date" name='birthday' class="form-control" id="entry_date"  />
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
                                <input placeholder="Email" id="email" type="email" class="form-control" name="email" required autocomplete="email">
                              </div>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                  <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-users"></i>
                                  </span>
                                </div>
                                <select class="form-select">
                                    <option selected>Select Role</option>
                                    <option name="1" value="1">Regional Director</option>
                                    <option name="2" value="2">Regional Planning Officer</option>
                                    <option name="3" value="3">Provincial Director</option>
                                    <option name="4" value="4">Provincial Planning Officer</option>
                                    <option name="5" value="5">Division Chief</option>
                                  </select>
                              </div>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                  <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-lock"></i>
                                  </span>
                                </div>
                                <input placeholder="Password" id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                              </div>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                  <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-lock-open"></i></i>
                                  </span>
                                </div>
                                <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                               
                              </div>
                        </div>
                       
                        <div class="row mb-0">
                            <div class="d-block">
                                <button type="submit" class="btn btn-primary d-block w-100">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
