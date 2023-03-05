@props(['driversact', 'measures', 'provinces', 'annual_targets', 'monthly_targets'])
<h1>This part is for the division Level View</h1>
<table class="table table-bordered border-primary">
    <thead>
        <tr>
            <th rowspan="2" class="text-center align-middle">Drivers</th>
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
        @foreach ($driversact as $driver)
            <tr>
                <td rowspan="{{ $driver->measures->count() + 1 }}" class="text-center align-middle">
                    {{ $driver->driver }}</td>
                @foreach ($driver->measures as $measure)
            <tr>
                <td class="text-center align-middle">{{ $measure->measure }}</td>
                @foreach ($provinces as $province)
                    <td class="text-center align-middle">
                        @if (isset($annual_targets[$measure->strategic_measure_ID][$province->province_ID]))
                            <p>
                                {{ $annual_targets[$measure->strategic_measure_ID][$province->province_ID]->first()->annual_target }}
                            </p>
                        @else
                            <p>N/A</p>
                        @endif
                    </td>

                @endforeach
            </tr>
        @endforeach
        </tr>
        @endforeach
    </tbody>
</table>


