<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v2.1.15
* @link https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="pt-BR">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
   
    <title>Labirinto</title>

    <!-- Icons-->
    <link href="{{ asset('admin/node_modules/@coreui/icons/css/coreui-icons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/node_modules/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/node_modules/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/node_modules/simple-line-icons/css/simple-line-icons.css')}}" rel="stylesheet">
    <!-- <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">-->
    <!-- Main styles for this application-->
    <link href="{{ asset('admin/css/style.css')}}" rel="stylesheet" defer>
    <link href="{{ asset('admin/vendors/pace-progress/css/pace.min.css')}}" rel="stylesheet">

    <!-- Select com busca -->
    <!-- <link rel="stylesheet" href="{{ asset('docsupport/style.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('docsupport/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css" integrity="sha256-IvM9nJf/b5l2RoebiFno92E5ONttVyaEEsdemDC6iQA=" crossorigin="anonymous" />
    
    
    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        // Shared ID
        gtag('config', 'UA-118965717-3');
        // Bootstrap ID
        gtag('config', 'UA-118965717-5');

    </script>
    <style>
        #toast {
            visibility: hidden;
            max-width: 50px;
            height: 50px;
            /*margin-left: -125px;*/
            margin: auto;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;

            position: fixed;
            z-index: 1;
            left: 0;right:0;
            bottom: 30px;
            font-size: 17px;
            white-space: nowrap;
        }
        #toast #img{
            width: 50px;
            height: 50px;

            float: left;

            padding-top: 16px;
            padding-bottom: 16px;

            box-sizing: border-box;

            color: #fff;
        }
        #toast #desc{


            color: #fff;

            padding: 16px;

            overflow: hidden;
            white-space: nowrap;
        }

        #toast.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, expand 0.5s 0.5s,stay 3s 1s, shrink 0.5s 2s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, expand 0.5s 0.5s,stay 3s 1s, shrink 0.5s 4s, fadeout 0.5s 4.5s;
        }

        @-webkit-keyframes fadein {
            from {bottom: 0; opacity: 0;} 
            to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }

        @-webkit-keyframes expand {
            from {min-width: 50px} 
            to {min-width: 500px}
        }

        @keyframes expand {
            from {min-width: 50px}
            to {min-width: 500px}
        }
        @-webkit-keyframes stay {
            from {min-width: 500px} 
            to {min-width: 500px}
        }

        @keyframes stay {
            from {min-width: 500px}
            to {min-width: 500px}
        }
        @-webkit-keyframes shrink {
            from {min-width: 500px;} 
            to {min-width: 50px;}
        }

        @keyframes shrink {
            from {min-width: 500px;} 
            to {min-width: 50px;}
        }

        @-webkit-keyframes fadeout {
            from {bottom: 30px; opacity: 1;} 
            to {bottom: 60px; opacity: 0;}
        }

        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 60px; opacity: 0;}
        }
            </style>
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show" style="position:relative;">
    <header class="app-header navbar row">

        <div class="d-lg-none mr-auto" align="left">
            <button class="navbar-toggler sidebar-toggler" type="button" data-toggle="sidebar-show">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="{{url('home')}}" class="home">
                <i class="cui-home"></i>
            </a>
        </div>
        <div class="d-md-down-none" align="left">
            <button class="navbar-toggler sidebar-toggler" type="button" data-toggle="sidebar-lg-show">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="{{url('home')}}" class="home">
                <span>Home</span>
            </a>
        </div>


    </header>
    <div class="app-body">
        <div id="toast"><div id="img"></div><div id="desc"></div></div>
        <script>
        @if(Session::has('message'))
        var type = "{{Session::get('alert-type','info')}}";
        document.getElementById("desc").innerHTML = "{{ Session::get('message') }}";


        switch (type) {
            case 'info':
                document.getElementById("img").style = "background-color:#004077;";
                document.getElementById("img").innerHTML = '<i class="fa fa-info"></i>';
                document.getElementById('toast').style = "background-color:#3c8fd6;";
                break;
            case 'success':
                document.getElementById("img").style = "background-color:#018830";
                document.getElementById("img").innerHTML = '<i class="fa fa-check-circle"></i>';
                document.getElementById('toast').style = "background-color:#04af40;";
                break;
            case 'warning':
                document.getElementById('img').style = "background-color:#b5a700;";
                document.getElementById("img").innerHTML = '<i class="fa fa-exclamation-triangle"></i>';
                document.getElementById('toast').style = "background-color:#e5d40e;";
                break;
            case 'error':
                document.getElementById('img').style = "background-color:#860000;";
                document.getElementById("img").innerHTML = '<i class="fa fa-times"></i>';
                document.getElementById('toast').style = "background-color:#cb0c0c;";
                break;
        }
            
        var x = document.getElementById("toast");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
        @endif
        

    </script>
        
        

        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    @hasrole('professor')
                    <li class="nav-title">MENU DO PROFESSOR</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admin/sala')}}">
                            <i class="nav-icon icon-pencil"></i> Editar Salas</a>
                    </li>
                    @endhasrole
                    @hasrole('user')
                    <li class="nav-title">MENU DO USUÁRIO</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admin/virtual')}}">
                            <i class="nav-icon fa fa-rocket"></i> Espaço Virtual</a>
                    </li>
                    @endhasrole
                    @hasrole('admin')
                    <li class="nav-title">MENU DO ADMINISTRADOR</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admin/users')}}">
                            <i class="nav-icon icon-people"></i> Usuários</a>
                    </li>
                    @endhasrole
                    <li class="nav-title">CONFIGURAÇÕES</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/manual')}}">
                            <i class="nav-icon fa fa-book"></i> Manual</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admin/settings')}}">
                            <i class="nav-icon icon-user"></i> Editar Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admin/settings/password')}}">
                            <i class="nav-icon icon-settings"></i> Editar Senha</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="nav-icon cui-account-logout"></i> Logout

                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>
        <main class="main">
            <div class="container-fluid">
                <div class="animated fadeIn"></div>

                @yield('content')
            </div>
        </main>
    </div>
    <footer class="app-footer">
        <div>
            <a href="https://www.unicamp.br" target="_blank">UNICAMP</a>
            <span>&copy; 2019 UNICAMP</span>
        </div>
        <div class="ml-auto">
            <span>Powered by</span>
            LarCom
        </div>
    </footer>


    @yield('myscript')

    
    <script src="{{ asset('docsupport/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
   
    <!--<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js" defer></script>-->

    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/caixa.js')}}" defer></script>
<!--    <script src="{{ asset('admin/node_modules/jquery/dist/jquery.min.js')}}"></script>-->
    <script src="{{ asset('admin/node_modules/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{ asset('admin/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('admin/node_modules/pace-progress/pace.min.js')}}"></script>
    <script src="{{ asset('admin/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ asset('admin/node_modules/@coreui/coreui/dist/js/coreui.min.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
    <script src="{{asset('js/jquery.ui.touch-punch.min.js')}}" defer></script>
    

</body>

</html>
