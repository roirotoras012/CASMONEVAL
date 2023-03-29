@extends('layouts.app')
@section('title')
    {{ 'Provincial Planning Officer Dashboard' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div>
        <div class="container-fluid px-4 py-5">

            <ol class="breadcrumb mb-4">

                <li class="breadcrumb-item active">
                    <h1 class="text-uppercase lead bg-primary text-white p-2 rounded">Provincial Planning Officer Dashboard
                    </h1>


                </li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card mb-4 shadow">
                        <div class="card-body bg-primary text-white">Total Number of OPCR</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">

                            <h2>12</h2>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </x-user-sidebar>
@endsection
