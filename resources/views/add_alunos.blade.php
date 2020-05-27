@extends('vendor.menu')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <input type="hidden" value="{{$id}}" id="id_sala">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title ">Controle de Jogadores
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addAlunoModal">
              Adicionar aluno
            </button>
          </h4>
          <p class="card-category"></p>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th>
                  Nome
                </th>
                <th>
                  E-mail
                </th>
                <th style="text-align:right">
<!--                <th style="float:right;">-->
                  Remover
                </th>
              </thead>
              <tbody>
                  @if($qtd>0)
                @foreach($data as $aluno)
                <tr class="{{'aluno_sala'.$aluno->id}}">
                  <td>{{$aluno->name}}</td>
                  <td>
                    {{$aluno->email}}

                  </td>
                  <td>

                    <i onclick="removeAluno(1,{{$aluno->id}},1)" id="{{'checkreturn'.$aluno->id}}" style="display: none;float:right;" class="fa fa-undo rotationteste" aria-hidden="true"></i>
                    <i class="material-icons rotationteste" id="{{'checkremove'.$aluno->id}}" style="color:red;float:right;" onclick="removeAluno(0,{{$aluno->id}},1)"></i>

                  </td>
                </tr>
                @endforeach
                  @else
                  <tr>
                      <td>
                    <h4>Não há alunos cadastrados nesta sala!</h4>
                          </td>
                  </tr>
                  @endif

              </tbody>
            </table>
          </div>
            <button id="save_remove" class="btn btn-success" style="float:right; display: none " onclick="check(0,5)">Salvar alterações</button>
        </div>
      </div>
    </div>
  </div>






  <div class="modal fade " id="addAlunoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content">


        <div class="card card-nav-tabs card-plain">
          <div class="card-header card-header-primary">

            <div class="nav-tabs-navigation container">
              <div class="row justify-content-between">

                <div class="nav-tabs-wrapper">

                  <ul class="nav nav-tabs mb-3 col" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#alunos" role="tab" aria-controls="pills-home" aria-selected="true">Alunos</a>
                    </li>
                    <li class="nav-item">


                      <a class="nav-link " id="pills-profile-tab" data-toggle="pill" href="#grupos" role="tab" aria-controls="pills-profile" aria-selected="false">Grupos</a>

                    </li>
                  </ul>

                </div>


                <button type="button" class="close col-1" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>
          </div>
        </div>



        <div class="modal-body">
          <div class="row">
            <input type="hidden" id="user_id" value="{{Auth::user()->id}}">
            <input type="hidden" name="sala_id" id="sala_id" value="{{$id}}">
            <div class="form-group" style="margin-top:-4%; margin-bottom:5%">
              <div class="container">
                <label for="user_id" display="inline">Escolha o aluno a ser adicionado:</label>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#addNovoAlunoModal">
                  Enviar Convite
                </button>

              </div>

            </div>
          </div>

          <div class="row container" style="margin-bottom:5%">
            <h5>Pesquisar:&emsp;</h5>
            <input id="search" name="search" type="text" class="fa fa-search" style="width: 60%; height: 40px ; border-radius: 5px;">
          </div>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="alunos" role="tabpanel" aria-labelledby="nav-home-tab">
              <div class="tab-content" id="divtabela2">

              </div>
              <div class="row justify-content-center">
                <nav aria-label="Paginação">
                  <ul class="pagination justify-content-center">
                  </ul>
                </nav>
              </div>
            </div>
            <div class="tab-pane fade " id="grupos" role="tabpanel" aria-labelledby="nav-home-tab">
              <div class="tab-content" id="divtabelagrupo">
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button id="save-edit" class="btn btn-success" style="float:right; " onclick="check(0,4)">Salvar alterações</button>
            <!-- <button type="submit" class="btn btn-success" data-dismiss="modal">Sair</button> -->
            <!-- <button onclick="salvarGrupo({{Auth::user()->id}})" class="btn btn-success" style="float:right; ">Salvar</button> -->
          </div>

        </div>
      </div>
    </div>
  </div>



  <div class="modal fade bd-example-modal-lg " id="addNovoAlunoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Adicionar aluno</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ url('/admin/new/email') }}" method="POST" style="margin-left: 5%;margin-right:1%;margin-top:3%">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="sala_id" id="sala_id" value="{{$id}}">
            <div class="form-group" style="margin-top:3.5%">
              <label for="email" display="inline">E-mail do aluno</label>
              <input type="email" name="email" id="email" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-secondary" data-dismiss="modal">Fechar</a>
            <button type="submit" class="btn btn-success">Enviar convite</button>
          </div>
        </form>
      </div>
    </div>
  </div>




  <!--    CONFIRMAÇÃO DELETAR ALUNO-->
  <div class="modal fade bd-example-modal-sm" id="removerAlunoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tituloModal">Você realmente deseja remover o usuário desta sala?</h5>
          <button style="color:black" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row align-self-center">
            <button type="button" id="fecharModal" data-dismiss="modal" class="btn btn-secundary col">Cancelar</button>
            <a class="btn col btn-primary larcom" id="confirmarRemoverAluno">Confirmar</a>
          </div>
        </div>

      </div>
    </div>
  </div>


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





  @endsection
