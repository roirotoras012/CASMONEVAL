@extends('layouts.app')

@section('content')
    <div class="landing-banner h-100">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-5">
                    <div class="card">

                        <div class="card-body p-5">
                            <form method="POST" action="{{ route('register') }}">

                                <div class="text-center">
                                    @csrf
                                    <div class="m-4">
                                        <img style="height:100px;width: auto;margin-bottom:10px;"
                                            src="{{ url('/images/dti-logo.png') }}" />
                                    </div>
                                    @if ($message = Session::get('validated'))
                                        <div class="alert alert-success mt-4">
                                            <p class="m-0">{{ $message }}</p>
                                        </div>
                                    @endif


                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                            class="p-1 fa-solid fa-user"></i>
                                                    </span>
                                                </div>
                                                <input value="{{ old('first_name') }}" placeholder="Firstname"
                                                    id="first_name" type="text"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    value="{{ old('first_name') }}" name="first_name"
                                                    autocomplete="first_name" autofocus>
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
                                                    <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                            class="p-1 fa-solid fa-user"></i>
                                                    </span>
                                                </div>
                                                <input value="{{ old('last_name') }}" placeholder="Lastname" id="last_name"
                                                    type="text"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    name="last_name" value="{{ old('last_name') }}""
                                                    autocomplete="last_name" autofocus>
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                            class="p-1 fa-solid fa-user"></i>
                                                    </span>
                                                </div>
                                                <input value="{{ old('middle_name') }}" placeholder="Middlename"
                                                    id="middle_name" type="text"
                                                    class="form-control @error('middle_name') is-invalid @enderror"
                                                    name="middle_name" value="{{ old('middle_name') }}"
                                                    autocomplete="middle_name" autofocus>
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
                                                    <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                            class="p-1 fa-solid fa-user"></i>
                                                    </span>
                                                </div>
                                                <input value="{{ old('extension_name') }}" placeholder="Extension name"
                                                    id="extension_name" type="text"
                                                    class="form-control @error('extension_name') is-invalid @enderror"
                                                    name="extension_name" name="extension_name"
                                                    autocomplete="extension_name" autofocus>
                                                @error('extension_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label style="color:#505050f5;text-align:left;">Birthday</label>
                                        <div class="input-group-sm">
                                            <div class="input-group-prepend">
                                                <div class="input-group date" id="datepicker">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-icon"
                                                            id="inputGroup-sizing-sm logo-input"><i
                                                                class="p-1 fa-solid fa-user"></i>
                                                        </span>
                                                    </div>

                                                    <input value="{{ old('date') }}" type="date" name='birthday'
                                                        class="form-control @error('birthday') is-invalid @enderror"
                                                        id="entry_date" />
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
                                                <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                        class="p-1 fa-solid fa-at"></i>
                                                </span>
                                            </div>
                                            <input value="{{ old('email') }}"" placeholder="Email" id="email"
                                                type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" autocomplete="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <input value="{{ request('user-id') }}" id="usertype-id" type="hidden"
                                        name="user_type_ID"/>
                                    <input value="{{ request('registration-key') }}" id="registration_key"
                                        type="hidden" name="registration_key" />

                                </div>
                                {{-- <div class="row mb-3">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                        class="p-1 fa-solid fa-users"></i>
                                                </span>
                                            </div>
                                            <select name="user_type_ID" class="form-select">
                                                <option selected name="{{request("user-id")}}">Select Role</option>
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
                                    </div> --}}
                                <div class="row mb-3">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                    class="p-1 fa-solid fa-lock"></i>
                                            </span>
                                        </div>
                                        <input placeholder="Password" id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            autocomplete="new-password">
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
                                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                    class="p-1 fa-solid fa-lock-open"></i></i>
                                            </span>
                                        </div>
                                        <input placeholder="Confirm Password" id="password-confirm" type="password"
                                            class="form-control" name="password_confirmation"
                                            @error('password_confirmation') is-invalid @enderror"
                                            autocomplete="password_confirmation">
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 d-block">
                                    {{ __('Register') }}
                                </button>
                        </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
