@extends('layouts.app')
@section('title')
    {{ 'RPO Save Target' }}
@endsection
@section('content')
    <x-sidebars.rpo-sidebar>
        <div class="container-fluid px-4 py-5">
                
            <ol class="breadcrumb mb-4">
            
                <li class="breadcrumb-item active"><h1>Saved Targets</h1></li>
                <div><h2>Bobo Ka</h2></div>
            </ol>
            <div class="opcr-list-container">
                @foreach ($opcr as $item)
                    <div class="opcr-item" style="border: solid black; padding: 15px;">
                        <ul>
                            <li style="list-style: none !important;">
                               <a href="{{ url('rpo/opcr/'.$item->opcr_ID) }}"><h4>ID:  {{$item->opcr_ID}}</h2></a> 
                               
                            </li>
                            <li style="list-style: none !important;">
                                <h4>Description:  {{$item->description}}</h2>
                            </li >
                            <li style="list-style: none !important;">
                                <h4>Year:  {{$item->year}}</h2>
                            </li>
                            <li style="list-style: none !important;">
                                <h4>Status:  {{$item->status}}</h2>
                            </li>
                          
                            
                        </ul>


                    </div>




                @endforeach



            </div>
            
        
        </div>

    </x-sidebars.rpo-sidebar>
@endsection