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
                                        <input placeholder="Please enter registraion key" id="registration_key"
                                            type="text"
                                            class="form-control @error('registration_key') is-invalid @enderror"
                                            name="registration_key" autocomplete="registration_key">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
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
