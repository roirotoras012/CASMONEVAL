<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

       

        <style>
            :root {
                --primary: #0d6efd;
                --primary-darker: #0b5ed7;
            }

            body {
                font-family: 'Nunito', sans-serif;
            }
            a .fa, a .fas {
            margin-right: 5px;
            }
            a.btn-primary, .btn-primary {
            background: var(--primary);
            font-size: 14px;
            padding: 10px 60px;

            }
          
            .container-sm {
            max-width: 1000px;
            }

            header {
                background: #FFF;
            }
            header .container {
                position: relative;
            }
            header .top {
                background: #FFF;
                padding: 25px 0;
                position: relative;
                z-index: 10;
                -webkit-box-shadow: 0px 2px 4px var(--shadow);
                -moz-box-shadow: 0px 2px 4px var(--shadow);
                box-shadow: 0px 2px 4px var(--shadow);
            }
           
            header .top.fixed {
                position: fixed;
                width: 100%;
            }
            header .logo {
                font-weight: 700;
                font-size: 18px;
            }
            header .navigation {
                margin-top: 2px;
                float: right;
            }
            header .navigation a {
                margin: 0px 15px;
            
            }
            header .blob-container {
                position: relative;
                overflow: hidden;
           
            }
          
            header .header-content h1 {
                font-weight: 800;
            }
            header .header-content p {
                color: #999999;
            }
           
            section.features {
                padding: 100px 0;
            }
            .card.card-feature {
                box-shadow: 0px 2px 4px var(--shadow);
            }
            .banner-title {
                font-size: 50px;
                text-transform: uppercase;
            }
        
           
         
            .input-group-icon{
            display: flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: center;
            white-space: nowrap;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
           
    }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0">
          
            <header>
                <div class="blob-container">
                  <div class="top fixed">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                          <div class="navigation">
                            @if (Route::has('login'))
                            {{-- <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block"> --}}
                            <div class="fixed top-0 right-0 px-6 py-4 sm:block">
            
                                @auth
                                    <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
            
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <svg class="blob1"><use href="#blob1" /></svg>
                  <div class="container fixed-offset">
                    <div class="header-content">
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <img style="height:150px;width: auto" src="{{url('/images/dti-logo.png')}}"/>
                            </div>
                          <h1 class="banner-title">Casmoneval</h1>
                          <p>A great Boostrap website template for startups. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin dignissim massa vitae vulputate molestie. Cras a risus eget.</p>
                          <a href="{{ route('login') }}" class="btn btn-primary"underline">Log in</a>
                        </div>
                       
                      </div>
                    </div>
                  </div>
                </div>
              </header>
              
            {{-- <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <div class="text-center mb-4">
                        <img style="height:150px;width: auto" src="{{url('/images/dti-logo.png')}}"/>
                    </div>
                </div>

                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        
                    </div>
                </div>
                <h1 class="banner-title">Casmoneval</h1>
                <p class="banner-text">We understand the problems faced by DTI Region 10 and have created a solution to resolve them. Our system features a user-friendly interface that allows management to input OPCR targets and monitor performance, providing an alert mechanism for underperformance and opportunities for coaching and mentoring. With this system, DTI Region 10 will have a more efficient and effective way to manage their processes and improve decision-making. Try our solution today and see the difference it can make.</p>
                <a href="{{ route('login') }}" class="banner-btn btn-primary">Log in</a>
            </div> --}}
        </div>
    </body>
</html>
