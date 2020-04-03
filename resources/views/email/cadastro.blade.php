<!DOCTYPE html>
<html>

<head>

    <!--        BOOTSTRAP-->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">

    <link href="css/buttons.css" rel="stylesheet">

    <meta charset="utf-8">
    <!--
        <style>
            
            body{
                background-color: #ffffff;
                color: #4a4a4a;
                font-family: 'Raleway', sans-serif;
                font-weight: 200;
                font-size: 18px;
                margin: 0;
                align-self: center;
            }
            
            
            .card-header{
                background-color: #f8fafc;
                height: 76px;
                color: #636b6f;
                width: 604px;
                padding:25px 0;
                text-align:center;
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

            .btn-outline-info:focus, .btn-outline-info.focus {
              box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.5);
            }

            .btn-outline-info.disabled, .btn-outline-info:disabled {
              color: #17a2b8;
              background-color: transparent;
            }

            .btn-outline-info:not(:disabled):not(.disabled):active, .btn-outline-info:not(:disabled):not(.disabled).active,
            .show > .btn-outline-info.dropdown-toggle {
              color: #fff;
              background-color: #17a2b8;
              border-color: #17a2b8;
            }

            .btn-outline-info:not(:disabled):not(.disabled):active:focus, .btn-outline-info:not(:disabled):not(.disabled).active:focus,
            .show > .btn-outline-info.dropdown-toggle:focus {
              box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.5);
            }
        </style>
-->
</head>

<body>
    <div class="container" style="background-color: #ffffff;color: #4a4a4a;font-family: 'Raleway', sans-serif;font-weight: 200;font-size: 18px;margin: 0;align-self: center; width:100%">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-color: #f8fafc;height: 70px;color: #636b6f;width: 604px;padding:25px 0;text-align:center;">Labirinto</div>

                    <div class="card-body">
                        <br>
                        <p>Olá, </p>
                        <p>Para se cadastrar e participar da sala {{$sala->name}} do(a) Professor(a) {{$prof}}, basta clicar no link abaixo:</p>
                        <p class="botao">
                            <a href="{{ url('usuario/cadastro/'.$email.'/'.$sala->id) }}">
                                <button style="color: #fff;background-color: #17a2b8;border-color: #17a2b8; border-radius: 7px; height:37px">Cadastro Labirinto</button>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
