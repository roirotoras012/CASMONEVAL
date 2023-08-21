@extends('layouts.app')
@section('title')
    {{ 'Division Chief Accomplishment' }}
@endsection
@section('content')
    <x-user-sidebar>
        {{-- <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div> --}}

        <div class="container-fluid px-4 py-5">
            {{-- @if (count($notification) > 0) --}}
            @if (!is_null($notification) && count($notification) > 0)
                {{-- <div class="text-uppercase lead bg-primary text-white p-2 rounded d-inline-block mb-5">
                    {{ $userDetails->first_name }} -
                    {{ match ($userDetails->province_ID) {
                        1 => 'Bukidnon BDD Division',
                        2 => 'Lanao Del Norte',
                        3 => 'Misamis Oriental',
                        4 => 'Misamis Occidental',
                        5 => 'Camiguin',
                        default => 'other',
                    } }}

                </div>
                <div class="text-uppercase lead bg-danger text-white p-2 rounded d-inline-block mb-5">
                    {{ match ($userDetails->division_ID) {
                        1 => 'Business Development Division',
                        2 => 'Consumer Protection Division',
                        3 => 'Finance Administrative Division',
                        default => 'other',
                    } }}
                </div> --}}
                <div class="d-flex justify-content-end align-items-center gap-4">
                    <span><b>Click if OPCR is already reviewed <i class="fas fa-arrow-right"></i></b></span>
                    <form action="{{ route('reviewed_by') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="opcr_id" value={{ $opcrs_active[0]->opcr_ID }}>
                        <button type="submit" class="btn btn-success my-2">Review</button>
                    </form>
                </div>
                <div class="col-md-12">
                    @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p class="m-0">{{ $message }}</p>
                            </div>
                        @endif

                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger">
                            <p class="m-0">{{ $message }}</p>
                        </div>
                        @endif
                    <div>
                        @foreach ($provinces as $province)
                            @if ($province->province_ID == $user->province_ID)
                                @php
                                    $printProvince = substr($province->province, 0, 3);
                                    
                                @endphp
                            @endif
                        @endforeach
                        @php
                            if ($user->division_ID == 1) {
                                $printDiv = 'bdd';
                            }
                            if ($user->division_ID == 2) {
                                $printDiv = 'cpd';
                            }
                            if ($user->division_ID == 3) {
                                $printDiv = 'fad';
                            }
                        @endphp
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center gap-4">
                                <button class="btn btn-primary my-2"
                                    data-file-name="{{ $printProvince }}-{{ $printDiv }}Targets-OPCR{{ $opcrs_active[0]->opcr_ID }}_{{ $opcrs_active[0]->year }}"
                                    id="print-button">Print Table</button>
                                <a href="/dc/accomplishment"><i class="fas fa-sync-alt" style="font-size: 25px;"></i></a>
                            </div>

                            <div class="legend-container">

                                <div class="legend-item">
                                    <div class="box bg-danger text-white"></div>
                                    <div class="text-danger">Monthly Cutoff</div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered shadow" id="table">
                        <thead>
                            <tr>
                                <th colspan="2" rowspan="2" class="text-center align-middle bg-primary text-white">
                                    Operational Driver</th>
                                <th rowspan="2" class="text-center align-middle bg-primary text-white">#</th>
                                <th rowspan="2" class="text-center align-middle bg-primary text-white">KPI</th>
                                <th rowspan="2" class="text-center align-middle bg-primary text-white">Div</th>
                                <th colspan="1" class="text-center align-middle bg-primary text-white bg-warning">{{ $opcrs_active[0]->year }}</th>
                                <th colspan="12" class="text-center align-middle bg-primary text-white">Month
                                    Accomplishment
                                </th>
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
                            @php
                                $driver_letter = 65;
                                $a = 0;
                                
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

                            {{-- {{dd($driversact)}} --}}
                            @foreach ($driversact as $key => $driver)
                                @php
                                    $divisionName = match ($userDetails->division_ID) {
                                        1 => 'Business Development Division',
                                        2 => 'Consumer Protection Division',
                                        3 => 'Finance Administrative Division',
                                        default => 'other',
                                    };
                                    
                                    $measures = $driver->targets->where('division.division', $divisionName)->where('opcr_id', $opcrs_active[0]->opcr_ID);
                                    
                                 
                                    $measure_count = $measures->count();
                                    $has_province = false;
                                    $annual_count = 0;
                                    foreach ($measures as $measure_key) {
                                        # code...
                                        if ($measure_key->province_ID == $user->province_ID) {
                                            $has_province = true;
                                            $annual_count++;
                                        }
                                    }
                                @endphp

                                @if ($measure_count > 0 && $has_province)
                                    <tr>
                                        <td rowspan="{{ $annual_count + 1 }}" class="text-center align-middle">
                                            {{ chr($driver_letter) }}</td>
                                        @php
                                            $driver_letter++;
                                            $i++;
                                        @endphp
                                        <td rowspan="{{ $annual_count + 1 }}" class="text-center align-middle">
                                            {{ $driver->driver }}</td>
                                    </tr>
                                    {{-- {{dd($measures)}} --}}
                                    @foreach ($measures as $measure)
                                        @if ($measure->province_ID == $user->province_ID)
                                            @php
                                                
                                                $a++;
                                            @endphp
                                            <tr>
                                                {{-- {{dd($measures)}} --}}
                                                <td class="text-center align-middle">
                                                    {{ $a }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $measures_list[$measure->strategic_measures_ID]->first()->strategic_measure }}
                                                </td>
                                                <td class="text-center align-middle">{{ $measure->division->division }}
                                                </td>

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
                                                                    @if ($annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->type == 'PERCENTAGE')
                                                                        %
                                                                    @endif
                                                                </p>
                                                            @else
                                                                <p>N/A</p>
                                                            @endif
                                                        </td>
                                                        {{-- loop for the months of the year monthly target area --}}
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <?php $month = Carbon\Carbon::createFromDate(null, $i, 1); ?>

                                                            @if (isset(
                                                                    $monthly_targets[strtolower($month->format('M'))][
                                                                        $annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID
                                                                    ]))
                                                                @if (isset(
                                                                        $monthly_targets[strtolower($month->format('M'))][
                                                                            $annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID
                                                                        ]->first()->monthly_accomplishment))
                                                                    {{-- {{ dd($monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->validated == 'Invalid') }} --}}
                                                                    {{-- <td class="text-center align-middle">

                                                                {{ $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_accomplishment }}
                                                           
                                                            </td> --}}



                                                                    {{-- @else --}}
                                                                    @php
                                                                        $monthly_accomplishment = $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_accomplishment;
                                                                        $monthly_target = $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_target;
                                                                    //    dd($measures_list);
                                                                        if ($monthly_target != 0 && $measures_list[$measure->strategic_measures_ID]->first()->is_sub != 1) {
                                                                            $ratio = ($monthly_accomplishment / $monthly_target) * 100;
                                                                        
                                                                            if ($ratio >= 90) {
                                                                                $valid90[$i - 1]++;
                                                                                # code...
                                                                            }
                                                                        } else {
                                                                            // handle the case where monthly_target is zero
                                                                        }
                                                                        
                                                                    @endphp
                                                                    {{-- {{dd($monthly_targets[strtolower($month->format('M'))][
                                                                        $annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID
                                                                    ]->first())}} --}}
                                                                    @if (!$cutoff[$i - 1])
                                                                    
                                                                        <td class="text-center align-middle">
                                                                            {{-- {{$remarks}} --}}
                                                                            @if (
                                                                                ($monthly_targets[strtolower($month->format('M'))][
                                                                                    $annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID
                                                                                ]->first()->validated == 'Invalid' || $monthly_targets[strtolower($month->format('M'))][
                                                                                    $annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID
                                                                                ]->first()->remark == 'Revise') && !isset($measures_list[$measure->strategic_measures_ID]->first()->sum_of))
                                                                                <a href="#" data-bs-toggle="modal"
                                                                                    data-bs-target="#<?= strtolower($month->format('M')) . '_' . $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_target_ID ?>"
                                                                                    id="#<?= strtolower($month->format('M')) . '_' . $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_target_ID ?>"
                                                                                    class="text-danger">
                                                                                    {{ $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_accomplishment }}
                                                                                </a>
                                                                                <span>out of
                                                                                    <b>{{ $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_target }}
                                                                                        @if ($monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->type == 'PERCENTAGE')
                                                                                            %
                                                                                        @endif
                                                                                    </b></span>

                                                                                <x-update_monthly_accom_modal
                                                                                    :month="strtolower(
                                                                                        $month->format('M'),
                                                                                    )" :division_ID="$userDetails->division_ID"
                                                                                    :year="202" :monthly_target="$monthly_targets[
                                                                                        strtolower($month->format('M'))
                                                                                    ][
                                                                                        $annual_targets[
                                                                                            $measure
                                                                                                ->strategic_measures_ID
                                                                                        ][
                                                                                            $province->province_ID
                                                                                        ]->first()->annual_target_ID
                                                                                    ]->first()->monthly_target_ID"
                                                                                    :strategic_measure="$measures_list[
                                                                                        $measure->strategic_measures_ID
                                                                                    ]->first()->strategic_measure" />
                                                                            @else
                                                                            <span style="<?php if ($monthly_accomplishment < ($monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_target * 0.9)) { ?> color: red; <?php } ?>">
                                                                                {{ $monthly_accomplishment = $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_accomplishment }}
                                                                                <span>out of <b>{{ $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_target }}
                                                                                    @if ($monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->type == 'PERCENTAGE')
                                                                                    %
                                                                                @endif</b></span>
                                                                            </span>
                                                                            
                                                                            </span>
                                                                            
                                                                            </span>
                                                                            
                                                                            
                                                                            @endif
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center align-middle bg-danger text-white">
                                                                            {{ $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_accomplishment }}
                                                                            <span>out of
                                                                                <b>{{ $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_target }}
                                                                                    @if ($monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->type == 'PERCENTAGE')
                                                                                    %
                                                                                @endif</b></span>
                                                                        </td>
                                                                    @endif
                                                                @else
                                                                    @if (!$cutoff[$i - 1])
                                                                        <td class="text-center align-middle">

                                                                            @if (!isset($measures_list[$measure->strategic_measures_ID]->first()->sum_of))
                                                                            <a href="#" data-bs-toggle="modal"
                                                                            data-bs-target="#<?= strtolower($month->format('M')) . '_' . $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_target_ID ?>"
                                                                            id="#<?= strtolower($month->format('M')) . '_' . $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_target_ID ?>"
                                                                            class="text-danger">
                                                                            N/A
                                                                            </a>
                                                                            
                                                                            @else
                                                                            N/A
                                                                            @endif
                                                                            
                                                                            <span>out of
                                                                                <b>{{ $monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->monthly_target }}
                                                                                    @if ($monthly_targets[strtolower($month->format('M'))][$annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target_ID]->first()->type == 'PERCENTAGE')
                                                                                    %
                                                                                @endif</b></span>
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center align-middle bg-danger text-white">N/A</td>
                                                                    @endif

                                                                    <x-update_monthly_accom_modal :month="strtolower($month->format('M'))"
                                                                        :division_ID="$userDetails->division_ID" :year="202"
                                                                        :monthly_target="$monthly_targets[
                                                                            strtolower($month->format('M'))
                                                                        ][
                                                                            $annual_targets[
                                                                                $measure->strategic_measures_ID
                                                                            ][$province->province_ID]->first()
                                                                                ->annual_target_ID
                                                                        ]->first()->monthly_target_ID" :strategic_measure="$measures_list[
                                                                            $measure->strategic_measures_ID
                                                                        ]->first()->strategic_measure" />
                                                                @endif
                                                            @else
                                                            @if (!$cutoff[$i - 1])
                                                                <td class="text-center align-middle ">No Monthly Target Set
                                                                </td>
                                                            @else
                                                                <td class="text-center align-middle bg-danger text-white">N/A</td>
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
                            <tr>

                                <td colspan="999">
                                    <table style="width: 100%;" class="ratings_table table table-bordered ppo-table-opcr">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th class="text-center align-middle" colspan="999">Monthly Ratings</th>
                                            </tr>
                                            <tr>
                                                <th colspan="1" class="text-center align-middle" style="min-width: 150px"></th>
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
                                                    <td class="text-left align-middle">
                                                        {{ $valid_meas2[$i] }}</td>
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
                                                <th>OPCR rating	</th>
                                                @for ($i = 0; $i < 12; $i++)
                                                    @php
                                                        $pgsratingtext = '';
                                                        $pgsrating_month = null;
                                                        $pgsrating_month = \App\Models\Pgs::where('total_num_of_targeted_measure', $valid_meas2[$i])

                                                            ->get()
                                                            ->groupBy('actual_num_of_accomplished_measure');
                                                        if (count($pgsrating_month) !== 0 && $valid90[$i] !== 0) {
                                                            if ($pgsrating_month[$valid90[$i]]->first()->numeric == 5.0) {
                                                                $pgsratingtext = 'Outstanding';
                                                            } elseif ($pgsrating_month[$valid90[$i]]->first()->numeric >= 4.5) {
                                                                $pgsratingtext = 'Very Satisfactory';
                                                            } elseif ($pgsrating_month[$valid90[$i]]->first()->numeric >= 3.25) {
                                                                $pgsratingtext = 'Satisfactory';
                                                            } elseif ($pgsrating_month[$valid90[$i]]->first()->numeric >= 2.5) {
                                                                $pgsratingtext = 'Below Satisfactory';
                                                            } elseif ($pgsrating_month[$valid90[$i]]->first()->numeric < 2.5) {
                                                                $pgsratingtext = 'Poor';
                                                            }
                                                        }
                                                    @endphp
                                                    <td class="text-left align-middle">
                                                        {{ count($pgsrating2) !== 0 && $valid90[$i] !== 0 ? $pgsrating2[$valid90[$i]]->first()->numeric : null }}
                                                    </td>
                                                    <td class="text-left align-middle">{{ $pgsratingtext }}</td>
                                                @endfor





                                            </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @if (isset($pgs))
                        <div class="p-5">
                            <table class="table" style="width:50%" id="rating_table">
                                <thead>
                                    <th>Description</th>
                                    <th>Number</th>
                                    <th>Rating</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>No. of valid measure</th>
                                        <td>{{ $pgs['total_number_of_valid_measures'] }}</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <th>No. of valid measure atleast 90%</th>
                                        <td>{{ $pgs['total_number_of_accomplished_measure'] }}</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <th>OPCR rating</th>
                                        <td>{{ $pgs['numerical_rating'] }}</td>
                                        <td class="text-center align-middle"
                                        style="background-color: {{ $pgs['rating_bg_color'] }}">{{ $pgs['rating'] }}
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            @else
                <h1 style="color:red">NO OPCR SUBMITTED AT THE MOMENT</h1>
            @endif


        </div>



    </x-user-sidebar>
@endsection
