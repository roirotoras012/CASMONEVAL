@props(['objectivesact', 'measures', 'provinces', 'annual_targets'])




<table class="table table-bordered border-primary">
    <thead>
        <tr>
            <th rowspan="2" class="text-center align-middle">Objectives</th>
            <th rowspan="2" class="text-center align-middle">Measure</th>
            <th colspan="{{ $provinces->count() }}" class="text-center align-middle">Annual Target</th>
        </tr>
        <tr>
            @foreach ($provinces as $province)
                <th class="text-center align-middle">{{ $province->province }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

        {{-- {{ dd($objectivesact[0]->strategic_measures) }} --}}
        @foreach ($objectivesact as $objective)
            <tr>
                <td rowspan="{{ $objective->measures->count() + 1 }}" class="text-center align-middle">
                    {{ $objective->strategic_objective }}</td>
               {{-- {{ dd($objective->measures) }}      --}}
                @foreach ($objective->measures as $measure)
            <tr>
                <td class="text-center align-middle">{{ $measure->strategic_measure }}</td>
                @foreach ($provinces as $province)
                    <td class="text-center align-middle">
                        @if (isset($annual_targets[$measure->strategic_measure_ID][$province->province_ID]))
                            {{-- <a href="#" data-bs-toggle="modal"
                                data-bs-target="#<?= $measure->strategic_measure_ID . '_' . $province->province_ID ?>"
                                id="{{ $province->province_ID }}" class="text-success"> --}}
                                {{ $annual_targets[$measure->strategic_measure_ID][$province->province_ID]->first()->annual_target }}
                            {{-- </a> --}}
                            {{-- <x-update_target_modal :measure="$measure->strategic_measure_ID" :province="$province->province_ID" :target="$annual_targets[$measure->strategic_measure_ID][$province->province_ID]->first()
                                ->annual_target_ID" /> --}}
                        @else
                            {{-- <a href="#" data-bs-toggle="modal"
                                data-bs-target="#<?= $measure->strategic_measure_ID . '_' . $province->province_ID ?>"
                                id="{{ $province->province_ID }}" class="text-danger">N/A</a> --}}
                            {{-- <x-add_target_modal :measure="$measure->strategic_measure_ID" :province="$province->province_ID" /> --}}
                        @endif
                    </td>

                    {{--  --}}
                @endforeach
            </tr>
        @endforeach
        </tr>
        @endforeach
    </tbody>
</table>


