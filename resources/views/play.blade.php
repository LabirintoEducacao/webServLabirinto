<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="js/all.js"></script>


    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            right: 10px;
            top: 18px;
        }

        .top-left {
            left: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 56px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        @media (max-width: 760px) {
            .logins{
                margin: 2% 14% 2% 4%;
            }
            .title{

                display: none;
            }
            .mobile-hide{

                display: none;
            }
        }

    </style>
</head>
<body>



<div class="container position-ref full-height">
    <div class="row" style="margin-top: 16px; margin-bottom: 16px">
        <div class="links col-md-3">
            <a href="{{ url('/') }}">Labirinto</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 title m-b-md justify-content-center" style="margin-top: 7%; text-align: center">
            Labirinto da Educação
        </div>
    </div>

    <div class="row content justify-content-center logins">
        <div class="col-md-3 col-sm-12" style="margin-bottom: 16px">
            <div class="card border-info">
                <div class="card-body text-info">
                    <i class="fas fa-gamepad fa-10x" style="width: 80%; color: #636b6f; margin: 8px"></i>
                    <div class="card-text links">
                        <a href="{{ url('jogo/web/') }}">Jogar</a><br>
                        <br/>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-12" style="margin-bottom: 16px">
            <div class="card border-info">
                <div class="card-body text-info">
                    <i class="fab fa-android fa-10x" style="width: 80%; color: #636b6f; margin: 8px"></i>
                    <div class="card-text links">
                        <a href="{{ url('jogo/android/labirinto.apk') }}">Baixar</a><br>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
