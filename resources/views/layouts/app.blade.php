<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>@yield('title')</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href={{ asset('css/custom.css') }}>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- <link rel="stylesheet" href="{{ asset('css/rd.css') }}"> --}}
    {{-- <script src="{{ asset('js/custom.js') }}"></script> --}}
    <script src="{{ asset('js/loading.js') }}"></script>


    <style>

    </style>
</head>

<body>
    <div id="app">
        <span id="notification-text" class="notification-design" role="alert" style="display: none;"></span>


        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm position-fixed w-100 z-index-master">
            <div class="container">
                <a class="navbar-brand" href="{{ 
                    auth()->check() ? (
                        auth()->user()->user_type_ID === 1 ? url('/rd/dashboard') : 
                        (auth()->user()->user_type_ID === 2 ? url('/rpo/dashboard') : 
                        (auth()->user()->user_type_ID === 3 ? url('/pd/dashboard') : 
                        (auth()->user()->user_type_ID === 4 ? url('/ppo/dashboard') : 
                        (auth()->user()->user_type_ID === 5 ? url('/dc/dashboard') : '#'))))) : url('/') 
                }}">
                    <b>DTI's M&E System</b>
                </a>
                
                
                
                
                
                
                 
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto" style="align-items: center;">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('login') ? 'active' : '' }}"
                                        href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('register') ? 'active' : '' }}"
                                        href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <div class="dropdown">
                                    <a class="nav-link" href="#" id="notification-dropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-bell"></i>
                                        <span class="badge badge-danger" id="notification-count"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notification-dropdown"
                                        id="notification-dropdown-menu">
                                        <a class="dropdown-item no-notifications" href="#">No new notifications.</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item mark-all-as-read" href="#">Mark all as read</a>
                                    </div>
                                </div>
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#logout-modal">
                                        Logout
                                    </button>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <x-modal-logout />
        <main class="py-4 vh-100">
            @yield('content')
        </main>

        {{-- <script>
            function getNotifications() {
                $.ajax({
                    url: "{{ url('/notifications') }}",
                    type: 'GET',
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        var notifications = response.notifications;
                        var dropdownMenu = $('#notification-dropdown-menu');
                        dropdownMenu.empty();
                        $.each(notifications, function(index, notification) {
                            var dataYear = notification.data;
                            var url = '';
                            if (notification.user_type_ID == 4) { // PPO user type ID
                                url = "{{ url('/ppo/opcr') }}";
                            } else if (notification.user_type_ID == 5) { // DC user type ID
                                url = "{{ url('/dc/view-target') }}";
                            }
                            
                            url += '?opcr=' + notification.opcr_ID;
                            dropdownMenu.append('<a class="dropdown-item" href="' + url + '">' +
                                dataYear + '</a>');
                        });
                        var count = notifications.length;
                        if (count > 0) {
                            dropdownMenu.append(
                                '<a class="dropdown-item mark-all-as-read" href="#">Mark all as read</a>'
                            );
                        } else {
                            dropdownMenu.append('<a class="dropdown-item" href="#">No notifications</a>');
                        }
                        $('#notification-count').text(count);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        var dropdownMenu = $('#notification-dropdown-menu');
                        dropdownMenu.empty();
                        dropdownMenu.append('<a class="dropdown-item" href="#">Error loading notifications</a>');
                    }
                });
            }
            $(document).ready(function() {
                getNotifications();
                setInterval(getNotifications, 10000);
                $('#notification-dropdown-menu').on('click', '.mark-all-as-read', function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ url('/notifications/mark-all-as-read') }}",
                        type: 'POST',
                        dataType: "json",
                        success: function(response) {
                            getNotifications();
                            console.log(response);
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });
            });
        </script> --}}
      
        <script>
            $(document).ready(function() {
              

                function getNotifications() {
                    $.ajax({
                        url: "{{ url('/notifications') }}",
                        type: 'GET',
                        dataType: "json",
                        success: function(response) {
                            // console.log(response);
                            var notifications = response.notifications;
                            var dropdownMenu = $('#notification-dropdown-menu');
                            dropdownMenu.empty();
                            $.each(notifications, function(index, notification) {
                                var dataYear = notification.data;
                                var url = '';
                                if (notification.user_type_ID == 4) { // PPO user type ID
                                    url = "{{ url('/ppo/opcr') }}";
                                    if (notification.type == 'BDD') {
                                        url = "{{ url('/ppo/bdd') }}";
                                    } else if (notification.type == 'CPD') {
                                        url = "{{ url('/ppo/cpd') }}";
                                    } else if (notification.type == 'FAD') {
                                        url = "{{ url('/ppo/fad') }}";
                                    }
                                } else if (notification.user_type_ID == 5) { // DC user type ID
                                    url = "{{ url('/dc/manage') }}";
                                    if (notification.type == 'BDD') {
                                        url = "{{ url('/dc/coaching') }}";
                                    } else if (notification.type == 'CPD') {
                                        url = "{{ url('/dc/coaching') }}";
                                    } else if (notification.type == 'FAD') {
                                        url = "{{ url('/dc/coaching') }}";
                                    }
                                }else if (notification.user_type_ID == 3) { // PD user type ID
                                    url = "{{ url('/pd/assessment') }}";
                                }
                                
                                // url += '?opcr=' + notification.opcr_ID;
                                var dateFromNow = moment(notification.created_at).fromNow();
                    var notificationText = dataYear + " (" + dateFromNow + ")";
                    var notificationLink = $('<a class="dropdown-item" href="' + url + '">' + notificationText + '</a>');
                                notificationLink.click(function(e) {
                                    e.preventDefault();
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $(
                                                'meta[name="csrf-token"]').attr(
                                                'content')
                                        }
                                    });
                                    $.ajax({
                                        url: "{{ url('/notifications/mark-as-read') }}",
                                        type: 'POST',
                                        dataType: "json",
                                        data: {
                                            notification_id: notification.id
                                        },
                                        success: function(response) {
                                            window.location.href = url;
                                        },
                                        error: function(xhr) {
                                            console.log(xhr.responseText);
                                        }
                                    });
                                });
                                dropdownMenu.append(notificationLink);
                            });
                            var count = notifications.length;
                            if (count > 0) {
                                dropdownMenu.append(
                                    '<a class="dropdown-item mark-all-as-read" href="#">Mark all as read</a>'
                                );
                            } else {
                                dropdownMenu.append(
                                    '<a class="dropdown-item" href="#">No notifications</a>');
                            }
                            $('#notification-count').text(count);

                            // Show current notification on breadcrumbs and fade after 10 seconds
                            var currentNotification = notifications[0];
                            var currentNotificationText = currentNotification.data;
                            var notificationTextElement = $('#notification-text');
                            if (notificationTextElement.css('display') === 'none') {
                                notificationTextElement.text(currentNotificationText);
                                notificationTextElement.fadeIn(1000);
                                setTimeout(function() {
                                    notificationTextElement.fadeOut(1000, function() {
                                        notificationTextElement.text('');
                                        notificationTextElement
                                            .remove(); // Remove the notification text element after fading out
                                    });
                                }, 10000);
                            }

                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            var dropdownMenu = $('#notification-dropdown-menu');
                            dropdownMenu.empty();
                            dropdownMenu.append(
                                '<a class="dropdown-item" href="#">Error loading notifications</a>');
                        }
                    });
                }


                getNotifications();
                setInterval(getNotifications, 10000);



                $('#notification-dropdown-menu').on('click', '.mark-all-as-read', function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ url('/notifications/mark-all-as-read') }}",
                        type: 'POST',
                        dataType: "json",
                        success: function(response) {
                            getNotifications();
                            console.log(response);
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // fetch all the forms we want to apply custom style
    var inputs = document.getElementsByClassName('form-control')

    // loop over each input and watch blue event
    var validation = Array.prototype.filter.call(inputs, function(input) {
        
      input.addEventListener('blur', function(event) {
        // reset
        input.classList.remove('is-invalid')
        input.classList.remove('is-valid')
        
        if (input.checkValidity() === false) {
            input.classList.add('is-invalid')
        }
        else {
            input.classList.add('is-valid')
        }
      }, false);
    });

     var passwordInput = document.getElementById('password');
    var passwordConfirmInput = document.getElementById('password-confirm');
    var passwordConfirmError = document.getElementById('password-confirm-error');

    function validatePasswordConfirmation() {
      if (passwordInput.value !== passwordConfirmInput.value) {
          passwordConfirmInput.classList.remove('is-valid');
        passwordConfirmInput.classList.add('is-invalid');
        passwordConfirmError.style.display = 'block';
      } else {
        passwordConfirmInput.classList.remove('is-invalid');
        passwordConfirmError.style.display = 'none';
      }
    }

    passwordInput.addEventListener('input', validatePasswordConfirmation);
    passwordConfirmInput.addEventListener('input', validatePasswordConfirmation);
  }, false);
})()

            });
        </script>






    </div>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#manage-user').DataTable()({
                responsive: true,

            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    {{-- <script src={{ asset('demo/chart-area-demo.js') }}></script>
        <script src={{ asset('demo/chart-bar-demo.js') }}></script> --}}
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src={{ asset('js/datatables-simple-demo.js') }}></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js" "></script>

</body>

</html>
