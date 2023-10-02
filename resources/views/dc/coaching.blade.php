@extends('layouts.app')
@section('title')
    {{ 'Division Chief Coaching and Mentoring' }}
@endsection
@section('content')
    <x-user-sidebar>
        {{-- <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div> --}}
        <div class="container-fluid px-4 py-5">
            @if (!is_null($notification) && count($notification) > 0)
                <ol class="breadcrumb mb-4">

                    <li class="breadcrumb-item active">
                        <h1>Division Chief Coaching and Mentoring</h1>
                    </li>

                </ol>
                <div>
                    @if (session()->has('update'))
                        <div class="alert alert-success">
                            {{ session('update') }}
                        </div>
                    @endif
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center gap-4">
                            <button class="btn btn-primary my-2" id="print-button"><i class="fas fa-print"></i> Print
                                Table</button>
                        </div>


                    </div>
                    @if (isset($eval))
                        <table class="table" id="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="bg-primary text-white">Measure</th>
                                    <th scope="col" class="bg-primary text-white">Month</th>
                                    <th scope="col" class="bg-primary text-white">Target</th>
                                    <th scope="col" class="bg-primary text-white">C.Accom</th>
                                    <th scope="col" class="bg-primary text-white">Percentage</th>
                                    <th scope="col" class="bg-primary text-white">Reason</th>
                                    <th scope="col" class="bg-primary text-white">Remarks</th>
                                    <th scope="col" class="bg-primary text-white">Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eval as $eva)
                                    <tr>
                                        <th>{{ $eva->strategic_measure }}</th>
                                        <td>{{ $eva->month }}</td>
                                        <td>{{ $eva->monthly_target }}</td>
                                        <td>{{ $eva->monthly_accomplishment }}</td>
                                        <td>{{ number_format(($eva->monthly_accomplishment / $eva->monthly_target) * 100, 2) }}
                                            %</td>
                                        @if ($eva->reason == null)
                                            <td>
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#reason<?= $eva->evaluation_ID ?>">
                                                    Add Reason for not hitting the target
                                                </a>
                                                <x-update_reason_eval_modal :evaluation_ID="$eva->evaluation_ID" />
                                            </td>
                                        @else
                                            <td>
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#reason<?= $eva->evaluation_ID ?>">
                                                    {{ $eva->reason }}
                                            </td>
                                            </a>
                                            <x-update_reason_eval_modal :evaluation_ID="$eva->evaluation_ID" />
                                        @endif
                                        @if ($eva->remark == null)
                                            <td>No remarks yet</td>
                                        @else
                                            <td class="text-center"
                                                style="background-color: {{ $eva->remark === 'Approve' ? 'green' : ($eva->remark === 'See me about this' ? '#ffc107' : ($eva->remark === 'Revise' ? 'red' : 'inherit')) }}">
                                                <a href="/dc/accomplishment" style="color: #fff;">{{ $eva->remark }}</a>
                                            </td>
                                        @endif

                                        @if ($eva->comment == null)
                                            <td>No comment added yet</td>
                                        @else
                                            <td>{{ $eva->comment }}</td>
                                        @endif

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif


                </div>


        </div>
    @else
        <h1 style="color:red">NO OPCR SUBMITTED AT THE MOMENT</h1>
        @endif

    </x-user-sidebar>
@endsection
