<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Charts\PerguntaChart;
use App\User;
use App\Sala;
use App\Pergunta;
use App\Resposta;
use App\Path;
use App\Data;
use DateTime;
use DateTimeZone;

class EstatisticaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $data = DB::table('data')->select('maze_id')->get();

      if(count($data) > 0){

        $sala_user = DB::table('sala_user')->where('sala_id', '=', '$data')->select('user_id','sala_id')->get();

        foreach($sala_user as $salasuser){


         $resultado = $salasuser->user_id;
       }

     }

     return view ('home')->with(['data' => $resultado]);

   }

        public function grafico($sala_id)
    {




            //----------------RESPOSTAS POR PERGUNTA-------------------//
        $data =  array();

        $id = (int) Auth::user()->id;

        $perguntas = DB::table('perguntas')->select('pergunta','id')->whereNotNull('ordem')->where('sala_id',$sala_id)->orderBy('id')->get();

        $sql = 'select p.pergunta from perguntas p JOIN salas s ON p.sala_id = s.id WHERE p.ordem is not NULL AND s.prof_id = ' . $id . ' AND p.sala_id = '.$sala_id.' ORDER BY p.ordem';


        $salas = DB::select($sql);


        foreach($perguntas as $pergunta){
            array_push($data,$pergunta->pergunta);
        }


        $sql = 'select pr.perg_id, count(pr.resp_id) as total from perg_resp pr JOIN perguntas p ON p.id = pr.perg_id JOIN salas s ON p.sala_id = s.id WHERE p.ordem is not NULL AND s.prof_id = ' . $id . ' AND s.id = '.$sala_id.' GROUP BY pr.perg_id ORDER BY p.ordem';


        $totais = DB::select($sql);



        $data_perg = array();

        foreach($totais as $total){
            array_push($data_perg,$total->total);
        }



        $chart = new PerguntaChart;


         $chart->labels($data);
        $chart->dataset('Quantidade de respostas por pergunta', 'bar', $data_perg)->options([
            'backgroundColor' => 'rgba(0, 214, 189, 0.71)'
        ]);


            //----------------ACERTOS POR PERGUNTA-------------------//


            $sala = DB::table('salas')->where('id',$sala_id)->get();

            $y = 0;
            $w = 0;

            $pergs = array();


                    $perguntas = DB::table('perguntas')->where('sala_id','=',$sala[0]->id)->get();
                    foreach($perguntas as $pergunta){

                        for($i = 0; $i<3 ; $i++){
                            $sql =  'select count(d.wrong_count) as total from data d';
                            $sql .= ' JOIN perguntas p ON p.id = d.question_id';
                            $sql .= ' WHERE d.event = "question_end" AND wrong_count = ' . $i . ' AND p.sala_id = '.$sala[0]->id.' AND question_id = ' . $pergunta->id;
                            $sql .= ' GROUP BY d.question_id;';
                            if($i==0){
                                $qtd0 = DB::select($sql);
                                if($qtd0 == NULL)
                                    $qtd0 = 0;
                                else
                                    $qtd0 = $qtd0[0]->total;
                            }elseif($i==1){
                                $qtd1 = DB::select($sql);
                                if($qtd1 == NULL)
                                    $qtd1 = 0;
                                else
                                    $qtd1 = $qtd1[0]->total;
                            }else{
                                $qtd2 = DB::select($sql);
                                if($qtd2 == NULL)
                                    $qtd2 = 0;
                                else
                                    $qtd2 = $qtd2[0]->total;
                            }
                        }

                        $pergs[$y] = ['id' => $pergunta->id, 'pergunta' => $pergunta->pergunta, 'wrong_count' => array('qtd0' => $qtd0, 'qtd1' => $qtd1, 'qtd2' => $qtd2)];

                        $y++;
                    }


                   $grafico[$w] = ['sala_id' => $sala[0]->id, 'sala_nome' => $sala[0]->name, 'sala_pergs' => $pergs];
                    $w++;



            $json = json_encode($grafico);


            /*       SQL??????????


            select user_id, wrong_count, question_id from data
            where wrong_count is not null
            and question_id is not null
            and event='question_end'
            and maze_id = 1
            order by id;


            */


        return view('grafico', [ 'usersChart' => $chart , "acertos" => $json] );



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

      $jogadas = 1;

      $resposta = $request->all(['event_name', 'user_id', 'maze_id', 'question_id', 'answer_id', 'wrong_count', 'correct_count', 'correct', 'elapsed_time', 'answers_read_count','async_timestamp']);

      if($resposta['async_timestamp'] == 0){

       $date = NULL;

     }else{
      $async_timestamp = $resposta['async_timestamp'];
      $formDate = new DateTime('', new DateTimeZone('America/Sao_Paulo'));
      $formDate->setTimeStamp($async_timestamp);
      $date = $formDate->format('Y/m/d H:i:s');
    }


    $event = $resposta['event_name'];


    $start = DB::table('data')->where('maze_id', $resposta['maze_id'])->where('user_id',$resposta['user_id'])->select('event', 'start')->get();





    foreach ($start as $value) {



      if($value->event == 'maze_end'){


        $jogadas = (int)$value->start;
        $jogadas ++;


      }

    }

    $eventos_gerais = array(

      'maze_start' => array ('event_name' => 'maze_start',
        'user_id'   =>  $resposta['user_id'],
        'maze_id' => $resposta['maze_id'],
        'question_id' => $resposta['question_id'],
        'elapsed_time' =>  $resposta['elapsed_time']
      ),
      'question_start' => array ('event_name' => 'question_start',
        'user_id'   =>  $resposta['user_id'],
        'maze_id' => $resposta['maze_id'],
        'question_id' => $resposta['question_id'],
        'elapsed_time' =>  $resposta['elapsed_time'],
        'wrong_count'  => $resposta['wrong_count'],
        'correct_count' => $resposta['correct_count']
      ),
      'question_read' => array ('event_name' => 'question_read',
        'user_id'   =>  $resposta['user_id'],
        'maze_id' => $resposta['maze_id'],
        'question_id' => $resposta['question_id'],
        'elapsed_time' =>  $resposta['elapsed_time']
      ),
      'answer_read' => array ('event_name' => 'answer_read',
        'user_id'   =>  $resposta['user_id'],
        'maze_id' => $resposta['maze_id'],
        'question_id' => $resposta['question_id'],
        'elapsed_time' =>  $resposta['elapsed_time'],
        'answer_id'    =>  $resposta['answer_id']
      ),
      'answer_interaction' => array ('event_name' => 'answer_interaction',
        'user_id'   =>  $resposta['user_id'],
        'maze_id' => $resposta['maze_id'],
        'question_id' => $resposta['question_id'],
        'elapsed_time' =>  $resposta['elapsed_time'],
        'answer_id'    =>  $resposta['answer_id'],
        'correct'      => $resposta['correct'],
      ),
      'question_end' => array ('event_name' => 'question_end',
        'user_id'   =>  $resposta['user_id'],
        'maze_id' => $resposta['maze_id'],
        'question_id' => $resposta['question_id'],
        'elapsed_time' =>  $resposta['elapsed_time'],
        'correct'      => $resposta['correct'],
        'wrong_count'  => $resposta['wrong_count'],
        'correct_count' => $resposta['correct_count']
      ),
      'maze_end' => array ('event_name' => 'maze_end',
        'user_id'   =>  $resposta['user_id'],
        'maze_id' => $resposta['maze_id'],
        'elapsed_time' =>  $resposta['elapsed_time'],
        'wrong_count'  => $resposta['wrong_count'],
        'correct_count' =>$resposta['correct_count']
      )

    );

    $x=0;

    if(isset($_REQUEST['user_id']) && isset($resposta['maze_id'])){

      $user = DB::table('users')
      ->where('id', '=', $resposta['user_id'])
      ->get();
      if(count($user)>0 || $_REQUEST['user_id'] == '0'){
        $x++;
        $sala = DB::table('salas')
        ->where('id', '=', $resposta['maze_id'])
        ->get();
        if(count($sala)>0){
          $x++;
          if( $resposta['question_id'] !=null && $event != 'maze_end'){
            $perg = DB::table('perguntas')
            ->where('id', '=', $resposta['question_id'])
            ->get();
            if(count($perg)>0){
              $x++;
            }else{

              $invalido = array(

                'error' => array(

                  'question_id' => 'invalido'
                ),

                'success' => -1
              );


              return $invalido;

            }
          }
        }else{

          $invalido = array(

            'error' => array(

              'maze' => 'invalido'
            ),

            'success' => -1
          );

          return $invalido;

        }
      }else{


        $invalido = array(

          'error' => array(

            'user' => 'invalido'
          ),

          'success' => -1
        );

        return $invalido;

      }
    }

    foreach ($eventos_gerais  as $key => $value){


     if($value['event_name'] == $event){

       $valor[] = $value;
     }

   }

   if(isset($valor)){


    foreach ($valor[0] as $key => $value) {


      if($value === NULL){


       $erro[] = $key;

     }

   }

   if(isset($erro)){

     $total = array(
      'error' => array(
        'campos vazios' => $erro
      ),
      'success' => -1
    );

     return $total;

   }

   if($_REQUEST['user_id'] == '0'){

     DB::table('data_guest')->insertGetId(array(
      'maze_id' => isset($_REQUEST['maze_id']) ? $_REQUEST['maze_id'] : NULL,
      'event'  =>   $event,
      'question_id' => isset($_REQUEST['question_id']) ? $_REQUEST['question_id'] : NULL,
      'answer_id'   =>  isset($_REQUEST['answer_id']) ? $_REQUEST['answer_id'] : NULL,
      'wrong_count'  =>  isset($_REQUEST['wrong_count']) ? $_REQUEST['wrong_count'] : NULL,
      'correct_count' => isset($_REQUEST['correct_count']) ? $_REQUEST['correct_count'] : NULL,
      'correct'       => isset($_REQUEST['correct']) ? $_REQUEST['correct'] : NULL,
      'start' => $jogadas,
      'elapsed_time' =>  isset($_REQUEST['elapsed_time']) ? $_REQUEST['elapsed_time'] : NULL,
      'answers_read_count' => isset($_REQUEST['answers_read_count']) ? $_REQUEST['answers_read_count'] : NULL,
      'async_timestamp' => $date

    ));


   }else{

               //////Tabela Data ////////////////////////
    DB::table('data')->insertGetId(array(

      'user_id' => isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : NULL ,
      'maze_id' => isset($_REQUEST['maze_id']) ? $_REQUEST['maze_id'] : NULL,
      'event'  =>   $event,
      'question_id' => isset($_REQUEST['question_id']) ? $_REQUEST['question_id'] : NULL,
      'answer_id'   =>  isset($_REQUEST['answer_id']) ? $_REQUEST['answer_id'] : NULL,
      'wrong_count'  =>  isset($_REQUEST['wrong_count']) ? $_REQUEST['wrong_count'] : NULL,
      'correct_count' => isset($_REQUEST['correct_count']) ? $_REQUEST['correct_count'] : NULL,
      'correct'       => isset($_REQUEST['correct']) ? $_REQUEST['correct'] : NULL,
      'start' => $jogadas,
      'elapsed_time' =>  isset($_REQUEST['elapsed_time']) ? $_REQUEST['elapsed_time'] : NULL,
      'answers_read_count' => isset($_REQUEST['answers_read_count']) ? $_REQUEST['answers_read_count'] : NULL,
      'async_timestamp' => $date

    ));

  }



  $resultado = array(

    "event_name" =>  $event,
    "success" => 1

  );

  return $resultado;


}else{

  $resultado = array(
    'error' => array(
      'event_name' => 'Event invalido'
    ),
    'success' => -1
  );

  return $resultado;

}

}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function load(Request $request){
        $id = $_REQUEST['user_id'];
        $maze = $_REQUEST['maze_id'];
        $lastquestion = 0;
        $gamestat = 0;
        $nextquestion = -1;
        $indexperg =0;
        $jogada=0;
        $next = 0;
        $ordem = 0;
        $correct_count=0;
        $wrong_count=0;
        $startnextquestion = null;
        $load = [];
        $rooms = [];
        $resrooms = [];
        $time_elapsed = 0;

        $tperg = Pergunta::select('id','ordem')->where('sala_id',$maze)->whereNotNull('ordem')->orderBy('ordem')->get();

        $start =  Data::select('start')->where('user_id',$id)->where('maze_id',$maze)->latest('created_at')->first();


        if(count($tperg)== 0){

            $result = array(
                'error'=>array('nao existe registro com essas informacoes'),
                'success'=> -1
            );

            return $result;

        }
        else{

            $jogada = $start['start'];


            $save =  Data::select('event','question_id','correct_count','wrong_count','correct','answer_id', 'created_at', 'elapsed_time')->where('user_id',$id)->where('maze_id',$maze)->where('start',$jogada)->get();

            $lastquestion_id = 0;
            if(count($save)>0){
                foreach ($save as $stop) {

                    if($stop->question_id > 0){
                        if(!isset($rooms[$stop->question_id])){
                            $rooms[$stop->question_id]['room_id'] = $stop->question_id;
                            $rooms[$stop->question_id]['answer_id'] = 0;
                            $rooms[$stop->question_id]['right'] = 0;
                            $rooms[$stop->question_id]['wrong'] = 0;
                            $rooms[$stop->question_id]['status'] = 0;
                            $rooms[$stop->question_id]['enterTime'] = 0;
                            $rooms[$stop->question_id]['timeInside'] = 0;
                        }
                    }

                    if($stop->event == "maze_start"){
                        $gamestat = 0;
                    }
                    if($stop->event == "answer_interaction"){
                        $rooms[$stop->question_id]['answer_id'] = $stop->answer_id;
                    }
                    if($stop->event == "question_start"){
                        $rooms[$stop->question_id]['enterTime'] = strtotime($stop->created_at);
                    }
                    if($stop->event == "question_end"){
                        $correct_count = $stop->correct_count;
                        $wrong_count = $stop->wrong_count;
                        $lastquestion = $stop->question_id;

                        $rooms[$stop->question_id]['right'] = (int) ($stop->correct);
                        $rooms[$stop->question_id]['wrong'] = (int) (!$stop->correct);
                        $rooms[$stop->question_id]['status'] = ($stop->correct) ? 1 : 2;
                        $rooms[$stop->question_id]['timeInside'] = strtotime($stop->created_at) - $rooms[$stop->question_id]['enterTime'];
                    }
                    if($stop->event == "maze_end"){
                        $gamestat = 1;
                    }

                    $time_elapsed = $stop->elapsed_time;
                }

            }

            foreach($tperg as $perg){
                $next = $perg->ordem;
                if($indexperg == 0){
                    $startquestion = $perg->id;
                }

                $indexperg ++;

                if($perg->id == $lastquestion){
                    $stopped =  $indexperg;
                    $nextquestion = $perg->ordem +1;
                    $ordem = $nextquestion;
                }

                $endquestion = $perg->id;

                if($perg->ordem == $nextquestion){
                    $nextquestion = $perg->id;
                }


                if($perg->ordem == 1){
                    $startnextquestion = $perg->id;
                }

                if(isset($rooms[$perg->id])){
                    $room = $rooms[$perg->id];
                } else {
                    $room['room_id'] = $perg->id;
                    $room['answer_id'] = 0;
                    $room['right'] = 0;
                    $room['wrong'] = 0;
                    $room['status'] = 0;
                }
                array_push($resrooms, $room);
            }



            if($next < $ordem){
                $nextquestion = null;
            }

            if($nextquestion == -1){
                $nextquestion = $startquestion;
            }

            if(count($save)>0){
                if($lastquestion == 0){

                    $lastquestion = null;
                }

                if($gamestat == 0){

                    $load = array(

                        "stopped_question"=>$lastquestion,
                        "next_question"=>$nextquestion,
                        "correct_count"=>$correct_count,
                        "wrong_count"=>$wrong_count,
                        "timeElapsed" => $time_elapsed,
                        "rooms" => $resrooms

                    );

                }else{

                    $load = array(
                        "stopped_question"=>$endquestion,
                        "next_question"=> null,
                        "correct_count"=>$correct_count,
                        "wrong_count"=>$wrong_count,
                        "timeElapsed" => $time_elapsed,
                        "rooms" => $resrooms
                    );

                }
            }else{
                $load = array(
                    "stopped_question"=> $startquestion,
                    "next_question"=> $startnextquestion,
                    "correct_count"=>$correct_count,
                    "wrong_count"=>$wrong_count,
                    "timeElapsed" => $time_elapsed,
                    "rooms" => $resrooms

                );
            }

            return $load;

        }
    }



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
    public function edit($id)
    {
        //
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
        //
    }
  }
