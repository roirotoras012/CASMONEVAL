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
            @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
        <div class="card mb-4 m-4">
           
            {{-- {{var_dump(Session::all())}} --}}
            <div class="card-header">
                <div class="table-title">
                    <div class="row d-flex align-items-center">
                        
                          
                        <div class="text-left d-flex justify-content-between align-items-center">
                            <h6 class="m-0">Manage <b>Measures & Objectives</b></h6>
                            <button><a href="#" data-bs-toggle="modal"
                                data-bs-target="#objectiveModal"
                                id="#objectiveModal"
                                class="text-decoration-none text-black"
                                >Add Objective

                            </a></button>
                            
                                

                           
                          
                            <x-add_objective_modal/>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div>
                <div>
                    @foreach ($objectives as $objective)
                     <div>
                        <div class="table table-bordered ppo-table bg-primary text-white p-2 d-flex justify-content-between align-items-center">
                            <div><span class="fs-5"> {{$objective->strategic_objective}}</span></div>
                            <div>
                                <button><a href="#" data-bs-toggle="modal"
                                    data-bs-target="#_{{$objective->strategic_objective_ID}}"
                                    id="#_{{$objective->strategic_objective_ID}}"
                                    ><i class="fa-solid fa-plus"></i>
    
                                </a></button>
                                
                                    
    
                               
                              
                                <x-add_measure_rpo :objective=$objective :divisions=$divisions/>
                            
                            
                            </div>
                            
                        </div>
                        <div class="table table-bordered ppo-table shadow">
                            @if (isset($measures[$objective->strategic_objective_ID]))
                            @foreach ($measures[$objective->strategic_objective_ID] as $measure)
                            @foreach ($measure as $item)
                                <div class="table-bordered p-1">{{$item->strategic_measure }}</div>
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
