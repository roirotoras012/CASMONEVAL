@extends('layouts.app')
@section('title')
    {{ 'Provincial Director Dashboard' }}
@endsection
@section('content')
    <x-user-sidebar>
        {{-- <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div> --}}
        <div class="container-fluid ">
            @if (!empty($opcrs_active) && count($opcrs_active) > 0)
            {{-- <div class="text-uppercase lead bg-success text-white p-2 rounded d-inline-block mb-5">
                Provincial Director Dashboard
            </div>
            <div class="text-uppercase lead bg-primary text-white p-2 rounded d-inline-block mb-5">
                {{ match ($userDetails->province_ID) {
                    1 => 'Bukidnon BDD Division',
                    2 => 'Lanao Del Norte',
                    3 => 'Misamis Oriental',
                    4 => 'Misamis Occidental',
                    5 => 'Camiguin',
                    default => 'other',
                } }}
            </div> --}}

            <table class="table table-bordered ppo-table-opcr shadow d-none" id="table">
                <thead class="bg-primary text-white">
                    <tr>
                        <th rowspan="2" class="text-center align-middle">#</th>
                        <th rowspan="2" class="text-center align-middle">Objectives</th>
                        <th rowspan="2" class="text-center align-middle">#</th>
                        <th rowspan="2" class="text-center align-middle">Measure</th>
                        <th colspan="{{ $provinces->count() }}" class="text-center align-middle bg-warning">
                            {{ $opcrs_active[0]->year }}</th>

                    </tr>
                    <tr>
                        @foreach ($provinces as $province)
                            @if ($province->province_ID == $user->province_ID)
                                <th class="text-center align-middle bg-danger">{{ $province->province }}</th>
                                <th class="text-center align-middle bg-danger">C.Accom</th>
                            @endif
                        @endforeach

                    </tr>
                </thead>
                <tbody>

                    {{-- {{ dd($objectivesact[0]->strategic_measures) }} --}}
                    @foreach ($objectivesact as $objective)
                        @if (count($objective->measures) > 0)
                            @php
                                $mainDirectMeasures = $objective
                                    ->measures()
                                    ->where(function ($query) {
                                        $query->where('strategic_measures.type', 'DIRECT MAIN')->orWhere('strategic_measures.type', 'DIRECT');
                                    })
                                    ->get();
                                
                            @endphp
                            <tr>
                                <td rowspan="{{ count($mainDirectMeasures) + 1 }}" class="text-center align-middle">
                                    {{ $objective->objective_letter }}
                                </td>
                                <td rowspan="{{ count($mainDirectMeasures) + 1 }}" class="text-center align-middle">
                                    {{ $objective->strategic_objective }}
                                </td>
                            </tr>
                            @php
                                $colors = [
                                    'DIRECT' => 'text-white',
                                    'DIRECT MAIN' => 'text-white',
                                ];
                                $measures = $objective
                                    ->measures()
                                    ->orderByRaw('CAST(number_measure AS UNSIGNED) ASC')
                                    ->get();
                            @endphp

                            @foreach ($measures as $measure)
                                @php
                                    if ($measure->type == 'DIRECT') {
                                        $accomClass = $colors[$measure->type];
                                    } elseif ($measure->type == 'DIRECT MAIN') {
                                        $accomClass = $colors[$measure->type];
                                    } else {
                                        $accomClass = '';
                                    }
                                    $accomPercentage = 0;
                                    $bgColor = '';
                                    if (isset($annual_targets[$measure->strategic_measure_ID][$user->province_ID])) {
                                        $annual_target = $annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target;
                                        $annual_target_ID = $annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID;
                                        $target_type = $annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type;
                                        if (isset($monthly_targets[$annual_target_ID])) {
                                            $accom = $monthly_targets[$annual_target_ID]->annual_accom;
                                    
                                            if ($target_type == 'PERCENTAGE') {
                                                $accomPercentage = $accom / count($monthly_targets[$annual_target_ID]);
                                            } else {
                                                $accomPercentage = $accom / $annual_target;
                                            }
                                    
                                            // Set the background color based on the value of $accomPercentage
                                            if ($accomPercentage >= 0.9) {
                                                $bgColor = 'background-color: #4CAF50;';
                                            } else {
                                                $bgColor = 'background-color: #FF0000;';
                                            }
                                        } else {
                                            $accom = '';
                                            $bgColor = 'background-color: none;';
                                        }
                                        // Check if $annual_target exists and is greater than 0 before setting the $bgColor variable
                                        if (isset($annual_target) && $annual_target > 0) {
                                            // if ($measure->type == 'DIRECT MAIN') {
                                            //     if ($commonMeasures[$measure->strategic_measure]->annual >= 0.9 * $annual_target) {
                                            //         $bgColor = 'background-color: #4CAF50;';
                                            //     } else {
                                            //         $bgColor = 'background-color: #FF0000;';
                                            //     }
                                            // } else {
                                            if ($accomPercentage >= 0.9) {
                                                $bgColor = 'background-color: #4CAF50;';
                                            } else {
                                                $bgColor = 'background-color: #FF0000;';
                                            }
                                            // }
                                        } else {
                                            $bgColor = 'background-color: none;';
                                        }
                                    }
                                    
                                @endphp

                                @if ($measure->type == 'DIRECT' || $measure->type == 'DIRECT MAIN')
                                    <tr>
                                        <td class="text-center align-middle">
                                            {{ $measure->number_measure }}
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ $measure->strategic_measure }}
                                        </td>
                                        @if (isset($annual_targets[$measure->strategic_measure_ID][$user->province_ID]))
                                            <td class="text-center align-middle">
                                                {{ $annual_target }}@if ($target_type == 'PERCENTAGE')
                                                    %
                                                @endif
                                            </td>
                                            <td class="text-center align-middle" style="{{ $bgColor }} color: #fff">
                                                @if (isset($monthly_targets[$annual_target_ID]))
                                                    <span <?php if (isset($monthly_targets[$annual_target_ID]->validated) && $monthly_targets[$annual_target_ID]->validated == true) { ?> style="font-weight: bold;"
                                                        <?php } ?>>
                                                        @if ($target_type == 'PERCENTAGE')
                                                            {{ $accomPercentage }}%
                                                        @else
                                                            {{ $accom }}
                                                        @endif
                                                    </span>
                                                @endif
                                                {{-- @if ($measure->type == 'DIRECT MAIN')
                                                    <span class="{{ $colors[$measure->type] }} full-width">
                                                        @if ($commonMeasures[$measure->strategic_measure]->annual == 0)
                                                            <span></span>
                                                        @else
                                                            <span>{{ $commonMeasures[$measure->strategic_measure]->annual }}</span>
                                                        @endif
                                                    </span>
                                                @endif --}}
                                            </td>
                                        @else
                                            <td class="text-center align-middle">
                                                N/A
                                            </td>
                                            <td class="text-center align-middle" style="background-color: none;"></td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                </tbody>
            </table>







            <table class="table table-bordered ppo-table-opcr shadow d-none" id="rpo_scoreCard">
                <thead class="bg-primary text-white">
                    <tr>
                        <th rowspan="2" class="text-center align-middle">#</th>
                        <th rowspan="2" class="text-center align-middle">Strategic Objectives</th>
                        <th rowspan="2" class="text-center align-middle">#</th>
                        <th rowspan="2" class="text-center align-middle">Strategic Measures</th>
                        <th colspan="5" class="text-center align-middle">{{ $opcrs_active[0]->year }} TARGETS</th>
                        {{-- <th colspan="5" class="text-center align-middle">{{ !empty($opcrs_active[0]) ? $opcrs_active[0]->year . ' TARGETS' : 'No active OPCRs found' }}</th> --}}

                        <th colspan="2" class="text-center align-middle">ACCOMP</th>
                        <th colspan="3" class="text-center align-middle">{{ $opcrs_active[0]->year }} - 1ST SEMESTER
                        </th>
                        <th colspan="3" class="text-center align-middle">{{ $opcrs_active[0]->year }} - 2ND SEMESTER
                        </th>

                        {{-- <th colspan="3" class="text-center align-middle">{{ !empty($opcrs_active[0]) ? $opcrs_active[0]->year . ' - 1ST SEMESTER' : 'No active OPCRs found' }}</th>
            <th colspan="3" class="text-center align-middle">{{ !empty($opcrs_active[0]) ? $opcrs_active[0]->year . ' - 2ND SEMESTER' : '' }}</th> --}}

                        <th colspan="1" class="text-center align-middle">Jan</th>
                        <th colspan="1" class="text-center align-middle">Feb</th>
                        <th colspan="1" class="text-center align-middle">Mar</th>
                        <th colspan="1" class="text-center align-middle">Apr</th>
                        <th colspan="1" class="text-center align-middle">May</th>
                        <th colspan="1" class="text-center align-middle">Jun</th>
                        <th colspan="1" class="text-center align-middle">Jul</th>
                        <th colspan="1" class="text-center align-middle">Aug</th>
                        <th colspan="1" class="text-center align-middle">Sep</th>
                        <th colspan="1" class="text-center align-middle">Oct</th>
                        <th colspan="1" class="text-center align-middle">Nov</th>
                        <th colspan="1" class="text-center align-middle">Dec</th>

                    </tr>
                    <tr>


                        <th class="text-center align-middle">ANNUAL</th>
                        <th class="text-center align-middle">Q1</th>
                        <th class="text-center align-middle">Q2</th>
                        <th class="text-center align-middle">Q3</th>
                        <th class="text-center align-middle">Q4</th>


                        <th class="text-center align-middle">C.Accom</th>
                        <th class="text-center align-middle">% of Accom</th>

                        <th class="text-center align-middle">Target</th>
                        <th class="text-center align-middle">C.Accom</th>
                        <th class="text-center align-middle">% of Accom</th>

                        <th class="text-center align-middle">Target</th>
                        <th class="text-center align-middle">C.Accom</th>
                        <th class="text-center align-middle">% of Accom</th>

                        <th class="text-center align-middle">Accom</th>
                        <th class="text-center align-middle">Accom</th>
                        <th class="text-center align-middle">Accom</th>
                        <th class="text-center align-middle">Accom</th>
                        <th class="text-center align-middle">Accom</th>
                        <th class="text-center align-middle">Accom</th>
                        <th class="text-center align-middle">Accom</th>
                        <th class="text-center align-middle">Accom</th>
                        <th class="text-center align-middle">Accom</th>
                        <th class="text-center align-middle">Accom</th>
                        <th class="text-center align-middle">Accom</th>
                        <th class="text-center align-middle">Accom</th>


                    </tr>
                </thead>
                <tbody>
                    @php
                        
                        $valid90[0] = 0;
                        $valid90[1] = 0;
                        
                        $valid90[2] = 0;
                        $valid90[3] = 0;
                        $valid90[4] = 0;
                        $valid90[5] = 0;
                        $valid90[6] = 0;
                        $valid90[7] = 0;
                        $valid90[8] = 0;
                        $valid90[9] = 0;
                        $valid90[10] = 0;
                        $valid90[11] = 0;
                    @endphp
                    {{-- {{ dd($objectivesact[0]->strategic_measures) }} --}}
                    @foreach ($objectivesact as $objective)
                        @if (count($objective->measures) > 0)
                            @php
                                $mainDirectMeasures = $objective
                                    ->measures()
                                    ->where(function ($query) {
                                        $query->where('strategic_measures.type', 'DIRECT MAIN')->orWhere('strategic_measures.type', 'DIRECT');
                                    })
                                    ->get();
                                
                            @endphp
                            <tr>
                                <td rowspan="{{ count($mainDirectMeasures) + 1 }}" class="text-center align-middle">
                                    {{ $objective->objective_letter }}
                                </td>
                                <td rowspan="{{ count($mainDirectMeasures) + 1 }}" class="text-center align-middle">
                                    {{ $objective->strategic_objective }}
                                </td>
                            </tr>
                            @php
                                $colors = [
                                    'DIRECT' => 'text-white',
                                    'DIRECT MAIN' => 'text-white',
                                ];
                                $measures = $objective
                                    ->measures()
                                    ->orderByRaw('CAST(number_measure AS UNSIGNED) ASC')
                                    ->get();
                                
                            @endphp
                            @foreach ($measures as $measure)
                                @php
                                    
                                    if ($measure->type == 'DIRECT') {
                                        $accomClass = $colors[$measure->type];
                                    } elseif ($measure->type == 'DIRECT MAIN') {
                                        $accomClass = $colors[$measure->type];
                                    } else {
                                        $accomClass = '';
                                    }
                                    $accomPercentage = 0;
                                    $bgColor = '';
                                    if (isset($annual_targets[$measure->strategic_measure_ID][$user->province_ID])) {
                                        $annual_target = $annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target;
                                        $annual_target_ID = $annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID;
                                        if (isset($monthly_targets[$annual_target_ID])) {
                                            $accom = $monthly_targets[$annual_target_ID]->annual_accom;
                                            $accomPercentage = $accom / $annual_target;
                                            // Set the background color based on the value of $accomPercentage
                                            if ($accomPercentage >= 0.9) {
                                                $bgColor = 'background-color: #4CAF50;';
                                            } else {
                                                $bgColor = 'background-color: #FF0000;';
                                            }
                                        } else {
                                            $accom = '';
                                            $bgColor = 'background-color: none;';
                                        }
                                        // Check if $annual_target exists and is greater than 0 before setting the $bgColor variable
                                        if (isset($annual_target) && $annual_target > 0) {
                                            // if ($measure->type == 'DIRECT MAIN') {
                                            //     if ($commonMeasures[$measure->strategic_measure]->annual >= 0.9 * $annual_target) {
                                            //         $bgColor = 'background-color: #4CAF50;';
                                            //     } else {
                                            //         $bgColor = 'background-color: #FF0000;';
                                            //     }
                                            // } else {
                                            if ($accomPercentage >= 0.9) {
                                                $bgColor = 'background-color: #4CAF50;';
                                            } else {
                                                $bgColor = 'background-color: #FF0000;';
                                            }
                                            // }
                                        } else {
                                            $bgColor = 'background-color: none;';
                                        }
                                    }
                                    
                                @endphp

                                @if ($measure->type == 'DIRECT' || $measure->type == 'DIRECT MAIN')
                                    <tr>
                                        <td class="text-center align-middle">
                                            {{ $measure->number_measure }}
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ $measure->strategic_measure }}
                                        </td>
                                        @if (isset($annual_targets[$measure->strategic_measure_ID][$user->province_ID]))
                                            <td class="text-center align-middle">
                                                {{ $annual_target }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                    %
                                                @endif
                                            </td>

                                            @if (isset($monthly_targets2[$measure->strategic_measure_ID]))
                                                <td class="text-center align-middle">

                                                    {{ $monthly_targets2[$measure->strategic_measure_ID]->first_qrtr }}
                                                    @if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                        %
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $monthly_targets2[$measure->strategic_measure_ID]->second_qrtr }}
                                                    @if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                        %
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $monthly_targets2[$measure->strategic_measure_ID]->third_qrtr }}
                                                    @if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                        %
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $monthly_targets2[$measure->strategic_measure_ID]->fourth_qrtr }}
                                                    @if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                        %
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $monthly_targets2[$measure->strategic_measure_ID]->total_accom }}
                                                    @if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                        %
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ number_format(($monthly_targets2[$measure->strategic_measure_ID]->total_accom / $monthly_targets2[$measure->strategic_measure_ID]->total_targets) * 100, 2) }}%
                                                </td>

                                                <td class="text-center align-middle">
                                                    {{ $monthly_targets2[$measure->strategic_measure_ID]->first_sem }}
                                                    @if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                        %
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $monthly_targets2[$measure->strategic_measure_ID]->first_sem_accom }}
                                                    @if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                        %
                                                    @endif
                                                </td>
                                                {{-- <td>{{ number_format(($monthly_targets2[$measure->strategic_measure_ID]->first_sem_accom / $monthly_targets2[$measure->strategic_measure_ID]->first_sem) * 100, 2) }}%
                                                </td> --}}
                                                <td class="text-center align-middle">
                                                    @php
                                                        if ($monthly_targets2[$measure->strategic_measure_ID]->first_sem != 0) {
                                                            $result = ($monthly_targets2[$measure->strategic_measure_ID]->first_sem_accom / $monthly_targets2[$measure->strategic_measure_ID]->first_sem) * 100;
                                                            echo number_format($result, 2) . '%';
                                                        } else {
                                                            echo 'Denominator cannot be zero';
                                                        }
                                                        
                                                    @endphp
                                                </td>

                                                <td class="text-center align-middle">
                                                    {{ $monthly_targets2[$measure->strategic_measure_ID]->second_sem }}
                                                    @if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                        %
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $monthly_targets2[$measure->strategic_measure_ID]->second_sem_accom }}
                                                    @if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                        %
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    @php
                                                        if ($monthly_targets2[$measure->strategic_measure_ID]->second_sem != 0) {
                                                            $result = ($monthly_targets2[$measure->strategic_measure_ID]->second_sem_accom / $monthly_targets2[$measure->strategic_measure_ID]->second_sem) * 100;
                                                            echo number_format($result, 2) . '%';
                                                        } else {
                                                            echo 'Denominator cannot be zero';
                                                        }
                                                        
                                                    @endphp
                                                </td>


                                                @php
                                                    $jan_total = null;
                                                    $feb_total = null;
                                                    $mar_total = null;
                                                    $apr_total = null;
                                                    $may_total = null;
                                                    $jun_total = null;
                                                    $jul_total = null;
                                                    $aug_total = null;
                                                    $sep_total = null;
                                                    $oct_total = null;
                                                    $nov_total = null;
                                                    $dec_total = null;
                                                    
                                                    $jan_target = null;
                                                    $feb_target = null;
                                                    $mar_target = null;
                                                    $apr_target = null;
                                                    $may_target = null;
                                                    $jun_target = null;
                                                    $jul_target = null;
                                                    $aug_target = null;
                                                    $sep_target = null;
                                                    $oct_target = null;
                                                    $nov_target = null;
                                                    $dec_target = null;
                                                    
                                                    if (isset($monthly_targets2[$measure->strategic_measure_ID])) {
                                                        foreach ($monthly_targets2[$measure->strategic_measure_ID] as $measure_target) {
                                                            if ($measure_target->validated == 'Validated') {
                                                                if ($measure_target->monthly_target != 0) {
                                                                    if ($measure_target->month == 'jan') {
                                                                        $jan_total += $measure_target->monthly_accomplishment;
                                                                        $jan_target += $measure_target->monthly_target;
                                                                        if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                            $valid90[0]++;
                                                                        }
                                                                    }
                                                                    if ($measure_target->month == 'feb') {
                                                                        $feb_total += $measure_target->monthly_accomplishment;
                                                                        $feb_target += $measure_target->monthly_target;
                                                                        if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                            $valid90[1]++;
                                                                        }
                                                                    }
                                                                    if ($measure_target->month == 'mar') {
                                                                        $mar_total += $measure_target->monthly_accomplishment;
                                                                        $mar_target += $measure_target->monthly_target;
                                                                        if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                            $valid90[2]++;
                                                                        }
                                                                    }
                                                                    if ($measure_target->month == 'apr') {
                                                                        $apr_total += $measure_target->monthly_accomplishment;
                                                                        $apr_target += $measure_target->monthly_target;
                                                                        if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                            $valid90[3]++;
                                                                        }
                                                                    }
                                                                    if ($measure_target->month == 'may') {
                                                                        $may_total += $measure_target->monthly_accomplishment;
                                                                        $may_target += $measure_target->monthly_target;
                                                                        if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                            $valid90[4]++;
                                                                        }
                                                                    }
                                                                    if ($measure_target->month == 'jun') {
                                                                        $jun_total += $measure_target->monthly_accomplishment;
                                                                        $jun_target += $measure_target->monthly_target;
                                                                        if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                            $valid90[5]++;
                                                                        }
                                                                    }
                                                                    if ($measure_target->month == 'jul') {
                                                                        $jul_total += $measure_target->monthly_accomplishment;
                                                                        $jul_target += $measure_target->monthly_target;
                                                                        if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                            $valid90[6]++;
                                                                        }
                                                                    }
                                                                    if ($measure_target->month == 'aug') {
                                                                        $aug_total += $measure_target->monthly_accomplishment;
                                                                        $aug_target += $measure_target->monthly_target;
                                                                        if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                            $valid90[7]++;
                                                                        }
                                                                    }
                                                                    if ($measure_target->month == 'sep') {
                                                                        $sep_total += $measure_target->monthly_accomplishment;
                                                                        $sep_target += $measure_target->monthly_target;
                                                                        if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                            $valid90[8]++;
                                                                        }
                                                                    }
                                                                    if ($measure_target->month == 'oct') {
                                                                        $oct_total += $measure_target->monthly_accomplishment;
                                                                        $oct_target += $measure_target->monthly_target;
                                                                        if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                            $valid90[9]++;
                                                                        }
                                                                    }
                                                                    if ($measure_target->month == 'nov') {
                                                                        $nov_total += $measure_target->monthly_accomplishment;
                                                                        $nov_target += $measure_target->monthly_target;
                                                                        if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                            $valid90[10]++;
                                                                        }
                                                                    }
                                                                    if ($measure_target->month == 'dec') {
                                                                        $dec_total += $measure_target->monthly_accomplishment;
                                                                        $dec_target += $measure_target->monthly_target;
                                                                        if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                            $valid90[11]++;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                @endphp

                                                <td class="text-center align-middle">
                                                    @if (isset($jan_total))
                                                        {{ $jan_total }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                            %
                                                        @endif
                                                    @endif
                                                </td>



                                                <td class="text-center align-middle">
                                                    @if (isset($feb_total))
                                                        {{ $feb_total }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                            %
                                                        @endif
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($mar_total))
                                                        {{ $mar_total }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                            %
                                                        @endif
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($apr_total))
                                                        {{ $apr_total }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                            %
                                                        @endif
                                                    @endif
                                                </td>



                                                <td class="text-center align-middle">
                                                    @if (isset($may_total))
                                                        {{ $may_total }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                            %
                                                        @endif
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($jun_total))
                                                        {{ $jun_total }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                            %
                                                        @endif
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($jul_total))
                                                        {{ $jul_total }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                            %
                                                        @endif
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($aug_total))
                                                        {{ $aug_total }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                            %
                                                        @endif
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($sep_total))
                                                        {{ $sep_total }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                            %
                                                        @endif
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($oct_total))
                                                        {{ $oct_total }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                            %
                                                        @endif
                                                    @endif
                                                </td>



                                                <td class="text-center align-middle">
                                                    @if (isset($nov_total))
                                                        {{ $nov_total }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                            %
                                                        @endif
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($dec_total))
                                                        {{ $dec_total }}@if ($annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->type == 'PERCENTAGE')
                                                            %
                                                        @endif
                                                    @endif
                                                </td>
                                            @else
                                                @php
                                                    
                                                    $jan_total = null;
                                                    $feb_total = null;
                                                    $mar_total = null;
                                                    $apr_total = null;
                                                    $may_total = null;
                                                    $jun_total = null;
                                                    $jul_total = null;
                                                    $aug_total = null;
                                                    $sep_total = null;
                                                    $oct_total = null;
                                                    $nov_total = null;
                                                    $dec_total = null;
                                                    
                                                    $jan_target = null;
                                                    $feb_target = null;
                                                    $mar_target = null;
                                                    $apr_target = null;
                                                    $may_target = null;
                                                    $jun_target = null;
                                                    $jul_target = null;
                                                    $aug_target = null;
                                                    $sep_target = null;
                                                    $oct_target = null;
                                                    $nov_target = null;
                                                    $dec_target = null;
                                                    
                                                    if (isset($monthly_targets2[$measure->strategic_measure_ID])) {
                                                        foreach ($monthly_targets2[$measure->strategic_measure_ID] as $measure_target) {
                                                            if ($measure_target->month == 'jan') {
                                                                $jan_total += $measure_target->monthly_accomplishment;
                                                                $jan_target += $measure_target->monthly_target;
                                                                if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                    $valid90[0]++;
                                                                }
                                                            }
                                                            if ($measure_target->month == 'feb') {
                                                                $feb_total += $measure_target->monthly_accomplishment;
                                                                $feb_target += $measure_target->monthly_target;
                                                                if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                    $valid90[1]++;
                                                                }
                                                            }
                                                            if ($measure_target->month == 'mar') {
                                                                $mar_total += $measure_target->monthly_accomplishment;
                                                                $mar_target += $measure_target->monthly_target;
                                                                if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                    $valid90[2]++;
                                                                }
                                                            }
                                                            if ($measure_target->month == 'apr') {
                                                                $apr_total += $measure_target->monthly_accomplishment;
                                                                $apr_target += $measure_target->monthly_target;
                                                                if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                    $valid90[3]++;
                                                                }
                                                            }
                                                            if ($measure_target->month == 'may') {
                                                                $may_total += $measure_target->monthly_accomplishment;
                                                                $may_target += $measure_target->monthly_target;
                                                                if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                    $valid90[4]++;
                                                                }
                                                            }
                                                            if ($measure_target->month == 'jun') {
                                                                $jun_total += $measure_target->monthly_accomplishment;
                                                                $jun_target += $measure_target->monthly_target;
                                                                if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                    $valid90[5]++;
                                                                }
                                                            }
                                                            if ($measure_target->month == 'jul') {
                                                                $jul_total += $measure_target->monthly_accomplishment;
                                                                $jul_target += $measure_target->monthly_target;
                                                                if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                    $valid90[6]++;
                                                                }
                                                            }
                                                            if ($measure_target->month == 'aug') {
                                                                $aug_total += $measure_target->monthly_accomplishment;
                                                                $aug_target += $measure_target->monthly_target;
                                                                if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                    $valid90[7]++;
                                                                }
                                                            }
                                                            if ($measure_target->month == 'sep') {
                                                                $sep_total += $measure_target->monthly_accomplishment;
                                                                $sep_target += $measure_target->monthly_target;
                                                                if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                    $valid90[8]++;
                                                                }
                                                            }
                                                            if ($measure_target->month == 'oct') {
                                                                $oct_total += $measure_target->monthly_accomplishment;
                                                                $oct_target += $measure_target->monthly_target;
                                                                if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                    $valid90[9]++;
                                                                }
                                                            }
                                                            if ($measure_target->month == 'nov') {
                                                                $nov_total += $measure_target->monthly_accomplishment;
                                                                $nov_target += $measure_target->monthly_target;
                                                                if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                    $valid90[10]++;
                                                                }
                                                            }
                                                            if ($measure_target->month == 'dec') {
                                                                $dec_total += $measure_target->monthly_accomplishment;
                                                                $dec_target += $measure_target->monthly_target;
                                                                if (($measure_target->monthly_accomplishment / $measure_target->monthly_target) * 100 >= 90) {
                                                                    $valid90[11]++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    
                                                @endphp
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>


                                                <td></td>
                                                <td></td>

                                                <td></td>
                                                <td></td>
                                                <td></td>

                                                <td></td>
                                                <td></td>
                                                <td></td>

                                                <td class="text-center align-middle">
                                                    @if (isset($jan_total))
                                                        {{ $jan_total }}
                                                    @endif
                                                </td>



                                                <td class="text-center align-middle">
                                                    @if (isset($feb_total))
                                                        {{ $feb_total }}
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($mar_total))
                                                        {{ $mar_total }}
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($apr_total))
                                                        {{ $apr_total }}
                                                    @endif
                                                </td>



                                                <td class="text-center align-middle">
                                                    @if (isset($may_total))
                                                        {{ $may_total }}
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($jun_total))
                                                        {{ $jun_total }}
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($jul_total))
                                                        {{ $jul_total }}
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($aug_total))
                                                        {{ $aug_total }}
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($sep_total))
                                                        {{ $sep_total }}
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($oct_total))
                                                        {{ $oct_total }}
                                                    @endif
                                                </td>



                                                <td class="text-center align-middle">
                                                    @if (isset($nov_total))
                                                        {{ $nov_total }}
                                                    @endif
                                                </td>




                                                <td class="text-center align-middle">
                                                    @if (isset($dec_total))
                                                        {{ $dec_total }}
                                                    @endif
                                                </td>
                                            @endif
                                        @else
                                            <td class="text-center align-middle">
                                                N/A
                                            </td>
                                            <td class="text-center align-middle" style="background-color: none;"></td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach


                    <tr>

                        <td colspan="999">
                            <table style="width: 100%;" class="ratings_table table table-bordered ppo-table-opcr">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th class="text-center align-middle" colspan="999">Monthly Ratings</th>
                                    </tr>
                                    <tr>
                                        <th colspan="1" class="text-center align-middle" style="min-width: 150px">
                                        </th>
                                        <th colspan="2" class="text-center align-middle">January</th>
                                        <th colspan="2" class="text-center align-middle">February</th>
                                        <th colspan="2" class="text-center align-middle">March</th>
                                        <th colspan="2" class="text-center align-middle">April</th>
                                        <th colspan="2" class="text-center align-middle">May</th>
                                        <th colspan="2" class="text-center align-middle">June</th>
                                        <th colspan="2" class="text-center align-middle">July</th>
                                        <th colspan="2" class="text-center align-middle">August</th>
                                        <th colspan="2" class="text-center align-middle">September</th>
                                        <th colspan="2" class="text-center align-middle">October</th>
                                        <th colspan="2" class="text-center align-middle">November</th>
                                        <th colspan="2" class="text-center align-middle">December</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-left align-middle">
                                            Description</th>
                                        @for ($i = 0; $i < 12; $i++)
                                            <th class="text-left align-middle">No.</th>
                                            <th class="text-left align-middle">Rate</th>
                                        @endfor

                                    </tr>
                                    <tr>
                                        <th>No. of valid measure</th>
                                        @for ($i = 0; $i < 12; $i++)
                                            <td class="text-left align-middle">{{ $pgs['monthly_valid'][$i] }}</td>
                                            <td class="text-left align-middle"></td>
                                        @endfor




                                    </tr>

                                    <tr>
                                        <th>No. of valid measure atleast 90%</th>
                                        @for ($i = 0; $i < 12; $i++)
                                            <td class="text-left align-middle">{{ $valid90[$i] }}</td>
                                            <td class="text-left align-middle"></td>
                                        @endfor





                                    </tr>
                                    <tr>
                                        <th>OPCR rating </th>
                                        @for ($i = 0; $i < 12; $i++)
                                            @php
                                                $pgsratingtext = '';
                                                
                                                if (count($pgsrating2[$i]) !== 0 && $valid90[$i] !== 0) {
                                                    if ($pgsrating2[$i][$valid90[$i]]->first()->numeric == 5.0) {
                                                        $pgsratingtext = 'Outstanding';
                                                    } elseif ($pgsrating2[$i][$valid90[$i]]->first()->numeric >= 4.5) {
                                                        $pgsratingtext = 'Very Satisfactory';
                                                    } elseif ($pgsrating2[$i][$valid90[$i]]->first()->numeric >= 3.25) {
                                                        $pgsratingtext = 'Satisfactory';
                                                    } elseif ($pgsrating2[$i][$valid90[$i]]->first()->numeric >= 2.5) {
                                                        $pgsratingtext = 'Below Satisfactory';
                                                    } elseif ($pgsrating2[$i][$valid90[$i]]->first()->numeric < 2.5) {
                                                        $pgsratingtext = 'Poor';
                                                    }
                                                }
                                                
                                                // dd($pgsrating2);
                                                
                                            @endphp
                                       <td class="text-left align-middle">
                                                    @if (isset($pgsrating2[$i][$valid90[$i]]))
                                                        {{ $pgsrating->numeric }}
                                                    @else
                                                        <!-- Display empty cell -->
                                                    @endif
                                                </td>
                                        @endfor




                                    </tr>

                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>

            </table>
            @else
            {{-- <h1 style="color:red">NO OPCR SUBMITTED AT THE MOMENT</h1> --}}
            @endif
        
            

            @php
                // Calculate OPCR ratings and store them in an array
                $opcrRatings = [];
                for ($i = 0; $i < 12; $i++) {
                    $pgsrating_numeric = 0; // Initialize with a default value
                    if (count($pgsrating2[$i]) !== 0 && $valid90[$i] !== 0) {
                        $pgsrating_numeric = $pgsrating2[$i][$valid90[$i]]->first()->numeric;
                    }
                    $opcrRatings[] = $pgsrating_numeric; // Add the numeric rating to the array
                }
            @endphp
            <div class="row mt-5">
                <div class="col-sm-12 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="opcrLineChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-5">
                    <table class="table table-bordered table-hover mt-3">
                        <thead>
                            <tr>
                              <th class="text-center bg-primary text-white" colspan="3" scope="col">PGS Rating Matrix</th>
                            </tr>
                          </thead>
                        <thead>
                     <thead>
                       <tr>
                         <th class="text-center bg-primary text-white" scope="col">Numerical</th>
                         <th class="text-center bg-primary text-white" scope="col" colspan="2">Adjectival Rating</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr class="text-center">
                         <td scope="row">5.00</td>
                         <td>Outstanding</td>
                         <td>O</td>

                       </tr>
                       <tr class="text-center">
                         <td>4.50 - 4.75</td>
                         <td>Very Satisfactory</td>
                         <td>VS</td>
                       </tr>
                       <tr class="text-center">
                         <td>3.25 - 4.25</td>
                         <td>Satisfactory</td>
                         <td>S</td>
                       </tr>
                       <tr class="text-center">
                         <td>2.50 - 3.00</td>
                         <td>Below Satisfactory</td>
                         <td>BS</td>
                       </tr>
                       <tr class="text-center">
                                                     <td>Below 2.50 - 3.00</td>
                         <td>Poor</td>
                         <td>P</td>
                       </tr>
                     </tbody>
                   </table>
                
         </div>
            </div>
            <x-dashboard-ppo-pd />
            {{-- <div class="container-fluid">
       
        </div> --}}
    </x-user-sidebar>

    <script>
        const ctxLine = document.getElementById('opcrLineChart').getContext('2d');

        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
            'November', 'December'
        ];

        // Replace $opcrRatings with the actual variable name that holds your calculated OPCR ratings
        const opcrRatings = {!! json_encode($opcrRatings) !!};

        const dataLine = {
            labels: months,
            datasets: [{
                label: 'OPCR Ratings',
                data: opcrRatings,
                fill: false,
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHitRadius: 8,
                pointBorderWidth: 2,
            }]
        };

        const optionsLine = {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1, // Display whole numbers
                    }
                }
            }
        };

        new Chart(ctxLine, {
            type: 'line',
            data: dataLine,
            options: optionsLine,
        });
    </script>
@endsection
