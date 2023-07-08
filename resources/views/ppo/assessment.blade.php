@extends('layouts.app')
@section('title')
    {{ 'Provincial Planning Officer - Performance Assessment' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div>
        <div class="container-fluid px-4 py-5">
                <div class="text-uppercase lead bg-primary text-white p-2 rounded d-inline-block mb-5">
                    Provincial Planning Officer Performance Assessment
                </div>
            <div>
                @if (session()->has('update'))
                    <div class="alert alert-success">
                        {{ session('update') }}
                    </div>
                @endif
                @if (isset($eval))
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="bg-primary text-white">Measure</th>
                                <th scope="col" class="bg-primary text-white">Division</th>
                                <th scope="col" class="bg-primary text-white">Month</th>
                                <th scope="col" class="bg-primary text-white">Target</th>
                                <th scope="col" class="bg-primary text-white">Accomplishment</th>
                                <th scope="col" class="bg-primary text-white">Percentage</th>
                                <th scope="col" class="bg-primary text-white">Reason</th>
                                <th scope="col" class="bg-primary text-white">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eval as $eva)
                          
                                <tr>
                                    <th>{{ $eva->strategic_measure }}</th>
                                    <th>{{ $eva->division}}</th>
                                    <td>{{ $eva->month }}</td>
                                    <td>{{ $eva->monthly_target }}</td>
                                    <td>{{ $eva->monthly_accomplishment }}</td>
                                    <td>{{ ($eva->monthly_accomplishment / $eva->monthly_target) * 100 }} %</td>
                                    @if ($eva->reason == null)
                                        <td>No reason added yet</td>
                                        <td>No Remarks</td>
                                    @else
                                        <td>{{ $eva->reason }}</td>
                                        @if ($eva->remark == null)
                                            <td>
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#reason<?= $eva->evaluation_ID ?>">
                                                    Add Remarks
                                                </a>
                                                <x-update_remark_eval_modal :evaluation_ID="$eva->evaluation_ID" :division_ID="$eva->division" />
                                            </td>
                                        @else
                                            <td>{{ $eva->remark }}</td>
                                        @endif
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif


            </div>

        </div>

    </x-user-sidebar>
@endsection
