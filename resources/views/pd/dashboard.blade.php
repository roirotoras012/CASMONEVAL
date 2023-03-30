@extends('layouts.app')
@section('title')
    {{ 'Provincial Director Dashboard' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div>
        <div class="container-fluid px-4 py-5">


            <li class="breadcrumb-item active">
                <h1 class="text-uppercase lead bg-primary text-white p-2 rounded">Provincial Director Dashboard</h1>


            </li>
            <div class="alert alert-warning d-inline-block px-4" role="alert">
                Welcome, {{ $userDetails->first_name . ' ' . $userDetails->last_name }}!

            </div>

        </div>

    </x-user-sidebar>
@endsection
