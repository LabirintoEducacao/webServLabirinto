<!--
=========================================================
 Material Dashboard - v2.1.1
=========================================================

 Product Page: https://www.creative-tim.com/product/material-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/material-dashboard/blob/master/LICENSE.md)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->

<!DOCTYPE html>
<html lang="en" id="abrirmenu">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="cache-control" content="no-cache" />
    <title>
        Labirinto Educacional
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <!-- CSS Files -->
    <link href="{{asset('assets/css/material-dashboard.css?v=2.1.1')}}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{asset('assets/demo/demo.css')}}" rel="stylesheet" />
    <link href="{{asset('css/style.css')}}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/c0ff39d208.js" crossorigin="anonymous"></script>



</head>

<body onload="totalresposta()">
    <div class="wrapper ">
        <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">


            <div class="logo">
                <span style="margin-left: 40%">{{ Auth::user()->name }}</span>
            </div>
            <div class="sidebar-wrapper" id="sidebar">
                <ul class="nav">
                    <!-- <li class="nav-item active"> -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('home')}}">
                            <i class="material-icons">home</i>
                            Home
                        </a>
                    </li>
                    @hasrole('admin')
                    <li class="nav-item ">
                        <h6 style="margin-left:6%;">Menu do Administrador</h6>
                        <a class="nav-link" href="{{url('/admin/users')}}">
                            <i class="material-icons">supervisor_account</i>
                            Usuários
                        </a>
                    </li>
                    @endhasrole
                    @hasrole('professor')
                    <li class="nav-item ">
                        <h6 style="margin-left:6%;">Menu do Professor</h6>
                        <a class="nav-link" href="{{url('/admin/sala')}}">
                            <i class="material-icons">widgets</i>
                            Editar Salas
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{url('/grupos')}}">
                            <i class="material-icons">group</i>
                            Grupos
                        </a>
                    </li>
                    @endhasrole
                    @hasrole('user')
                    <li class="nav-item ">
                        <h6 style="margin-left:6%;">Menu do Jogador</h6>
                        <a class="nav-link" href="{{url('/admin/virtual')}}">
                            <i class="fas fa-rocket"></i>
                            Espaço Virtual
                        </a>
                    </li>
                    @endhasrole
                    <li class="nav-item ">
                        <a class="nav-link" href="{{url('/admin/settings')}}">
                            <i class="material-icons">person</i>
                            Perfil
                        </a>
                    </li>
                    <!--
                    <li class="nav-item ">
                        <a class="nav-link" href="{{url('/admin/settings/password')}}">
                            <i class="material-icons">lock</i>
                            Senha
                        </a>
                    </li>
-->
                    <li class="nav-item ">
                        <a class="nav-link" href="{{url('/manual')}}">
                            <i class="material-icons">library_books</i>
                            Manual
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">

                            <i class="nav-icon fa fa-sign-out-alt"></i> Sair
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel" id="overlayer">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                <div class="container-fluid">

                    <button class="navbar-toggler" id="botaomenu" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" onclick="botaomenu()">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>

                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="animated fadeIn"></div>

                    @yield('content')
                </div>
            </div>
            <footer class="footer">

            </footer>

            <!--  <div class="close-layer visible" id=""></div> -->



        </div>
    </div>


      @yield('myscript')



    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
<!--    <script src=https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.js charset=utf-8></script>-->
     {{-- ChartScript --}}
    @if(isset($usersChart))
    {!! $usersChart->script() !!}
    @endif


    <script src="{{asset('assets/js/core/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
    <!--     <script src="{{asset('assets/js/core/bootstrap-material-design.min.js')}}"></script> -->
    <!--  <script src="{{asset('assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script> -->
    <!-- Plugin for the momentJs  -->
    <script src="{{asset('assets/js/plugins/moment.min.js')}}"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="{{asset('assets/js/plugins/sweetalert2.j')}}s"></script>
    <!-- Forms Validations Plugin -->
    <script src="{{asset('assets/js/plugins/jquery.validate.min.j')}}s"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="{{asset('assets/js/plugins/jquery.bootstrap-wizard.js')}}"></script>
    <!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="{{asset('assets/js/plugins/bootstrap-selectpicker.js')}}" defer></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="{{asset('assets/js/plugins/bootstrap-datetimepicker.min.js')}}"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
    <!--  Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="{{asset('assets/js/plugins/bootstrap-tagsinput.js')}}"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="{{asset('assets/js/plugins/jasny-bootstrap.min.js')}}"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="{{asset('assets/js/plugins/fullcalendar.min.js')}}"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="{{asset('assets/js/plugins/jquery-jvectormap.js')}}"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{asset('assets/js/plugins/nouislider.min.js')}}"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="{{asset('assets/js/plugins/arrive.min.js')}}"></script>

    <script src="{{asset('assets/js/plugins/chartist.min.js')}}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{asset('assets/js/plugins/bootstrap-notify.js')}}"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('assets/js/material-dashboard.js?v=2.1.1')}}" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{asset('assets/demo/demo.js')}}"></script>
    <script>


            $('#qntdeRespPerg').change(function(){

                if($('#qntdeRespPerg').is(":checked") == true){

                    $('#qntdeRespPergDiv').css('display','block');

                }else{

                    $('#qntdeRespPergDiv').css('display','none');

                }

            })

        $('#qntdeTentativas').change(function(){

                if($('#qntdeTentativas').is(":checked") == true){

                    $('#qntdeTentativasDiv').css('display','block');

                }else{

                    $('#qntdeTentativasDiv').css('display','none');

                }

            })


        $('#removerAlunoModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);

            var id = button.data('id');

            var nome = button.data('nome');

            var sala = button.data('sala');

            var modal = $(this);

            var url = '/admin/deletar-aluno/' + id + '/' + sala;




            console.log(url)

            modal.find("#tituloModal").html("Você realmente deseja deletar o usuário \'" + nome + "\' desta sala?");
            modal.find('#confirmarRemoverAluno').on('click', function() {
                window.location.href = url;
            })




        });



        $('#removerPerguntaModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var perg = button.data('pergunta');

            var url = '/admin/visualizar/deletar-pergunta/' + id;


            var modal = $(this);

            modal.find("#tituloPergModal").html("Você realmente deseja deletar a pergunta \'" + perg + "\' desta sala?");

            modal.find('#confirmarRemoverPergunta').on('click', function() {
                window.location.href = url;
            })

        });


        $(document).ready(function() {


            $('#question_type').tooltip(options);


            $().ready(function() {

                $('.selectpicker').selectpicker('refresh');

                $sidebar = $('.sidebar');

                $sidebar_img_container = $sidebar.find('.sidebar-background');

                $full_page = $('.full-page');

                $sidebar_responsive = $('body > .navbar-collapse');

                window_width = $(window).width();

                fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                    if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                        $('.fixed-plugin .dropdown').addClass('open');
                    }

                }

                $('.fixed-plugin a').click(function(event) {
                    // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                    if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });

                $('.fixed-plugin .active-color span').click(function() {
                    $full_page_background = $('.full-page-background');

                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-color', new_color);
                    }

                    if ($full_page.length != 0) {
                        $full_page.attr('filter-color', new_color);
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr('data-color', new_color);
                    }
                });

                $('.fixed-plugin .background-color .badge').click(function() {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('background-color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-background-color', new_color);
                    }
                });

                $('.fixed-plugin .img-holder').click(function() {
                    $full_page_background = $('.full-page-background');

                    $(this).parent('li').siblings().removeClass('active');
                    $(this).parent('li').addClass('active');


                    var new_image = $(this).find("img").attr('src');

                    if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function() {
                            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                            $sidebar_img_container.fadeIn('fast');
                        });
                    }

                    if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function() {
                            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                            $full_page_background.fadeIn('fast');
                        });
                    }

                    if ($('.switch-sidebar-image input:checked').length == 0) {
                        var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                    }
                });

                $('.switch-sidebar-image input').change(function() {
                    $full_page_background = $('.full-page-background');

                    $input = $(this);

                    if ($input.is(':checked')) {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar_img_container.fadeIn('fast');
                            $sidebar.attr('data-image', '#');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page_background.fadeIn('fast');
                            $full_page.attr('data-image', '#');
                        }

                        background_image = true;
                    } else {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar.removeAttr('data-image');
                            $sidebar_img_container.fadeOut('fast');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page.removeAttr('data-image', '#');
                            $full_page_background.fadeOut('fast');
                        }

                        background_image = false;
                    }
                });

                $('.switch-sidebar-mini input').change(function() {
                    $body = $('body');

                    $input = $(this);

                    if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                    } else {

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                        setTimeout(function() {
                            $('body').addClass('sidebar-mini');

                            md.misc.sidebar_mini_active = true;
                        }, 300);
                    }

                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function() {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);

                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function() {
                        clearInterval(simulateWindowResize);
                    }, 1000);

                });
            });
        });

    </script>
    <script>
        // $(document).ready(function() {
        //     // Javascript method's body can be found in assets/js/demos.js
        //     md.initDashboardPageCharts();


        // });




        $(document).ready(function() {
            @if(Session::has('message'))
            var type = "{{Session::get('alert-type','info')}}";
            $.notify({
                message: "{{ Session::get('message') }}"

            }, {
                type: type,
                timer: 4000,
                placement: {
                    from: 'top',
                    align: 'right'
                }
            });
            @endif
        });


        function abrir(id) {
            console.log(id);
            $("#" + id).slideToggle("slow");
        }

        function transforma(tempo, campo) {
            var x = 0;
            console.log(tempo);
            var y = 0;


            resultado = tempo.split(":");
            console.log(resultado)
            for (var i = 0; i < resultado.length; i++) {

                y += parseInt(resultado[i]);
                //                console.log(y)

            }
            console.log(y)
            if (y > 0) {
                if (resultado.length == 3) {
                    x = parseInt(resultado[0] * 3600);
                    x += parseInt(resultado[1] * 60);
                    x += parseInt(resultado[2]);
                } else if (resultado.length == 2) {
                    x = parseInt(resultado[0] * 3600);
                    x += parseInt(resultado[1] * 60);
                } else if (resultado.length == 1) {
                    x = parseInt(resultado[0] * 3600);
                } else
                    x = 0;
            }
            console.log(x);

            if (campo == 0)
                document.getElementById("time5").value = x;
            else
                document.getElementById("time4").value = x;
        }


        function muda(radio,op) {
            if(op == 0 && document.getElementById('room_type').value != 'true_or_false'){
               let y = document.getElementsByName('corret[]');

                for (let i = 0; i < y.length; i++) {
                    y[i].value = 0;

                }
            }else if(op == 1 && document.getElementById('room_type_ref').value != 'true_or_false'){
                let w = document.getElementsByName('corret_ref[]');

                for (let x = 0; x < w.length; x++) {
                    w[x].value = 0;

                }
            }

            if (radio.checked) {

                $(radio).attr("value", "1");

            } else {

                $(radio).attr("value", "0");

            }
        }

        function qrcodebtn(id) {

            $(".qrcode").attr('disabled', true);
            $.get("/admin/virtual/" + id).done(function(data) {

                var parse = JSON.parse(data);

                if (data == "null") {

                    $('#noinfomodal').modal('show');
                    $(".qrcode").attr('disabled', false);

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
                    $(".qrcode").attr('disabled', false);


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





        $('#addPerg').on('hide.bs.modal', function(e) {

            window.location.reload();


        });









        // perfect-scrollbar-on nav-open

        var t = 0;

        function botaomenu() {
            if (t == 0) {

                var overlayer = '<div class="close-layer visible" onclick="deletalayer()"id="divlayer"></div>';

                $('#botaomenu').attr("class", "navbar-toggler toggled");
                $('#abrirmenu').attr("class", "nav-open");
                $('#overlayer').append(overlayer);

                t = 1;


                $('#sidebar').show();


                console.log('é' + t);


            }

            //             else{
            //
            //                $('#botaomenu').attr("class","navbar-toggler");
            //                 $('#abrirmenu').attr("class","");
            //                $('#sidebar').hide();
            //
            //
            //                t = 0;
            //                console.log('não e' + t);
            //
            //             }

        }

        function deletalayer() {

            $('#divlayer').detach();
            $('#botaomenu').attr("class", "navbar-toggler");
            $('#abrirmenu').attr("class", "");

            t = 0;
        }

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });


        $('#editarSalaModal1').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipientnome = button.data('whatevernome');
            var recipientid = button.data('whateverid');
            var recipienttempo = button.data('whatevertempo');
            console.log(recipienttempo);
            var recipienttema = button.data('whatevertema');
            var recipientcorrect = button.data('whateverpublic');
            var recipientenable = button.data('whateverenable');
            var tempo = button.data('tempoo');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('#nome').val(recipientnome);
            modal.find('#time3').val(recipienttempo);
            modal.find('#time4').val(tempo);
            modal.find('#sala_id').val(recipientid);
            modal.find('#theme').val(recipienttema).change();
            console.log(recipientcorrect);
            console.log(recipientenable);

            if (recipientcorrect == 1) {
                $('#public1').prop("checked", true);
                $('#public1').prop("value", 1);
            } else {
                $('#public1').prop("checked", false);
                $('#public1').prop("value", 0);
            }

            if (recipientenable == 1) {
                $('#enable1').prop("checked", true);
                $('#enable1').prop("value", 1);
            } else {
                $('#enable1').prop("checked", false);
                $('#enable1').prop("value", 0);
            }
        });



        $('#editarSalaModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipientnome = button.data('whatevernome');
            var recipientid = button.data('whateverid');
            var recipienttempo = button.data('whatevertempo');
            var recipienttema = button.data('whatevertema');
            var recipientcorrect = button.data('whateverpublic');
            var recipientenable = button.data('whateverenable');
            var tempo = button.data('tempoo');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('#nome').val(recipientnome);
            modal.find('#time3').val(recipienttempo);
            console.log(tempo)
            modal.find('#time4').val(tempo);
            modal.find('#sala_id').val(recipientid);
            modal.find('#theme').val(recipienttema).change();


            if (recipientcorrect == 1) {
                $('#public1').prop("checked", true);
                $('#public1').prop("value", 1);
            } else {
                $('#public1').prop("checked", false);
                $('#public1').prop("value", 0);
            }

            if (recipientenable == 1) {
                $('#enable1').prop("checked", true);
                $('#enable1').prop("value", 1);
            } else {
                $('#enable1').prop("checked", false);
                $('#enable1').prop("value", 0);
            }
        });



        $('#public1').on('click', function() {
            if (this.checked) {
                document.getElementById('public1').value = 1;
            } else {
                document.getElementById('public1').value = 0;
            }

        });

        $('#enable1').on('click', function() {
            if (this.checked) {
                document.getElementById('enable1').value = 1;
            } else {
                document.getElementById('enable1').value = 0;
            }

        });

        function totalresposta(id) {

            var total = 0;

            var cont = 0;
            var cont2 = 0;

            $('#pai').children('.panel2').each(function() {


                var t = $(this).children().length;

                $('.textototalref' + cont2).append(
                    '<p>' + t + '</p>'
                );

                cont2++;
            });

        }


        function totalresposta(id) {
            var total = 0;
            var cont = 0;
            var cont2 = 0;

            $('#pai').children('.panel').each(function() {


                var t = $(this).children().length;

                $('.textototal' + cont).append(
                    '<p>' + t + '</p>'
                );

                cont++;
            });
            $('#pai').children('.panel2').each(function() {


                var t = $(this).children().length;

                $('.textototalref' + cont2).append(
                    '<p>' + t + '</p>'
                );

                cont2++;
            });

        }

    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
    <!--script src="{{asset('js/jquery.ui.touch-punch.min.js')}}" defer></script-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous" defer></script>
    <script src="{{ asset('js/Alunos.js')}}" defer></script>
    <script src="{{ asset('js/caixa.js')}}" defer></script>
    <!--      <script src="{{ asset('js/Perguntas.js')}}" defer></script>-->
</body>

</html>
