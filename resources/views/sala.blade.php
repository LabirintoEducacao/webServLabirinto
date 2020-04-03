@extends('vendor.menu')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <h4 class="nav-tabs-title">
                                Controle de Salas
                                <button type="button" class="btn btn-info btn-just-icon" data-toggle="modal" data-target="#addSalaModal">
                                    <i class="material-icons">add</i>
                                </button>
                            </h4>
                            <ul class="nav nav-tabs" data-tabs="tabs" style="float:right;">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#todos" data-toggle="tab">
                                        <!--                            <i class="material-icons">bug_report</i>-->
                                        Todas
                                        <div class="ripple-container"></div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#ativas" data-toggle="tab">
                                        <!--                            <i class="material-icons">code</i>-->
                                        Ativadas
                                        <div class="ripple-container"></div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#desativadas" data-toggle="tab">
                                        <!--                            <i class="material-icons">cloud</i>-->
                                        Desativadas
                                        <div class="ripple-container"></div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#publicas" data-toggle="tab">
                                        <!--                            <i class="material-icons">code</i>-->
                                        Públicas
                                        <div class="ripple-container"></div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#privadas" data-toggle="tab">
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
                        <div class="tab-pane active table-responsive" id="todos">
                            <table class="table table-hover">
                                <thead class=" text-primary">
                                    <th>
                                        Nome
                                    </th>
                                    <th>
                                        Tema
                                    </th>
                                    <th>
                                        Tempo
                                    </th>
                                    <th>
                                        Tipo
                                    </th>
                                    <th>
                                        Ativa
                                    </th>
                                    <th>
                                        Ações
                                    </th>
                                </thead>
                                <tbody>


                                    @foreach($salas as $sala)
                                    @if($sala->enable == 0)
                                    <tr id="sala"style="cursor: pointer; background-color:rgba(229, 229, 229, 0.4);">
                                    @else
                                    <tr id="sala"style="cursor: pointer;">
                                    @endif
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">{{$sala->name}}</td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
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
                                        <?php
                                            $x = gmdate("H:i:s", $sala->duracao);

                                        ?>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">{{ $x }}</td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
                                            @if($sala->public==0)
                                            Privada
                                            @else
                                            Pública
                                            @endif
                                        </td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
                                            @if($sala->enable==1)
                                            Sim
                                            @else
                                            Não
                                            @endif
                                        </td>
                                        <td>
                                            <a class="nav-link" id="sala{{$sala->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                <i id="teste" class="material-icons">more_vert</i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="sala{{$sala->id}}">
                                                <a class="dropdown-item" href="{{ url('admin/visualizar/'.$sala->id) }} ">Visualizar</a>

                                                <a class="dropdown-item" data-toggle="modal" data-target="#editarSalaModal1" data-whateverid="{{$sala->id}}" data-whatevernome="{{$sala->name}}" data-whatevertempo="{{ $x }}" data-whatevertema="{{$sala->tematica}}" data-whateverpublic="{{$sala->public}}" data-tempoo="{{$sala->duracao}}" data-whateverenable="{{$sala->enable}}">Editar</a>

                                                @if($sala->enable==1)
                                                <a class="dropdown-item" href="{{url('admin/desativar/'.$sala->id)}}">Desativar</a>
                                                @else
                                                <a class="dropdown-item" href="{{url('admin/ativar/'.$sala->id)}}">Ativar</a>
                                                @endif
                                                @if($sala->public==0)
                                                <a class="dropdown-item" href="{{url('admin/alunos/'.$sala->id)}}">Adicionar Alunos</a>
                                                @endif
                                             </div>
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane table-responsive" id="publicas">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        Nome
                                    </th>
                                    <th>
                                        Tema
                                    </th>
                                    <th>
                                        Tempo
                                    </th>
                                    <th>
                                        Tipo
                                    </th>
                                    <th>
                                        Ativa
                                    </th>
                                    <th>
                                        Ações
                                    </th>
                                </thead>
                                <tbody>

                                    @foreach($salas as $sala)
                                    @if($sala->public==1)
                                    <?php
                                            $x = gmdate("H:i:s", $sala->duracao);

                                        ?>
                                    @if($sala->enable == 0)
                                    <tr id="sala"style="cursor: pointer; background-color:rgba(229, 229, 229, 0.4);">
                                    @else
                                    <tr id="sala"style="cursor: pointer;">
                                    @endif
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">{{$sala->name}}</td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
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
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">{{ $x }}</td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
                                            @if($sala->public==0)
                                            Privada
                                            @else
                                            Pública
                                            @endif
                                        </td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
                                            @if($sala->enable==1)
                                            Sim
                                            @else
                                            Não
                                            @endif
                                        </td>
                                        <td>

                                            <a class="nav-link" id="sala{{$sala->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                <i class="material-icons" >more_vert</i>

                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="sala{{$sala->id}}" >
                                                <a class="dropdown-item" href="{{ url('admin/visualizar/'.$sala->id) }}">Visualizar</a>
                                                <button class="dropdown-item" data-toggle="modal" data-target="#editarSalaModal1" data-whateverid="{{$sala->id}}" data-whatevernome="{{$sala->name}}" data-tempoo="{{$sala->duracao}}" data-whatevertempo="{{$sala->duracao}}" data-whatevertema="{{$sala->tematica}}" data-whateverpublic="{{$sala->public}}" data-whateverenable="{{$sala->enable}}" style="width:93%;cursor: pointer;" style="cursor: pointer;">Editar</button>
                                                @if($sala->enable==1)
                                                <a class="dropdown-item" href="{{url('admin/desativar/'.$sala->id)}}">Desativar</a>
                                                @else
                                                <a class="dropdown-item" href="{{url('admin/ativar/'.$sala->id)}}">Ativar</a>
                                                @endif
<!--                                                <a class="dropdown-item" href="{{url('admin/alunos/'.$sala->id)}}">Adicionar Alunos</a>-->
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane table-responsive" id="privadas">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        Nome
                                    </th>
                                    <th>
                                        Tema
                                    </th>
                                    <th>
                                        Tempo
                                    </th>
                                    <th>
                                        Tipo
                                    </th>
                                    <th>
                                        Ativa
                                    </th>
                                    <th>
                                        Ações
                                    </th>
                                </thead>
                                <tbody>

                                    @foreach($salas as $sala)
                                    @if($sala->public==0)
                                    <?php
                                            $x = gmdate("H:i:s", $sala->duracao);

                                        ?>
                                    @if($sala->enable == 0)
                                    <tr id="sala"style="cursor: pointer; background-color:rgba(229, 229, 229, 0.4);">
                                    @else
                                    <tr id="sala"style="cursor: pointer;">
                                    @endif
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">{{$sala->name}}</td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
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
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">{{ $x }}</td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
                                            @if($sala->public==0)
                                            Privada
                                            @else
                                            Pública
                                            @endif
                                        </td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
                                            @if($sala->enable==1)
                                            Sim
                                            @else
                                            Não
                                            @endif
                                        </td>
                                        <td>

                                            <a class="nav-link" id="sala{{$sala->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                <i class="material-icons" >more_vert</i>

                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="sala{{$sala->id}}" >
                                                <a class="dropdown-item" href="{{ url('admin/visualizar/'.$sala->id) }}" >Visualizar</a>
                                               <button class="dropdown-item" data-toggle="modal" data-target="#editarSalaModal1" data-whateverid="{{$sala->id}}" data-whatevernome="{{$sala->name}}" data-tempoo="{{$sala->duracao}}" data-whatevertempo="{{$sala->duracao}}" data-whatevertema="{{$sala->tematica}}" data-whateverpublic="{{$sala->public}}" data-whateverenable="{{$sala->enable}}" style="width:93%; cursor: pointer;">Editar</button>
                                                @if($sala->enable==1)
                                                <a class="dropdown-item" href="{{url('admin/desativar/'.$sala->id)}}">Desativar</a>
                                                @else
                                                <a class="dropdown-item" href="{{url('admin/ativar/'.$sala->id)}}">Ativar</a>
                                                @endif
                                                <a class="dropdown-item" href="{{url('admin/alunos/'.$sala->id)}}">Adicionar Alunos</a>

                                            </div>
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
                                    <th>
                                        Nome
                                    </th>
                                    <th>
                                        Tema
                                    </th>
                                    <th>
                                        Tempo
                                    </th>
                                    <th>
                                        Tipo
                                    </th>
                                    <th>
                                        Ativa
                                    </th>
                                    <th>
                                        Ações
                                    </th>
                                </thead>
                                <tbody>

                                    @foreach($salas as $sala)
                                    @if($sala->enable==1)
                                    <?php
                                            $x = gmdate("H:i:s", $sala->duracao);

                                        ?>
                                    <tr style="cursor: pointer;">
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">{{$sala->name}}</td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
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
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">{{ $x }}</td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
                                            @if($sala->public==0)
                                            Privada
                                            @else
                                            Pública
                                            @endif
                                        </td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
                                            @if($sala->enable==1)
                                            Sim
                                            @else
                                            Não
                                            @endif
                                        </td>
                                        <td>

                                            <a class="nav-link" id="sala{{$sala->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                <i class="material-icons">more_vert</i>

                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="sala{{$sala->id}}">
                                                <a class="dropdown-item" href="{{ url('admin/visualizar/'.$sala->id) }}">Visualizar</a>
                                                <button class="dropdown-item" data-toggle="modal" data-target="#editarSalaModal1" data-whateverid="{{$sala->id}}" data-whatevernome="{{$sala->name}}" data-tempoo="{{$sala->duracao}}" data-whatevertempo="{{$sala->duracao}}" data-whatevertema="{{$sala->tematica}}" data-whateverpublic="{{$sala->public}}" data-whateverenable="{{$sala->enable}}" style="width:93%; cursor: pointer;" >Editar</button>

                                                <a class="dropdown-item" href="{{url('admin/desativar/'.$sala->id)}}">Desativar</a>


                                                @if($sala->public==0)
                                                <a class="dropdown-item" href="{{url('admin/alunos/'.$sala->id)}}">Adicionar Alunos</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane table-responsive" id="desativadas">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        Nome
                                    </th>
                                    <th>
                                        Tema
                                    </th>
                                    <th>
                                        Tempo
                                    </th>
                                    <th>
                                        Tipo
                                    </th>
                                    <th>
                                        Ativa
                                    </th>
                                    <th>
                                        Ações
                                    </th>
                                </thead>
                                <tbody>

                                    @foreach($salas as $sala)
                                    @if($sala->enable==0)
                                    <?php
                                            $x = gmdate("H:i:s", $sala->duracao);

                                        ?>

                                    <tr id="sala"style="cursor: pointer; background-color:rgba(229, 229, 229, 0.4);">
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">{{$sala->name}}</td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
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
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">{{ $x }}</td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
                                            @if($sala->public==0)
                                            Privada
                                            @else
                                            Pública
                                            @endif
                                        </td>
                                        <td onclick="window.location.href = '{{ url('admin/visualizar/'.$sala->id) }}'; ">
                                            @if($sala->enable==1)
                                            Sim
                                            @else
                                            Não
                                            @endif
                                        </td>
                                        <td>

                                            <a class="nav-link" id="sala{{$sala->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                <i class="material-icons">more_vert</i>

                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="sala{{$sala->id}}">
                                                <a class="dropdown-item" href="{{ url('admin/visualizar/'.$sala->id) }}">Visualizar</a>
                                                <button class="dropdown-item" data-toggle="modal" data-target="#editarSalaModal1" data-whateverid="{{$sala->id}}" data-whatevernome="{{$sala->name}}" data-tempoo="{{$sala->duracao}}" data-whatevertempo="{{$sala->duracao}}" data-tempoo="{{$sala->duracao}}" data-whatevertema="{{$sala->tematica}}" data-whateverpublic="{{$sala->public}}" data-whateverenable="{{$sala->enable}}" style="width:93%; cursor: pointer" >Editar</button>

                                                <a class="dropdown-item" href="{{url('admin/ativar/'.$sala->id)}}">Ativar</a>

                                                @if($sala->public==0)
                                                <a class="dropdown-item" href="{{url('admin/alunos/'.$sala->id)}}">Adicionar Alunos</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--    MODAL ADICIONAR SALA-->

    <div class="modal fade bd-example-modal-lg" id="addSalaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro de Sala</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/sala') }}" method="POST" style="margin-left: 5%;margin-right:1%;margin-top:3%">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_prof" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="sala_id" id="sala_id" value="0">
                        <div class="form-group">
                            <label for="nome" display="inline">Nome da Sala:</label>
                            <input type="text" name="nome" id="nome" class="form-control has-feedback {{ $errors->has('nome') ? 'has-error bg-primary' : '' }}" required aria-describeby="nomeHelp">
                                <small id="nameHelp" style="color:red;font-size:10px">(*) CAMPO OBRIGAÓRIO </small>


                            @if ($errors->has('nome'))
                            <div class="help-block">
                                {{ $errors->first('nome') }}
                            </div>
                            @endif

                        </div>
                        <div class="form-group" style="margin-top:3.5%">
                            <label for="time" display="inline">Tempo de Duração de cada sala (em minutos):</label>
                            <input type="time" name="time2" id="time2" step='1' class="form-control" min="00:00:00" max="01:00:00" onblur="transforma(this.value,0);" value="00:00:00">
                            <small id="namelHelp" style="color:red;font-size:10px">CASO DEIXE COMO 0, O ALUNO TERÁ TEMPO ILIMITADO PARA RESPONDER AS PERGUNTAS </small>

                            <input type="hidden" name="time5" id="time5" class="form-control" value="0">
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
                                    <input class="form-check-input" type="checkbox" value="0" name="public" id="public">Sala Pública
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            </div>
                            <div class="form-group col">
                            <div class="form-check" style="margin-top:17%">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="0" name="enable" id="enable" checked>Ativo
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" data-dismiss="modal">Fechar</a>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



</div>



<div class="modal fade bd-example-modal-lg" id="editarSalaModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="hidden" value="0" id="page" name="page">
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
                                    <input class="form-check-input" type="checkbox" value="0" name="public1" id="public1">Sala Pública
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            </div>
                            <div class="form-group col">
                            <div class="form-check" style="margin-top:17%">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="0" name="enable1" id="enable1">Ativo
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" data-dismiss="modal">Fechar</a>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
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


@section('js')
    <script>
        $(document).ready(function(){
            $('.teste').on('click', function (event) {
               var button = $(event.relatedTarget); // Button that triggered the modal
                console.log(button);

           });
        };





    </script>
@endsection

@endsection
