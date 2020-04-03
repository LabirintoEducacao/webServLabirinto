@extends('vendor.menu')

@section('content')





<!------------------------ Espaço das Salas  --------------------------->

<?php $user = Auth::user()->id;
$flag =0;
?>

<?php $linha = 0; $flag = 0; $flag_sala =0; $flag_salap =0;
?>





<div class="container">
    <div class="col-md-12">
        <div class="card">

            <div class="card-header card-header-tabs card-header-primary ">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">

                        <h4 class="nav-tabs-title col-md-3">
                            Espaço Virtual 
                        </h4>
                    

                        <ul class="nav nav-tabs" id="menu" data-tabs="tabs" style="float:right;">
                            <li class="nav-item">
                                <a class="nav-link active" id="mtodos" href="#todos" data-toggle="tab">
                                    <!--                            <i class="material-icons">bug_report</i>-->
                                    Todas
                                    <div class="ripple-container"></div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="mativas" href="#ativas" data-toggle="tab">
                                    <!--                            <i class="material-icons">code</i>-->
                                    Ativadas
                                    <div class="ripple-container"></div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link "  id="mdesativas" href="#desativadas" data-toggle="tab">
                                    <!--                            <i class="material-icons">cloud</i>-->
                                    Desativadas
                                    <div class="ripple-container"></div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"  id="mpublicas" href="#publicas" data-toggle="tab">
                                    <!--                            <i class="material-icons">code</i>-->
                                    Públicas
                                    <div class="ripple-container"></div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"  id="mprivadas" href="#privadas" data-toggle="tab">
                                    <!--                            <i class="material-icons">code</i>-->
                                    Privadas
                                    <div class="ripple-container"></div>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="tab-content">


                    <div class="tab-pane  table-responsive active" id="todos">
                        <table class="table">
                            <thead class=" text-primary">
                                <th>Nome</th>
                                <th>Tematica</th>
                                <th>Tempo</th>
                                <th>Tipo</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <?php
                                            $x = gmdate("H:i:s", $item->duracao);
                                            
                                        ?>
                                @if($item->public == 0)
                                @foreach($sala_user as $sala)
                                @if($item->id==$sala->sala_id)
                                @if($user == $sala->user_id)

                                @if($item->enable == 0)
                                <tr id="sala" style="cursor: pointer; background-color:rgba(229, 229, 229, 0.4);">
                                @else
                                <tr id="sala" style="cursor: pointer;">
                                @endif
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @if($item->tematica=="urban")
                                        Urbano
                                        @elseif($item->tematica=="mansion")
                                        Casa/Mansão
                                        @elseif($item->tematica=="icy_maze")
                                        Gelo
                                        @else
                                        Selva
                                        @endif
                                    </td>
                                    <td>{{ $x }}</td>
                                    <td>
                                        @if($item->public==0)
                                        Privada
                                        @else
                                        Pública
                                        @endif
                                    </td>
                                    <td>
<!--                                        <a href="" class="btn btn-primary btn-sm"> Estatisticas</a>-->
                                        @if($item->enable==1)

                                         <button type="button" class="btn btn-info btn-sm  fa fa-qrcode qrcode" id="{{$item->id}}" value="{{$item->id}}"  onclick="qrcodebtn({{$item->id}});"> Qr Code</button>

                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endif

                                @endforeach
                                @else
                                @if($item->enable == 0)
                                <tr id="sala" style="cursor: pointer; background-color:rgba(229, 229, 229, 0.4);">
                                @else
                                <tr id="sala" style="cursor: pointer;">
                                @endif
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @if($item->tematica=="urban")
                                        Urbano
                                        @elseif($item->tematica=="mansion")
                                        Casa/Mansão
                                        @elseif($item->tematica=="icy_maze")
                                        Gelo
                                        @else
                                        Selva
                                        @endif
                                    </td>
                                    <td>{{ $x }}</td>
                                    <td>
                                        @if($item->public==0)
                                        Privada
                                        @else
                                        Pública
                                        @endif
                                    </td>
                                    <td>
<!--                                        <a href="" class="btn btn-primary btn-sm"> Estatisticas</a>-->
                                        @if($item->enable==1)

                                        <button type="button" class="btn btn-info btn-sm  fa fa-qrcode qrcode" id="{{$item->id}}" value="{{$item->id}}"  onclick="qrcodebtn({{$item->id}});"> Qr Code</button>


                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    
                    
                    <div class="tab-pane table-responsive" id="ativas">
                        <table class="table">
                            <thead class=" text-primary">
                                <th>Nome</th>
                                <th>Tematica</th>
                                <th>Tempo</th>
                                <th>Tipo</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <?php
                                            $x = gmdate("H:i:s", $item->duracao);
                                            
                                        ?>
                                @if($item->enable==1)
                                @if($item->public == 0)
                                @foreach($sala_user as $sala)
                                @if($item->id==$sala->sala_id)
                                @if($user == $sala->user_id)
                                
                                <tr id="sala" style="cursor: pointer;">
                         
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @if($item->tematica=="urban")
                                        Urbano
                                        @elseif($item->tematica=="mansion")
                                        Casa/Mansão
                                        @elseif($item->tematica=="icy_maze")
                                        Gelo
                                        @else
                                        Selva
                                        @endif
                                    </td>
                                    <td>{{ $x }}</td>
                                    <td>
                                        @if($item->public==0)
                                        Privada
                                        @else
                                        Pública
                                        @endif
                                    </td>
                                    <td>
<!--                                        <a href="" class="btn btn-primary btn-sm"> Estatisticas</a>-->

                                        <button type="button" class="btn btn-info btn-sm  fa fa-qrcode qrcode" id="{{$item->id}}" value="{{$item->id}}"  onclick="qrcodebtn({{$item->id}});"> Qr Code</button>

                                    </td>
                                </tr>
                                @endif
                                @endif

                                @endforeach
                                @else
                                <tr id="sala" style="cursor: pointer;">
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @if($item->tematica=="urban")
                                        Urbano
                                        @elseif($item->tematica=="mansion")
                                        Casa/Mansão
                                        @elseif($item->tematica=="icy_maze")
                                        Gelo
                                        @else
                                        Selva
                                        @endif
                                    </td>
                                    <td>{{ $x }}</td>
                                    <td>
                                        @if($item->public==0)
                                        Privada
                                        @else
                                        Pública
                                        @endif
                                    </td>
                                    <td>
<!--                                        <a href="" class="btn btn-primary btn-sm"> Estatisticas</a>-->

                                       <button type="button" class="btn btn-info btn-sm  fa fa-qrcode qrcode" id="{{$item->id}}" value="{{$item->id}}"  onclick="qrcodebtn({{$item->id}});"> Qr Code</button>

                                    </td>
                                </tr>
                                @endif
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    
                    
                                        
                    <div class="tab-pane table-responsive" id="desativadas">
                        <table class="table">
                            <thead class=" text-primary">
                                <th>Nome</th>
                                <th>Tematica</th>
                                <th>Tempo</th>
                                <th>Tipo</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <?php
                                            $x = gmdate("H:i:s", $item->duracao);
                                            
                                        ?>
                                @if($item->enable==0)
                                @if($item->public == 0)
                                @foreach($sala_user as $sala)
                                @if($item->id==$sala->sala_id)
                                @if($user == $sala->user_id)
                                
                                <tr scope="row" id="sala" style="cursor: pointer; background-color:rgba(229, 229, 229, 0.4);">
                         
                                    <td>{{$item->name}}</td>
                                    <td>
                                       @if($item->tematica=="urban")
                                        Urbano
                                        @elseif($item->tematica=="mansion")
                                        Casa/Mansão
                                        @elseif($item->tematica=="icy_maze")
                                        Gelo
                                        @else
                                        Selva
                                        @endif
                                    </td>
                                    <td>{{ $x }}</td>
                                    <td>
                                        @if($item->public==0)
                                        Privada
                                        @else
                                        Pública
                                        @endif
                                    </td>
                                    <td>
<!--                                        <a href="" class="btn btn-primary btn-sm"> Estatisticas</a>-->

                                    </td>
                                </tr>
                                @endif
                                @endif

                                @endforeach
                                @else
                                <tr scope="row" id="sala" style="cursor: pointer; background-color:rgba(229, 229, 229, 0.4);">
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @if($item->tematica==1)
                                        Deserto
                                        @elseif($item->tematica==2)
                                        Cidade Abandonada
                                        @elseif($item->tematica==3)
                                        Casa
                                        @else
                                        Floresta
                                        @endif
                                    </td>
                                    <td>{{ $x }}</td>
                                    <td>
                                        @if($item->public==0)
                                        Privada
                                        @else
                                        Pública
                                        @endif
                                    </td>
                                    <td>
<!--                                        <a href="" class="btn btn-primary btn-sm"> Estatisticas</a>-->

                                    </td>
                                </tr>
                                @endif
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    
                    
                    


                    <!---------------------------------------------------------------------->

                    <div class="tab-pane table-responsive" id="publicas">
                        <table class="table">
                            <thead class=" text-primary">
                                <tr>
                                    <th> Nome </th>
                                    <th> Tematica </th>
                                    <th> Tempo </th>
                                    <th> Tipo </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($data as $item)
                                <?php
                                            $x = gmdate("H:i:s", $item->duracao);
                                            
                                        ?>
                                @if($item->public == 1)
                                @if($item->enable == 0)
                                <tr scope="row" id="sala" style="cursor: pointer; background-color:rgba(229, 229, 229, 0.4);">
                                @else
                                <tr id="sala" style="cursor: pointer;">
                                @endif
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @if($item->tematica==1)
                                        Deserto
                                        @elseif($item->tematica==2)
                                        Cidade Abandonada
                                        @elseif($item->tematica==3)
                                        Casa
                                        @else
                                        Floresta
                                        @endif
                                    </td>
                                    <td>{{ $x }}</td>
                                    <td>Pública</td>
                                    <td>
<!--                                        <a href="" class="btn btn-primary btn-sm"> Estatisticas</a>-->
                                        @if($item->enable==1)
                                        <button type="button" class="btn btn-info btn-sm  fa fa-qrcode qrcode" id="{{$item->id}}" value="{{$item->id}}"  onclick="qrcodebtn({{$item->id}});"> Qr Code</button>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <!---------------------------------------------------------------------->

                    <div class="tab-pane table-responsive" id="privadas">
                        <table class="table">
                            <thead class=" text-primary">
                                <th> Nome </th>
                                <th> Tematica </th>
                                <th> Tempo </th>
                                <th> Tipo </th>
                                <th> </th>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <?php
                                            $x = gmdate("H:i:s", $item->duracao);
                                            
                                        ?>
                                @foreach($sala_user as $sala)
                                @if($item->id==$sala->sala_id)
                                @if($user == $sala->user_id)
                                @if($item->public == 0)
                                @if($item->enable == 0)
                                <tr scope="row" id="sala" style="cursor: pointer; background-color:rgba(229, 229, 229, 0.4);" class="qrcode">
                                @else
                                <tr id="sala" style="cursor: pointer;" class="qrcode">
                                @endif
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @if($item->tematica==1)
                                        Deserto
                                        @elseif($item->tematica==2)
                                        Cidade Abandonada
                                        @elseif($item->tematica==3)
                                        Casa
                                        @else
                                        Floresta
                                        @endif
                                    </td>
                                    <td>{{ $x }}</td>
                                    <td>Privada</td>
                                    <td>
<!--                                        <a href="" class="btn btn-primary btn-sm">Estatisticas</a>-->
                                        @if($item->enable==1)
                                        <button type="button" class="btn btn-info btn-sm  fa fa-qrcode qrcode" id="{{$item->id}}" value="{{$item->id}}"  onclick="qrcodebtn({{$item->id}});"> Qr Code</button>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endif
                                @endif
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





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
