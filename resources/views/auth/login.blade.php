@extends('layouts.app')

@section('content')
    <div class="landing-banner h-100">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-4">
                    <div class="card">
                        {{-- <div class="card-header bg-primary text-white font-weight-bold text-center">{{ __('Login') }}</div> --}}

                        <div class="card-body p-5">
                            <div class="text-center m-4">
                                <img style="height:100px;width: auto" src="{{ url('/images/dti-logo.png') }}" />
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row mb-3">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                    class="p-1 fa-solid fa-user"></i>
                                            </span>
                                        </div>
                                        <input id="login" type="text"  placeholder="Username or Email" 
                                            pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                                            class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="login" value="{{ old('username') ?: old('email') }}" required autofocus>
                                        @if ($errors->has('username') || $errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                           <div class="invalid-feedback">Please input your username or email</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="w-100 d-block">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                                        class="p-1 fa-solid fa-lock"></i></span>
                                            </div>
                                            <input placeholder="Password" id="password" type="password"
                                                class="form-control eye-password @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
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
                                </div>

                                <div class="row mb-3">
                                    <div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="d-block">
                                        <button type="submit" class="d-block w-100 btn btn-primary">
                                            {{ __('Login') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                            <div style="display: flex; justify-content: center;">
                                                {{-- <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a> --}}
                                                <a class="btn btn-link" href="/register">
                                                    {{ __('Dont Have Account?') }}
                                                </a>
                                            </div>
                                        @endif
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
