@extends('layouts.app')
@section('title')
    {{ 'RPO Add Measures' }}
@endsection

@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div>
        <div class="container-fluid px-4 py-5">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
            @if (count($opcrs) > 0 && isset($opcrs_active) && count($opcrs_active) > 0)
                <div class="disable-message">
                    <h1 class="text-success" style="font-size: 50px !important;">
                        ON GOING PROCESS FOR OPCR #{{ $opcrs[0]->opcr_ID }} {{ $opcrs[0]->year }}
                    </h1>
                </div>
            @endif



            <div class="card mb-4 m-4" @if ($opcr_gotActive) style="pointer-events: none; opacity: 0.5;" @endif>

                {{-- {{var_dump(Session::all())}} --}}
                <div class="card-header">
                    <div class="table-title">
                        <div class="row d-flex align-items-center">


                            <div class="text-left d-flex justify-content-between align-items-center">
                                <h6 class="m-0">Manage <b>Measures & Objectives</b></h6>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#objectiveModal"
                                    id="#objectiveModal"
                                    class="text-decoration-none text-black btn btn-primary text-white">Add Objective

                                </a>





                                <x-add_objective_modal />
                            </div>

                        </div>
                    </div>
                </div>

                <div>
                    <div>
                        @foreach ($objectives as $objective)
                            <div>
                                <div
                                    class="table table-bordered ppo-table bg-primary text-white p-2 d-flex justify-content-between align-items-center">
                                    <div><span class="fs-5">{{ $objective->objective_letter }}. {{ $objective->strategic_objective }}</span></div>
                                    <div class="d-flex gap-1">
                                        <form method="POST" action="{{ route('rpo.remove_objective') }}">
                                            @csrf
                                            <input type="hidden" name="objective_ID"
                                                value="{{ $objective->strategic_objective_ID }}">
                                            <input
                                                onclick="return confirm('Are you sure you want to remove this objective?')"
                                                type="submit" value="remove" class="bg-white">

                                        </form>



                                        <button class="bg-white"><a href="#" data-bs-toggle="modal"
                                                data-bs-target="#_{{ $objective->strategic_objective_ID }}"
                                                id="#_{{ $objective->strategic_objective_ID }}"><i
                                                    class="fa-solid fa-plus"></i>

                                            </a></button>



                                        <x-add_measure_rpo :objective=$objective :divisions=$divisions />


                                    </div>

                                </div>
                                <div class="table table-bordered ppo-table shadow">
                                    @if (isset($measures[$objective->strategic_objective_ID]))
                                        @foreach ($measures[$objective->strategic_objective_ID] as $measure)
                                            @foreach ($measure as $item)
                                            
                                                <div
                                                    class="table-bordered p-1 d-flex justify-content-between align-items-center">
                                                    <span>{{ $item->number_measure }}. {{ $item->strategic_measure }} 
                                                        @if (isset($item->sum_of))
                                                        <b>{{ '(' }}
                                                        @foreach (explode(", ", $item->sum_of) as $key => $sum)
                                                        @php
                                                        $sum_measure = DB::table('strategic_measures')->where('strategic_measure_ID', $sum)->first();
                                                        if(isset($sum_measure)){
                                                            $sum_measure_value = $sum_measure->strategic_measure;
                                                        }
                                                        else{
                                                            $sum_measure_value = null;

                                                        }
                                                       
                                                        @endphp
                                                        {{ $sum_measure_value}}
                                                        @if($key < count(explode(", ", $item->sum_of)) - 1)
                                                            +
                                                        @endif
                                                        @endforeach
                                                        {{ ')' }}
                                                        </b>
                                                        @endif
                                                       
                                                        </span>
                                                    
                                                    <form method="POST" action="{{ route('rpo.remove_measure') }}">
                                                        @csrf
                                                        <input type="hidden" name="measure_ID"
                                                            value="{{ $item->strategic_measure_ID }}">
                                                        <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#triggerSumModal_{{ $item->strategic_measure_ID }}"
                                                        id="#triggerSumModal_{{ $item->strategic_measure_ID }}"
                                                            style="background: #0d6efd"
                                                            class="text-decoration-none text-black btn btn-primary text-white">Auto Sum
                        
                                                        </a>
                                                       
                                                        <button type="submit" class="border-0"
                                                            onclick="return confirm('Are you sure you want to remove this measure?')">
                                                            <i class="fa-solid fa-xmark" style="color: #ff0000;"></i>
                                                        </button>
                                                        <x-add_trigger_modal :item=$item :measures=$measure/>
                                                    </form>
                                                </div>
                                                
                                            @endforeach
                                        @endforeach
                                    @endif


                                </div>
                            </div>
                        @endforeach


                    </div>







                </div>



            </div>




        </div>
    </x-user-sidebar>
@endsection
