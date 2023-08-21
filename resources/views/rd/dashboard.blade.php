@extends('layouts.app')
@section('title')
    {{ 'RD Dashboard' }}
@endsection

@section('content')
    <x-user-sidebar>
        {{-- <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div> --}}
        <div class="container-fluid px-4 py-5">

            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    <h2 class="text-uppercase lead  text-black p-2 rounded">RD <i class="fa-solid fa-angles-right"></i> Dashboard</h2>

                </li>


            </ol>
            
        </div>
    <div class="container-fluid">
            <x-dashboard-ppo-pd/>

            </div>
            
    </x-user-sidebar>
@endsection
