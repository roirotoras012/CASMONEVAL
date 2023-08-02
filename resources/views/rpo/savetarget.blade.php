@extends('layouts.app')
@section('title')
    {{ 'RPO Save Target' }}
@endsection
@section('content')
    <x-user-sidebar>
        <div class="loading-screen">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
        </div>
        <div class="container-fluid px-4 py-5">

            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    <h2 class="text-uppercase lead  text-black p-2 rounded">RPO <i class="fa-solid fa-angles-right"></i> Saved Targets</h2>                </li>
            </ol>
            <div style="margin-bottom: 1em;">
                <button class="btn btn-secondary">
                    <a style="text-decoration: none; color:white;" href="{{ url('rpo/archive') }}">View Archived Targets</a> 
                </button>
            </div>
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
            <div class="opcr-list-container">
                @foreach ($opcr as $item)
                    <div class="opcr-item" style="position:relative">
                        <div style="position:absolute; right: 10px">
                            <form action="{{ route('rpo.remove_opcr') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ $item->opcr_ID }}" name="opcr_ID">
                                <button type="submit" class="btn" onclick="confirmDeletion(event)"><i
                                        class="fas fa-file-archive" style="font-size: 25px;"></i></button>
                            </form>
                           

                        </div>
                        <ul style="margin-right: 50px">
                            <li style="list-style: none !important;">
                                <a href="{{ url('rpo/opcr/' . $item->opcr_ID) }}"
                                    style="text-decoration: none; color: black">
                            <li style="list-style: none !important;">
                                <h4>Description: {{ $item->description }}</h4>
                            </li>
                            <li style="list-style: none !important;">
                                <h4>Year: {{ $item->year }}</h4>
                            </li>
                            <li style="list-style: none !important;">
                                @if ($item->status == 'COMPLETE')
                                    <h5
                                        style="color: #fff; background: green; padding: 10px 20px; border-radius: 20px; width: 280px;">
                                        Target Status: {{ $item->status }}</h5>
                                @elseif ($item->status == 'INCOMPLETE')
                                    <h5
                                        style="color: #fff; background: red; padding: 10px 20px; border-radius: 20px; width: 280px;">
                                        Target Status: {{ $item->status }}</h5>
                                @elseif ($item->status == 'DONE')
                                    <h5
                                        style="color: #fff; background: green; padding: 10px 20px; border-radius: 20px; width: 230px;">
                                        OPCR Status: {{ $item->status }}</h5>
                                @else
                                    <h4>Status: </h4>
                                @endif


                                @if ($item->is_active == true && $item->status != 'DONE')
                                    <h5
                                        style="color: #fff; background: green; padding: 10px 20px; border-radius: 20px; width: 280px;">
                                        Submit Status: ACTIVE
                                    @elseif ($item->is_active == false && $item->status != 'DONE')
                                        <h5
                                            style="color: #fff; background: red; padding: 10px 20px; border-radius: 20px; width: 280px;">
                                            Submit Status: INACTIVE</h5>
                                    @else
                                @endif
                               
                            </li>
                            <button class="btn btn-primary" style="border-radius: 25px; padding: 5px 25px;">
                                <a style="text-decoration: none; color:white;" href="{{ url('rpo/opcr/' . $item->opcr_ID) }}"><i class="fa-solid fa-eye"></i><span
                                    class="p-1 d-inline-block">View OPCR</span></a> 
                            </button>
                            </a>

                            </li>



                        </ul>


                    </div>
                @endforeach



            </div>


        </div>
        <script>
            function confirmDeletion(event) {
                event.preventDefault();
                var result = confirm("Are you sure you want to archive it?");
                if (result) {
                    var form = event.target.closest('form');
                    form.submit();
                }
            }
        </script>
    </x-user-sidebar>
@endsection
