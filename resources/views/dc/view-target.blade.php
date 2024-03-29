@extends('layouts.app')
@section('title')
    {{ 'Division Chief View Target' }}
@endsection
@section('content')
    <x-user-sidebar>
        {{-- <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div> --}}
        <div class="container-fluid px-4 py-5">
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
                </div>
                <div> --}}
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
                                        <a href="/dc/view-target"><i class="fas fa-sync-alt" style="font-size: 25px;"></i></a>
                                </div>
                           
                             
                            </div>

                            
                        </div>
                        <table class="table table-bordered shadow" id="table">
                            <thead>
                                <tr>

                                    <th colspan="2" rowspan="2"
                                        class="text-center align-middle bg-primary text-white">Operational Driver</th>
                                    <th rowspan="2" class="text-center align-middle bg-primary text-white">#</th>
                                    <th rowspan="2" class="text-center align-middle bg-primary text-white">KPI</th>
                                    <th rowspan="2" class="text-center align-middle bg-primary text-white">Div</th>
                                    <th colspan="1" class="text-center align-middle bg-primary text-white bg-warning">
                                        {{ $opcrs_active[0]->year }}</th>
                                    <th colspan="12" class="text-center align-middle bg-primary text-white">Monthly Target
                                    </th>
                                    <th rowspan="2" class="text-center align-middle bg-primary text-white">Total Target
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



                                {{-- {{dd($driversact)}} --}}
                                @php
                                    $a = 0;
                                    $driver_letter = 65;
                                @endphp

                                @foreach ($driversact as $key => $driver)
                                    @php
                                        $divisionName = match ($userDetails->division_ID) {
                                            1 => 'Business Development Division',
                                            2 => 'Consumer Protection Division',
                                            3 => 'Finance Administrative Division',
                                            default => 'other',
                                        };
                                        $division_id = $userDetails->division_ID;
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
                                        // dd($measures);
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
                                                {{ $driver->driver }} <form action="{{ route('dc.undo_driver') }}" method="post" id="{{$driver->driver_ID}}">
                                                    @csrf
                                                    <input type="hidden" value="{{$driver->driver_ID}}" name="driver_id"> 
                                                    <input type="hidden" value="{{$opcrs_active[0]->opcr_ID}}" name="opcr_id"> 
                                                    <input type="hidden" value="{{$division_id}}" name="division_id"> 
                                                    
                                                    <button type="submit" class="btn" onclick="confirmDeletion(event)"><i class="fa-solid fa-rotate-left"></i></button>
                                                </form>
                                            
                                            </td>
                                        </tr>


                                        {{-- {{dd($measures)}} --}}
                                        @foreach ($measures as $measure)
                                            @if ($measure->province_ID == $user->province_ID)
                                                @php
                                                    
                                                    $a++;
                                                @endphp
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        {{ $a }}
                                                        {{-- {{ $measures_list[$measure->strategic_measures_ID]->first()->number_measure }} --}}
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
                                                                    <p style="margin-bottom: 0">{{ $annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->annual_target }}
                                                                        @if ($annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first()->type == 'PERCENTAGE')
                                                                            %
                                                                        @endif
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
                                                                    @if (isset($annual_targets[$measure->strategic_measures_ID][$province->province_ID]))
                                                                        <?php
                                                                        $annualTarget = $annual_targets[$measure->strategic_measures_ID][$province->province_ID]->first();
                                                                        $totalTarget = 0;
                                                                        $monthly_target_count = 0;
                                                                        ?>
                                                                        @for ($i = 1; $i <= 12; $i++)
                                                                            <?php $month = Carbon\Carbon::createFromDate(null, $i, 1); ?>

                                                                            @if (isset($monthly_targets[strtolower($month->format('M'))][$annualTarget->annual_target_ID]))
                                                                                {{-- @if (isset($monthly_targets_array[strtolower($month->format('M'))][$annualTarget->annual_target_ID]))    --}}
                                                                                <?php $monthlyTarget = $monthly_targets[strtolower($month->format('M'))][$annualTarget->annual_target_ID]->first(); ?>
                                                                                <td class="text-center align-middle">
                                                                                    @if (isset($measure->sum_of))
                                                                                    
                                                                                    {{ $monthlyTarget->monthly_target }}
                                                                                   
                                                                                    @else
                                                                                   


                                                                                   
                                                                                        <a href="#"
                                                                                           
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#<?= strtolower($month->format('M')) . '_' . $annualTarget->annual_target_ID ?>"
                                                                                            id="#<?= strtolower($month->format('M')) . '_' . $annualTarget->annual_target_ID ?>">
                                                                                            {{ $monthlyTarget->monthly_target }}
                                                                                            @if ($monthlyTarget->type == 'PERCENTAGE')
                                                                                                %
                                                                                            @endif
                                                                                        </a>
                                                                                        <x-edit_monthly_target_modal
                                                                                            :month="strtolower(
                                                                                                $month->format('M'),
                                                                                            )"
                                                                                            :division_ID="$userDetails->division_ID"
                                                                                            :year="202"
                                                                                            :annual_target="$annualTarget->annual_target_ID"
                                                                                            :monthly_target_ID="$monthlyTarget->monthly_target_ID"
                                                                                            :monthly_target="$monthlyTarget->monthly_target" />
                                                                                   
                                                                                    @endif
                                                                                </td>
                                                                             
                                                                                <?php $totalTarget += $monthlyTarget->monthly_target;
                                                                                        $monthly_target_count ++;
                                                                                            ?>
                                                                            @else
                                                                               
                                                                            <td class="text-center align-middle">
                                                                            @if (isset($measure->sum_of))
                                                                            N/A
                                                                            @else
                                                                            
                                                                                <a href="#"

                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#<?= strtolower($month->format('M')) . '_' . $annualTarget->annual_target_ID ?>"
                                                                                    id="#<?= strtolower($month->format('M')) . '_' . $annualTarget->annual_target_ID ?>"
                                                                                    class="text-danger">N/A</a>
                                                                                <x-update_monthly_target_modal
                                                                                    :month="strtolower(
                                                                                        $month->format('M'),
                                                                                    )"
                                                                                    :division_ID="$userDetails->division_ID"
                                                                                    :year="202"
                                                                                    :annual_target="$annualTarget->annual_target_ID"
                                                                                    :target_type="$annualTarget->type" />
                                                                           
                                                                            @endif
                                                                        </td>
                                                                                 
                                                                              
                                                                            @endif
                                                                        @endfor
                                                                        <td class="text-center align-middle">
                                                                            @if ($monthly_target_count > 0)
                                                                                @if ($annualTarget->type == 'PERCENTAGE')
                                                                                    {{ $totalTarget / $monthly_target_count }}%
                                                                                @else
                                                                                    {{ $totalTarget }}
                                                                                @endif
                                                                            @else
                                                                                N/A
                                                                            @endif
                                                                        </td>
                                                                        
                                                                    @endif
                                                                @endif
                                                            @endfor

                                                            {{-- end of loop for the months of the year monthly target area --}}
                                                        @endif
                                                    @endforeach
                                                    <!-- New column for total target -->






                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                @else
                    <h1 style="color:red">NO OPCR SUBMITTED AT THE MOMENT</h1>
            @endif

        </div>



    </x-user-sidebar>
    <script>

function confirmDeletion(event) {
                event.preventDefault();
                var result = confirm("Are you sure you want to undo driver group?");
                if (result) {
                    var form = event.target.closest('form');
                    form.submit();
                }
            }
    </script>
@endsection
