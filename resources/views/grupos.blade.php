@extends('vendor.menu')
@section('content')
<div class="card">
    <div class="card-header card-header-tabs card-header-primary">
        <div>
            <h3 class="card-title" style="margin-top: 10px;">
                Controle de grupos
                @if(Auth::user()->hasAnyRole('professor'))
                <a onclick="mostrarmaisalunos2(0,1,5)" data-toggle="modal" data-target="#addGrupoModal" class="btn btn-info" style="float:right; ">
                    Adicionar novo grupo
                </a>
                <!-- <a class="btn btn-success" onclick="teste()" >Salvar</a> -->
                @endif
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="tab-content table-responsive">
            <table class="table table-hover">
                <thead class=" text-primary">
                    <th>Nome do grupo</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    @foreach($turmas as $turma)
                    <tr>
                        <td class="id_linha" id="{{'linha'.$turma->id}}" onclick="linhaTabela({{$turma->id}})" width='90%'>{{$turma->turma}}
                        </td>
                        <td style="text-align: center">
                            <a class="nav-link" id="{{$turma->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i id="teste" class="material-icons">more_vert
                                </i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="{{$turma->id}}">
                                <a data-toggle="modal" data-target="#confirmalert" data-id="{{$turma->id}}" data-prof="{{Auth::user()->id}}" data-turma="'{{$turma->turma}}'" class="dropdown-item" id="{{'grupo'.$turma->turma}}">Excluir</a>
                                <a onclick="editTabela({{$turma->id}})" class="dropdown-item">Editar</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="addAlunoModalGrupos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar grupo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>




<!-- Modal ADD Grupo -->
<div class="modal fade bd-example-modal-lg" id="addGrupoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Grupos</h5>
                <button style="color:black" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> -->

              <div class="card card-nav-tabs card-plain">
                <div class="card-header card-header-primary">
                    <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                    <div class="row align-items-center">
                        <div class="col-11">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                   <h5 class="modal-title" id="exampleModalLabel" style="font-size: 170%">Cadastro de Grupos</h5>
                                
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
            @csrf

            <div class="modal-body">
                <div class="form-group" style="margin-top: -20px;">
                    <label for="nome" display="inline">Nome do Grupo:</label>
                    <input required type="text" name="nome" id="nome" class="form-control has-feedback {{ $errors->has('nome') ? 'has-error bg-primary' : '' }}" required aria-describeby="grupoHelp">

                    <small id="grupoHelp" style="color:red;font-size:10px">(*) CAMPO OBRIGAÓRIO </small>

                    @if ($errors->has('nome'))
                    <div class="help-block">
                        {{ $errors->first('nome') }}
                    </div>
                    @endif
                </div>
                <div id="divtabela">
                </div>
                <div class="row justify-content-center">
                    <nav aria-label="...">
                        <ul class="pagination justify-content-center">
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" id="teste" data-dismiss="modal">Fechar</a>
                <button onclick="salvarGrupo({{Auth::user()->id}})" class="btn btn-success" style="float:right; ">Salvar</button>
            </div>

        </div>
    </div>
</div>
<!-- Modal ADD Grupo -->

<!-- Modal da confirmação -->
<div class="modal fade bd-example-modal-sm" id="confirmalert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title texto-confirmar" id="exampleModalLabel">Você realmente deseja deletar este grupo?</h5>
                <button style="color:black" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row align-self-center">
                    <button type="button" id="fecharGrupo" data-dismiss="modal" class="btn btn-secundary col">Cancelar</button>
                    <a class="btn col btn-primary" style="color:white;" id="confirmar">Confirmar</a>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Modal da confirmação -->



<!-- Modal alunos do grupos -->
<div class="modal fade" tabindex="-1" id="alunosModal" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           <div class="card card-nav-tabs card-plain">
                <div class="card-header card-header-primary">
                    <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                    <div class="row align-items-center">
                        <div class="col-11">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul class="nav nav-tabs esconder" data-tabs="tabs">
                                          <li class="nav-item">
                                                <a class="nav-link active nomegrupo" onclick="troca_tabs(1)" style="width:100%; cursor:pointer;" href="" data-toggle="tab"> </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link adicionar" style="width:100%;cursor:pointer;" onclick="troca_tabs(0)" data-toggle="tab">
                                                    Adcionar Alunos
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link vincular" onclick="troca_tabs(2)" style="width:100%; cursor:pointer;" data-toggle="tab"> Salas Vinculadas</a>
                                            </li>
                                    </ul>
                                       <ul class="row nav nav-tabs esconder2" data-tabs="tabs">
                                          <li class="nav-item col-12">
                                                <a class="nav-link active nomegrupo" onclick="troca_tabs(1)" style="width:100%; cursor:pointer;" href="" data-toggle="tab"> </a>
                                            </li>
                                            <li class="nav-item col-12">
                                                <a class="nav-link adicionar" style="width:100%;cursor:pointer;" onclick="troca_tabs(0)" data-toggle="tab">
                                                    Adcionar Alunos
                                                </a>
                                            </li>
                                            <li class="nav-item col-12">
                                                <a class="nav-link vincular" onclick="troca_tabs(2)" style="width:100%; cursor:pointer;" data-toggle="tab"> Salas Vinculadas</a>
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

            <div id="adicionaralunos" style="display:none;">
                <div id="divtabela2" class="modal-body">
                </div>
                <div class="row justify-content-center">
                    <nav aria-label="...">
                        <ul class="pagination justify-content-center">
                        </ul>
                    </nav>
                </div>
            </div>

            @csrf
            <div id="divdatabela" class="modal-body" >
                <div class="form-group">
                    @if ($errors->has('nome'))
                    <div class="help-block">
                        {{ $errors->first('nome') }}
                    </div>
                    @endif
                </div>
                <table class="table table-hover">
                    <thead class=" text-primary">
                        <tr>
                        <th>Alunos</th>
                        <th>Ações</th>
                       </tr>
                    </thead>
                    <tbody id="tabelaalunosgrupos">

                    </tbody>
                </table>
            </div>

            <div id="salas_v" class="modal-body"  style="display:none;">
                  <table class="table table-hover">
                    <div class="container row">
                        <h5 style="margin-left:5px;">Grupo:</h5>
                        <h5 id="nome_grupo" style="margin-left:5px;"> teste</h5>
                    </div>
                    <thead class=" text-primary">
                          <tr>
                          <th >Salas</th>
                          <th><span style="visibility: hidden;">testetesttetteteteteetghgfhgfhgfhg</span></th>
                          <th style="margin-left: 30%;">Ações</th>
                         </tr>
                    </thead>
                    <tbody id="t_salas_v">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button id="save-edit" class="btn btn-success" style="float:right; ">Salvar alterações</button>
                <!-- <a data-toggle="modal" data-target="#confirmalert" data-id="39" data-prof="59" data-turma="'Google2'" class="dropdown-item" id="grupoGoogle2">Excluir</a> -->
            </div>
        </div>
    </div>
</div>
<!-- Modal alunos do grupos -->

@endsection