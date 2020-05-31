<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Pergunta;
use App\Sala;
use App\Data;
use App\TurmaSala;
use File;

class SalaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function getSalas()
  {
    //        $salas = DB::table('salas')
    //                ->where('prof_id','=',Auth::user()->id)
    //                ->paginate(6);
    $salas = DB::table('salas')
      ->where('prof_id', '=', Auth::user()->id)
      ->orderBy('enable', 'desc')
      ->get();

    return view('sala')->with(["salas" => $salas]);
  }


  public function getSala($id)
  {
    $sala = DB::table('salas')
      ->where('id', '=', $id)
      ->get();
    if (count($sala) > 0) {
      $perguntas = DB::table('perguntas')
        ->where('sala_id', '=', $id)
        ->get();
      //            $respostas = DB::table('respostas')
      //                        ->join('perg_resp','perg_resp.resp_id'.'respostas.id')
      return view('visu')->with(['sala' => $sala[0], 'perguntas' => $perguntas]);
    }
  }

  public function desativar($id)
  {
    $sala = Sala::find($id);

    $sala->enable = 0;
    $sala->save();

    $notification = array(
      'message' => 'Sala desativada com sucesso!',
      'alert-type' => 'success'
    );

    return redirect('admin/sala')->with($notification);
  }

  public function ativar($id)
  {
    $sala = Sala::find($id);

    $sala->enable = 1;
    $sala->save();

    $notification = array(
      'message' => 'Sala desativada com sucesso!',
      'alert-type' => 'success'
    );

    return redirect('admin/sala')->with($notification);
  }

  public function index()
  {
    return view('add_sala');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    $request->validate([

      'nome' => 'required|max:20'

    ]);




    if ($request->sala_id == 0) {
      $sala = new Sala();
      $sala->prof_id = $request->input('id_prof');
      $sala->name = $request->input('nome');
      $sala->duracao = 0;
      $sala->tematica = $request->input('theme');
      if ($request->public == null) {
        $sala->public = 0;
      } else {
        $sala->public = 1;
      }


      if ($request->enable == null) {

        $sala->enable = 0;
      } else {

        $sala->enable = 1;
      }



      $sala->save();

      $notification = array(
        'message' => 'Sala criada com sucesso!',
        'alert-type' => 'success'
      );



      $idsala = Sala::all()->last()->id;


      // public function salvar($objArquivo, $objProjeto, $objDataAtualizacao) {
      $strCaminho = public_path() . '/sala/' . $idsala; // 'public\projetos_arquivos\codigo_projeto'

      if (!file_exists($strCaminho)) { // Cria pasta para o projeto, caso não já exista uma
        $objProjetoDiretorio = File::makeDirectory($strCaminho);
      }
    } else {
      $sala = Sala::find($request->sala_id);
      $sala->name = $request->input('nome');
      $sala->duracao = 0;
      $sala->tematica = $request->input('theme');
      if ($request->input('public1') == null || $request->input('public1') == 0) {
        $sala->public = 0;
      } else {
        $sala->public = 1;
      }
      if ($request->input('enable1') == null || $request->input('enable1') == 0) {

        $sala->enable = 0;
      } else {

        $sala->enable = 1;
      }

      $sala->save();
      $notification = array(
        'message' => 'Sala alterada com sucesso!',
        'alert-type' => 'success'
      );
      if ($request->page == 0)
        return redirect('admin/sala')->with($notification);
      else
        return redirect('admin/visualizar/' . $request->sala_id)->with($notification);
    }



    return redirect('admin/sala')->with($notification);
  }



  //    public function edit_sala(Request $request)
  //    {
  //
  //           $request->validate([
  //
  //                  'nome' => 'required|max:20'
  //
  //           ]);
  //
  //            $time = $request->input('time');
  //
  //           if($time == ""){
  //
  //            $time = 0;
  //
  //           }
  //
  //            $sala = Sala::find($request->sala_id);
  //            $sala->name = $request->input('nome');
  //            $sala->duracao = $time;
  //            $sala->tematica = $request->input('theme');
  //            if($request->public==null){
  //                $sala->public=0;
  //            }
  //            else{
  //                $sala->public=1;
  //            }
  //             if($request->enable == null){
  //
  //            $sala->enable = 0;
  //           }
  //           else{
  //
  //            $sala->enable =1;
  //           }
  //
  //            $sala->save();
  //            $notification = array(
  //                'message' => 'Sala alterada com sucesso!',
  //                'alert-type' => 'success'
  //            );
  //
  //            return redirect('admin/sala')->with($notification);

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {

    $perguntas = DB::table('perguntas')
      ->where('sala_id', '=', $id)
      ->get();

    foreach ($perguntas as $pergunta) {
      $path = DB::table('path_perg')
        ->select('path_id')
        ->where('perg_id', '=', $pergunta->id)
        ->get();
      if (count($path) > 0) {
        foreach ($path as $path_id) {
          DB::table('paths')->where('id', '=', $path_id->path_id)->delete();
        }
      }
    }


    $sala = Sala::find($id);

    if (isset($sala)) {
      $sala->delete();
    }
    $notification = array(
      'message' => 'Sala deletada com sucesso!',
      'alert-type' => 'danger'
    );

    $strCaminho = public_path() . '/sala/' . $id;


    File::deleteDirectory($strCaminho);



    return redirect('admin/sala')->with($notification);
  }

  public function add_user(Request $request)
  {
    // $data = $request->all();
    // DB::table('sala_user')->insert(
    //   array('sala_id' => $data->sala_id, 'user_id' => $data->user_id)
    // );
    // $salas = Sala::where('public','=',1)->get();
    // $notification = array(
    //   'message' => 'Usuário adicionado com sucesso!!!',
    //   'alert-type' => 'success'
    // );



    // return redirect('admin/alunos'. $request->get('sala_id'))->with($notification);




    // //__________--
    $id_aluno = $request['aluno'];
    $id_sala = $request['sala'];

    if (sizeof($id_aluno) > 0) {
      $tamanho = sizeof($id_aluno);

      for ($cont = 0; $cont < $tamanho; $cont++) {
        DB::table('sala_user')
          ->insert(
            ['user_id' => intval($id_aluno[$cont]), 'sala_id' => $id_sala]
          );
      }
    }
    return response()->json(['success' => 'Sucesso']);
  }

  public function entrar()
  {



    $salas = DB::table('salas')
      //            ->where('enable',1)             //só busca as salas ativas
      ->orderBy('enable', 'desc')
      ->get();;

    $sala_user = DB::table('sala_user')
      ->get();

    $salapu = DB::table('salas')
      ->where('public', '=', 1)
      ->where('enable', 1)
      ->get();

    $salapu2 = count($salapu);

    $salapr = DB::table('salas')
      ->join('sala_user', 'sala_user.sala_id', '=', 'salas.id')
      ->where('sala_user.user_id', '=', Auth::user()->id)
      ->where('public', '=', 0)
      ->where('enable', '=', 1)
      ->get();

    $salapr2 = count($salapr);

    return view('virtual')->with(['data' => $salas, 'sala_user' => $sala_user, 'salapu' => $salapu2, 'salapr' => $salapr2]);
  }

    public function play()
    {
        return view('play');
    }


  public function entrar_guest()
  {
    $salas = Sala::where('public', '=', 1)->get();

    $professores = DB::table('users')
      ->join('role_user', 'users.id', '=', 'role_user.user_id')
      ->orderBy('name')
      ->where('role_user.role_id', '=', 2)
      ->get();

    return view('virtual_guest')->with(['data' => $salas, 'professores' => $professores]);
  }

  public function buscar(Request $request)
  {
    $salas = DB::table('salas')
      ->orderBy('name')
      ->where('public', '=', 1)
      ->where('name', $request->buscar)
      ->get();
    $professores = DB::table('users')
      ->join('role_user', 'users.id', '=', 'role_user.user_id')
      ->orderBy('name')
      ->where('role_user.role_id', '=', 2)
      ->get();
    if (count($salas) <= 0) {
      $salas = Sala::where('public', '=', 1)->get();
      $notification = array(
        'message' => 'Você não tem permissão para editar!',
        'alert-type' => 'warning'
      );
      return redirect('virtual')->with($notification);
    } else
      return view('virtual_guest')->with(['data' => $salas, 'professores' => $professores]);
  }





  public function login(Request $request)
  {


    $email = $request->all('email');
    $senha = $request->all('password');

    $senha2 = $senha['password'];


    $user = DB::table('users')->where('email', $email)->get();


    if (count($user) > 0 && (Hash::check($senha2, $user[0]->password))) {


      $user2 = array(

        'id' => $user[0]->id,
        'name' => $user[0]->name
      );
    } else {

      $user2 = array(

        'id' => -1

      );
    }


    return $user2;
  }



  public function teste()
  {


    if (isset($_REQUEST['type']) && $_REQUEST['type'] != null) {

      $tipo = (int) $_REQUEST['type'];
    } else {

      $tipo = 1;
    }






    if ($tipo == 0) {



      $salas_publicas = DB::table('salas')
        ->where('public', '=', 1)->select('id', 'name')->get();


      if (count($salas_publicas) > 0) {
          $jsn = array();


        foreach ($salas_publicas as $salas) {

          //------------------------------------Porcentagem---------------------------//

          $maze = $salas->id;
          $id =   $_REQUEST['id'];

          $indexperg = 1;
          $progress = 0;
          $jogada = 0;

          $tperg = Pergunta::select('id', 'ordem')->where('sala_id', $maze)->orderBy('ordem')->get();


          $start =  Data::select('start')->where('user_id',$id)->where('maze_id',$maze)->latest('created_at')->first();

            $save = [];

            if($start){

                $jogada = $start->start;

                $save =  Data::select('event', 'question_id')->where('user_id', $id)->where('maze_id', $maze)->where('start', $jogada)->where('event', 'question_end')->get();

            }

          if (count($save) > 0) {

            foreach ($save as $stop) {

              if ($stop->event == "question_end") {

                $progress++;
              }
            }

            $total = count($tperg);

            $progress = ($progress * 100) / $total;
          } else {

            $progress = 0;
          }
          
          //---------------------------Termino Porcentagem--------------------------------//

          $perguntasref = DB::table('perguntas')
            ->join('perg_ref', 'perguntas.id', '=', 'perg_ref.perg_id')
            ->where('sala_id', '=', $salas->id)->get();

          $perguntas = DB::table('perguntas')
            ->where('sala_id', '=', $salas->id)->get();


          if (count($perguntas) > 0) {

            $i2 = count($perguntas);
            $i = count($perguntasref);

            $total = $i2 - $i;

              $salaData = array(
                  'id' => $salas->id,
                  'name' => $salas->name,
                  'Pergunta' => $total,
                  'Reforco' => $i,
                  'Progress' => $progress
              );

              array_push($jsn, $salaData);
          }
        }

        $resultado = array(

          "salas" => $jsn,
          "success" => 1

        );


        return $resultado;
      } else {


        $jsn = array();

        $resultado = array(

          "salas" => $jsn,
          "success" => 1

        );

        return $resultado;
      }
    } elseif ($tipo == 1 && isset($_REQUEST['id'])) {

      $json = $_REQUEST['id'];

      $user = DB::table('users')->where('id', '=', $json)->get();


      if (count($user) > 0) {

        $salas_user = DB::table('sala_user')->where('user_id', '=', $json)->get();

        if (count($salas_user) > 0) {
            $jsn = array();

          foreach ($salas_user as $sala_user) {

            //------------------------------------Contagem ---------------------------//

            $maze = $sala_user->sala_id;
            $id =   $_REQUEST['id'];

            $indexperg = 1;
            $progress = 0;
            $jogada = 0;


            $tperg = Pergunta::select('id', 'ordem')->where('sala_id', $maze)->orderBy('ordem')->get();

            $start =  Data::select('start')->where('user_id',$id)->where('maze_id',$maze)->latest('created_at')->first();

            $save = [];

            if($start){

                $jogada = $start->start;

                $save =  Data::select('event', 'question_id')->where('user_id', $id)->where('maze_id', $maze)->where('start', $jogada)->where('event', 'question_end')->get();

            }

            if (count($save) > 0) {

                foreach ($save as $stop) {

                    if ($stop->event == "question_end") {

                        $progress++;
                    }
                }

                $total = count($tperg);

                $progress = ($progress * 100) / $total;
            } else {

              $progress = 0;
            }



            //---------------------------Termino Contagem --------------------------------//




            $perguntasref = DB::table('perguntas')
              ->join('perg_ref', 'perguntas.id', '=', 'perg_ref.perg_id')
              ->where('sala_id', '=', $sala_user->sala_id)->get();

            $perguntas = DB::table('perguntas')
              ->where('sala_id', '=', $sala_user->sala_id)->get();

            if (count($perguntas) > 0) {

                $i2 = count($perguntas);
                $i = count($perguntasref);

                $total = $i2 - $i;


              $sala = DB::table('salas')
                ->where('id', '=', $sala_user->sala_id)
                ->where('public', '=', 0)
                ->select('id', 'name')->get();
              if (count($sala) > 0){
                  $salaData = array(

                      'id' => $sala[0]->id,
                      'name' => $sala[0]->name,
                      'Pergunta' => $total,
                      'Reforco' => $i,
                      'Progress' => $progress
                  );

                  array_push($jsn, $salaData);
              }
            }
          }

          $resultado = array(

            "salas" => $jsn,
            "success" => 1

          );


          return $resultado;
        } else {

          $jsn = array();

          $resultado = array(

            "salas" => $jsn,
            "success" => 1

          );


          return $resultado;
        }
      } else {

        $jsn = array();

        $resultado = array(

          "salas" => $jsn,
          "success" => -1

        );


        return $resultado;
      }
    } else {

      $jsn = array();

      $resultado = array(

        "salas" => $jsn,
        "success" => -1

      );


      return $resultado;
    }
  }




  public function estatistica($id)
  {
    $salas = DB::table('salas')
      ->where('id', '=', $id)
      ->get();
    $users = DB::table('users')
      ->join('sala_user', 'sala_user.user_id', '=', 'users.id')
      ->where('sala_user.sala_id', $id)
      ->get();
    $perguntas = DB::table('perguntas')
      ->where('sala_id', '=', $id)
      ->get();
    //acertos
    //erros

    if (count($salas) > 0) {
      //            return view('grafico');
      return view('grafico')->with(['salas' => $salas, 'users' => $users, 'perguntas' => $perguntas]);
    }
  }



  public function buscarS(Request $request)
  {
    $id = $request->id;
    $sala = DB::table('salas')->where('id', $id)->get();

    $salas = array(
      'id' => $id,
      'name' => $sala[0]->name,
      'duracao' => $sala[0]->duracao,
      'tematica' => $sala[0]->tematica,
      'public' => $sala[0]->public,
      'enable' =>  $sala[0]->enable
    );

    return json_encode($salas);
  }


  public function addgrupo($id, $salaid)
  {

    $alunos = DB::table('alunos_turma')->where('turmas_id', $id)->get();
    $alunos_sala = DB::table('sala_user')->select('user_id')->where('sala_id', "=", $salaid)->get();
    $salas = TurmaSala::where('id_t', $id)->where('id_s', $salaid)->get();

    if (count($salas) == 0) {

      $salas_t = new TurmaSala;
      $salas_t->id_t = $id;
      $salas_t->id_s = $salaid;
      $salas_t->save();
    }


    foreach ($alunos as $value) {

      $existe = 0;

      foreach ($alunos_sala as $id) {

        if ($id->user_id == $value->aluno_id) {

          $existe  = 1;
        }
      }

      if ($existe  == 0) {

        DB::table('sala_user')->insert(['sala_id' => $salaid, 'user_id' => $value->aluno_id]);
      }
    }


    return;
  }


  public function showgrupos($id)
  {

    $data = DB::table('turmas')->where('id_prof', $id)->get();

    return json_encode($data);
  }

  public function vinculogrupo($id)
  {

    $vinculos = Tumasala::where('id_t', $id)->get();

    return json_encode($vinculos);
  }

    public function remove_user(Request $request)
    {
        $id_aluno = $request['aluno'];
        $id_sala = $request['sala'];

        if (sizeof($id_aluno) > 0) {
            $tamanho = count($id_aluno);

            for ($cont = 0; $cont < $tamanho; $cont++) {

                DB::table('sala_user')->where(['user_id' => intval($id_aluno[$cont]), 'sala_id' => $id_sala])->delete();
            }
        }
        return response()->json(['success' => 'Sucesso']);
    }
}
