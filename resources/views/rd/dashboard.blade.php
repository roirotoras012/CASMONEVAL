@extends('layouts.app')
<head>
    <link rel="stylesheet" href="{{ asset('css/rd.css') }}">
    <script src="{{ asset('js/custom.js') }}"></script>
</head>
@section('content')
    <x-user-sidebar>
        <div class="container-fluid px-4 py-5">
                
            <ol class="breadcrumb mb-4">
            
                <li class="breadcrumb-item active"><h1>Regional Director Dashboard</h1></li>
                <div><h2>Bobo Ka</h2></div>
            </ol>
            <div class="opcr-container">
                <h1>OPCR</h1>
                
                <div class="opcr-table">

                  
        
              

              
      
            
                    <table>
                        <thead>
                          <tr>
                           
                            <th >Strategic Objectives</th>
                            <th >Strategic Measures</th>
                            <th>REGION 10</th>
                            <th>BUK</th>
                            <th>CAM</th>
                            <th>LDN</th>
                            <th>MISOR</th>
                            <th>MISOC</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                          @foreach ($labels as $label)
                          <tr class="table-tr">
                            @if ($label->strategic_objective)
                                
                            @endif
                            <td>{{ $label->strategic_objective }}</td>
                            <td>{{ $label->strategic_measure }}</td>
                          
                            <td></td>
                            <td><input type="number"></td>
                            <td><input type="number"></td>
                            <td><input type="number"></td>
                            <td><input type="number"></td>
                            <td><input type="number"></td>
                            
                            </tr>
                          @endforeach
                       
                            
                           
                          
                              
                               
                          
                            
                            
                      
                           
                            
                         
                        
                       
                       
                        
                          
                          
                          
                        </tbody>
                      </table>
                </div>
        
        
            </div>
        </div>
       
    </x-user-sidebar>

   
@endsection
