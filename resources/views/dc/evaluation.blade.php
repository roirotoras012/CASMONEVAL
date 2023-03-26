@extends('layouts.app')
@section('title')
    {{ 'Division Chief Coaching and Mentoring' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
          </div>
        <div class="container-fluid px-4 py-5">
                
            <ol class="breadcrumb mb-4">
            
                <li class="breadcrumb-item active"><h1>Evaluation</h1></li>

            </ol>
    
        
        </div>
        {{-- {{dd($monthly_target_data)}} --}}

        <div class="card-body p-5">
            <form method="POST" action="{{ route('register') }}">
                <div class="text-center">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                            class="p-1 fa-solid fa-user"></i>
                                    </span>
                                </div>
                                <input value="{{ $accom->monthly_target }}"
                                    id="monthly_target" type="text"
                                    class="form-control" name="monthly_target" autofocus disabled>
                                @error('monthly_target')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                            class="p-1 fa-solid fa-user"></i>
                                    </span>
                                </div>
                                <input value="{{ $accom->monthly_accomplishment }}"
                                    id="monthly_accomplishment" type="text"
                                    class="form-control" name="monthly_accomplishment" autofocus disabled>
                                @error('monthly_accomplishment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                    class="p-1 fa-solid fa-users"></i>
                            </span>
                        </div>
                        <select name="user_type_ID" class="form-select">
                            <option selected name="{{request("user-id")}}">Select Role</option>
                            <option name="1" {{ old('user_type_ID') == '1' ? 'selected' : '' }}
                                value="1">Regional Director</option>
                            <option name="2" {{ old('user_type_ID') == '2' ? 'selected' : '' }}
                                value="2">Regional Planning Officer</option>
                            <option name="3" {{ old('user_type_ID') == '3' ? 'selected' : '' }}
                                value="3">Provincial Director</option>
                            <option name="4" {{ old('user_type_ID') == '4' ? 'selected' : '' }}
                                value="4">Provincial Planning Officer</option>
                            <option name="5" {{ old('user_type_ID') == '5' ? 'selected' : '' }}
                                value="5">Division Chief</option>
                        </select>

                    </div> --}}
                </div>
                        
                    </div> 
                <button type="submit" class="btn btn-primary w-100 d-block">
                    {{ __('Add Evaluation') }}
                </button>
        </div>

    </x-user-sidebar>
@endsection
