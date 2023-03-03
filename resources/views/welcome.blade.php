@extends('layouts.app')

@section('content')
    <div class="jumbotron d-flex align-items-center bg-white landing-banner" style="height: 95vh;">
        <div class="container">
            <div class="landing-details">
                <div class="text-left mb-4">
                    <img style="height:100px;" src="{{ url('/images/dti-logo.png') }}" />
                </div>
                <h5>Established to address local industry and foreign trade growth,</h5>
                <h1 class="display-3">Casmoneval</h1>
                <p class="lead"> Nearly 75 years following its inception, changes in government and agency functions would
                    make possible the establishment of the Ministry of Trade and Industry, and, following the People Power
                    Revolution, the Department as it is presently known.</p>
                <a href="/login"><button class="btn btn-primary btn-login">Login</button></a>
            </div>
        </div>
    </div>
@endsection
