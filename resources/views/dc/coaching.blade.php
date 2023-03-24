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

                <li class="breadcrumb-item active">
                    <h1>Division Chief Coaching and Mentoring</h1>
                </li>

            </ol>

            <ul class="breadcrumb mb-4">
                @if (isset($eval))
                    @foreach ($eval as $eva)
                        <li>
                            @if ($eva->reason == null)
                                <ul class="bg-danger">
                                    <li>{{ $eva->strategic_measure }}</li>
                                    <li>{{ $eva->monthly_target }}</li>
                                    <li>{{ $eva->monthly_accomplishment }}</li>
                                    <li>{{ ($eva->monthly_accomplishment / $eva->monthly_target) * 100 }} %</li>
                                    <li>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#reason1">
                                            Add Reason for not hitting the target
                                    </a>

                                    </li>
                                    <li>No Remarks yet</li>
                                </ul>
                                <x-update_reason_eval_modal :evaluation_ID="$eva->evaluation_ID" />
                            @else
                            <ul class="bg-success">
                                <li>{{ $eva->strategic_measure }}</li>
                                <li>{{ $eva->monthly_target }}</li>
                                <li>{{ $eva->monthly_accomplishment }}</li>
                                <li>{{ ($eva->monthly_accomplishment / $eva->monthly_target) * 100 }} %</li>
                                <li>{{ $eva->reason }}</li>
                                <li>No Remarks yet</li>
                            </ul>
                            @endif
                        </li>
                    @endforeach
                @endif

            </ul>


        </div>

    </x-user-sidebar>
@endsection
