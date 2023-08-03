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
                    <h2 class="text-uppercase lead  text-black p-2 rounded">RPO <i class="fa-solid fa-angles-right"></i> Saved
                        Targets</h2>
                </li>
            </ol>
            <div style="margin: 0 1.5em 1em 0;" class="d-flex flex-row-reverse">
                <button class="btn btn-dark">
                    <a style="text-decoration: none; color:white;" href="{{ url('rpo/archive') }}"><i
                            class="fa-solid fa-eye"></i> Archived Targets</a>
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
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Year</th>
                            <th>OPCR Status</th>
                            <th>Submit Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($opcr as $item)
                            <tr>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->year }}</td>
                                <td>
                                    @if ($item->status == 'COMPLETE')
                                        <span class="status-complete">{{ $item->status }}</span>
                                    @elseif ($item->status == 'INCOMPLETE')
                                        <span class="status-incomplete">{{ $item->status }}</span>
                                    @elseif ($item->status == 'DONE')
                                        <span class="status-done">{{ $item->status }}</span>
                                    @else
                                        <span>Status:</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->is_active == true && $item->status != 'DONE')
                                        <span class="submit-status-active">ACTIVE</span>
                                    @elseif ($item->is_active == false && $item->status != 'DONE')
                                        <span class="submit-status-inactive">INACTIVE</span>
                                    @elseif ($item->status == 'DONE')
                                        <span class="submit-status-active">DONE</span>
                                    @else
                                    @endif
                                </td>
                                <td class="row d-flex align-items-center">
                                    <form action="{{ route('rpo.remove_opcr') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $item->opcr_ID }}" name="opcr_ID">
                                        <button type="submit" class="btn btn-danger" onclick="confirmDeletion(event)"><i
                                                class="fas fa-file-archive text-white"></i></button>
                                        <a class="btn btn-warning" href="{{ url('rpo/opcr/' . $item->opcr_ID) }}"><i
                                                class="fa-solid fa-eye text-white"></i></a>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
