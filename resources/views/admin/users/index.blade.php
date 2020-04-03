@extends('vendor.menu')
@section('content')

<div class="container">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                    <h3 class="card-title" style="margin-top: 10px;">
                        Controle de Usuários
                        @if(Auth::user()->hasAnyRole('admin'))
                        <a data-toggle="modal" data-target="#addUserModal" class="btn btn-info" style="float:right">
                            Adicionar novo usuário
                        </a>
                        @elseif(Auth::user()->hasAnyRole('professor'))
                        <a data-toggle="modal" data-target="#addEmailModal" class="btn btn-info" style="float:right; ">
                            Adicionar novo usuário
                        </a>
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <table class="table">
                            <thead class=" text-primary">
                                <th>
                                    Nome
                                </th>
                                <th>
                                    E-mail
                                </th>
                                <th>
                                    Tipo
                                </th>
                                <th>
                                    Ações
                                </th>
                            </thead>
                            <tbody>

                                @foreach($users as $user)
                                @if(Auth::user()->hasAnyRole('admin'))
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>
                                        {{$user->email}}

                                    </td>
                                    <td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
                                    <td>
                                        <a class="nav-link" id="user{{$user->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i id="teste" class="material-icons">more_vert</i>
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="user{{$user->id}}">
                                            <a class="dropdown-item" data-toggle="modal" data-target="#modal{{$user->id}}" data-whateverid="{{$user->id}}">Editar</a>
                                            <a class="dropdown-item" href="{{ url('admin/deletar/'.$user->id) }}">Deletar</a>

                                        </div>
                                    </td>
                                </tr>


                                <div class="modal fade bd-example-modal-sm" id="modal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Permissões do Usuário</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.users.update', ['user' => $user->id]) }}" name="formEdit" method="POST" style="margin-left:5%">
                                                @csrf
                                                {{ method_field('PUT') }}
                                                <div class="modal-body">
                                                    <h6>Nome: {{$user->name}}</h6>
                                                    @foreach($roles as $role)


                                                    <div class="form-group col">
                                                        <div class="form-check" style="margin-left:10%;margin-top:17%">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $user->hasAnyRole($role->name)?'checked':'' }}>&emsp;{{ $role->name }}

                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach

                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-secondary" data-dismiss="modal">Fechar</a>
                                                    <button type="submit" class="btn btn-info">Atualizar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @elseif(Auth::user()->hasAnyRole('professor'))

                                @if($user->hasAnyRole('user'))
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>
                                        {{$user->email}}

                                    </td>
                                    <td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
                                    <td>
                                        @if(!$user->hasAnyRole('admin'))
                                        @if($user->id!=Auth::user()->id)
                                        <a class="nav-link" id="user{{$user->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="material-icons">more_vert</i>

                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="user{{$user->id}}">

                                            <a class="dropdown-item" href="{{ url('admin/deletar/'.$user->id) }}">Deletar</a>





                                        </div>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endif
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



<div class="modal fade bd-example-modal-lg" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ url('/admin/new/user') }}" style="width:60%;margin-top:2%;margin-left:22%" class="justify-content-center">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus aria-describedby="nameHelp">

                        <small id="nameHelp" style="color:red;font-size:10px">(*) CAMPO OBRIGAÓRIO </small>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <div class="form-group" style="margin-top:3.5%">
                        <label for="email">E-mail:</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" aria-describeby="emailHelp">
                        
                        <small id="emailHelp" style="color:red;font-size:10px">(*) CAMPO OBRIGAÓRIO </small>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="type">Tipo:&emsp;</label>
                        <select class="form-control selectpicker" data-style="btn btn-primary" id="type" name="type" style="width:160px">
                            <option value="1">&emsp;ADMINISTRADOR&emsp;</option>
                            <option value="2">&emsp;PROFESSOR&emsp;</option>
                            <option value="3">&emsp;USUÁRIO&emsp;</option>
                        </select>
                    </div>


                    <div class="form-group row">
                        <div class="form-group col">
                            <label for="password">Senha:</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" ariadescirbeby="passwordHelp">
                             
                            <small id="passwordHelp" style="color:red;font-size:10px">(*) CAMPO OBRIGAÓRIO </small>

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="form-group col">
                            <label for="password-confirm">Confirmar senha:</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" autofocus ariadescirbeby="passwordCHelp">

                            <small id="passwordCHelp" style="color:red;font-size:10px">(*) CAMPO OBRIGAÓRIO </small>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary" data-dismiss="modal">Fechar</a>
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
            </form>

        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-sm" id="addEmailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ url('/admin/new/email') }}" style="width:100%;margin-top:2%" class="justify-content-center">
                @csrf
                <div class="modal-body">
                    <div class="form-group" style="margin-top:3.5%">
                        <label for="email">E-mail:</label>
                        <input id="email2" type="email" class="form-control @error('email') is-invalid @enderror" name="email2" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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


@endsection
