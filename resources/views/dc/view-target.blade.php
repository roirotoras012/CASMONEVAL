@extends('layouts.app')
@section('title')
    {{ 'Division Chief View Target' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div>

        
        <div class="container-fluid px-4 py-5">
            @if (count($notification) > 0)
            <div class="text-uppercase lead bg-primary text-white p-2 rounded d-inline-block mb-5"> {{ $userDetails->first_name }} -  {{ match ($userDetails->province_ID) {
                1 => 'Bukidnon BDD Division',
                2 => 'Lanao Del Norte',
                3 => 'Misamis Oriental',
                4 => 'Misamis Occidental',
                5 => 'Camiguin',
                default => 'other',
            } }}
            </div>

            <div >
                <button class="btn btn-primary my-2"  id="print-button">Print Table</button>
                <table class="table table-bordered shadow" id="table">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center align-middle bg-primary text-white">Drivers</th>
                            <th rowspan="2" class="text-center align-middle bg-primary text-white">Measure</th>
                            <th rowspan="2" class="text-center align-middle bg-primary text-white">Div</th>
                            <th colspan="1" class="text-center align-middle bg-primary text-white bg-warning">Annual Target</th>
                            <th colspan="12" class="text-center align-middle bg-primary text-white">Monthly Target</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle bg-danger text-white">
                                {{ match ($userDetails->province_ID) {
                                    1 => 'Bukidnon ',
                                    2 => 'Lanao Del Norte',
                                    3 => 'Misamis Oriental',
                                    4 => 'Misamis Occidental',
                                    5 => 'Camiguin',
                                    default => 'other',
                                } }}
                            </th>
                            {{-- loop for the months of the year header part --}}
                            @for ($i = 1; $i <= 12; $i++)
                                <?php $month = Carbon\Carbon::createFromDate(null, $i, 1); ?>
                                <th class="text-center align-middle">{{ $month->format('M') }}</th>
                            @endfor
                            {{-- end of loop for the months of the year header part --}}
                        </tr>
                    </thead>
                    <tbody>

                        {{-- {{dd($driversact)}} --}}
                        @foreach ($driversact as $driver)
                            @php
                                $divisionName = match ($userDetails->division_ID) {
                                    1 => 'Business Development Division',
                                    2 => 'Consumer Protection Division',
                                    3 => 'Finance Administrative Division',
                                    default => 'other',
                                };
                                
                                $measures = $driver->targets->where('division.division', $divisionName);
                                $measure_count = $measures->count();
                                $has_province = false;
                                $annual_count = 0;
                                foreach ( $measures as  $measure_key) {
                                    # code...
                                    if($measure_key->province_ID == $user->province_ID) {
                                        $has_province = true;
                                        $annual_count++;
                                    }
                                }
                                // dd($measures);
                            @endphp

                            @if ($measure_count > 0 && $has_province)
                                <tr>
                                    <td rowspan="{{  $annual_count + 1 }}" class="text-center align-middle">
                                        {{ $driver->driver }}</td>
                                </tr>
                                {{-- {{dd($measures)}} --}}
                                @foreach ($measures as $measure)
                                @if ($measure->province_ID == $user->province_ID)
                                <tr>
                                    <td class="text-center align-middle">{{ $measures_list[$measure->strategic_measures_ID]->first()->strategic_measure }}</td>
                                    <td class="text-center align-middle">{{ $measure->division->division }}</td>

                                    @foreach ($provinces as $province)
                                        @php
                                            $provinceName = match ($userDetails->province_ID) {
                                                1 => 'Bukidnon',
                                                2 => 'Lanao Del Norte',
                                                3 => 'Misamis Oriental',
                                                4 => 'Misamis Occidental',
                                                5 => 'Camiguin',
                                                default => 'Other',
                                            };
                                        @endphp

                                        @if ($province->province == $provinceName)
                                           
                                            <td class="text-center align-middle">
                                                @if (isset($annual_targets[$measure->strategic_measures_ID][$province->province_ID]))
                                                
                                                    <p>{{ $annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target }}
                                                    </p>
                                                @else
                                                    <p>N/A</p>
                                                @endif
                                            </td>
                                            {{-- {{dd($measure->strategic_measures_ID)}} --}}
                                            {{-- loop for the months of the year monthly target area --}}
                                            @for ($i = 1; $i <= 12; $i++)
                                                <?php $month = Carbon\Carbon::createFromDate(null, $i, 1); ?>
                                                {{-- {{dd( $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measure_ID][$province->province_ID]->first()->annual_target_ID ]->first()->monthly_target     )}} --}}
                                                @if (isset($annual_targets[$measure->strategic_measures_ID]))
                                                   
                                                @if (isset(
                                                    $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID ]))
                                               <td class="text-center align-middle">
                                                {{$monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID ]->first()->monthly_target  }}
                                                </td>
                                                @else
                                                    {{-- {{dd(strtolower($month->format('M')))}} --}}
                                                    <td class="text-center align-middle">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#<?= strtolower($month->format('M')) . '_' . $annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID ?>"
                                                            id="#<?= strtolower($month->format('M')) . '_' . $annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID ?>"
                                                            class="text-danger">N/A

                                                        </a>

                                                    </td>
                                                
                                                    <x-update_monthly_target_modal :month="strtolower($month->format('M'))" :division_ID="$userDetails->division_ID"
                                                        :year="202" :annual_target="$annual_targets[$measure->strategic_measures_ID][
                                                            $province->province_ID
                                                        ]->first()->annual_target_ID" />
                                            @endif

                                                @endif
                                               
                                            @endfor
                                            
                                            {{-- end of loop for the months of the year monthly target area --}}
                                        @endif
                                    @endforeach
                                </tr>
                                @endif
                                    
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>


            </div>


            @else
            <h1 style="color:red" >NO OPCR SUBMITTED AT THE MOMENT</h1>
            @endif

        </div>
       
        

    </x-user-sidebar>
@endsection
