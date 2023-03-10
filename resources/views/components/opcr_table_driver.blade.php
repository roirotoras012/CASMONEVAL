@props(['driversact', 'measures', 'provinces', 'annual_targets', 'monthly_targets', 'opcrs_active'])
<h1>BDD division level view</h1>
<table <?php if ($opcrs_active[0]->is_submitted_division == true){ ?> style="background: #00800026;" <?php   } ?> class="table table-bordered border-primary">
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
        {{-- {{dd($driver->measures)}}     --}}
        @if ($driver->code == "BDD")
        
        <tr>
            <td rowspan="{{ $driver->measures->count() + 1 }}" class="text-center align-middle">
                {{ $driver->driver }}</td>
            @foreach ($driver->measures as $measure)
        <tr>
          
            <td class="text-center align-middle">{{ $measure->strategic_measure }}</td>
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
        @endif
           
        @endforeach
    </tbody>
</table>


{{-- BDD VIEW END --}}



<h1>CPD division level view</h1>
<table <?php if ($opcrs_active[0]->is_submitted_division == true){ ?> style="background: #00800026;" <?php   } ?> class="table table-bordered border-primary">
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
        {{-- {{dd($driver->measures)}}     --}}
        @if ($driver->code == "CPD")
        
        <tr>
            <td rowspan="{{ $driver->measures->count() + 1 }}" class="text-center align-middle">
                {{ $driver->driver }}</td>
            @foreach ($driver->measures as $measure)
        <tr>
          
            <td class="text-center align-middle">{{ $measure->strategic_measure }}</td>
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
        @endif
           
        @endforeach
    </tbody>
</table>



{{-- CPD VIEW END --}}



<h1>FAD division level view</h1>
<table <?php if ($opcrs_active[0]->is_submitted_division == true){ ?> style="background: #00800026;" <?php   } ?> class="table table-bordered border-primary">
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
        {{-- {{dd($driver->measures)}}     --}}
        @if ($driver->code == "FAD")
        
        <tr>
            <td rowspan="{{ $driver->measures->count() + 1 }}" class="text-center align-middle">
                {{ $driver->driver }}</td>
            @foreach ($driver->measures as $measure)
        <tr>
          
            <td class="text-center align-middle">{{ $measure->strategic_measure }}</td>
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
        @endif
           
        @endforeach
    </tbody>
</table>




{{-- FAD VIEW END --}}