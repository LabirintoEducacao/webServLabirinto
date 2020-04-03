@extends('vendor.menu')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div id ="teste2" class="card-header card-header-primary">
                    <h3 class="card-title" style="text-align:center">{{$sala->name}}
                        <button class="btn btn-warning btn-just-icon" data-toggle="modal" data-target="#editarSalaModal2" data-whateverid="{{$sala->id}}" data-whatevernome="{{$sala->name}}" data-whatevertempo="{{$sala->duracao}}" data-whatevertema="{{$sala->tematica}}" data-whateverpublic="{{$sala->public}}" data-whateverenable="{{$sala->enable}}" style="float:right;"><i class="material-icons">create</i></button>
                    </h3>
                    <p class="card-category"></p>
                </div>
                <div class="card-body">
                    <div>
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
                                            {{$sala->duracao / 60}}:00 min
                                        </td>
                                        <td>
                                            @if($sala->tematica==1)
                                                Deserto
                                            @elseif($sala->tematica==2)
                                                Cidade Abandonada
                                            @elseif($sala->tematica==3)
                                                Casa
                                            @else
                                                Floresta
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
                    <div class="meio" style="padding-bottom:10%;">
                        <button type="button" class="btn btn-primary" style="float:left;">Estatistícas</button>
                        @if($sala->public==0)
                            <a class="btn btn-info" href="{{url('admin/alunos/'.$sala->id)}}" style="float:right;">Vincular Alunos</a>
                        @endif
                    </div>
                    <div id="flip">
                        
                      
                      <div class="row align-items-center">
                        <div class="col-auto mr-auto">
                        
                        </div>
                        <div class="col-auto">
                        <a class="nav-link" href="#pablo" id="sala{{$sala->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i id="teste" class="material-icons">more_vert</i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="sala{{$sala->id}}">
                            <a class="dropdown-item" href="#">Editar</a>
                            <a class="dropdown-item" href="#">Excluir</a>
                        </div>
                        </div>
                       </div>
                    </div>
                    <div id="panel"></div>               
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
                            <input type="number" name="time" id="time" class="form-control" min="0" max="120">
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label for="theme">Tema:&emsp;</label>
<!--                                <select class="form-control selectpicker" data-style="btn btn-link" name="theme" id="theme">-->
                                <select id="theme" name="theme" class="form-control" data-style="btn btn-link">
                                    <option value="1">Deserto</option>
                                    <option value="2">Cidade Abandonada</option>
                                    <option value="3">Casa</option>
                                    <option value="4">Floresta</option>
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
                                    <input class="form-check-input" type="checkbox" value="0" name="enable" id="enable">Ativo
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



@endsection
