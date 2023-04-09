@props(['objectivesact', 'measures', 'provinces', 'annual_targets', 'user', 'monthly_targets', 'commonMeasures'])


<div class="d-flex justify-content-between">
    <button class="btn btn-primary my-2" id="print-button">Print Table</button>
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
            <th rowspan="2" class="text-center align-middle">Objectives</th>
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
                        {{ $objective->strategic_objective }}
                    </td>
                </tr>
                @php
                    $colors = [
                        'DIRECT' => 'text-white',
                        'DIRECT MAIN' => 'text-white',
                    ];
                    
                @endphp
                @foreach ($objective->measures as $measure)
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
                                } elseif ($accomPercentage >= 0.5) {
                                    $bgColor = 'background-color: #FFC107;';
                                } else {
                                    $bgColor = 'background-color: #FF0000;';
                                }
                            } else {
                                $accom = '';
                                $bgColor = 'background-color: none;';
                            }
                            // Check if $annual_target exists and is greater than 0 before setting the $bgColor variable
                            if (isset($annual_target) && $annual_target > 0) {
                                if ($measure->type == 'DIRECT MAIN') {
                                    if ($commonMeasures[$measure->strategic_measure]->annual >= 0.9 * $annual_target) {
                                        $bgColor = 'background-color: #4CAF50;';
                                    } else {
                                        $bgColor = 'background-color: #FF0000;';
                                    }
                                } else {
                                    if ($accomPercentage >= 0.9) {
                                        $bgColor = 'background-color: #4CAF50;';
                                    } elseif ($accomPercentage >= 0.5) {
                                        $bgColor = 'background-color: #FFC107;';
                                    } else {
                                        $bgColor = 'background-color: #FF0000;';
                                    }
                                }
                            } else {
                                $bgColor = 'background-color: none;';
                            }
                        }
                        
                    @endphp

                    @if ($measure->type == 'DIRECT' || $measure->type == 'DIRECT MAIN')
                        <tr>
                            <td class="text-center align-middle">
                                {{ $measure->strategic_measure }} ({{ $measure->division_ID }} - {{ $measure->type }})
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
                                    @if ($measure->type == 'DIRECT MAIN')
                                        <span class="{{ $colors[$measure->type] }} full-width">
                                            @if ($commonMeasures[$measure->strategic_measure]->annual == 0)
                                                <span></span>
                                            @else
                                                <span>{{ $commonMeasures[$measure->strategic_measure]->annual }}</span>
                                            @endif
                                        </span>
                                    @endif
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
