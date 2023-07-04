@extends('layouts.app')

@section('content')
    <div class="landing-banner h-100">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-5">
                    <div class="card">

                        <div class="card-body p-5">
                            <form method="POST" action="{{ route('register') }}" novalidate oninput='password-confirm.setCustomValidity(password-confirm.value != password.value ? "Passwords do not match." : "")'>
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
                                                    class="form-control @error('first_name') @enderror 
                                                    value="{{ old('first_name') }}"
                                                    name="first_name" pattern="[A-Za-z]+" autocomplete="first_name"
                                                    autofocus required>
                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                                <div class="invalid-feedback">Please enter a valid first name</div>

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
                                                    type="text" class="form-control @error('last_name') @enderror"
                                                    name="last_name" autocomplete="last_name" required pattern="[A-Za-z]+"
                                                    autofocus>
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                                <div class="invalid-feedback">Please enter a valid last name</div>
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
                                                    class="form-control @error('middle_name') @enderror" name="middle_name"
                                                    autocomplete="middle_name" required pattern="[A-Za-z]+" autofocus>
                                                @error('middle_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                                <div class="invalid-feedback">Please enter a valid middle name</div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-icon" id="inputGroup-sizing-sm logo-input">
                                                        <i class="p-1 fa-solid fa-user"></i>
                                                    </span>
                                                </div>
                                                <select class="form-control @error('extension_name') is-invalid @enderror"
                                                    style="height:40px;" id="extension_name" name="extension_name"
                                                    autocomplete="extension_name" autofocus>
                                                    {{-- <option value="" disabled
                                                        {{ old('extension_name') ? '' : 'selected' }}>Extension name
                                                    </option> --}}
                                                    <option value="N/A"
                                                        {{ old('extension_name') ? '' : 'selected' }}>No extension
                                                        name</option>
                                                    <option value="Jr"
                                                        {{ old('extension_name') == 'Jr' ? 'selected' : '' }}>Jr</option>
                                                    <option value="Sr"
                                                        {{ old('extension_name') == 'Sr' ? 'selected' : '' }}>Sr</option>
                                                    <option value="II"
                                                        {{ old('extension_name') == 'II' ? 'selected' : '' }}>II</option>
                                                    <option value="III"
                                                        {{ old('extension_name') == 'III' ? 'selected' : '' }}>III</option>
                                                    <option value="IV"
                                                        {{ old('extension_name') == 'IV' ? 'selected' : '' }}>IV</option>
                                                </select>
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
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-icon"
                                                            id="inputGroup-sizing-sm logo-input"><i
                                                                class="p-1 fa-solid fa-user"></i>
                                                        </span>
                                                    </div>
                                                    <input value="{{ old('birthday') }}" type="date" name='birthday'
                                                        class="form-control @error('birthday') is-invalid @enderror"
                                                        id="entry_date"
                                                        pattern="(19\d{2}|20[01]\d|202[01])-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])"
                                                        max="{{ date('Y-m-d', strtotime('-18 years')) }}" required />
                                                    {{-- <input value="{{ old('birthday') }}" type="date" name='birthday'
                                                        class="form-control @error('birthday') is-invalid @enderror"
                                                        id="entry_date" />
                                                    @error('birthday')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror --}}
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
                                            {{-- <input value="{{ old('email') }}"" placeholder="Email" id="email"
                                                type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" autocomplete="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror --}}
                                            <input value="{{ old('email') }}"" placeholder="Email" id="email"
                                                type="email" class="form-control" name="email"
                                                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required
                                                autocomplete="email">

                                            <div class="invalid-feedback">Please enter a valid valid email</div>
                                        </div>
                                    </div>


                                    <input value="{{ request('user-id') }}" id="usertype-id" type="hidden"
                                        name="user_type_ID" />
                                    <input value="{{ request('registration-key') }}" id="registration_key"
                                        type="hidden" name="registration_key" />
                                    <input value="{{ request('division-id') }}" id="division_ID" type="hidden"
                                        name="division_ID" />
                                    <input value="{{ request('province-id') }}" id="province_ID" type="hidden"
                                        name="province_ID" />
                                    <input value="{{ request('status') }}" id="status" type="hidden"
                                        name="status" />
                                </div>
                                <div class="row mb-3">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input">
                                                <i class="p-1 fa-solid fa-lock"></i>
                                            </span>
                                        </div>
                                        <input placeholder="Password" id="password" type="password"
                                            class="form-control" name="password" autocomplete="new-password"
                                            pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$" required>
                                        <div class="invalid-feedback">At least 6 characters: 1 uppercase, 1 lowercase, and
                                            1 numeric.</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input">
                                                <i class="p-1 fa-solid fa-lock-open"></i>
                                            </span>
                                        </div>
                                        <input value="{{ old('password_confirm') }}" placeholder="Confirm Password"
                                            id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="password_confirmation">
                                        <div class="invalid-feedback" id="password-confirm-error">Passwords do not match.
                                        </div>
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
