@extends('layouts.app')
@section('title')
    {{ 'RPO Dashboard' }}
@endsection
@section('content')
    <x-sidebars.rpo-sidebar>
        <div class="container-fluid px-4 py-5">
                
            <ol class="breadcrumb mb-4">
            
                <li class="breadcrumb-item active"><h1>Regional Planning Officer Dashboard</h1></li>
                <div><h2>Bobo Ka</h2></div>
            </ol>
    
        
        </div>

    </x-sidebars.rpo-sidebar>
@endsection