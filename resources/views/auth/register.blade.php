@extends('layouts.app')

@section('content')
    <div class="landing-banner h-100">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-5">
                    <div class="card">

                        <div class="card-body p-5">
                            <form method="GET" action="register-key">
                                <div class="text-center">
                                    <div class="m-4">
                                        <img style="height:100px;width: auto" src="{{ url('/images/dti-logo.png') }}" />
                                    </div>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                    class="p-1 fa-solid fa-key"></i>
                                            </span>
                                        </div>
                                       
                                        <input placeholder="Please enter registraion key" id="password" type="password"
<<<<<<< HEAD
           class="form-control eye-password @error('registration_key') is-invalid invalid-input @enderror{{ session('error') ? ' invalid-input' : '' }}"
                                            name="registration_key" autocomplete="registration_key" required
                                            pattern="^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert" />
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                       
=======
                                            class="form-control eye-password {{ session('error') ? 'invalid-input-key' : '' }}"
                                            name="registration_key" autocomplete="registration_key" required
                                            pattern="^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$"  oninvalid="this.setCustomValidity('Please enter a valid registration key')"
                                            oninput="this.setCustomValidity('')">

                                           

                                        {{-- @error('email')
                                            <span class="invalid-feedback" role="alert" />
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror --}}
>>>>>>> 8f8ec200fd5bad74364a041a625f58102d7cf756
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                                id="toggle-password">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                       
                                    </div>
<<<<<<< HEAD
                                     @if (session('error'))
                                            <small class="text-danger">
                                                {{ session('error') }}
                                            </small>
                                        @endif
=======
                                    @if(session('error'))
                                    <small class="text-danger">
                                        {{ session('error') }}
                                    </small>
                                @endif
>>>>>>> 8f8ec200fd5bad74364a041a625f58102d7cf756
                                    <div class="mb-0 mt-2">
                                        <button type="submit" class="btn btn-primary w-100 d-block">
                                            {{ __('Validate') }}
                                        </button>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
