@extends('layouts.app')

@section('content')
    <div class="jumbotron d-flex align-items-center bg-white landing-banner" style="height: 95vh;">
        <div class="container">
            <div class="landing-details">
                <div class="text-left mb-4">
                    <img style="height:100px;" src="{{ url('/images/dti-logo.png') }}" />
                </div>
                <h5>Established to address local industry and foreign trade growth,</h5>
                <h2 class="display-3">DTI's M&E System</h2>
                <p class="lead"> Nearly 75 years following its inception, changes in government and agency functions would
                    make possible the establishment of the Ministry of Trade and Industry, and, following the People Power
                    Revolution, the Department as it is presently known.</p>
                <a
                    href="{{ auth()->check()
                        ? (auth()->user()->user_type_ID === 1
                            ? url('/rd/dashboard')
                            : (auth()->user()->user_type_ID === 2
                                ? url('/rpo/dashboard')
                                : (auth()->user()->user_type_ID === 3
                                    ? url('/pd/dashboard')
                                    : (auth()->user()->user_type_ID === 4
                                        ? url('/ppo/dashboard')
                                        : (auth()->user()->user_type_ID === 5
                                            ? url('/dc/dashboard')
                                            : '#')))))
                        : url('/login') }}"><button
                        class="btn btn-primary btn-login">{{ auth()->check() ? 'Back to Dashboard' : 'Login' }}</button></a>
            </div>
        </div>
    </div>
@endsection
