<!DOCTYPE html>
<html>
    <head>
    
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
        
        <link href="css/buttons.css" rel="stylesheet">
        
        <meta charset="utf-8">
    
    
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
                            <p>Para participar da sala {{$sala}} do(a) Professor(a) {{$prof}}, basta clicar no link abaixo:</p>
                            <p class="botao">
                                <a href="{{ url('usuario/login') }}">
                                <button style="color: #fff;background-color: #17a2b8;border-color: #17a2b8; border-radius: 7px; height:37px">Participar da sala</button>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>