@extends('layouts.app')
@section('title')
    {{ 'RD Profile Page' }}
@endsection

@section('content')
    <x-user-sidebar>
        <div class="container-fluid px-4 py-5">


            <div class="profile-container w-50 mx-auto">
                <div class="card p-2">
                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('register') }}">
                            <div>
                                @csrf
                                @if ($message = Session::get('validated'))
                                    <div class="alert alert-success mt-4">
                                        <p class="m-0">{{ $message }}</p>
                                    </div>
                                @endif

                                <span class="badge badge-primary">Id Number</span>

                                <div class="form-row">
                               
                                        <label>Username</label>
                                        <input id="username" type="text"
                                            class="form-control mb-2 @error('username') is-invalid @enderror" value="20234432"
                                            name="username" autofocus disabled>
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                   
                                    <div class="form-group col-md-6">
                                        <label>Firstname</label>
                                        <input id="first_name" type="text"
                                            class="form-control @error('first_name') is-invalid @enderror" value="20234432"
                                            name="first_name" autofocus>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Lastname</label>
                                        <input value="Lastname" placeholder="Lastname" id="last_name" type="text"
                                            class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                            autocomplete="last_name" autofocus>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Middlename</label>

                                        <input value="Middlename" placeholder="Middlename" id="middle_name" type="text"
                                            class="form-control @error('middle_name') is-invalid @enderror"
                                            name="middle_name" autocomplete="middle_name" autofocus>
                                        @error('middle_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">

                                        <label>Extension</label>

                                        <input value="T" placeholder="Extension name" id="extension_name"
                                            type="text"
                                            class="form-control @error('extension_name') is-invalid @enderror"
                                            name="extension_name" name="extension_name" autocomplete="extension_name"
                                            autofocus>
                                        @error('extension_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Birthdate</label>

                                    <input type="date" name='birthday'
                                        class="form-control @error('birthday') is-invalid @enderror" id="entry_date" />
                                    @error('birthday')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input value="denzel@gmail.com" placeholder="Email" id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>






                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <div class="input-group input-group-sm">
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
                            </div>
                            <button type="submit" class="btn btn-primary w-100 d-block">
                                {{ __('Update Profile') }}
                            </button>
                    </div>
                </div>


            </div>
        </div>

    </x-user-sidebar>
@endsection
