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

                                <span class="badge badge-primary mb-2">ID Number : {{$userDetails->user_ID}}</span>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Firstname</label>
                                        <input value={{$userDetails->first_name}} disabled id="first_name" type="text"
                                            class="form-control" value="20234432"
                                            name="first_name" autofocus>
                                      
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                     
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Lastname</label>
                                        <input value={{$userDetails->last_name}} disabled placeholder="Lastname" id="last_name" type="text"
                                            class="form-control" name="last_name"
                                            autocomplete="last_name" autofocus>
                                     

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Middlename</label>

                                        <input value={{$userDetails->middle_name}} disabled placeholder="Middlename" id="middle_name" type="text"
                                            class="form-control"
                                            name="middle_name" autocomplete="middle_name" autofocus>
                                   
                                    </div>
                                    <div class="form-group col-md-6">

                                        <label>Extension</label>

                                        <input  value={{$userDetails->extension_name != null ? $userDetails->extension_name : "N/A"}} disabled  placeholder="Extension name" id="extension_name"
                                            type="text"
                                            class="form-control"
                                            name="extension_name" name="extension_name" autocomplete="extension_name"
                                            autofocus>
                                     

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Birthdate</label>

                                    <input value={{$userDetails->birthday}} disabled type="date" name='birthday'
                                        class="form-control" id="entry_date" />

                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input value={{$userDetails->email}} placeholder="Email" id="email" type="email"
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
