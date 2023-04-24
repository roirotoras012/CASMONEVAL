@extends('layouts.app')
@section('title')
    {{ 'Provincial Planning Officer View OPCR' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div>
        <div class="container-fluid px-4 py-5">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p class="m-0">{{ $message }}</p>
                </div>
            @endif

            <ol class="breadcrumb mb-4">

                <li class="breadcrumb-item active">
                    <h1></h1>
                </li>

            </ol>



            @if ($annual_targets)
                <div class="container">

                    <h1 class="province-name bg-primary text-white text-uppercase mb-5 rounded">Provincial view of OPCR</h1>
                    <x-opcr_table :opcrs_active=$opcrs_active :provinces=$provinces :objectivesact=$objectivesact
                        :measures=$measures :annual_targets=$annual_targets :user=$user :monthly_targets=$monthly_targets
                        :commonMeasures=$commonMeasures :monthly_targets2=$monthly_targets2 :pgs=$pgs/>

                    {{-- <div class="row">
                        <div class="col-6 mx-auto">
                            <x-add_driver_form :opcrs=$opcrs :divisions=$divisions />
                        </div>
                        <div class="col-12 d-flex">
                            <x-group_driver_form :measures=$measures :drivers=$driversact />
                        </div>
                    </div> --}}

                    {{-- <x-opcr_table_driver :provinces=$provinces :driversact=$driversact :measures=$measures :annual_targets=$annual_targets/> --}}
                    <form method="POST" action="{{ route('submit_to_division') }}" class="">
                        {{ csrf_field() }}
                        <input type="hidden" name="opcr_id" value={{$opcrs_active[0]->opcr_ID}}>
                        {{-- @if (!empty($opcrs_active) && count($opcrs_active) > 0)
                            <input type="hidden" name="opcr_id" value="{{ $opcrs_active[0]->opcr_ID }}">
                        @endif --}}



                        @if (count($notification) > 0)
                            <button class="btn btn-primary" disabled
                                type="submit">{{ __('Already Submitted to Division') }}</button>
                        @else
                            <button class="btn btn-primary" type="submit">{{ __('Submit to Division') }}</button>
                        @endif


                        {{--             
                    <button type="button" class="btn btn-primary my-2" id="print-button">Print Table</button> --}}


                    </form>
                </div>
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
                                    <td>{{ $pgs['rating'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            @else
                <h1 style="color:red">NO OPCR SUBMITTED AT THE MOMENT</h1>
            @endif

        </div>

    </x-user-sidebar>
@endsection
