@extends('vendor.menu')

@section('content')
<div class="container">
    
    
    <div class="bd-example" style="width: 100%; margin-top:-5%;">
        <div class="row">
            <div class="col-3">
                <div id="list-example" class="list-group">
                    @if(Auth::user()->hasAnyRole('professor'))
                    <a class="list-group-item list-group-item-action" href="manual#list-item-1">Sala
                        <div id="list-example" class="list-group" style="margin-top:-12%;">
                            <a class="list-group-item list-group-item-action" href="manual#list-item-1-1">&emsp;Criar</a>
                            <a class="list-group-item list-group-item-action" href="manual#list-item-1-2">&emsp;Editar</a>
                            <a class="list-group-item list-group-item-action" href="manual#list-item-1-3">&emsp;Desativadas</a>
                            <a class="list-group-item list-group-item-action" href="manual#list-item-1-4">&emsp;Ativas</a>
                            <a class="list-group-item list-group-item-action" href="manual#list-item-1-5">&emsp;Estatísticas</a>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action" href="manual#list-item-2">Perguntas e Respostas
                        <div id="list-example" class="list-group" style="margin-top:-12%;">
                            <a class="list-group-item list-group-item-action" href="manual#list-item-2-1">&emsp;Criar</a>
                            <a class="list-group-item list-group-item-action" href="manual#list-item-2-2">&emsp;Editar</a>
                            <a class="list-group-item list-group-item-action" href="manual#list-item-2-3">&emsp;Alterar Sequência</a>
                            <a class="list-group-item list-group-item-action" href="manual#list-item-2-4">&emsp;Deletar</a>
                            <a class="list-group-item list-group-item-action" href="manual#list-item-2-5">&emsp;Salvar todas as alterações</a>
                        </div>
                    </a>
                    @endif
                    @if(Auth::user()->hasAnyRole('user'))
                    <a class="list-group-item list-group-item-action" href="manual#list-item-virtual">Espaço Virtual</a>
                    @endif
                    <a class="list-group-item list-group-item-action" href="manual#list-item-perfil">Editar Perfil</a>
                    <a class="list-group-item list-group-item-action" href="manual#list-item-senha">Editar Senha</a>
                </div>
            </div>
            <div class="col-9">
                <div data-spy="scroll" data-target="#list-example" data-offset="0" class="scrollspy-example" style="overflow-y: scroll;height: 700px;width:800px">
                    @if(Auth::user()->hasAnyRole('professor'))
                    <div>
                        <h4 id="list-item-1">
                            Salas
                        </h4>
                        <p>
                            Para acessar a área de configuração de salas, vá ao menu e clique em Editar Salas. Caso já possua salas cadastradas, elas apareceram.
                            <img src="/img/salas.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                        </p>
                        <div style="padding-left: 5%">
                            <!--                            CRIAR SALA                 -->
                            <h5 id="list-item-1-1">
                                Criar Sala
                            </h5>
                            <p>
                                Para criar uma nova sala, clique em “ADICIONAR SALA" que fica localizado na parte superior direita do site.
                                <br>
                                <img src="/img/criar_sala.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                                <br>
                                Após clicar no botão, você será guiado para outra página com os seguintes campos:
                            </p>
                            
                                <ul style="list-style-type:square;padding-left:18%">
                                    <li>
                                        Nome da Sala: é o que irá aparecer para os alunos;
                                    </li>
                                    <li>
                                        Tempo de duração de cada sala: é o tempo (em segundos) em que o usuário pode permanecer dentro do labirinto. Caso não haja tempo pré-definido, o usuário permanecerá no labirinto até o jogo acabar;
                                    </li>
                                    <li>
                                        Tema: cenário do labirinto;
                                    </li>
                                    <li>
                                        Sala Pública: este campo deverá ser marcado se a sala tiver que ser aberta a todos os jogadores, caso contrário apenas usuários escolhidos pelo criador do labirinto poderão acessar o jogo.
                                    </li>
                                    <li>
                                        Ativo: este campo é marcado por padrão, ele permite que os alunos cadastrados na sala possam vê-la. Se não estiver marcado, os dados estatísticos serão mantidos, mas nenhum aluno poderá jogar o labirinto.
                                    </li>
                                </ul>

                                <img src="/img/nova_sala.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                            <p>
                                Após preencher todos os campos necessários, basta clicar em “CRIAR SALA”.
                            </p>
                            
                            
                            
                            <!--                            EDITAR SALA                           -->
                            <h5 id="list-item-1-2">
                                Editar Sala
                            </h5>
                            <p>
                                Após criar a sala, se algum dos campos tiver sido preenchido de forma errada, é só clicar no botão <i class="material-icons">more_vert</i> e selecionar a opção 'Editar'. Assim, aparecerá uma caixa semelhante a que foi utilizada para criar a sala, mas, desta vez, os campos já aparecerão preenchidos.
                                <br>
                                <img src="/img/editar_sala.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                               
                            </p>
                            
                            
                            <!--                            DESABILITAR SALA                           -->
                            <h5 id="list-item-1-3">
                                Desativar Sala
                            </h5>
                            <p>
                                As salas desativadas estarão sinalizadas com outra cor (cinza), mas também podem ser visualizadas na aba 'DESATIVADAS'
                                <br>
                                <img src="/img/disabled.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                            </p>
                            
                            
                            <!--                            HABILITAR SALA                           -->
                            <h5 id="list-item-1-4">
                                Ativar Sala
                            </h5>
                            <p>
                                As salas ativadas sempre apareceram primeiro nas listas, elas podem ser visualizadas na aba 'ATIVADAS'
                                <br>
                                <img src="/img/enabled.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                            </p>
                            
                            <!--                            ESTATÍSTICAS SALA                           -->
                            <h5 id="list-item-1-5">
                                Estatísticas da Sala
                            </h5>
                            <p>
                                Para os dados estatísticos da sala (acertos e erros por pergunta, acertos e erros por usuário), é necessário clicar primeiro em <i class="material-icons">more_vert</i> e, depois, na opção 'Visualizar'
                                <br>
                                <img src="/img/estatistica2.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                                <br><br>
                                E, depois, clicar na opção estatística:
                                <br>
                                <img src="/img/estatistica.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                            </p>
                            
                        </div>
                    </div>
                    <div>
                        <h4 id="list-item-2">
                            Perguntas e Respostas
                        </h4>
                        <p>
                            Para acessar a área de perguntas e repostas, clique em <i class="material-icons">more_vert</i> e, depois, na opção 'Visualizar'
                            <img src="/img/editar_sala_perg.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                        </p>
                        <div style="padding-left: 5%">
                            <!--                            CRIAR SALA                 -->
                            <h5 id="list-item-2-1">
                                Cadastrar Pergunta e Resposta
                            </h5>
                            <p>
                                Para criar uma nova sala, clique em “+ PERGUNTA" que fica localizado na parte superior direita do site.
                                <br>
                                <img src="/img/nova_perg.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                                <br>
                                Após clicar no botão, aparecerá uma caixa:
                            </p>
                            
                                <ul style="list-style-type:square;padding-left:18%">
                                    <li>
                                        Pergunta:
                                        <ul style="list-style-type:circle;padding-left:6%">
                                            <li>
                                                Tipo da pergunta: se é texto, imagem, vídeo ou áudio;
                                            </li>
                                            <li>
                                                Interação: como irá interagir com o usuário, caso seja selecionado "Porta da Esperança", será necessário adicionar uma pergunta reforço;
                                            </li>
                                            <li>
                                                Pergunta: este campo irá variar de acordo com o que foi selecionado no campo tipo de pergunta: se for texto, aparecerá um campo para digitar, se for imagem ou áudio, aparecerá um campo para realizar o upload do arquivo e, caso seja vídeo, aparecrá um campo para digitar a url do mesmo.
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        Resposta:
                                        <ul style="list-style-type:circle;padding-left:6%">
                                            <li>
                                                Tipo da resposta: se é texto, imagem, vídeo ou áudio;
                                            </li>
                                            <li>
                                                Definição da resposta: se esta certa ou errada;
                                            </li>
                                            <li>
                                                Resposta: este campo irá variar de acordo com o que foi selecionado no campo tipo de resposta: se for texto, aparecerá um campo para digitar, se for imagem ou áudio, aparecerá um campo para realizar o upload do arquivo e, caso seja vídeo, aparecrá um campo para digitar a url do mesmo;
                                            </li>
                                            <li>
                                                Se for a primeira resposta, aparecerá um botão para adicionar mais uma resposta, caso contrário, aparecerá um botão para deletar a resposta.
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        Ambiente:
                                        <ul style="list-style-type:circle;padding-left:6%">
                                            <li>
                                                Tipo do ambiente: se será um corredor ou um labirinto;
                                            </li>
                                            <li>
                                                Tamanho: pequeno, médio ou grande;
                                            </li>
                                            <li>
                                                Largura: pequeno, médio ou grande;
                                            </li>
                                        </ul>
                                        <img src="/img/add_perg.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                                    </li>
                                    <li>
                                        Reforço: só aparecerá se o campo Porta da Esperança estiver selecionado na aba Pergunta, os campos são exatamente iguais aos anteriores, a única diferença é que há duas configurações de ambientes diferentes: a primeira é o caminho que usuário irá percorrer para achar o reforço e o outro será o caminho pelo qual ele passará quando acertar a pergunta.
                                        <img src="/img/ref.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                                        <img src="/img/add_ref.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                                    </li>
                                    
                                </ul>

                                <!--                            imagem                 -->
                            <p>
                                Após preencher todos os campos necessários, basta clicar em “SALVAR”.
                            </p>
                            
                            
                            
                            <!--                            EDITAR SALA                           -->
                            <h5 id="list-item-2-2">
                                Editar Pergunta/Resposta
                            </h5>
                            <p>
                                Após criar as perguntas, se algum dos campos tiver sido preenchido de forma errada, é só clicar no botão <i class="material-icons">more_vert</i> e depois em 'Editar', e ele abrirá um editor de texto com os mesmos campos da caixa de criar pergunta e, ao finalizar, clique em “SALVAR ALTERAÇÕES”.
                                <br>
                                <img src="/img/editar_perg.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                            </p>
                            <!--                            ALTERAR ORDEM                          -->
                            <h5 id="list-item-2-3">
                                Alterar Sequência
                            </h5>
                            <p>
                                É o botão que serve para alterar a ordem em que o jogador verá as perguntas. Para alterar a ordem, basta arrastar a perqunta para a posição desejada.
                                <br>
                                <img src="/img/ordem_perg.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                                <img src="/img/ordem.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                            </p>
                            
                            <!--                            DELETAR SALA                           -->
                            <h5 id="list-item-2-4">
                                Deletar Pergunta
                            </h5>
                            <p>
                                Para deletar uma pergunta, basta clicar no botão <i class="material-icons">more_vert</i> e, depois, na opção 'Excluir'.
                                <br>
                                <span style="color:#aa0000">Obs.: ao clicar em 'Excluir', a(s) resposta(s) e, se houver, o reforço serão deletados juntos a pergunta.</span>
                                <br>
                                <img src="/img/deletar_perg.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                            </p>
                            
                        </div>
                    </div>
<!--
                    <h4 id="list-item-2">Item 2</h4>
                    <p>...</p>
                    <h4 id="list-item-3">Item 3</h4>
                    <p>...</p>
                    <h4 id="list-item-4">Item 4</h4>
                    <p>...</p>
-->
                    @endif
                    @if(Auth::user()->hasAnyRole('user'))
                    <div>
                        <h4 id="list-item-virtual">
                            Espaço Virtual
                        </h4>
                        <p>
                            É o item do menu que, ao ser clicado, mostra ao usuário todas as salas em que ele pode jogar.
                            <br>
                            <img src="/img/virtual.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                            <br>
                            Para jogar, basta clicar em QrCode e, depois, lê-lo com o celular.
                            <img src="/img/virtual2.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                        </p>
                        
                    </div>
    
    
    


                    @endif
                    <div>
                        <h4 id="list-item-perfil">
                            Editar Perfil
                        </h4>
                        <p>
                            Para alterar os dados do perfil (nome e/ou e-mail), é só clicar na opção Editar Perfil.
                            <br>
                            <img src="/img/perfil.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                        </p>
                        
                    </div>
                    <div>
                        <h4 id="list-item-senha">
                            Editar Senha
                        </h4>
                        <p>
                            Para alterar a senha, basta ir clicar em Perfil e, depois, em Alterar Senha.
                            <br>
                            <img src="/img/senha.png" class="img-fluid" style="width: 800px; padding-bottom: 50px; padding-top:50px; ">
                        </p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
