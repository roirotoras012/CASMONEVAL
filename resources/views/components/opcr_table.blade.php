@props(['monthly_targets2', 'objectivesact', 'measures', 'provinces', 'annual_targets', 'user', 'monthly_targets', 'commonMeasures', 'opcrs_active'])


@foreach ($provinces as $province)
    @if ($province->province_ID == $user->province_ID)
        @php
            $printProvince = substr($province->province, 0, 3);
        @endphp
    @endif
@endforeach
<div class="d-flex justify-content-between">
    <div>
        <button class="btn btn-primary my-2"
            data-file-name="{{ $printProvince }}_OPCR-{{ $opcrs_active[0]->opcr_ID }}_{{ $opcrs_active[0]->year }}"
            id="print-button">Print Table</button>
        <button type="button" class="btn btn-primary my-2"
            data-file-name="{{ $printProvince }}_OPCR-{{ $opcrs_active[0]->opcr_ID }}_{{ $opcrs_active[0]->year }}"
            id="print-scoreCard">Scorecard</button>
        {{-- @if (count($opcrs_active) > 0)
            <button class="btn btn-primary my-2"
                data-file-name="{{ $printProvince }}_OPCR-{{ $opcrs_active[0]->opcr_ID }}_{{ $opcrs_active[0]->year }}"
                id="print-button">Print Table</button>
            <button type="button" class="btn btn-primary my-2"
                data-file-name="{{ $printProvince }}_OPCR-{{ $opcrs_active[0]->opcr_ID }}_{{ $opcrs_active[0]->year }}"
                id="print-scoreCard">Scorecard</button>
        @endif --}}

    </div>

    <div class="legend-container">


        <div class="legend-item">
            <div class="box" style="background: #4CAF50"></div>
            <div class="text-success">Passed</div>
        </div>

        <div class="legend-item">
            <div class="box" style="background: #FF0000"></div>
            <div class="text-danger">Failed</div>
        </div>

    </div>
</div>
<table class="table table-bordered ppo-table-opcr shadow" id="table">
    <thead class="bg-primary text-white">
        <tr>
            <th rowspan="2" class="text-center align-middle">#</th>
            <th rowspan="2" class="text-center align-middle">Objectives</th>
            <th rowspan="2" class="text-center align-middle">#</th>
            <th rowspan="2" class="text-center align-middle">Measure</th>
            <th colspan="{{ $provinces->count() }}" class="text-center align-middle bg-warning">Annual Target</th>

        </tr>
        <tr>
            @foreach ($provinces as $province)
                @if ($province->province_ID == $user->province_ID)
                    <th class="text-center align-middle bg-danger">{{ $province->province }}</th>
                    <th class="text-center align-middle bg-danger">Accomplished</th>
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
                        ->orderBy('number_measure', 'asc')
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
                                    {{ $annual_target }}
                                </td>
                                <td class="text-center align-middle" style="{{ $bgColor }} color: #fff">
                                    @if (isset($monthly_targets[$annual_target_ID]))
                                        <span <?php if (isset($monthly_targets[$annual_target_ID]->validated) && $monthly_targets[$annual_target_ID]->validated == true) { ?> style="font-weight: bold;" <?php } ?>>
                                            {{ $accom }}
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
            <th colspan="3" class="text-center align-middle">{{ $opcrs_active[0]->year }} - 1ST SEMESTER</th>
            <th colspan="3" class="text-center align-middle">{{ $opcrs_active[0]->year }} - 2ND SEMESTER</th>
            
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
                        ->orderBy('number_measure', 'asc')
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
                                    {{ $annual_target }}
                                </td>

                                @if (isset($monthly_targets2[$measure->strategic_measure_ID]) &&
                                        count($monthly_targets2[$measure->strategic_measure_ID]) >= 12)
                                    <td>{{ $monthly_targets2[$measure->strategic_measure_ID]->first_qrtr }}</td>
                                    <td>{{ $monthly_targets2[$measure->strategic_measure_ID]->second_qrtr }}</td>
                                    <td>{{ $monthly_targets2[$measure->strategic_measure_ID]->third_qrtr }}</td>
                                    <td>{{ $monthly_targets2[$measure->strategic_measure_ID]->fourth_qrtr }}</td>


                                    <td>{{ $monthly_targets2[$measure->strategic_measure_ID]->total_accom }}</td>
                                    <td>{{ number_format(($monthly_targets2[$measure->strategic_measure_ID]->total_accom / $monthly_targets2[$measure->strategic_measure_ID]->total_targets) * 100, 2) }}%
                                    </td>

                                    <td>{{ $monthly_targets2[$measure->strategic_measure_ID]->first_sem }}</td>
                                    <td>{{ $monthly_targets2[$measure->strategic_measure_ID]->first_sem_accom }}</td>
                                    {{-- <td>{{ number_format(($monthly_targets2[$measure->strategic_measure_ID]->first_sem_accom / $monthly_targets2[$measure->strategic_measure_ID]->first_sem) * 100, 2) }}%
                                    </td> --}}
                                    <td>
                                        @php
                                            if ($monthly_targets2[$measure->strategic_measure_ID]->first_sem != 0) {
                                                $result = $monthly_targets2[$measure->strategic_measure_ID]->first_sem_accom / ($monthly_targets2[$measure->strategic_measure_ID]->first_sem * 100);
                                                echo number_format($result, 2) . '%';
                                            } else {
                                                echo 'Denominator cannot be zero';
                                            }
                                            
                                        @endphp
                                    </td>

                                    <td>{{ $monthly_targets2[$measure->strategic_measure_ID]->second_sem }}</td>
                                    <td>{{ $monthly_targets2[$measure->strategic_measure_ID]->second_sem_accom }}</td>
                                    <td>
                                        @php
                                            if ($monthly_targets2[$measure->strategic_measure_ID]->second_sem != 0) {
                                                $result = $monthly_targets2[$measure->strategic_measure_ID]->second_sem_accom / ($monthly_targets2[$measure->strategic_measure_ID]->second_sem * 100);
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
                                                if ($measure_target->month == 'jan') {
                                                    $jan_total += $measure_target->monthly_accomplishment;
                                                    $jan_target += $measure_target->monthly_target;
                                                }
                                                if ($measure_target->month == 'feb') {
                                                    $feb_total += $measure_target->monthly_accomplishment;
                                                    $feb_target += $measure_target->monthly_target;
                                                }
                                                if ($measure_target->month == 'mar') {
                                                    $mar_total += $measure_target->monthly_accomplishment;
                                                    $mar_target += $measure_target->monthly_target;
                                                }
                                                if ($measure_target->month == 'apr') {
                                                    $apr_total += $measure_target->monthly_accomplishment;
                                                    $apr_target += $measure_target->monthly_target;
                                                }
                                                if ($measure_target->month == 'may') {
                                                    $may_total += $measure_target->monthly_accomplishment;
                                                    $may_target += $measure_target->monthly_target;
                                                }
                                                if ($measure_target->month == 'jun') {
                                                    $jun_total += $measure_target->monthly_accomplishment;
                                                    $jun_target += $measure_target->monthly_target;
                                                }
                                                if ($measure_target->month == 'jul') {
                                                    $jul_total += $measure_target->monthly_accomplishment;
                                                    $jul_target += $measure_target->monthly_target;
                                                }
                                                if ($measure_target->month == 'aug') {
                                                    $aug_total += $measure_target->monthly_accomplishment;
                                                    $aug_target += $measure_target->monthly_target;
                                                }
                                                if ($measure_target->month == 'sep') {
                                                    $sep_total += $measure_target->monthly_accomplishment;
                                                    $sep_target += $measure_target->monthly_target;
                                                }
                                                if ($measure_target->month == 'oct') {
                                                    $oct_total += $measure_target->monthly_accomplishment;
                                                    $oct_target += $measure_target->monthly_target;
                                                }
                                                if ($measure_target->month == 'nov') {
                                                    $nov_total += $measure_target->monthly_accomplishment;
                                                    $nov_target += $measure_target->monthly_target;
                                                }
                                                if ($measure_target->month == 'dec') {
                                                    $dec_total += $measure_target->monthly_accomplishment;
                                                    $dec_target += $measure_target->monthly_target;
                                                }
                                            }
                                        }
                                    @endphp

                                    <td>
                                        @if (isset($jan_total))
                                            {{ $jan_total }}
                                        @endif
                                    </td>



                                    <td>
                                        @if (isset($feb_total))
                                            {{ $feb_total }}
                                        @endif
                                    </td>




                                    <td>
                                        @if (isset($mar_total))
                                            {{ $mar_total }}
                                        @endif
                                    </td>




                                    <td>
                                        @if (isset($apr_total))
                                            {{ $apr_total }}
                                        @endif
                                    </td>



                                    <td>
                                        @if (isset($may_total))
                                            {{ $may_total }}
                                        @endif
                                    </td>




                                    <td>
                                        @if (isset($jun_total))
                                            {{ $jun_total }}
                                        @endif
                                    </td>




                                    <td>
                                        @if (isset($jul_total))
                                            {{ $jul_total }}
                                        @endif
                                    </td>




                                    <td>
                                        @if (isset($aug_total))
                                            {{ $aug_total }}
                                        @endif
                                    </td>




                                    <td>
                                        @if (isset($sep_total))
                                            {{ $sep_total }}
                                        @endif
                                    </td>




                                    <td>
                                        @if (isset($oct_total))
                                            {{ $oct_total }}
                                        @endif
                                    </td>



                                    <td>
                                        @if (isset($nov_total))
                                            {{ $nov_total }}
                                        @endif
                                    </td>




                                    <td>
                                        @if (isset($dec_total))
                                            {{ $dec_total }}
                                        @endif
                                    </td>
                                @else
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

    </tbody>
</table>
