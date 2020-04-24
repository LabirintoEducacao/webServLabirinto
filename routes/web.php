<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ROTA DO WELCOME

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ROTAS PADRÃO DO LARAVEL

Auth::routes();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ROTA PROFILE

Route::post('profile/edit', 'ProfileController@edit');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ROTAS DO EMAIL
Route::get('/email', function () {
    return view('email.cadastro');
});

Route::post('convite/novo/{email}', 'Admin\UserController@invite');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ROTAS DO HOME

Route::prefix('/home')->group(function () {

    Route::get('/', 'HomeController@index')->name('home');
    Route::post('/', 'ProfileController@reset_password');
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ROTAS DE LOGIN E REGISTER

Route::get('login/user', function () {
    return view('user.login');
});

Route::get('register/user', function () {
    return view('user.register');
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// USUARIOS

Route::prefix('/usuario')->group(function () {

    /* Rotas de Usuario */

    Route::get('/login', 'User\UserRegisterController@login')->name('userLogin');
    Route::get('/register', 'User\UserRegisterController@showRegistrationForm')->name('userRegister');
    Route::post('/register', 'Auth\UserRegisterController@register')->name('userRegister');
    Route::post('/cadastro/{id}', 'Auth\UserRegisterController@createWithSala');

    /* Rotas de Login de Usuario */

    Route::post('/login', 'Auth\LoginController@login')->name('userLogin');

    /* Rotas de email de Usuario */

    Route::get('/cadastro/{email}/{id}', function ($email, $id) {
        return view('cad_sala')->with(['email' => $email, 'id' => $id]);
    });
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ROTAS SOMENTE DO ADMINISTRADOR

Route::get('/admin', function () {

    return view('home');
})->middleware(['auth', 'auth.admin']);



Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'auth.admin'])->name('admin.')->group(function () {

    Route::resource('/users', 'UserController', ['except' => ['show', 'create', 'store']]);
});


///////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ADMIN

Route::prefix('/admin')->group(function () {

    Route::get('/deletar/{id}', 'Admin\UserController@deleteUser');

    Route::get('/teste1', 'SalaController@testeTabela');

    Route::get('/desativar/{id}', 'SalaController@desativar');
    Route::get('/ativar/{id}', 'SalaController@ativar');

    /*Rotas da pergunta e Resposta*/
    Route::get('/teste/{id}', 'PerguntaRespostaController@index2')->middleware(['auth', 'auth.admin']);

    Route::get('/grafico/{id}', 'EstatisticaController@grafico');

    Route::post('/visualizar/editar-sala/{id}', 'PerguntaRespostaController@store');
    Route::post('/editar-resp', 'PerguntaRespostaController@edit_resp');
    Route::post('/editar-perg', 'PerguntaRespostaController@edit_perg');
    Route::post('/editar-ambi', 'PerguntaRespostaController@edit_ambi')->middleware(['auth', 'auth.admin']);
    Route::get('/visualizar/deletar-pergunta/{id}', 'PerguntaRespostaController@destroy')->middleware(['auth', 'auth.admin']);
    Route::get('/visualizar/deletar-resposta/{id}', 'PerguntaRespostaController@destroyresp');
    Route::post('/alterar-ordem', 'PerguntaRespostaController@alterar');
    Route::post('/busca-perg', 'PerguntaRespostaController@buscar');
    Route::post('/busca-sala', 'SalaController@buscarS');

    Route::get('/teste/{id}', 'PerguntaRespostaController@teste');


    Route::get('/users', 'Admin\UserController@getUsers');

    Route::get('/pergunta', function () {
        return view('questions');
    })->middleware(['auth', 'auth.admin']);



    //Rotas da salas

    Route::get('/adicionar-sala', 'SalaController@index')->middleware(['auth', 'auth.admin']);
    Route::get('/estatistica/{id}', 'SalaController@estatistica');
    //Route::get('/estatistica/', function(){
    //    return view('grafico');
    //});

    //Route::post('/estatistica/{id}', 'SalaController@index');
    Route::post('/sala', 'SalaController@store');
    Route::post('/add-aluno', 'SalaController@add_user')->middleware(['auth', 'auth.admin']);

    Route::get('/virtual', 'SalaController@entrar');

    Route::post('/editar-sala', 'SalaController@edit_sala');
    Route::get('/visualizar/{id}', 'SalaController@destroy')->middleware(['auth', 'auth.admin']);

    Route::GET('/sala-disable', function () {

        $data = \App\Sala::where('enable', 0)->get();

        return view('sala-disable')->withData($data);
    });



    Route::get('/sala', 'SalaController@getSalas');

    Route::get('/visualizar/{id}', 'PerguntaRespostaController@index')->middleware(['auth', 'auth.admin']);


    // Rotas para gerar o json
    Route::get('/virtual/{id}', 'Json@show');

    Route::get('/virtualdelete/{id}', 'Json@filedelete');


    // Rotas para usuarios
    Route::get('/deletar-aluno/{id}/{sala}', 'Admin\UserController@deletar')->middleware(['auth', 'auth.admin']);
    Route::delete('/settings/delete/{id}', 'Admin\UserController@destroy');
    Route::get('/alunos/{id}', 'Admin\UserController@add_user')->middleware(['auth', 'auth.admin']);
    Route::post('/addaluno', 'Admin\UserController@teste')->middleware(['auth', 'auth.admin']);
    Route::post('/aluno', 'Admin\UserController@store');
    Route::get('/showaluno', 'Admin\UserController@showalunos');
    Route::post('/new/user', 'Admin\UserController@user');

    Route::get('/newuser', function () {
        return view('admin.users.newuser');
    })->middleware(['auth', 'auth.admin']);


    Route::get('/grupo/{id}', 'SalaController@showgrupos');
    Route::get('/addgrupo/{id}/{salaid}', 'SalaController@addgrupo');
    Route::get('/vinculogrupo/{id}', 'SalaController@vinculogrupo');



    /*  Rotas do Email */

    Route::post('/new/email', 'Admin\UserController@email');

    // Rotas Profile

    Route::get('/settings', function () {
        return view('profile');
    });
    Route::get('/deletar', function () {
        return view('profile');
    });
    Route::delete('/delete/{id}', 'ProfileController@delete');

    //Rotas para registro de users
    Route::get('/settings/create', function () {
        return view('admin.users.register');
    });

    // Rotas Password
    Route::get('/settings/password', function () {
        return view('password');
    });

    Route::post('/novoteste', function () {

        $data = "Eu sou um teste";
        return json_encode($data);
    });
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

// PUBLICO

Route::prefix('/virtual')->group(function () {

    // Salas Publicas não precisa logar

    Route::get('/', 'SalaController@entrar');
    Route::get('/', 'SalaController@entrar_guest');
});

Route::prefix('/play')->group(function () {

    // Salas Publicas não precisa logar

    Route::get('/', 'SalaController@play');
});

// Buscar Publico não precisa logar
Route::prefix('/buscar')->group(function () {

    Route::get('/', 'SalaController@buscar');
    Route::post('/', 'SalaController@buscar');
});


Route::GET('manual', function () {

    return view('manual');
});
// Route::post( 'api/virtual', ['json' => 'PessoaController@teste'] );


///////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/teste', function () {


    return view('qrcode');
});




///////////Thiago
Route::get('/grupos', 'Admin\UserController@pegaGrupo');
Route::get('/grupos/deletar-grupo/{id}', 'Admin\UserController@removeGrupo');
Route::get('/admin/showalunos', 'Admin\UserController@showalunos_grupos');
Route::post('/grupos/addaluno', 'Admin\UserController@addGrupo');
Route::get('/grupos/alunosgrupo/{id}', 'Admin\UserController@carregaAlunos');
Route::post('/grupos/remover/aluno', 'Admin\UserController@removeAluno');
Route::get('/grupos/nomegrupo/{id}', 'Admin\UserController@nomeGrupo');
Route::post('/grupos/addalunogrupo', 'Admin\UserController@adicionaAluno');
Route::get('/grupos/vinculado/{id}', 'Admin\UserController@vinculados');


Route::get('/alunos-sala/{id}', 'Admin\UserController@alunos_na_sala');
Route::get('/alunos-todos', 'Admin\UserController@todos_alunos');



