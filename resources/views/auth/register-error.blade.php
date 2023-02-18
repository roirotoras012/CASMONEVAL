@extends('layouts.app')

@section('content')
    <div class="landing-banner h-100">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-5">
                    <div class="card text-center">
                        <div class="card-body p-5 mx-auto">

                            <img style="height:100px;width: auto;margin-bottom:10px;"
                                src="{{ url('/images/dti-logo.png') }}" />
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger mt-4 text-center">
                                    <p class="m-0">{{ $message }}</p>
                                </div>
                            @endif
                            <div class='d-block'>
                                <a href='/register' class="btn btn-primary">Go black</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
