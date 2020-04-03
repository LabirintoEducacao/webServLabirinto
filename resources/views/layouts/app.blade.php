<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/caixa.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .sortable {
            list-style-type: none;
            margin: 0;
            padding: 0;
            margin-bottom: 10px;
        }

        .ui-state-default {
            margin: 5px;
            padding: 5px;
            width: 150px;
            border: 0.5px solid #dbdbdb;
            border-radius: 2.8px;
        }

        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 200;
            font-size: 18px;
            height: 100vh;
            margin: 0;
        }

        .btn-outline-cyan {
            color: #176eb8;
            border-color: #176eb8;
            background-color: transparent;
        }

        .btn-outline-cyan:hover {
            color: #fff;
            background-color: #176eb8;
            border-color: #176eb8;
            /*rgb(118, 184, 255);*/
        }

        .btn-outline-cyan:focus,
        .btn-outline-cyan.focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
        }

        .btn-outline-cyan.disabled,
        .btn-outline-cyan:disabled {
            color: #176eb8;
            background-color: transparent;
        }

        .btn-outline-cyan:not(:disabled):not(.disabled):active,
        .btn-outline-cyan:not(:disabled):not(.disabled).active,
        .show>.btn-outline-cyan.dropdown-toggle {
            color: #fff;
            background-color: #176eb8;
            border-color: #176eb8;
        }

        .btn-outline-cyan:not(:disabled):not(.disabled):active:focus,
        .btn-outline-cyan:not(:disabled):not(.disabled).active:focus,
        .show>.btn-outline-cyan.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
        }

        .btn-outline-danger {
            color: #dc3545;
            background-color: transparent;
            background-image: none;
            border-color: #dc3545;
        }

        .btn-outline-danger:hover {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-outline-danger:focus,
        .btn-outline-danger.focus {
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.5);
        }

        .btn-outline-danger.disabled,
        .btn-outline-danger:disabled {
            color: #dc3545;
            background-color: transparent;
        }

        .btn-outline-danger:not(:disabled):not(.disabled):active,
        .btn-outline-danger:not(:disabled):not(.disabled).active,
        .show>.btn-outline-danger.dropdown-toggle {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-outline-danger:not(:disabled):not(.disabled):active:focus,
        .btn-outline-danger:not(:disabled):not(.disabled).active:focus,
        .show>.btn-outline-danger.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.5);
        }

        .btn-outline-success {
            color: #28a745;
            background-color: transparent;
            background-image: none;
            border-color: #28a745;
        }

        .btn-outline-success:hover {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-outline-success:focus,
        .btn-outline-success.focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
        }

        .btn-outline-success.disabled,
        .btn-outline-success:disabled {
            color: #28a745;
            background-color: transparent;
        }

        .btn-outline-success:not(:disabled):not(.disabled):active,
        .btn-outline-success:not(:disabled):not(.disabled).active,
        .show>.btn-outline-success.dropdown-toggle {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-outline-success:not(:disabled):not(.disabled):active:focus,
        .btn-outline-success:not(:disabled):not(.disabled).active:focus,
        .show>.btn-outline-success.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
        }

        .btn-outline-info {
            color: #17a2b8;
            background-color: transparent;
            background-image: none;
            border-color: #17a2b8;
        }

        .btn-outline-info:hover {
            color: #fff;
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-outline-info:focus,
        .btn-outline-info.focus {
            box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.5);
        }

        .btn-outline-info.disabled,
        .btn-outline-info:disabled {
            color: #17a2b8;
            background-color: transparent;
        }

        .btn-outline-info:not(:disabled):not(.disabled):active,
        .btn-outline-info:not(:disabled):not(.disabled).active,
        .show>.btn-outline-info.dropdown-toggle {
            color: #fff;
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-outline-info:not(:disabled):not(.disabled):active:focus,
        .btn-outline-info:not(:disabled):not(.disabled).active:focus,
        .show>.btn-outline-info.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.5);
        }

        .btn-outline-secondary {
            color: #6c757d;
            background-color: transparent;
            border-color: #6c757d;
        }

        .btn-outline-secondary:hover {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-secondary:focus,
        .btn-outline-secondary.focus {
            box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.5);
        }

        .btn-outline-secondary.disabled,
        .btn-outline-secondary:disabled {
            color: #6c757d;
            background-color: transparent;
        }

        .btn-outline-secondary:not(:disabled):not(.disabled):active,
        .btn-outline-secondary:not(:disabled):not(.disabled).active,
        .show>.btn-outline-secondary.dropdown-toggle {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-secondary:not(:disabled):not(.disabled):active:focus,
        .btn-outline-secondary:not(:disabled):not(.disabled).active:focus,
        .show>.btn-outline-secondary.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.5);
        }

        .btn-outline-dark {
            color: #343a40;
            background-color: transparent;
            border-color: #343a40;
        }

        .btn-outline-dark:hover {
            color: #fff;
            background-color: #343a40;
            border-color: #343a40;
        }

        .btn-outline-dark:focus,
        .btn-outline-dark.focus {
            box-shadow: 0 0 0 0.2rem rgba(52, 58, 64, 0.5);
        }

        .btn-outline-dark.disabled,
        .btn-outline-dark:disabled {
            color: #343a40;
            background-color: transparent;
        }

        .btn-outline-dark:not(:disabled):not(.disabled):active,
        .btn-outline-dark:not(:disabled):not(.disabled).active,
        .show>.btn-outline-dark.dropdown-toggle {
            color: #fff;
            background-color: #343a40;
            border-color: #343a40;
        }

        .btn-outline-dark:not(:disabled):not(.disabled):active:focus,
        .btn-outline-dark:not(:disabled):not(.disabled).active:focus,
        .show>.btn-outline-dark.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(52, 58, 64, 0.5);
        }

    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <ul class="navbar-nav" align="center">
                        @if (\Request::is('virtual'))
                        <li class="nav-item">
                            <h3>Jogos</h3>
                        </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (\Request::is('usuario/login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('userLogin') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('userRegister') }}">{{ __('Registrar') }}</a>
                        </li>
                        @elseif (\Request::is('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Registrar') }}</a>
                        </li>
                        @elseif (\Request::is('usuario/register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('userLogin') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('userRegister') }}">{{ __('Registrar') }}</a>
                        </li>
                        @elseif (\Request::is('virtual'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('userLogin') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('userRegister') }}">{{ __('Registrar') }}</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Registrar') }}</a>
                        </li>

                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        @if(Session::has('message'))
        var type = "{{Session::get('alert-type','info')}}"

        switch (type) {
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;
            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;
            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
        
        
        
        
                function qrcodebtn(id) {


            $.get("/admin/virtual/" + id).done(function(data) {

                var parse = JSON.parse(data);

                if (data == "null") {

                    $('#noinfomodal').modal('show');

                } else {
                    console.log(data)

                    $('#nomeqrsala').append(parse[0]);
                    $('#hiddenid').val(id);


                    for (var i = 1; i < parse.length; i++) {

                        if (i == 1) {
                            $('#corouselimg').append(
                                '<div class="carousel-item active col" >' +
                                '<img class="d-block w-100 " src="' + parse[i] + '" alt="First slide">' +
                                '<p> Qr Code: ' + i + ":" + (parse.length - 1) + '  </p>' +
                                '</div>'
                            );
                        }

                        if (i > 1) {

                            $('#corouselimg').append(
                                '<div class="carousel-item  col" >' +
                                '<img class="d-block w-100 " src="' + parse[i] + '" alt="First slide">' +
                                '<p> Qr Code: ' + i + ":" + (parse.length - 1) + '</p>' +
                                '</div>'
                            );
                        }
                    }

                    $('#qrmodal').modal('show');
                    $('.carousel').carousel({
                        interval: 1000
                    });


                }
            });

        }


        /////////////////////////////

        $('#qrmodal').on('hide.bs.modal', function(e) {

            var idmodal = $('#hiddenid').val();


            $.get("/admin/virtualdelete/" + idmodal).done(function() {
                $('#corouselimg').empty();
                $('#nomeqrsala').empty();
                $('#carouselExampleControls').carousel('dispose');



            });
            

        });

    </script>
</body>

</html>
