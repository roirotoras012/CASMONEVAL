@props(['objectivesact', 'measures', 'provinces', 'annual_targets', 'user', 'monthly_targets', 'commonMeasures'])



<table class="table table-bordered ppo-table shadow" id="table">
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
                @foreach ($objective->measures as $measure)
                    @if ($measure->type == 'DIRECT' || $measure->type == 'DIRECT MAIN')
                        <tr>
                            <td class="text-center align-middle">
                                {{ $measure->strategic_measure }} ({{ $measure->division_ID }} - {{ $measure->type }})
                            </td>
                            @if (isset($annual_targets[$measure->strategic_measure_ID][$user->province_ID]))
                                <td class="text-center align-middle">
                                    {{ $annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target }}
                                </td>
                                @php
                                    if (isset($monthly_targets[$annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID])) {
                                        $accom = $monthly_targets[$annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID]->annual_accom;
                                    } else {
                                        $accom = '';
                                    }
                                @endphp
                                <td 
                                
                                {{-- style="<?php 
                            if (isset($monthly_targets[$annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID]) 
                                && $annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target == $accom) {
                                ?>background-color: #4CAF50; color: white;<?php 
                            } elseif (isset($monthly_targets[$annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID]) 
                                && $annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target > $accom) {
                                ?>background-color: #ff000021;<?php 
                            }
                            if ($accom >= 0.9 * $annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target) {
                                ?>background-color: #4CAF50;<?php
                            }
                        ?>" --}}
                                    class="text-center align-middle">
                                    @if (isset(
                                            $monthly_targets[
                                                $annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID
                                            ]))
                                        <span <?php if (isset($monthly_targets[$annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID]->validated) && $monthly_targets[$annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID]->validated == true) { ?> style="font-weight: bold;" <?php } ?>>
                                             {{ $accom }}
                                        </span>
                                    
                                        
                                    
                                    @endif
                                    @if ($measure->type == 'DIRECT MAIN')
                                    <span>
                                        @if ($commonMeasures[$measure->strategic_measure]->annual == 0)
                                            <span></span>
                                        @else
                                        <span>{{$commonMeasures[$measure->strategic_measure]->annual}}</span>
                                        @endif
                                         
                                    </span>
                                    @endif
                                </td>
                            @else
                                <td class="text-center align-middle">
                                    N/A
                                </td>
                                <td class="text-center align-middle"></td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            @endif
        @endforeach

    </tbody>
</table>
