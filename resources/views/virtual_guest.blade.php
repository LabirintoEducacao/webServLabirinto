@extends('layouts.app')

@section('content')
<!------------------------ Cabeçalho ------------------------>
<div class="container-fluid">
    <form class="form-inline mr-auto" action="{{ url('/buscar') }}" method="POST">
        @csrf
        <input class="form-control mr-sm-2" type="text" placeholder="Buscar" aria-label="Search" name="buscar" id="buscar">
        <button class="btn btn-outline-info" type="submit">Buscar</button>
    </form>
    <form class="form-inline mr-auto" action="/api/virtual" method="POST">
        @csrf
        <input class="form-control mr-sm-2" type="text" placeholder="ID" aria-label="Search" name="id" id="buscar">
        <button class="btn btn-outline-info" type="submit">teste</button>
    </form>
</div>
@if (session('status'))
<div class="alert alert-warning" role="alert">
    {{ session('status') }}
</div>
@endif
<!------------------------ Espaço das Salas  --------------------------->
<div class="container-fluid" style="padding-top: 10px; margin: 2% 2% 2% 2%">


    <!------- Estrutura de repetição (CARD)------------------->
    @foreach($data as $item)
    <?php $id=$item->id ?>

    <div class="col-md-3" style="padding-top:20px;" display="inline">
        <div class="card ">

            <p class="card-title">
                <h3 align="center">{{$item->name}}</h3>
            </p>

            <img src=" {{ asset('img/1.jpg')}} " style="width:100%; margin-bottom: 10px; " alt="imagen labirinto">

        <button type="button" class="btn btn-warning btn-sm  fa fa-qrcode" id="{{$item->id}}" value="{{$item->id}}" onclick="qrcodebtn({{$item->id}});">Qr Code</button>



            <!----------------------Botao do Modal-------------------------->

           <!--  <button type="button" class="btn btn-outline-cyan btn-sm fa fa-qrcode" data-toggle="modal" data-target="#salaModal" data-whatever="{{$item->id}}" data-whatevernome="{{$item->name}}"> Qr Code</button> -->


        </div>
    </div>
    @endforeach

<div class="modal fade" id="qrmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content " >
            <div class="modal-header" style="background-color:#4D226D;">
                <h5 class="modal-title"></h5>
                <h5 style="  font-size: 20px; color:#ffffff;" >Qr Code </h5>
            </div>
            
            <div class="modal-body">
                <h5 id="nomeqrsala">Nome: </h5>
                <input id="hiddenid" type="hidden" value="">

                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" id="corouselimg" >   
                    </div>

                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Próximo</span>
                    </a>
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="noinfomodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content ">
            <div class="modal-header" style="background-color:#4D226D;">
                <h5 class="modal-title"></h5>
                <h5 style="  font-size: 20px;color:#ffffff;" id="exampleModalScrollableTitle">Qr Code </h5>
            </div>
            <div class="modal-body">
                <h4 style="color: purple;"> Não existe QrCode para este labirinto, verifique se existem perguntas ou se as alterações do labirinto foram salvas.</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar </button>
            </div>
        </div>
    </div>
</div>




    @endsection
