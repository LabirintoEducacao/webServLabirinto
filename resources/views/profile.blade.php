@extends('vendor.menu')

@section('content')
<div class="container">
    <div class="col-md-8 offset-md-2 col-12">
        <div class="card">
            <div id="teste2" class="card-header card-header-primary">
                <h3 class="card-title" style="text-align:center">Alterar Perfil<!--{{Auth::user()->name}}--></h3>
                <p class="card-category"></p>
            </div>

            <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
            
                
                <form action="{{ url('profile/edit') }}" method="POST" style="margin-left: 1%;margin-right:1%">
                    
                        {{ csrf_field() }}
                    
                    <label for="name">Nome:</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nome" value="{{Auth::user()->name}}">
                    <br>
                    <label for="email">Email:</label>
                    <input type="email" id="name" name="email" class="form-control" placeholder="E-mail" value="{{Auth::user()->email}}">
                    <br>
                    
                    
                    <div class="row">
                           <a class="btn btn-primary col-12" style="color:white"  data-toggle="modal" data-target="#alterSenha" onclick="document.getElementById('password_atual').removeAttribute('readonly')">ALTERAR SENHA</a>
                               </div>
                    
                    <br>
                    
                    <div class="row align-self-center">
                                                  
                            <a class="btn btn-danger col" href="{{ url('/home') }}">
                                        {{ __('Cancelar') }}
                            </a>
                            
                        <button type="submit" class="btn btn-success col">Salvar alterações</button>

                        </div>

<!--                    </div>-->
                </form>
                    <br>
                           
                          

            </div>
        </div>
    </div>

</div>



<div class="modal fade" id="alterSenha" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content ">
            <div class="modal-header text-center" style="background-color:#a641b9;">
                 
<!--                <h5 class="modal-title"></h5>-->
                <h5 style=" margin-right:36%;font-size: 20px;color:#ffffff;" id="exampleModalScrollableTitle">Alterar Senha</h5>
                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float:right">
                      <i class="material-icons">clear</i>
                    </button>
            </div>
                            <form action="{{ url('home') }}" method="POST" style="margin-left: 1%;margin-right:1%" autocomplete="false">
                    <!--                        @method('POST')-->
                    {{ csrf_field() }}

                    <!--input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"-->
                                <div class="modal-body">
                    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                        <input type="password" name="password_atual" id="password_atual" class="form-control" placeholder="Senha atual" autocomplete="false" readonly aria-describeby="passwordHelp">
                            <small id="passwordHelp" style="color:red;font-size:10px">(*) CAMPO OBRIGAÓRIO </small>

                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                        <input type="password" name="passwordn" class="form-control" placeholder="Nova senha" aria-describeby="passwordNHelp">
                            <small id="passwordNHelp" style="color:red;font-size:10px">(*) CAMPO OBRIGAÓRIO </small>

                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirme sua nova senha" aria-describeby="passwordCHelp">
                            <small id="passwordCHelp" style="color:red;font-size:10px">(*) CAMPO OBRIGAÓRIO </small>

                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>
                                    </div>

                    <!--
                    {{ Form::label('password', 'Nova senha:') }}
                    {{ Form::password('password',['class'=>'form-control', 'autofocus', 'placeholder'=>'Nova senha']) }}<br>
                    {{ Form::label('password2', 'Confirmação de senha:') }}
                    {{ Form::password('password2',['class'=>'form-control', 'placeholder'=>'Confirmação de senha']) }}<br>
-->
                    <!--
                    {{ Form::label('password', 'Senha:') }}
                    {{ Form::password('password',['class'=>'form-control', 'placeholder'=>'Senha','minlength'=>'8', 'required']) }}<br>
-->             <div class="modal-footer">
                    <div class="row align-self-center">
                        
                         <button type="button" class="btn btn-default col" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success col">ALTERAR SENHA</button>
                    </div>
                                 </div>
                </form>
            
                
            
            
               
           
        </div>
    </div>
</div>
@endsection

