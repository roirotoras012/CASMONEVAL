@extends('layouts.app')
@section('title')
    {{ 'RPO Profile Page' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div>
        <div class="container-fluid px-4 py-5">


            <div class="profile-container w-75 mx-auto">
                <div class="p-5 bg-white rounded shadow mb-5">
                    <!-- Bordered tabs-->
                    {{-- @if (session()->has('update-pass-success'))
                        <div class="alert alert-success">
                            {{ session('update-pass-success') }}
                        </div>
                    @endif
                    @if ($message = Session::get('update-pass-error'))
                        <div class="alert alert-danger mt-4">
                            <p class="m-0">{{ $message }}</p>
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger mt-4">
                            <p class="m-0">{{ $message }}</p>
                        </div>
                    @endif --}}
                    <ul id="myTab1" role="tablist"
                        class="nav nav-tabs nav-pills with-arrow flex-column flex-sm-row text-center">
                        <li class="nav-item flex-sm-fill">
                            <a id="home1-tab" data-toggle="tab" href="#home1" role="tab" aria-controls="home1"
                                aria-selected="true"
                                class="nav-link text-uppercase font-weight-bold mr-sm-3 rounded-0 border active">Profile</a>
                        </li>
                        <li class="nav-item flex-sm-fill">
                            <a id="profile1-tab" data-toggle="tab" href="#profile1" role="tab" aria-controls="profile1"
                                aria-selected="false"
                                class="nav-link text-uppercase font-weight-bold mr-sm-3 rounded-0 border">Change Email </a>
                        </li>
                        <li class="nav-item flex-sm-fill">
                            <a id="contact1-tab" data-toggle="tab" href="#contact1" role="tab" aria-controls="contact1"
                                aria-selected="false"
                                class="nav-link text-uppercase font-weight-bold rounded-0 border">Change Password</a>
                        </li>
                    </ul>
                    <div id="myTab1Content" class="tab-content">
                        <div id="home1" role="tabpanel" aria-labelledby="home-tab"
                            class="tab-pane fade px-4 py-5 show active">

                            <form method="POST" action="{{ route('rpo.updateProfileHandler') , $userDetails->user_ID}}">
                                <div>
                                    @csrf
                                     @method('put')
                                    <span class="badge badge-primary mb-2">ID Number : {{ $userDetails->user_ID }}</span>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Firstname</label>
                                            <input value={{ $userDetails->first_name }} pattern="^[a-zA-Z\s]*$"
                                                id="first_name" required type="text" class="form-control"
                                             name="first_name" autofocus>
                                            <div class="invalid-feedback">Please enter a valid first name</div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Lastname</label>
                                            <input value={{ $userDetails->last_name }} pattern="^[a-zA-Z\s]*$" required
                                                placeholder="Lastname" id="last_name" type="text" class="form-control"
                                                name="last_name" autocomplete="last_name" autofocus>
                                            <div class="invalid-feedback">Please enter a valid last name</div>

                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Middlename</label>
                                            <input value={{ $userDetails->middle_name }} pattern="^[a-zA-Z\s]*$" required
                                                placeholder="Middlename" id="middle_name" type="text"
                                                class="form-control" name="middle_name" autocomplete="middle_name"
                                                autofocus>
                                            <div class="invalid-feedback">Please enter a valid middle name</div>

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label>Extension</label>

                                             <select class="form-control @error('extension_name') is-invalid @enderror"
                                                    style="height:40px;" id="extension_name" name="extension_name"
                                                    autocomplete="extension_name" autofocus>
                                                    {{-- <option value="" disabled
                                                        {{ old('extension_name') ? '' : 'selected' }}>Extension name
                                                    </option> --}}
                                                    <option value={{$userDetails->extension_name}} readonly selected>{{ $userDetails->extension_name }}</option>
                                                    <option value="N/A" {{ old('extension_name') }}>No
                                                        extension
                                                        name</option>
                                                    <option value="Jr" name="Jr"
                                                        {{ old('extension_name') == 'Jr' ? 'selected' : '' }}>Jr</option>
                                                    <option value="Sr" name="Sr"
                                                        {{ old('extension_name') == 'Sr' ? 'selected' : '' }}>Sr</option>
                                                    <option value="II" name="II"
                                                        {{ old('extension_name') == 'II' ? 'selected' : '' }}>II</option>
                                                    <option value="III" name="III"
                                                        {{ old('extension_name') == 'III' ? 'selected' : '' }}>III</option>
                                                    <option value="IV" name="IV"
                                                        {{ old('extension_name') == 'IV' ? 'selected' : '' }}>IV</option>
                                                </select>
                                            {{-- <input
                                                value={{ $userDetails->extension_name != null ? $userDetails->extension_name : 'N/A' }}
                                                placeholder="Extension name" id="extension_name" type="text"
                                                pattern="^[a-zA-Z\s]*$" required class="form-control" name="extension_name"
                                                name="extension_name" autocomplete="extension_name" autofocus> --}}
                                            <div class="invalid-feedback">Please enter a valid extension name</div>


                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Birthdate</label>

                                        <input value={{ $userDetails->birthday }} type="date" name='birthday' required
                                            pattern="(19\d{2}|20[01]\d|202[01])-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])"
                                            max="{{ date('Y-m-d', strtotime('-18 years')) }}" class="form-control"
                                            id="entry_date" />
                                        <div class="invalid-feedback">Enter a valid Birthdate. You must be at least 18 years
                                            old.</div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </form>
                        </div>
                        <div id="profile1" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 py-5">
                            <form method="POST" action="{{ route('rpo.updateEmailHandler') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Email</label>
                                    <input value={{ $userDetails->email }} placeholder="Email" id="email"
                                        type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <input type="hidden" name='current_password' value="current_password" />
                                </div>
                                <div class="form-group">
                                    <label for="password">Current Password:</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control eye-password" id="current_password2"
                                            pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$" name="current_password"
                                            required />

                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback">At least 6 characters: 1 uppercase, 1 lowercase, and
                                            1 numeric.</div>

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Email') }}
                                </button>
                            </form>
                        </div>
                        <div id="contact1" role="tabpanel" aria-labelledby="contact-tab"
                            class="tab-pane fade px-4 py-5">
                            <form method="POST" action="{{ route('rpo.updatePasswordHandler') }}"  oninput='passwordConfirm.setCustomValidity(passwordConfirm.value != newPassword.value ? "Passwords do not match." : "")'>
                                @csrf
                                <div class="form-group">
                                    <label for="password">Current Password:</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control eye-password" id="current_password1"
                                            pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$" name="current_password"
                                            required />
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>

                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="invalid-feedback">At least 6 characters: 1 uppercase, 1 lowercase, and
                                            1 numeric.</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New Password:</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control eye-password" id="newPassword"
                                            required pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$"
                                            name="new_password" />
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback">At least 6 characters: 1 uppercase, 1 lowercase, and
                                            1 numeric.</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">Confirm New Password</label>
                                    <div class="input-group input-group-sm">
                                        <input id="passwordConfirm" type="password" class="form-control eye-password"
                                            required pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$"
                                            name="password_confirmation" autocomplete="password_confirmation" />
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                      <div class="invalid-feedback" id="password-confirm-error">Passwords do not match.
                                        </div>

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Password') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- End bordered tabs -->
                </div>

            </div>


        </div>
        </div>

    </x-user-sidebar>
@endsection
