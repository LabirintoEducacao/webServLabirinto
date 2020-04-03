<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Sala;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Mail\LinkCadastro;
use App\Mail\LinkSala;

use function GuzzleHttp\json_encode;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dessa forma mostra sem paginação uma lista de usuarios
        //return view('admin.users.index')->with('users', User::all());

        //Com paginação
        return view('admin.users.index')->with('users', User::paginate(5));
    }

    public function getUsers()
    {
        // dessa forma mostra sem paginação uma lista de usuarios
        //return view('admin.users.index')->with('users', User::all());

        //Com paginação
        return view('admin.users.index')->with(['users' => User::all(), 'roles' => Role::all()]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {

        if (Auth::user()->id == $id) {
            $notification = array(
                'message' => 'Você não tem permissão para editar!',
                'alert-type' => 'warning'
            );
            return redirect()->route('admin.users.index')->with($notification);
        }

        return redirect('admin/users')->with(['user' => User::find($id), 'roles' => Role::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->id == $id) {
            $notification = array(
                'message' => 'Você não tem permissão para editar este usuáio!',
                'alert-type' => 'warning'
            );
            return redirect('admin/users')->with($notification);
        }

        $user = User::find($id);
        $user->roles()->sync($request->roles);

        $notification = array(
            'message' => 'Usuário atualizado com sucesso!',
            'alert-type' => 'success'
        );
        return redirect('admin/users')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->id == $id) {
            $notification = array(
                'message' => 'Você não tem permissão para deletar este usuário!',
                'alert-type' => 'warning'
            );
            return redirect('admin/users')->with($notification);
        }

        $user = User::find($id);

        if ($user) {
            $user->roles()->detach();
            $user->delete();
            $notification = array(
                'message' => 'Usuário deletado com sucesso!',
                'alert-type' => 'danger'
            );
            return redirect('admin/users')->with($notification);
        }
        $notification = array(
            'message' => 'Este usuário não pode ser deletado!',
            'alert-type' => 'warning'
        );
        return redirect('admin/users')->with($notification);
    }




    public function deleteUser($id)
    {
        if (Auth::user()->id == $id) {
            $notification = array(
                'message' => 'Você não tem permissão para deletar este usuário!',
                'alert-type' => 'warning'
            );
            return redirect('admin/users')->with($notification);
        }

        $user = User::find($id);

        if ($user) {
            $user->roles()->detach();
            $user->delete();
            $notification = array(
                'message' => 'Usuário deletado com sucesso!',
                'alert-type' => 'danger'
            );
            return redirect('admin/users')->with($notification);
        }
        $notification = array(
            'message' => 'Este usuário não pode ser deletado!',
            'alert-type' => 'warning'
        );
        return redirect('admin/users')->with($notification);
    }




    /*UM ADMINISTRADOR PODE CADASTRAR UM NOVO USUARIO*/
    public function user(Request $request)
    {
        $data = $request->all();
        $id = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $users = User::where('email', '=', $data['email'])->get();

        foreach ($users as $user) {
            $user->roles()->sync($data['type']);
        }

        $notification = array(
            'message' => 'Usuário cadastrado com sucesso!',
            'alert-type' => 'success'
        );

        return redirect('admin/users')->with($notification);
    }


    /*ENVIAR E-MAIL*/
    public function email(Request $request)
    {
        $data = $request->all();

        $users = User::where('email', '=', $data['email'])->get();

        $sala = Sala::find($request->sala_id);

        foreach ($users as $user) {
            if ($user) {
                \Mail::to($data['email'])->send(new LinkSala($sala->name, Auth::user()->name, Auth::user()->id));
                $notification = array(
                    'message' => 'E-mail enviado com sucesso!',
                    'alert-type' => 'success'
                );
                return redirect('admin/users')->with($notification);
            }
        }
        \Mail::to($data['email'])->send(new LinkCadastro($sala, Auth::user()->name, Auth::user()->id, $data['email']));
        $notification = array(
            'message' => 'E-mail para cadastro enviado com sucesso!',
            'alert-type' => 'success'
        );
        return redirect('admin/alunos/' . $data['sala_id'])->with($notification);
    }


    public function add_user($id)
    {
        $sala = Sala::find($id);

        if ($sala->public == 0) {
            $data = DB::table('users')
                ->select('users.id', 'users.name', 'users.email')
                ->join('sala_user', 'users.id', '=', 'sala_user.user_id')
                ->orderBy('name')
                ->where('sala_user.sala_id', '=', $id)
                ->get();



            $alunos = DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.id')
                ->orderBy('name')
                ->where('role_user.role_id', '=', 3)
                ->get();



            $alunos = \App\User::orderBy('name')->get();

            return view('add_alunos', ['id' => $id])->with(['data' => $data, 'alunos' => $alunos, 'qtd' => count($data)]);
        } else {
            $notification = array(
                'message' => 'Esta sala é pública, não há como adicionar alunos!',
                'alert-type' => 'warning'
            );
            return redirect('admin/sala')->with($notification);
        }
    }

    public function showalunos()
    {
        $salaid = $_GET['sala'];
        $sql = 'SELECT DISTINCT u.id,u.name,u.email FROM users u
        JOIN role_user r ON u.id = r.user_id 
        LEFT OUTER JOIN sala_user s ON u.id = s.user_id
        WHERE r.role_id=3 AND u.id NOT IN (SELECT DISTINCT u.id FROM users u
        JOIN role_user r ON u.id = r.user_id 
        LEFT OUTER JOIN sala_user s ON u.id = s.user_id
        WHERE r.role_id=3 AND s.sala_id=' . $salaid . ' ORDER BY id, sala_id) ORDER BY u.name';

        $aluno = DB::select($sql);
        return json_encode($aluno);
    }


    public function store(Request $request)
    {
        $data = DB::table('sala_user')
            ->where('sala_id', '=', $request->sala_id)
            ->where('user_id', '=', $request->user_id)
            ->get();


        $user = DB::table('users')
            ->where('id', '=', $request->user_id)
            ->get();

        $sala = DB::table('salas')
            ->where('id', '=', $request->sala_id)
            ->get();

        $prof = DB::table('users')
            ->where('id', '=', $request->user_id)
            ->get();
        //        var_dump($sala);
        if (count($data) == 0) {
            DB::table('sala_user')->insert(array('sala_id' => $request->sala_id, 'user_id' => $request->user_id));

            //            \Mail::to($user[0]->email)->send(new LinkSala($sala[0]->name,$prof[0]->name,$request->sala_id));

            $notification = array(
                'message' => 'Aluno adicionado com sucesso!',
                'alert-type' => 'success'
            );
            return redirect('admin/alunos/' . $request->get('sala_id'))->with($notification);
        }
        $notification = array(
            'message' => 'Aluno já cadastrado nesta sala!',
            'alert-type' => 'warning'
        );
        return redirect('admin/alunos/' . $request->get('sala_id'))->with($notification);
    }

    public function deletar($id, $sala)
    {

        DB::table('sala_user')
            ->where('user_id', '=', $id)
            ->where('sala_id', '=', $sala)
            ->delete();


        $notification = array(
            'message' => 'Aluno removido com sucesso!',
            'alert-type' => 'success'
        );


        // if(count($data) == 0){
        return redirect('admin/alunos/' . $sala);
        return redirect('admin/alunos/' . $sala)->with($notification);
        // }
        // return redirect('admin/alunos/'. $sala)->with('warning', 'Este aluno não pôde ser deletado!');
    }

    public function teste()
    {

        // $id = $_REQUEST['id'];
        // $salaid = $_REQUEST['salaid'];

        // DB::table('sala_user')->insert(
        //     ['sala_id' => $salaid, 'user_id' => $id]
        // );

        // return response()->json(['success' => 'Sucesso']);
    }

    //////////////////////////Thiago Grupos método
    public function pegaGrupo()
    {
        $turmas = DB::table('turmas')
            ->select('id', 'turma')
            ->where('id_prof', Auth::user()->id)
            ->get();

        return view('grupos')->with(['turmas' => $turmas]);
    }
    public function pegaAluno($id)
    {
        $turmas = DB::table('turmas')->where('id_prof', $id)->select('id', 'turma')->get();
        return view('grupos', ['turmas' => $turmas]);
    }
    public function addGrupo(Request $request)
    {
        $alunos = $request['alunos'];
        $grupo = $request['grupo'];

        $id = Auth::user()->id;
        $ides = DB::table('turmas')->insertGetId(
            ['id_prof' => $id, 'turma' => $grupo]
        );

        if (sizeof($alunos) > 0) {
            $tamanho = sizeof($alunos);

            for ($cont = 0; $cont < $tamanho; $cont++) {
                DB::table('alunos_turma')
                    ->insert(
                        ['aluno_id' => intval($alunos[$cont]), 'turmas_id' => $ides]
                    );
            }
        }
        return view('grupos/' . $id);
        //return response()->json(['success' => $ides]);
        //var_dump($ides);
    }

    public function removeGrupo($id)
    {

        DB::table('turmas')->where('id', '=', $id)->delete();
        echo "teste";
        return redirect('grupos/' . Auth::user()->id);
    }
    public function showalunos_grupos()
    {
        $sql = 'SELECT DISTINCT u.id,u.name,u.email FROM users u
        JOIN role_user r ON u.id = r.user_id 
        WHERE r.role_id=3  ORDER BY u.name';
        $aluno = DB::select($sql);

        return json_encode($aluno);
    }
    public function carregaAlunos($id)
    {
        $query = 'SELECT u.name, u.id, t.id as turma from users u
        join alunos_turma alt on alt.aluno_id=u.id
        join turmas t on alt.turmas_id=t.id
        where t.id=' . $id . ';';

        $alunos = DB::select($query);

        return $alunos;
    }
    public function removeAluno(Request $request)
    {
        $id_aluno = $request['aluno'];
        $id_grupo = $request['turma'];

        foreach ($id_aluno as $value) {
            DB::table('alunos_turma')
                ->where('aluno_id', '=', $value)
                ->where('turmas_id', '=', $id_grupo)
                ->delete();
        }
        return response()->json(['success' => 'Sucesso']);
    }
    public function adicionaAluno(Request $request)
    {
        $id_aluno = $request['aluno'];
        $id_grupo = $request['turma'];

        if (sizeof($id_aluno) > 0) {
            $tamanho = sizeof($id_aluno);

            for ($cont = 0; $cont < $tamanho; $cont++) {
                DB::table('alunos_turma')
                    ->insert(
                        ['aluno_id' => intval($id_aluno[$cont]), 'turmas_id' => $id_grupo]
                    );
            }
        }
        return response()->json(['success' => 'Sucesso']);

        // echo json_encode($id_aluno);
    }

    public function nomeGrupo($id)
    {
        $query = 'SELECT turma from turmas where id=' . $id . ';';
        $nome = DB::select($query);

        return $nome;
    }

    public function vinculados($id)
    {
        $sql = 'SELECT s.id , s.name from salas s join turma_salas ts on ts.id_t= ' . $id . ';';
        $data = DB::select($sql);

        return $data;
    }

    public function alunos_na_sala($id)
    {
        $data = DB::table('users')
            ->select('users.id', 'users.name','users.email')
            ->join('sala_user', 'users.id', '=', 'sala_user.user_id')
            ->orderBy('name')
            ->where('sala_user.sala_id', '=', $id)
            ->get();
        return $data;
    }

    public function todos_alunos()
    {
        $data = DB::table('users')
            ->select('users.id', 'users.name','users.email')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->orderBy('name')
            ->where('role_user.role_id', '=', 3)
            ->get();
        // $sql = 'SELECT u.id, u.name from users u
        // join role_user ru on ru.user_id=u.id
        // where ru.role_id=3 ORDER BY u.name;';

        return $data;
    }

    //////////////////////////Thiago Grupos método


}
