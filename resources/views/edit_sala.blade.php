@extends('vendor.menu')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<input type="hidden" value="52" id="num_y">

<div class="modal fade" id="addPerg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog larguramodal" role="document">
        <div class="modal-content">
            <div class="card card-nav-tabs card-plain">
                <div class="card-header card-header-primary">
                    <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                    <div class="container row align-items-center">
                        <div class="col-11">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#perg" data-toggle="tab">Pergunta</a>
                                        </li>
                                        <li id="desabilitar" class="nav-item" style="display:none">
                                            <a class="nav-link" href="#pergReforco" data-toggle="tab">Reforço</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-1">
                            <button type="submit" class="close btnModalClose" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="container ">
                <div class="row align-items-center">
                    <div class="col-6 alert alert-success print-success-msg" style="display: none; position: absolute; z-index: 9999999999999999999999;">
                        <ul style="list-style-type: none"></ul>
                    </div>
                </div>
                <!-- <div class="col-6 alert alert-danger print-error-msg" style="display: none;">
                    <ul></ul>
                </div> -->
            </div>

            <form name="add_name" id="add_name">
                <div class="modal-body">

                    @csrf
                    {{ csrf_field() }}

                    <input type="hidden" value="{{$id}}" name="sala_id">
                    <input type="hidden" value="0" name="perg_reforco" id="perg_reforco">


                    <!-- Pergunta  -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="perg">
                            <div class=" container" style="margin-top: -40px">
                                <div class="card houvercard">
                                    <div class=" container">
                                        <div class="row align-items-center" style="margin-top: 10px;">
                                            <div class="col col-sm-12 col-md-12 col-lg-4">
                                                <input type="hidden" value="0" name="perg_id" id="perg_id">
                                                <label for="pergunta" style=" font-size:  130%; color: black;">Pergunta:</label>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-auto" style="display:inline-block">
                                                <div class="row" style="height:50px;">
                                                    <div class="col-4 col-sm-4" style="height:100%;">
                                                        <label for="question_type" style="margin-right: 3.5px; padding-top:10%;">Tipo da pergunta:</label>
                                                    </div>
                                                    <div class="col-7 col-sm-6 col-md-6 col-lg-7">
                                                        <select class="form-control selectpicker" data-style="btn btn-primary" name="question_type" id="question_type" style="float:left;">
                                                            <option selected value="1">Texto</option>
                                                            <option disabled value="2">Imagem</option>
                                                            <option disabled value="3">Video</option>
                                                            <option disabled value="4">Audio</option>
                                                        </select>
                                                        <div id="tooltip_container"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-2 col-sm-2 col-md-3 col-lg-2" style=" margin-top: 12px;">
                                                        <label for="room_type">Interação:</label>
                                                    </div>
                                                    <div class="col-1 col-sm-1" style="margin-left: 12px; margin-top: 12px;">
                                                        <i class="material-icons info" data-toggle="modal" data-target="#modalinfo" style="cursor: pointer;" title="Informações sobre a Interação">info</i>
                                                    </div>
                                                    <div class="col-8 col-sm-8 col-md-6 col-lg-8">
                                                        <select id="room_type" class="form-control selectpicker room_type" data-style="btn btn-primary" name="room_type">
                                                            <option selected value="right_key">Chave Certa</option>
                                                            <option value="hope_door">Porta da esperança</option>
                                                            <option value="true_or_false">Verdadeiro ou Falso</option>
                                                            <option value="multiple_forms">Multiplas Formas</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="container" style="padding-top:2%">
                                        <!--                                        <br>-->
                                        <div class="textareaborda2" style="display:block;">
                                            <textarea id="pergunta" type="text" name="pergunta" rows="2" cols="50" class=" form-control @error('pergunta') is-invalid @enderror col" placeholder="Faça sua pergunta" maxlength="500" required aria-describeby="perguntaHelp"></textarea>

                                            <small id="perguntaHelp" style="color:red;font-size:10px">(*) CAMPO OBRIGATÓRIO </small>
                                        </div>

                                    </div>


                                       <!--   Ambinete  -->
                                    <label class="col-12" style=" margin-top: 10px;  font-size: 130%; color: black;">Definições do labirinto:</label>
                                    <div class=" container">
                                        <div class="row" style="line-height: 40px; margin-bottom: 10px;">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                                                <input type="hidden" name="path_id" id="path_id">
                                                <div class="row" style="height:50px;">
                                                    <div class="col-2 col-sm-2 col-lg-2" style="height:100%;">
                                                        <label for="answer_boolean" style="margin-right: 3.5px; padding-top:10%;">Caminho do jogo:</label>
                                                    </div>
                                                <div class="col-1 col-sm-1" style="margin-left: 12px; margin-top: 12px;">
                                                    <i class="material-icons info" data-toggle="modal" data-target="#modalinfoCorredor" style="cursor: pointer;" title="Informações sobre a Interação">info</i>
                                                </div>
                                                    <div class="col-7 col-sm-7">
                                                        <select name="answer_boolean" id="answer_boolean" class="form-control selectpicker " data-style="btn btn-primary" style="float:left;">
                                                            <option selected value="1">Corredor</option>
                                                            <option value="2">Labirinto</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-4">

                                                <div class="row" style="height:50px;">
                                                    <div class="col-4 col-sm-4 col-md-3 col-lg-5" style="height:100%;">
                                                        <label for="tamanho" style="margin-right: 3.5px; padding-top:10%;">Altura do Labirinto:</label>
                                                    </div>
                                                     <div class="col-1 col-sm-1" style="margin-left: -30px; margin-top: 12px;">
                                                    <i class="material-icons info" data-toggle="modal" data-target="#modalinfoTamanho" style="cursor: pointer;" title="Informações sobre a Interação">info</i>
                                                     </div>
                                                    <div class="col-7 col-sm-7">
                                                        <select name="tamanho" id="tamanho" class="form-control selectpicker conteudo" data-style="btn btn-primary" style="float:left;">
                                                            <option selected value="1">Pequeno</option>
                                                            <option disabled class="conteudo" value="2">Médio</option>
                                                            <option disabled class="conteudo"  value="3">Grande</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-4">

                                                <div class="row" style="height:50px;">
                                                    <div class="col-4 col-sm-4 col-md-3 col-lg-5" style="height:100%;">
                                                        <label for="largura" style="margin-right: 3.5px; padding-top:10%;">Largura do Labirinto:</label>
                                                    </div>
                                                    <div class="col-1 col-sm-1" style="margin-left: -40px; margin-top: 12px;">
                                                    <i class="material-icons info" data-toggle="modal" data-target="#modalinfoLargura" style="cursor: pointer;" title="Informações sobre a Interação">info</i>
                                                </div>
                                                    <div class="col-7 col-sm-7">
                                                        <select name="largura" id="largura" class="form-control selectpicker" data-style="btn btn-primary" style="float:left;">
                                                            <option selected value="1">Pequeno</option>
                                                            <option disabled class="conteudo"  value="2">Médio</option>
                                                            <option disabled class="conteudo"  value="3">Grande</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <div class=" container" style=" margin-top: -20px;">
                                <div class="card houvercard">
                                    <!--   Resposta -->
                                    <div class=" container" style=" margin-top: 10px;">
                                        <div class="row  align-items-center">
                                            <div class="col col-sm-12 col-md-12 col-lg-8">
                                                <label style=" margin-top: 10px;  font-size: 130%; color: black;">Resposta:&emsp;</label>
                                                <button type="button" name="add" id="add" class="btn btn-success btn-sm"><i class="material-icons">add</i></button>
                                                <small id="Help" class="col" style="color:red;font-size:10px">&emsp;(*) PELO MENOS 2 RESPOSTAS SÃO OBRIGATÓRIAS </small>
                                            </div>

                                            <div class="col-12 col-sm-10 col-md-4">

                                                <div class="row" style="height:70px;">
                                                    <div class="col-5" style="height:100%;">
                                                        <label for="tipo_opcao" style="margin-right: 3.5px; padding-top:15%;">Tipo da Resposta:</label>
                                                    </div>
                                                    <div class="col-7 col-sm-7">
                                                        <select name="tipo_resp" id="tipo_opcao" class="form-control selectpicker " data-style="btn btn-primary" style="float:left;">
                                                            <option selected value="1">Texto</option>
                                                            <option disabled value="2">Imagem</option>
                                                            <option disabled value="3">Vídeo</option>
                                                            <option disabled value="4">Áudio</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dynamic-added montarteste" id="dynamic_field" border="0">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aba do reforco -->

                        <div class="tab-pane" id="pergReforco">
                            <div class="hovereffect">
                                <div class="overlay">
                                    <div class="form-check" style="margin-left:5%; margin-bottom:2%;">
                                        <label class="form-check-label" style="color: #ffff;">

                                            <input class="form-check-input" type="checkbox" id="check-reforco" disabled>
                                            Pergunta Reforço
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="abcd">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary btnModalClose" data-dismiss="modal">Fechar</a>
                    <button name="submit" id="submit" class="btn btn-success" value="submit">Salvar</button>
                </div>
            </form>

        </div>
    </div>
</div>


<div class="container">
    <div class="col-md-12">
        <div class="card">
            <div id="teste2" class="card-header card-header-primary">
                @if($sala->enable==1)
                <h3 class="card-title" style="text-align:center">{{$sala->name}}
                </h3>
                @else
                <h3 class="card-title" style="text-align:center;"><i>{{$sala->name}}<span style="float:right;font-size:20px">Desativada</span></i>
                </h3>
                @endif
                <p class="card-category"></p>
            </div>
            <div class="card-body">
                <div>
                    <div class="row" style="margin-bottom: -35px;">
                        <?php
                        $x = gmdate("H:i:s", $sala->duracao);

                        ?>

                        <div class="col-12 col-md-auto">
                            <a align="right" class="btn btn-primary btn-sm" style="width:100%;" href="{{url('admin/grafico/'.$id)}}">Estatistica</a>
                        </div>

                        @if($sala->public==0)
                        <div class="col-12 col-md-auto">
                            <a class="btn btn-success btn-sm" href="{{url('admin/alunos/'.$sala->id)}}" style="width:100%;"><i class="material-icons">add
                                </i>&emsp;Aluno</a>
                        </div>
                        @endif

                        <div class="col-12 col-md-auto">
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarSalaModal2" data-whateverid="{{$sala->id}}" data-whatevernome="{{$sala->name}}" data-whatevertempo="{{$x}}" data-tempoo="{{$sala->duracao}}" data-whatevertema="{{$sala->tematica}}" data-whateverpublic="{{$sala->public}}" data-whateverenable="{{$sala->enable}}" style="float:right; width:100%;"><i class="material-icons">create</i>&emsp;Editar</button>
                        </div>

                    </div>

                    <hr style="border: 0.5px solid: grey;">

                    <table class="table">
                        <thead class=" text-primary">
                            <th>
                                Tempo de duração (em minutos)
                            </th>
                            <th>
                                Tema
                            </th>
                            <th>
                                Tipo
                            </th>
                            <th>
                                Ativa
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{$x}}
                                </td>
                                <td>
                                    @if($sala->tematica=="icy_maze")
                                        Gelo
                                    @elseif($sala->tematica=="cave")
                                        Caverna
                                    @elseif($sala->tematica=="desert")
                                        Deserto
                                    @elseif($sala->tematica=="forest")
                                        Floresta
                                    @elseif($sala->tematica=="mansion")
                                        Casa/Mansão
                                    @elseif($sala->tematica=="urban")
                                        Urbano
                                    @endif
                                </td>
                                <td>
                                    @if($sala->public==0)
                                    Privada
                                    @else
                                    Pública
                                    @endif
                                </td>
                                <td>
                                    @if($sala->enable==0)
                                    Não
                                    @else
                                    Sim
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <br>
                <br>
                <div class="row" style="margin-bottom: -35px;">
                    <div class="col-12 col-md-auto">
                        <button type="button" align="right" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#alteraModal" style="width:100%;">Sequência</button>
                    </div>

                    <div class="col-12 col-md-auto">
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addPerg" style="width:100%;"><i class="material-icons">add
                            </i>&emsp;Pergunta</button>
                    </div>


                    <div class="col-12 col-md-auto">

                        <button type="button" class="col-12 btn btn-warning btn-sm  fa fa-qrcode qrcode" id="{{$sala->id}}" value="{{$sala->id}}" onclick="qrcodebtn({{$sala->id}});">&emsp;Qr Code</button>

                    </div>
                </div>

                <hr style="border: 0.5px solid: grey;">

                <?php $x = 1;
                $y = 0;
                $letras = array("a)", "b)", "c)", "d)"); ?>

                <table class="table">
                    <thead class=" text-primary">
                        <th>
                            Perguntas
                        </th>
                        <th>

                        </th>
                        <th>
                            <div style="float:right;"> Ações </div>
                            <div style="float:right; margin-right: 10%;"> Resposta </div>

                        </th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!------- Estrutura de repetição (CARD)------------------->

                <div id="pai">
                    <?php
                    $cont = 0;
                    $cont2 = 0;
                    ?>

                    @foreach($data as $item)


                    <?php $errado = 0; ?>
                    @foreach($path_perg as $pp)
                    @if($pp->perg_id==$item->id)

                    @foreach($paths as $path)
                    @if($path->id==$pp->path_id)

                    @if($path->disp == 1)
                    <!--
                                                 <button type="button" class="btn btn-outline-info fa fa-pencil tamanhobutton" data-toggle="modal" data-target="#addPerg" data-whatever="{{$item->id}}"title="Editar pergunta"></button>&emsp;&emsp;
                                                  <a href="{{ url('admin/deletar-pergunta/'.$item->id) }}" class="btn btn-outline-danger fa fa-trash tamanhobutton"></a>
                     -->

                    <div id="flip">
                        <div class="row align-items-center" style="cursor: pointer;">
                            <div class="col col-sm-10 container" onclick="abrir('panel'+{{$item->id}});" style="padding-left: 25px;">
                                <?php
                                $str2 = $item->pergunta;
                                $total1 = strlen($str2);
                                ?>
                                @if($total1 > 80)
                                <div id="div2" data-toggle="tooltip" data-placement="top" title="{{$item->pergunta}}">{{$item->pergunta}}</div>
                                @else
                                <div>{{$item->pergunta}}</div>
                                @endif
                            </div>

                            <div class="col-2 col-sm-1  textototal{{$cont}}" style="padding-left: 8px;">

                            </div>
                            <div class="col-2 col-sm-1">
                                <a class="nav-link" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float: right;">
                                    <i id="teste" class="material-icons">more_vert</i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="">
                                    <a class="dropdown-item" data-toggle="modal" data-target="#addPerg" data-whatever="{{$item->id}}">Editar</a>
                                    <!--                                    <a class="dropdown-item" onclick="(confirm('Você realmente deseja deletar a pergunta: \'{{$item->pergunta}}\'? ')) ? window.location.href =  '{{ url('admin/visualizar/deletar-pergunta/'.$item->id) }}' : window.location.reload(forcedReload);">Excluir</a>-->
                                    <a data-toggle="modal" data-target="#removerPerguntaModal" data-id="{{$item->id}}" data-pergunta="{{$item->pergunta}}" class="dropdown-item" id="{{'perg'.$item->id}}">Excluir</a>
                                </div>
                            </div>
                            <div class="container col-sm-1 " onclick="abrir('panel'+{{$item->id}});" style="margin-top: -10px;">
                                <a style="margin-left: 50%;"><img src="{{asset('img/expand-button.png')}}" width="8px"></a>
                            </div>
                        </div>
                    </div>

                    <?php $cont++; ?>
                    @endif
                    @endif
                    @endforeach
                    @endif
                    @endforeach


                    <?php $y = 0; ?>

                    <div class="panel" id="panel{{$item->id}}">
                        @foreach($respostas as $resposta)
                        @foreach($perg_resp as $pergresp)
                        @if($pergresp->perg_id==$item->id)
                        @if($pergresp->resp_id==$resposta->id)

                        <div class="row">
                            <h5><?php echo $letras[$y]; ?></h5>
                            <div class="col totalresposta" style=" margin-top: -5px;">
                                <p style="font-size: 120%; line-height: 30px;">{{$resposta->resposta}}</p>
                            </div>
                        </div>
                        <?php $y++; ?>

                        @endif
                        @endif
                        @endforeach
                        @endforeach
                    </div>

                    <?php $y = 0; ?>

                    @foreach($perg_refs as $perg_ref)
                    @if($perg_ref->perg_id==$item->id)
                    @foreach($refs as $ref)
                    @if($ref->id==$perg_ref->ref_id)

                    @foreach($path_perg as $pp)
                    @if($pp->perg_id==$ref->id)
                    <!--                    <input value="{{$pp->perg_id}}"><br><br>-->
                    @foreach($paths as $path)
                    @if($path->id==$pp->path_id)
                    <!--                    <input value="{{$path->id}}"><br><br>-->

                    <div id="flip2">
                        <!-- <div id="texto" style="color: black">Reforço da pergunta {{$item->pergunta}}</div> -->
                        <div class="row align-items-center" style="cursor: pointer;">

                            <i class="material-icons info" data-toggle="tooltip" data-placement="left" title="Reforço da pergunta {{$item->pergunta}}" style="margin-left: 10px;">info</i>

                            <div class="col col-sm-9 container" onclick="abrir('panel'+{{$ref->id}});" style="margin-left: -3px;">
                                <?php
                                $str = $ref->pergunta;
                                $total = strlen($str);
                                ?>
                                @if($total > 50)
                                <div id="div2" data-toggle="tooltip" data-placement="top" title="{{$ref->pergunta}}">{{$ref->pergunta}}</div>
                                @else
                                <div>{{$ref->pergunta}}</div>
                                @endif
                            </div>
                            <div class="col-2 col-sm-1 textototalref{{$cont2}}">

                            </div>

                            <div class="col-2 col-sm-1">

                                <a  class="nav-link " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float: right;margin-right:-10px; display: none; ">

                                    <i  id="teste" class="material-icons">more_vert</i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="">

                                    <!--                                    <a class="dropdown-item" onclick="(confirm('Você realmente deseja deletar a pergunta reforço: \'{{$ref->pergunta}}\'? ')) ? window.location.href =  '{{ url('admin/visualizar/deletar-pergunta/'.$ref->id) }}' : window.location.reload(forcedReload)">Excluir</a>-->
                                    <a data-toggle="modal" data-target="#removerPerguntaModal" data-id="{{$ref->id}}" data-pergunta="{{$ref->pergunta}}" class="dropdown-item" id="{{'perg'.$ref->id}}">Excluir</a>
                                </div>
                            </div>
                            <div class="container col-sm-1 " style="margin-top: -10px;" onclick="abrir('panel'+{{$ref->id}});">
                                <a style="margin-left: 50%;"><img src="{{asset('img/expand-button.png')}}" width="8px"></a>
                            </div>
                        </div>
                    </div>
                    <?php $cont2++; ?>
                    @endif
                    @endforeach
                    @endif
                    @endforeach

                    <div class="panel2" id="panel{{$ref->id}}">
                        @foreach($respostas as $resposta)
                        @foreach($perg_resp as $pergresp)
                        @if($pergresp->perg_id==$ref->id)
                        @if($pergresp->resp_id==$resposta->id)
                        <div class="row">
                            <h5><?php echo $letras[$y]; ?></h5>
                            <div class="col" style=" margin-top: -5px;">
                                <p style="font-size: 120%; line-height: 30px;">{{$resposta->resposta}}</p>
                            </div>
                        </div>
                        <?php $y++; ?>
                        @endif
                        @endif
                        @endforeach
                        @endforeach
                    </div>
                    @endif
                    @endforeach
                    @endif
                    @endforeach
                    <hr style="border: 0.8px solid #afafaf;">

                    @endforeach
                </div>
                <div class="container">
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </div>
</div>





<div class="modal fade bd-example-modal-lg" id="editarSalaModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edição de Sala</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('admin/sala') }}" method="POST" style="margin-left: 5%;margin-right:1%;margin-top:3%">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_prof" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="sala_id" id="sala_id" value="0">
                    <input type="hidden" value="1" id="page" name="page">
                    <div class="form-group">
                        <label for="nome" display="inline">Nome da Sala:</label>
                        <input type="text" name="nome" id="nome" class="form-control has-feedback {{ $errors->has('nome') ? 'has-error bg-primary' : '' }}">

                        @if ($errors->has('nome'))
                        <div class="help-block">
                            {{ $errors->first('nome') }}
                        </div>
                        @endif

                    </div>
                    <div class="form-group" style="margin-top:3.5%">
                        <label for="time" display="inline">Tempo de Duração de cada sala (em minutos):</label>
                        <input type="time" name="time3" id="time3" step='1' class="form-control" min="00:00:00" max="01:00:00" onblur="transforma(this.value,1);">
                        <input type="hidden" name="time4" id="time4" class="form-control">

                    </div>

                    <div class="form-row">
                        <div class="form-group col" style="height:100%;">
                            <i class="material-icons info align-middle" data-toggle="modal" data-target="#modalinfoSala" style="cursor: pointer;" title="Informações sobre a Interação">info</i>
                            <label for="theme">Tema:&emsp;</label>
                            <select id="theme" name="theme" class="form-control selectpicker" data-style="btn btn-primary">
                                <option value="icy_maze">Gelo</option>
                                <option value="cave">Caverna</option>
                                <option value="desert">Deserto</option>
                                <option value="forest">Floresta</option>
                                <option value="mansion">Casa/Mansão</option>
                                <option value="urban">Urbano</option>
                            </select>

                        </div>
                        <div class="form-group col">
                            <div class="form-check" style="margin-left:10%;margin-top:17%">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="public1" id="public1">Sala Pública
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group col">
                            <div class="form-check" style="margin-top:17%">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="enable1" id="enable1">Ativo
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary btnModalClose" data-dismiss="modal">Fechar</a>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="alteraModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel"></h4>
            </div>
            <form>
                {{ csrf_field() }}
                <input type="hidden" value="{{$id}}" name="sala_id" id="sala_id">
                <div class="modal-body">
                    <ul id="sortable" class="sortable" style="list-style-type: none;">
                        @foreach($data as $item)
                        <li class="ui-state-default" value="{{$item->id}}">{{$item->pergunta}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary btnModalClose" data-dismiss="modal">Fechar</a>
                    <button type="button" class="btn btn-success altera" id="altera" name="altera">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="qrmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content ">
            <div class="modal-header" style="background-color:#4D226D;">
                <h5 class="modal-title"></h5>
                <h5 style="  font-size: 20px; color:#ffffff;">Qr Code </h5>
            </div>

            <div class="modal-body">
                <h5 id="nomeqrsala">Nome: </h5>
                <input id="hiddenid" type="hidden" value="">

                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" id="corouselimg">
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


<!----------------- Fim Modal ------------------->


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


<div id="modalinfo" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9124a3">
                <h4 class="modal-title" style="color: #ffffff;">Informação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>A interação define como o problema é apresentado. Algumas mecânicas restringem outras opções como ter ou não sala de reforço.</b></h5>
                <br>
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Chave Certa</b></h5>
                <p style="font-size: 12px; text-align: justify;">Diversas Chave Certas, mas só uma abrirá a porta no final do corredor. Não é possível colocar sala de reforço nessa sala.</p>
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Posta da Esperaça</b></h5>
                <p style="font-size: 12px; text-align: justify;">Há 3 portas de saída, 3 chaves. Mas só uma delas é a resposta certa, as outras levam a um reforço de conteúdo. Sala de reforço é obrigatória.</p>
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Verdadeiro ou Falso</b></h5>
                <p style="font-size: 12px; text-align: justify;">Uma sala com diversas alavancas e um botão, cada alavanca está associada a uma das alternativas à pergunta e o botão valida se a resposta está correta. Mais de uma alternativa pode estar correta ao mesmo tempo. Não é possível colocar sala de reforço nessa sala.</p>
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Multiplas Formas</b></h5>
                <p style="font-size: 12px; text-align: justify;">Diversos objetos e um "altar" para verificar se a forma escolhida representa a alternativa correta. Não é possível colocar sala de reforço nessa sala.</p>
            </div>
        </div>
    </div>
</div>

<div id="modalinfoCorredor" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9124a3">
                <h4 class="modal-title" style="color: #ffffff;">Informação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Corredor</b></h5>
                <p style="font-size: 12px; text-align: justify;">Caminho reto ligado uma pergunta à outra, sem escolhas. Não é possível configurar o tamanho.</p>
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Labirinto</b></h5>
                <p style="font-size: 12px; text-align: justify;">Caminho com bifurcações e caminhos sem saída ligando uma pergunta a outra.</p>
            </div>
        </div>
    </div>
</div>

<div id="modalinfoTamanho" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9124a3">
                <h4 class="modal-title" style="color: #ffffff;">Informação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Determina o quão Altura do caminho que o jogador irá passar. Só é possível configurar o tamanho para caminhos do tipo Labirinto.</b></h5>

            </div>
        </div>
    </div>
</div>

<div id="modalinfoLargura" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9124a3">
                <h4 class="modal-title" style="color: #ffffff;">Informação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Determina o quão longa ou cheia de bifurcações será a ligação entre uma sala e outra. Só é possível configurar o tamanho para caminhos do tipo Labirinto.</b></h5>

            </div>
        </div>
    </div>
</div>

<div id="modalinfoErrado" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9124a3">
                <h4 class="modal-title" style="color: #ffffff;">Informação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Determina o caminho pelo qual o jogador deverá passar para chegar a pergunta reforço.</b></h5>

            </div>
        </div>
    </div>
</div>



<!--    CONFIRMAÇÃO DELETAR ALUNO-->
<div class="modal fade bd-example-modal-sm" id="removerPerguntaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloPergModal">Você realmente deseja remover a pergunta desta sala?</h5>
                <button style="color:black" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row align-self-center">
                    <button type="button" id="fecharModal" data-dismiss="modal" class="btn btn-secundary col">Cancelar</button>
                    <a class="btn col btn-primary larcom" id="confirmarRemoverPergunta">Confirmar</a>
                </div>
            </div>

        </div>
    </div>
</div>



<div id="modalinfoSala" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9124a3">
                <h4 class="modal-title" style="color: #ffffff;">Informação</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Este tema determina a estética utilizada para mostrar o problema aos jogadores, nenhuma mecânica é influenciada por essa escolha.</b></h5>

                <br>
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Gelo</b></h5>
                <p style="font-size: 12px; text-align: justify;">O labirinto é formado por uma geleira, com quadro para os textos de pergunta e resposta e suporte para os itens todos lapidados em blocos de gelo.</p>
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Caverna</b></h5>
                <p style="font-size: 12px; text-align: justify;">O labirinto possui uma estética mais fechada e com paredes rochosas. O jogador passará pode diversos desafios com perguntas e respostas.</p>
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Deserto</b></h5>
                <p style="font-size: 12px; text-align: justify;">O labirinto possui uma estética mais egipcia, passando por passagens com paredes pintadas com símbolos, remetendo a um interior de um templo. O jogador passará pode diversos desafios com perguntas e respostas.</p>
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Floresta</b></h5>
                <p style="font-size: 12px; text-align: justify;">O labirinto possui ambientação harmônica com foco na natureza cheio de paredes e objetos rochosos com musgos. O jogador passará pode diversos desafios com perguntas e respostas.</p>
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Casa/Mansão</b></h5>
                <p style="font-size: 12px; text-align: justify;">Labirinto com uma estética simples e limpa, onde o jogador poderá aproveitar o ambiente para se sentir em uma casa cheio de quadros artísticos. O jogador passará pode diversos desafios com perguntas e respostas.</p>
                <h5 class="modal-title" style="color: black; font-size: 13px"><b>Urbano</b></h5>
                <p style="font-size: 12px; text-align: justify;">O labirinto possui uma ambientação de um centro de uma cidade, com algumas variações de paredes ( com posteres e rachaduras). O jogador passará pode diversos desafios com perguntas e respostas.</p>
            </div>
        </div>
    </div>
</div>






@endsection
