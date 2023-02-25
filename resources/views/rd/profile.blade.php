@extends('layouts.app')
@section('title')
    {{ 'RD Profile Page' }}
@endsection

@section('content')
    <x-user-sidebar>
        <div class="container-fluid px-4 py-5">

            <ol class="breadcrumb mb-4">

                <li class="breadcrumb-item active">
                    <h1>Regional Director Profile Page</h1>
                </li>

            </ol>
            <div class="profile-container">

              

                <div class="card" style="width: 18rem;">
                    <img class="card-img-top-1"
                    src="{{ url('/images/mark.jpeg') }}" />
                    <div class="card-body">
                      <h5 class="card-title">Regional Director</h5>
                      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                      {{-- <a href="#" class="btn btn-primary">Know More</a> --}}
                    </div>
                  </div>
                  
                 



            </div>
        </div>

    </x-user-sidebar>
@endsection
