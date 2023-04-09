@extends('layouts.app')
@section('title')
    {{ 'Provincial Planning Officer BDD' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div>
        <div class="container-fluid px-4 py-5">

            <ol class="breadcrumb mb-4">

                {{-- <li class="breadcrumb-item active"><h1>Manage Drivers</h1></li> --}}

            </ol>
            @if ($annual_targets)
                <div class="container">



                    <h1 class="province-name bg-danger text-white text-uppercase mb-5 rounded">BDD division level view</h1>
                    <div class="d-flex justify-content-between">
                        @foreach ($provinces as $province)
                        @if ($province->province_ID == $user->province_ID)
                        @php
                            $printProvince = substr($province->province, 0, 3)
                        @endphp
                        
                        @endif
                        @endforeach
                        <button class="btn btn-primary my-2" data-file-name="{{$printProvince}}-bdd-OPCR{{$opcrs_active[0]->opcr_ID}}_{{$opcrs_active[0]->year}}" id="print-button">Print Table</button>
                        <div class="legend-container">
                            <div class="legend-item">
                                <div class="box bg-warning"></div>
                                <div class="text-warning">Not Validated</div>
                            </div>

                            <div class="legend-item">
                                <div class="box bg-success"></div>
                                <div class="text-success">Validated</div>
                            </div>

                            <div class="legend-item">
                                <div class="box bg-danger"></div>
                                <div class="text-danger">Invalid</div>
                            </div>

                        </div>
                    </div>
                    <table class="table table-bordered ppo-table shadow" id="table">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th rowspan="2" class="text-center align-middle">Objectives</th>
                                <th rowspan="2" class="text-center align-middle">Measure</th>
                                <th colspan="1" class="text-center align-middle">Annual Target</th>
                                <th colspan="12" class="text-center align-middle bg-success">Accomplished</th>
                                <th rowspan="2" class="text-center align-middle bg-success">Total</th>
                            </tr>
                            <tr>
                                @foreach ($provinces as $province)
                                    @if ($province->province_ID == $user->province_ID)
                                        <th class="text-center align-middle">{{ $province->province }}</th>

                                        <th class="text-center align-middle">Jan</th>
                                        <th class="text-center align-middle">Feb</th>
                                        <th class="text-center align-middle">Mar</th>
                                        <th class="text-center align-middle">Apr</th>
                                        <th class="text-center align-middle">May</th>
                                        <th class="text-center align-middle">Jun</th>
                                        <th class="text-center align-middle">Jul</th>
                                        <th class="text-center align-middle">Aug</th>
                                        <th class="text-center align-middle">Sep</th>
                                        <th class="text-center align-middle">Oct</th>
                                        <th class="text-center align-middle">Nov</th>
                                        <th class="text-center align-middle">Dec</th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($objectives as $driver)
                                {{-- {{dd($driver->measures)}}     --}}


                                <tr>
                                    <td rowspan="{{ $driver->measures()->where('strategic_measures.strategic_objective_ID', $driver->strategic_objective_ID)->where(function ($query) {
                                            $query->where('division_ID', 1);
                                            
                                                
                                        })
                                        ->where(function ($query) {
                                            $query->where('type', 'DIRECT')
                                                  ->orWhere('type', 'DIRECT COMMON')
                                                  ->orWhere('type', 'DIRECT MAIN');
                                        })
                                        ->count() + 1 }}"
                                        class="text-center align-middle">
                                        {{ $driver->strategic_objective }}

                                    </td>

                                    @php
                                        $measures = $driver
                                            ->measures()
                                        
                                            ->where('strategic_measures.strategic_objective_ID', $driver->strategic_objective_ID)
                                        
                                            ->where(function ($query) {
                                                $query->where('division_ID', 1);
                                            
                                                
                                            })
                                            ->where(function ($query) {
                                                $query->where('type', 'DIRECT')
                                                    ->orWhere('type', 'DIRECT COMMON')
                                                    ->orWhere('type', 'DIRECT MAIN');
                                                    
                                            })
                                            ->get();
                                    @endphp
                                    @foreach ($measures as $measure)
                                <tr>

                                    <td class="text-center align-middle">{{ $measure->strategic_measure }}</td>


                                    <td class="text-center align-middle">
                                        @if (isset($annual_targets[$measure->strategic_measure_ID][$user->province_ID]))
                                            {{ $annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target }}
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    @php
                                        if (isset($monthly_targets[$annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID])) {
                                            $accoms = $monthly_targets[$annual_targets[$measure->strategic_measure_ID][$user->province_ID]->first()->annual_target_ID];
                                        } else {
                                            $accoms = null;
                                        }
                                    @endphp

                                    {{-- loop for the months of the year monthly target area --}}
                                    @for ($i = 1; $i <= 12; $i++)
                                        <?php $month = Carbon\Carbon::createFromDate(null, $i, 1); ?>
                                        <td class="text-center align-middle">
                                            @if (isset($accoms))
                                                <?php $monthly_accomplishment = null;
                                                $validated = null; ?>
                                                @foreach ($accoms as $accom)
                                                    @if ($accom->month == strtolower($month->format('M')))
                                                        <?php $monthly_accomplishment = $accom->monthly_accomplishment;
                                                        $validated = $accom->validated; ?>
                                                        <a href="" data-bs-toggle="modal"
                                                            data-bs-target="#_{{ $accom->monthly_target_ID }}"
                                                            class="text-{{ $validated == 'Validated' ? 'success' : ($validated == 'Invalid' ? 'danger' : 'warning') }}">
                                                            {{ $monthly_accomplishment }}
                                                        </a>
                                                        <x-validate-modal :monthly_target_ID="$accom->monthly_target_ID" />
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                    @endfor

                                    {{-- end of loop for the months of the year monthly target area --}}
                                    <td class="text-center align-middle">
                                        @if (isset($accoms->annual_accom))
                                            {{ $accoms->annual_accom }}
                                        @else
                                        @endif
                                    </td>



                                </tr>
                            @endforeach
                            </tr>
            @endforeach
            </tbody>
            </table>


        </div>
    @else
        <h1 style="color:red">NO OPCR SUBMITTED AT THE MOMENT</h1>
        @endif

        </div>

    </x-user-sidebar>
@endsection
