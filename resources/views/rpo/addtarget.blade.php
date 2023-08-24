<head>
    <link rel="stylesheet" href="{{ URL::asset('css/rd.css') }}" />
</head>
@extends('layouts.app')
@section('title')
    {{ 'RPO Add Target' }}
@endsection
@section('content')
    <x-user-sidebar>
        {{-- <div class="loading-screen">
        <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
      </div> --}}
        <div class="container-fluid px-4 py-5">

            {{-- <div class="card mb-4 m-4">
                <div class="card-header">
                    <div class="table-title">
                        <div class="row d-flex align-items-center">
                           
                              
                            <div class="col-sm-6 text-left">
                                <h6 class="m-0">Generate <b>OPCR</b></h6>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div> --}}
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    <h2 class="text-uppercase lead  text-black p-2 rounded">RPO <i class="fa-solid fa-angles-right"></i> Add
                        Targets</h2>
                </li>
            </ol>
            <div class="opcr-container">


                <div class="opcr-table">




                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p class="m-0">{{ $message }}</p>
                        </div>
                    @endif


                    <form action="{{ route('add_targets') }}" method="post" id="addTargetForm">

                        <table class="table table-bordered ppo-table shadow forms position-relative mt-5">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th class="p-3">#</th>
                                    <th class="p-3">Strategic Objectives</th>
                                    <th class="p-3">#</th>
                                    <th class="p-3">Strategic Measures</th>
                                    <th class="p-3">REGION 10</th>
                                    <th class="p-3">BUK</th>
                                    <th class="p-3">CAM</th>
                                    <th class="p-3">LDN</th>
                                    <th class="p-3">MISOR</th>
                                    <th class="p-3">MISOC</th>
                                </tr>
                            </thead>

                            <tbody>



                                @csrf
                                @php
                                    $current_objective = '';
                                    $ctr = 0;
                                @endphp
                                @foreach ($labels as $label)
                                    <tr class="table-tr">

                                        @if ($label->strategic_objective != $current_objective)
                                            @php
                                                $obj_count = 0;
                                                foreach ($labels as $label2) {
                                                    if ($label2->strategic_objective_ID == $label->strategic_objective_ID) {
                                                        $obj_count++;
                                                    }
                                                }
                                            @endphp
                                            {{-- <h2>{{$qwe}}</h2> --}}

                                            <td rowspan="{{ $obj_count }}">
                                                {{ $label->objective_letter }}
                                            </td>
                                            <td rowspan="{{ $obj_count }}">
                                                {{ $label->strategic_objective }}
                                            </td>
                                        @endif
                                        <td>
                                            @if (!$label->is_sub)
                                                {{ $label->number_measure }}
                                            @endif

                                        </td>
                                        <td>{{ $label->strategic_measure }}

                                            @if (!isset($label->sum_of))
                                                <input type="hidden" name="data[{{ $ctr }}][strategic_objective]"
                                                    value="{{ $label->strategic_objective_ID }}">
                                                <input type="hidden" name="data[{{ $ctr }}][strategic_measure]"
                                                    value="{{ $label->strategic_measure_ID }}">
                                                <input type="hidden" name="data[{{ $ctr }}][strategic_measurez]"
                                                    value="{{ $label->strategic_measure }}">
                                                <input type="hidden" name="data[{{ $ctr }}][type]"
                                                    value="{{ $label->type }}">
                                                <input type="hidden" name="data[{{ $ctr }}][division_ID]"
                                                    value="{{ $label->division_ID }}">
                                            @endif
                                        </td>

                                        <td>
                                            @if (!isset($label->sum_of))
                                                <input class="form-control" type="hidden"
                                                    name="data[{{ $ctr }}][total_targets]">
                                            @endif
                                        </td>
                                        <td>
                                        
                                            @if (!isset($label->sum_of))
                                            

                                                <div class="d-flex gap-1 align-items-center">
                                                    <input class="form-control rpo-add-target-inputs" type="text"
                                                        name="data[{{ $ctr }}][BUK]" pattern="^(?!-)[0-9]+$"
                                                         oninput="validateInputAddTarget(this, 'error-message-{{ $ctr }}')"
                                                        >

                                                    <label for="target_type_{{ $ctr }}" class="d-flex"
                                                        style="margin-bottom: 0 !important">
                                                        <input class="dynamic-checkbox" data-ctr="{{ $ctr }}"
                                                            type="checkbox" id="target_type_{{ $ctr }}"
                                                            name="data[{{ $ctr }}][buk_target_type]">
                                                        %
                                                    </label>
                                                </div>
                                                     <div id="error-message-{{ $ctr }}" class="add-target-error-msg" style="color: red;"></div>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!isset($label->sum_of))
                                                <div class="d-flex gap-1 align-items-center">
                                                    <input class="form-control" type="text"
                                                        name="data[{{ $ctr }}][CAM]" pattern="^(?!-)[0-9]+$"  oninput="validateInputAddTarget(this, 'error-message-{{ $ctr }}')">
                                                    <label for="target_type_{{ $ctr }}" class="d-flex"
                                                        style="margin-bottom: 0 !important">
                                                        <input class="dynamic-checkbox" data-ctr="{{ $ctr }}"
                                                            type="checkbox" id="target_type_{{ $ctr }}"
                                                            name="data[{{ $ctr }}][cam_target_type]">
                                                        %
                                                    </label>
                                                </div>
                                                     <div id="error-message-{{ $ctr }}" class="add-target-error-msg" style="color: red;"></div>
                                            @endif



                                        </td>
                                        <td>
                                            @if (!isset($label->sum_of))
                                                <div class="d-flex gap-1 align-items-center">
                                                    <input class="form-control" type="text"
                                                        name="data[{{ $ctr }}][LDN]" pattern="^(?!-)[0-9]+$" oninput="validateInputAddTarget(this, 'error-message-{{ $ctr }}')">
                                                    <label for="target_type_{{ $ctr }}" class="d-flex"
                                                        style="margin-bottom: 0 !important">
                                                        <input class="dynamic-checkbox" data-ctr="{{ $ctr }}"
                                                            type="checkbox" id="target_type_{{ $ctr }}"
                                                            name="data[{{ $ctr }}][ldn_target_type]">
                                                        %
                                                    </label>
                                                </div>
                                                     <div id="error-message-{{ $ctr }}" class="add-target-error-msg" style="color: red;"></div>
                                            @endif



                                        </td>
                                        <td>
                                            @if (!isset($label->sum_of))
                                                <div class="d-flex gap-1 align-items-center">
                                                    <input class="form-control" type="text"
                                                        name="data[{{ $ctr }}][MISOR]" pattern="^(?!-)[0-9]+$" oninput="validateInputAddTarget(this, 'error-message-{{ $ctr }}')">
                                                    <label for="target_type_{{ $ctr }}" class="d-flex"
                                                        style="margin-bottom: 0 !important">
                                                        <input class="dynamic-checkbox" data-ctr="{{ $ctr }}"
                                                            type="checkbox" id="target_type_{{ $ctr }}"
                                                            name="data[{{ $ctr }}][misor_target_type]">
                                                        %
                                                    </label>
                                                </div>
                                                     <div id="error-message-{{ $ctr }}" class="add-target-error-msg" style="color: red;"></div>
                                            @endif



                                        </td>
                                        <td>
                                            @if (!isset($label->sum_of))
                                                <div class="d-flex gap-1 align-items-center">
                                                    <input class="form-control" type="text"
                                                        name="data[{{ $ctr }}][MISOC]" pattern="^(?!-)[0-9]+$" oninput="validateInputAddTarget(this, 'error-message-{{ $ctr }}')">
                                                    <label for="target_type_{{ $ctr }}" class="d-flex"
                                                        style="margin-bottom: 0 !important">
                                                        <input class="dynamic-checkbox" data-ctr="{{ $ctr }}"
                                                            type="checkbox" id="target_type_{{ $ctr }}"
                                                            name="data[{{ $ctr }}][misoc_target_type]">
                                                        %
                                                    </label>
                                                </div>
                                                     <div id="error-message-{{ $ctr }}" class="add-target-error-msg" style="color: red;"></div>

                                            @endif



                                        </td>

                                    </tr>

                                    @php
                                        $ctr++;
                                        $current_objective = $label->strategic_objective;
                                    @endphp
                                @endforeach





                                {{-- <input type="submit" value="ADD" class="btn btn-success"> --}}
                                <div class="pb-3 opcr-btn">
                                    <button type="submit" class="btn btn-primary" value="ADD">
                                        Add OPCR
                                    </button>
                                    {{-- <button type="button" class="btn btn-success">
                                        <a style="text-decoration: none; color:white;" href="{{ url('rpo/savedtarget') }}">View OPCRs</a> 
                                    </button> --}}
                                </div>



                                <div class="form-group">
                                    <label for="year">Year:</label>
                                    <input type="text" name="year" class="form-control" id="usr" required
                                        pattern="^(19|20)\d{2}$"
                                        oninvalid="this.setCustomValidity('Please enter a valid year')"
                                        oninput="this.setCustomValidity('')">
                                    <div class="invalid-feedback">Please enter a valid year</div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea type="password" name="description" class="form-control" id="pwd" required
                                        pattern="^[A-Za-z0-9\s]+$
"></textarea>
                                    <div class="invalid-feedback">Please add a description</div>
                                </div>
                            </tbody>

                        </table>
                    </form>

                </div>


            </div>

        </div>

    </x-user-sidebar>
    <script>
        $(document).ready(function() {
            $('.dynamic-checkbox').on('click', function() {
                console.log("wew")
                // Get the value and data-ctr attribute of the clicked checkbox
                var checkboxValue = $(this).val();
                var ctrValue = $(this).data('ctr');
                var isChecked = $(this).prop('checked');
                console.log(isChecked)
                // Set the value for all checkboxes with the same data-ctr attribute
                $('.dynamic-checkbox[data-ctr="' + ctrValue + '"]').prop('checked', isChecked);
            });

            var target_form = document.getElementById('addTargetForm');

            target_form.addEventListener('submit', (event) => {

                // Prevent the form from submitting normally
                event.preventDefault();

                // Disable the submit button
                const button = event.submitter;
                button.disabled = true;

                // Submit the form

                event.target.submit();
            });



            // your code goes here
        });
    </script>
@endsection
