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
            
                <li class="breadcrumb-item active"><h1>Division Chief Coaching and Mentoring</h1></li>

            </ol>
                
            <ul class="breadcrumb mb-4">
                @if(isset($eval))
                    @foreach($eval as $eva)
                        @if($eva->reason == null or $eva->remark == null)
                        <li>
                                <ul>
                                    <li>{{$eva->strategic_measure}}</li>
                                    <li>{{$eva->monthly_target}}</li>
                                    <li>{{$eva->monthly_accomplishment}}</li>
                                    <li>{{($eva->monthly_accomplishment/$eva->monthly_target)*100}} %</li>
                                    <li><a href="#">Add reason why you did not meet the target</a></li>
                                    <li>No Remarks yet</li>
                                </ul>
                        </li>
                        @endif
                    @endforeach
                @endif

            </ul>
    
        
        </div>

    </x-user-sidebar>
@endsection
