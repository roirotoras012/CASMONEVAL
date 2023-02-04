@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-5">
            <div class="card">
                <div class="text-center card-header">{{ __('Register') }}</div>

                <div class="card-body p-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                  </span>
                                </div>
                                <input placeholder="Name" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                  </span>
                                </div>
                                <input placeholder="Email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
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
                                  <span class="input-group-text" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                  </span>
                                </div>
                                <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
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
                                  <span class="input-group-text" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                  </span>
                                </div>
                                <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                               
                              </div>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroup-sizing-sm logo-input"><i class="p-1 fa-solid fa-user"></i>
                                  </span>
                                </div>
                                <input placeholder="Security Key" id="name" type="text" class="form-control @error('name') is-invalid @enderror" required autocomplete="name" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
