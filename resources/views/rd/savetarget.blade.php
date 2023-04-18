@extends('layouts.app')
@section('title')
    {{ 'Regional Director Save Target' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
          </div>
          <div class="container-fluid px-4 py-5">

            <ol class="breadcrumb mb-4">

                <li class="breadcrumb-item active">
                    <h1 class="province-name bg-primary text-white text-uppercase mb-5 rounded">Saved Targets</h1>
                </li>

            </ol>
            <div class="opcr-list-container">
                @foreach ($opcr as $item)
                    <div class="opcr-item">
                        <ul>
                            <li style="list-style: none !important;">
                                <a href="{{ url('rd/opcr/' . $item->opcr_ID) }}">
                                    <h4>OPCR #: {{ $item->opcr_ID }}</h4>
                                </a>

                            </li>
                            <li style="list-style: none !important;">
                                <h4>Description: {{ $item->description }}</h4>
                            </li>
                            <li style="list-style: none !important;">
                                <h4>Year: {{ $item->year }}</h4>
                            </li>
                            <li style="list-style: none !important;">
                                @if ($item->status == 'COMPLETE')
                                    <h5 style="color: #fff; background: green; padding: 10px; border-radius: 20px; width: 180px;">
                                        Status: {{ $item->status }}</h5>
                                @elseif ($item->status == 'INCOMPLETE')
                                    <h5 style="color: #fff; background: red; padding: 10px; border-radius: 20px; width: 195px;">Status: {{ $item->status }}</h5>
                                @elseif ($item->status == 'DONE')
                                    <h5 style="color: #fff; background: green; padding: 10px; border-radius: 20px; width: 195px;">Status: {{ $item->status }}</h5>
                                @else
                                    <h4>Status: </h4>
                                @endif


                                @if ($item->is_active == true && $item->status != 'DONE')
                                <h5 style="color: #fff; background: green; padding: 10px; border-radius: 20px; width: 180px;">
                                    Status: ACTIVE
                                @elseif ($item->is_active == false && $item->status != 'DONE')
                                    <h5 style="color: #fff; background: red; padding: 10px; border-radius: 20px; width: 195px;">Status: INACTIVE</h5>
                                @else
                                    
                                @endif

                            </li>


                        </ul>


                    </div>
                @endforeach



            </div>


        </div>

    </x-user-sidebar>
@endsection