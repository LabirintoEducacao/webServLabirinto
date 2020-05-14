<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Pergunta;
use App\Path;
use App\Resposta;
use App\Sala;
use App\User;
use App\Charts\PerguntaChart;

class PerguntaRespostaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {

    //      $data = \App\Sala::all ();
    //     return view ( 'edit_sala' )->withData ( $data );
    // }





    public function buscar(Request $request){
        $id = $request->id;
        $pergunta = DB::table('perguntas')->where('id',$id)->get();
        $controle = 0;
        $i = 0;
        $flag = 0;
        $pergid = $id;

        //- Puxando o id do reforco da tabela de Relação perg_ref
        $reforcoid = DB::table('perg_ref')->where('perg_id',$pergid)->get();

        //- Puxando o id das respostas da tabela de Relação Perg_resp
        $respostaid = DB::table('perg_resp')->where('perg_id',$pergid)->get();

        // - Puxando o id dos Paths
        $pathid = DB::table('path_perg')->where('perg_id',$pergid)->get();

    // ------------------ Pergunta Reforço -------------------------

        if(count($reforcoid) == 0){
            $idref=0;
        }


        if(count($reforcoid) > 0){

            $idref = $reforcoid[0]->ref_id;
            $idperg = $reforcoid[0]->perg_id;

            $reforco =  Pergunta::select('id','tipo_perg','pergunta','room_type')->where('id', $idref)->get();

            $ref_resp = DB::table('perg_resp')->select('resp_id') ->where('perg_id',$idref)->get();

            $pathreforco = DB::table('path_perg') ->where('perg_id',$idref)->get();

            $pathrefs = Path::select('ambiente_perg','tamanho','largura','disp','id')->where('id',$pathreforco[0]->path_id)->get();

            // --------------------------- Path Pergunta Reforço-------------------//

            if($pathrefs[0]->disp == 0){
                $dispref = false;
            }

            if($pathrefs[0]->disp == 1){
                $dispref = true;
            }


            $pathref = array(
                'availability' => $dispref,
                'widht' => $pathrefs[0]->largura,
                'height' => $pathrefs[0]->tamanho,
                'type' => $pathrefs[0]->ambiente_perg,
                'conect_question' => $idperg,
                'path_id' => $pathrefs[0]->id
            );

            // ------------------ Respostas Reforço -------------------------

            foreach ($ref_resp as  $value) {

                $idresp = $value->resp_id;

                $respostaref =  Resposta::select('id','tipo_resp','resposta','corret')->where('id',$idresp )->get();

                if($respostaref[0]->corret == 0) {
                    $answ = false;
                }

                if($respostaref[0]->corret == 1) {
                    $answ = true;
                }

                $resp_ref = array(
                    'answer_id' => $respostaref[0]->id,
                    'answer' => $respostaref[0]->resposta,
                    'tipo_resp' => $respostaref[0]->tipo_resp,
                    'correct'=> $answ
                );

                $respref[] = $resp_ref;


            }

            $ref = array(
                'question_id' => $reforco[0]->id,
                'question_type' => $reforco[0]->tipo_perg,
                'question' => $reforco[0]->pergunta,
                'room_type' => $reforco[0]->room_type,
                'path' => $pathref,
                'answer' => $respref
            );
        }
        // Puxando as respostas com o id da tabela de relação !!!!!
        foreach ($respostaid as   $value) {
            $id = $value->resp_id;
            $resposta =  Resposta::select('id','tipo_resp','resposta','corret')->where('id', $id)->get();
            // Preenchendo os campos do json com as respostas !!!!!!!
            if($resposta[0]->corret == 0) {
                $answ = false;
            }
            if($resposta[0]->corret == 1) {
                $answ = true;
            }
            $arresp = array(
                'answer_id' => $resposta[0]->id,
                'answer' => $resposta[0]->resposta,
                'tipo_resp' => $resposta[0]->tipo_resp,
                'correct'=> $answ
            );
            $respost[] = $arresp;
        }
        //Puxando os path com id da tabela relação path_perg
        foreach ($pathid as $value) {
            $path = Path::select('ambiente_perg','tamanho','largura','disp','id')->where('id',$value->path_id)->get();

            if($path[0]->disp == 1){
                $disponivel = "right";
            }

            if($path[0]->disp == 0){
                $disponivel = "wrong";
                $conect = $idref;
            }

            // Definindo os campos do Jason com o path
            if($path[0]->disp == 1){

                $conttrue = 58;

                $pat= array(
                    'availability' => $disponivel,
                    'widht' => $path[0]->largura,
                    'height' => $path[0]->tamanho,
                    'type' => $path[0]->ambiente_perg,
                    'path_id' => $path[0]->id,
                    'end_game'=> true
                );

            }
            if($path[0]->disp == 0){

                $pat= array(
                    'availability' => $disponivel,
                    'widht' => $path[0]->largura,
                    'height' => $path[0]->tamanho,
                    'type' => $path[0]->ambiente_perg,
                    'path_id' => $path[0]->id,
                    'conect_question'=> $conect
                );
            }


            $paths [] = $pat;

        }

        //Preenchendo os campos do json com as perguntas !!!!!!

        $perguntas = array(
            'question_id' => $pergunta[0]->id,
            'question_type' => $pergunta[0]->tipo_perg,
            'question' => $pergunta[0]->pergunta,
            'room_type' => $pergunta[0]->room_type,
            'path' => $paths,
            'answer' =>  $respost
        );
        if(count($reforcoid) > 0){
            $arperg [] = $perguntas;
            $arperg [] = $ref;
        }
        if(count($reforcoid) == 0){
            $arperg [] = $perguntas;
        }
        $jsn = [
            "questions" => $arperg
        ];

//        return response()->json(['data' => json_encode($jsn)]);
        return json_encode($arperg);

//        $teste_perg=Pergunta::find(49);
//        echo $teste_perg->sala_id;
    }
    public function index2($id)
    {
      // dessa forma mostra sem paginação uma lista de usuarios
      //return view('admin.users.index')->with('users', User::all());

      //Com paginação
        $perguntas = Pergunta::where('sala_id', '=', $id)->paginate(5);
        $respostas = DB::table('respostas')
        ->where('sala_id','=',$id)
        ->get();
        $perg_resps =  DB::table('perg_resp')
        ->get();
        return view('teste_perg')->with(['data' => $perguntas, 'resps' =>$respostas, 'perg_resps' => $perg_resps]);
    }


    public function index($id)
    {

        $ref =0;

        /*$sql = 'SELECT COUNT(id) FROM perguntas';
        $sql += 'WHERE sala_id = ' . $id;
        $sql += 'AND ordem IS NOT NULL';

        $count = DB::select($sql); */

        $sala = DB::table('salas')
        ->where('id','=',$id)
        ->get();

        $perguntas = Pergunta::where('sala_id', $id)->whereNotNull('ordem')
        ->orderBy('ordem')->paginate(5);

        $path_perg = DB::table('path_perg')
        ->join('perguntas','perguntas.id','=','path_perg.perg_id')
        ->where('perguntas.sala_id', '=', $id)
        ->get();
        $paths = DB::table('paths')
        ->get();

        $ref = DB::table('perguntas')
        ->where('sala_id','=',$id )->whereNull('ordem')
        ->get();

        $pergs = DB::table('perguntas')
        ->where('sala_id','=',$id )->whereNotNull('ordem')
        ->orderBy('ordem')
        ->get();



        $perg_refs = DB::table('perg_ref')
        ->join('perguntas','perguntas.id','=','perg_ref.perg_id')
        ->where('perguntas.sala_id', '=', $id)
        ->get();


        $id_pergunta =  DB::table('perguntas')
        ->where('perguntas.sala_id', '=', $id)
        ->select('id')
        ->get();

        $qtdresps = DB::table('perguntas')
        ->join('perg_ref','perguntas.id','=','perg_ref.ref_id')
        ->join('perg_resp','perguntas.id','=','perg_resp.perg_id')
        ->join('respostas','respostas.id','=','perg_resp.resp_id')
        ->select('resposta')
        ->where('perguntas.sala_id', '=', $id)
        ->where('perguntas.id','=', 2)
        ->get();



  //`POr poergunta dinamico
   //       $id_pergunta =  DB::table('perguntas')
   //           ->join('perg_ref', 'perguntas.id','=', 'perg_ref.perg_id' )
   //           ->where('perguntas.sala_id', '=', $id)
   //           ->select('perguntas.id')
   //           ->get();

   // $qtdresps = DB::table('perguntas')
   //          ->join('perg_ref','perguntas.id','=','perg_ref.ref_id')
   //          ->join('perg_resp','perguntas.id','=','perg_resp.perg_id')
   //          ->join('respostas','respostas.id','=','perg_resp.resp_id')
   //          ->select('resposta')
   //          ->where('perguntas.sala_id', '=', $id)
   //          ->where('perguntas.id','=', 1)
   //          ->get();












        $teste50 =  count($qtdresps);
        //$teste50 = $id_pergunta[1]->id ;


        if(count($pergs)>0){
            $count_pergs=count($pergs);
        }else{
            $count_pergs=0;
        }

        if(count($ref)>0){
            $count_ref=count($ref);
        }else{
            $count_ref=0;
        }
        $respostas = DB::table('respostas')
        ->where('sala_id','=',$id)
        ->get();
        $perg_resp =  DB::table('perg_resp')
        ->get();
        return view ( 'edit_sala', ['id' => $id, 'sala'=>$sala[0] ] )->with(['data' => $perguntas, 'respostas' => $respostas, 'perg_resp' => $perg_resp, 'path_perg' => $path_perg, 'paths' => $paths,'pergs'=>$pergs,'c_perg'=>$count_pergs,'totalperg'=>$teste50,'c_ref'=>$count_ref, 'refs' =>$ref,'perg_refs'=>$perg_refs]);
    }

    public function alterar(Request $request){
        if($request->ajax())
        {
            $lista = $request->lista;
            $y=1;
            for($count = 0; $count < count($lista); $count++)
            {

                $perg = Pergunta::find($lista[$count]);
                $perg->ordem=$y;
                $perg->save();


                $y++;

            }

            return response()->json(['success' => 'sucesso.']);

        }

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

    public function edit_resp(Request $request){
        $data = $request->all();
        DB::table('respostas')
        ->where('id','=', $data['resposta_id'])
        ->update(['tipo_resp' => $data['resposta_type'],'resposta' => $data['resposta_name'],'corret' => $data['resposta_correct']]);

        $perg = DB::table('perguntas')
        ->where('sala_id','=',$data['sala_id'])
        ->get();
        $respostas = DB::table('respostas')
        ->where('sala_id','=',$data['sala_id'])
        ->get();
        $notification = array(
            'message' => 'Resposta alterada com sucesso!',
            'alert-type' => 'success'
        );
        return redirect('admin/editar-sala/'. $data['sala_id'])->with(['data' => $perg, 'respostas' => $respostas])->with($notification);
    }

    public function edit_perg(Request $request){
        $data = $request->all();
        DB::table('perguntas')
        ->where('id','=', $data['pergunta_id'])
        ->update(['tipo_perg' => $data['pergunta_type'],'pergunta' => $data['pergunta_name'],'room_type' => $data['perg_room_type']]);
        DB::table('paths')
        ->where('id','=',$data['pergunta_path'])
        ->update(['ambiente_perg' => $data['pergunta_ambiente'],'tamanho' => $data['pergunta_tamanho'], 'largura' => $data['pergunta_largura']]);

        $perg = DB::table('perguntas')
        ->where('sala_id','=',$data['sala_id'] )->whereNotNull('ordem')
        ->orderBy('ordem')
        ->get();
        $path_perg = DB::table('path_perg')
        ->get();
        $paths = DB::table('paths')
        ->get();
        $ref = DB::table('perguntas')
        ->where('sala_id','=',$data['sala_id'] )->whereNull('ordem')
        ->orderBy('ordem')
        ->get();
        $respostas = DB::table('respostas')
        ->where('sala_id','=',$data['sala_id'])
        ->get();
        $perg_resp =  DB::table('perg_resp')
        ->get();

        $notification = array(
            'message' => 'Pergunta alterada com sucesso!',
            'alert-type' => 'success'
        );

        return redirect('admin/editar-sala/'. $data['sala_id'])->with(['data' => $perg, 'ref' => $ref, 'respostas' => $respostas, 'perg_resp' => $perg_resp, 'path_perg' => $path_perg, 'paths' => $paths])->with($notification);
    }


    public function edit_ambi(Request $request){
        $data = $request->all();
        DB::table('paths')
        ->where('id','=',$data['path_id'])
        ->update(['ambiente_perg' => $data['pergunta_ambientex'],'tamanho' => $data['pergunta_tamanhox'], 'largura' => $data['pergunta_largurax']]);
        $perg = DB::table('perguntas')
        ->where('sala_id','=',$data['sala_id'] )->whereNotNull('ordem')
        ->orderBy('ordem')
        ->get();
        $path_perg = DB::table('path_perg')
        ->get();
        $paths = DB::table('paths')
        ->get();
        $ref = DB::table('perguntas')
        ->where('sala_id','=',$data['sala_id'] )->whereNull('ordem')
        ->orderBy('ordem')
        ->get();
        $respostas = DB::table('respostas')
        ->where('sala_id','=',$data['sala_id'])
        ->get();
        $perg_resp =  DB::table('perg_resp')
        ->get();


        $notification = array(
            'message' => 'Ambiente alterado com sucesso!',
            'alert-type' => 'success'
        );

        return redirect('admin/editar-sala/'. $data['sala_id'])->with(['data' => $perg, 'ref' => $ref, 'respostas' => $respostas, 'perg_resp' => $perg_resp, 'path_perg' => $path_perg, 'paths' => $paths])->with($notification);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $salaid = $request->sala_id;
        $ordem = Pergunta::select('ordem')->where('sala_id', $salaid)->orderBy('ordem')->get();

        foreach ($ordem as $value){
            $teste = $value->ordem;
        }


        if(isset($teste)){

            $teste ++;

        }
        if(!isset($teste)){

            $teste = 0;
        }


        if($request->ajax())
        {

            $rules = array(
            'resposta.*' => 'required',
            'resposta_ref.*' => 'required');

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['error' => $error->errors()->all()]);

            }

            if($request->perg_id == 0){

                ////////Perguntas///////////
                $sala_id = $request->sala_id;
                $tipo_perg = $request->question_type;
                $pergunta = $request->pergunta;
                $room_type = $request->room_type;

                ///////////Path////////////
                $ambiente_perg = $request->answer_boolean;
                $tamanho1 = $request->tamanho;
                $largura1 = $request->largura;
                $disponivel = true;

                if($ambiente_perg==1){

                    $tamanho_perg = rand(1,3);
                    $largura_perg = rand(1,3);

                }else{

                    if($tamanho1 == 1 ){
                        $tamanho_perg = rand(1,3);


                    }else if($tamanho1 == 2 ){
                        $tamanho_perg = rand(4,6);


                    }else if($tamanho1 == 3 ){
                        $tamanho_perg = rand(7,10);
                    }

                    if($largura1 == 1 ){

                        $largura_perg = rand(1,3);
                    }else if($largura1 == 2 ){

                        $largura_perg = rand(4,6);
                    }else if($largura1 == 3 ){

                        $largura_perg = rand(7,10);
                    }


                }

                ////////Tabela Pergunta ////////////////////////
                $pergid = DB::table('perguntas')->insertGetId(array(

                'sala_id' => $sala_id,
                'tipo_perg' => $tipo_perg,
                'pergunta' => $pergunta,
                'ordem' =>   $teste,
                'room_type' => $room_type

                ));



                ////////////Tabela Path//////////////////
                $pathid = DB::table('paths')->insertGetId(array(

                'ambiente_perg' => $ambiente_perg,
                'tamanho' => $tamanho_perg,
                'largura' => $largura_perg,
                'disp' => $disponivel


                ));


                DB::table('path_perg')->insert(array('perg_id' => $pergid, 'path_id' => $pathid));


                /////Resposta1////////////
                $tipo_resp = $request->tipo_resp;
                $resposta = $request->resposta;
                $corret = explode(',', $request->correto);
                $sala_id = $request->sala_id;


                for($count = 0; $count < count($resposta); $count++)
                {

                    $id = DB::table('respostas')->insertGetId(array(

                    'sala_id'  =>  $sala_id,
                    'tipo_resp' => $tipo_resp,
                    'resposta' => $resposta[$count],
                    'corret' => $corret[$count]


                    ));

                    DB::table('perg_resp')->insert(array('perg_id' => $pergid, 'resp_id' => $id));

                }

                if($request->perg_reforco==1){



                    //  ////////////////Patch errado da Pergunta/////////
                    $ambiente_perg = $request->answer_boolean_perg;
                    $tamanho2 = $request->tamanho_perg;
                    $largura2 = $request->largura_perg;
                    $disponivel = true;
                    if($ambiente_perg==1){
                        $tamanho_perg = rand(1,3);
                        $largura_perg = rand(1,3);
                    }else{

                        if($tamanho2 == 1 ){
                            $tamanho_perg = rand(1,3);


                        }else if($tamanho2 == 2 ){
                            $tamanho_perg = rand(4,6);


                        }else if($tamanho2 == 3 ){
                            $tamanho_perg = rand(7,10);


                        }

                        if($largura2 == 1 ){

                            $largura_perg = rand(1,3);

                        }else if($largura2 == 2 ){

                            $largura_perg = rand(4,6);

                        }else if($largura2 == 3 ){
                            $largura_perg = rand(7,10);

                        }




                    }
                    $disponivel_perg = false;

                    ////////Perguntas///////////

                    $sala_id_ref = $request->sala_id;
                    $tipo_perg_ref = $request->question_type_ref;
                    $pergunta_ref = $request->reforco;
                    $room_type_ref = $request->room_type_ref;


                    /////Resposta2////////////
                    $tipo_resp_ref = $request->tipo_resp_ref;
                    $resposta_ref = $request->resposta_ref;
                    $corret_ref = explode(',', $request->correto_ref);


                    ////////////////PatchReforco/////////
                    $ambiente_ref = $request->answer_boolean_ref;
                    $tamanho_ref1 = $request->tamanho_ref;
                    $largura_ref1 = $request->largura_ref;


                    if($ambiente_ref==1){
                        $tamanho_ref = rand(1,3);
                        $largura_ref = rand(1,3);
                    }else{
                        if($tamanho_ref1 == 1 ){
                            $tamanho_ref = rand(1,3);

                        }else if($tamanho_ref1 == 2 ){
                            $tamanho_ref = rand(4,6);

                        }else if($tamanho_ref1 == 3 ){
                            $tamanho_ref = rand(7,10);


                        }

                        if($largura_ref1 == 1 ){

                            $largura_ref = rand(1,3);

                        }else if($largura_ref1 == 2 ){

                            $largura_ref = rand(4,6);

                        }else if($largura_ref1 == 3 ){

                            $largura_ref = rand(7,10);

                        }


                    }

                    $disponivel_ref = true;


                    ////////////Tabela Path ambiente errado//////////////////
                    $pathidperg = DB::table('paths')->insertGetId(array(
                    'ambiente_perg' =>  $ambiente_perg,
                    'tamanho' =>   $tamanho_perg,
                    'largura' => $largura_perg,
                    'disp' => $disponivel_perg
                    ));

                    ////////////Tabela Path//////////////////
                    $pathidref = DB::table('paths')->insertGetId(array(
                    'ambiente_perg' =>  $ambiente_ref,
                    'tamanho' =>   $tamanho_ref,
                    'largura' => $largura_ref,
                    'disp' => $disponivel_ref
                    ));

                    ////////Tabela Pergunta ////////////////////////
                    $pergid2 = DB::table('perguntas')->insertGetId(array(
                    'sala_id' => $sala_id_ref,
                    'tipo_perg' => $tipo_perg_ref,
                    'pergunta' => $pergunta_ref,
                    'room_type' => $room_type_ref
                    ));

                    DB::table('path_perg')->insert(array('perg_id' => $pergid, 'path_id' =>  $pathidperg));

                    DB::table('path_perg')->insert(array('perg_id' => $pergid2, 'path_id' =>  $pathidref));

                    DB::table('perg_ref')->insert(array('perg_id' => $pergid, 'ref_id' => $pergid2));


                    ////////////////Tabela Resposta2//////////////////////

                    for($i = 0; $i < count($resposta_ref); $i++)
                    {
                        $reforcoid = DB::table('respostas')->insertGetId(array(

                        'sala_id'  =>  $sala_id,
                        'tipo_resp' => $tipo_resp_ref,
                        'resposta' => $resposta_ref[$i],
                        'corret' => $corret_ref[$i]


                        ));


                        DB::table('perg_resp')->insert(array('perg_id' => $pergid2, 'resp_id' => $reforcoid));

                    }

                }

                return response()->json(['success' => 'Pergunta cadastrada com sucesso!']);


            }else{

                DB::table('perguntas')
                ->where('id','=', $request->perg_id)
                ->update(['tipo_perg' => $request->question_type,'pergunta' => $request->pergunta,'room_type' => $request->room_type]);

                $respostas = DB::table('respostas')
                ->join('perg_resp','perg_resp.resp_id','=','respostas.id')
                ->where('perg_resp.perg_id','=', $request->perg_id)
                ->get();
                $tipo_resp = $request->tipo_resp;
                $resposta = $request->resposta;
                $resp_id = $request->resp_id;
                $corret = explode(',', $request->correto);
                $sala_id = $request->sala_id;
                $count=0;
                DB::table('respostas')
                ->where('id','=', $resp_id[$count])
                ->update(['tipo_resp' => $tipo_resp,'resposta' => $resposta[$count],'corret' => $corret[$count]]);

                foreach($respostas as $resp){
                    $v=0;
                    for($i=0;$i<count($resposta);$i++){
                        if($resp_id[$i]==$resp->id){
                            $v++;
                        }
                        if($i==(count($resposta)-1)){
                            if($v==0){
                                $deleteResp = Resposta::find($resp->id);
                                $deleteResp->delete();
                            }
                        }
                    }
                }

                for($count = 0; $count < count($resposta); $count++)
                {

                    $att_resp_id = DB::table('respostas')
                    ->where('id','=',$resp_id[$count])
                    ->get();

                    if(count($att_resp_id)>0){
                        DB::table('respostas')
                        ->where('id','=', $resp_id[$count])
                        ->update(['tipo_resp' => $tipo_resp,'resposta' => $resposta[$count],'corret' => $corret[$count]]);

                    }else{

                        $resposta_id_s = DB::table('respostas')->insertGetId(array(

                        'sala_id'  => $request->sala_id,
                        'tipo_resp' => $tipo_resp,
                        'resposta' => $resposta[$count],
                        'corret' => $corret[$count]


                        ));

                        DB::table('perg_resp')->insert(array('perg_id' => $request->perg_id, 'resp_id' => $resposta_id_s));

                    }


                }

                $ambiente_perg = $request->answer_boolean;

                $tamanho1 = $request->tamanho;
                $largura1 = $request->largura;
                if($ambiente_perg==1){
                    $tamanho_perg = rand(1,3);
                    $largura_perg = rand(1,3);

                }else{


                    if($tamanho1 == 1 ){
                        $tamanho_perg = rand(1,3);

                    }else if($tamanho1 == 2 ){
                        $tamanho_perg = rand(4,6);


                    }else if($tamanho1 == 3 ){
                        $tamanho_perg = rand(7,10);


                    }

                    if($largura1 == 1 ){
                        $largura_perg = rand(1,3);
                    }else if($largura1 == 2 ){
                        $largura_perg = rand(4,6);
                    }else if($largura1 == 3 ){
                        $largura_perg = rand(7,10);
                    }

                }

                //return response()->json(["success"=>$request->path_id]);
                DB::table('paths')
                ->where('id','=', $request->path_id)
                ->update(['ambiente_perg' => $ambiente_perg,'tamanho' => $tamanho_perg,'largura' => $largura_perg]);

                if($request->perg_reforco_id>0 && $request->perg_reforco==1){

                    DB::table('perguntas')
                    ->where('id','=', $request->perg_reforco_id)
                    ->update(['tipo_perg' => $request->question_type_ref,'pergunta' => $request->reforco,'room_type' => $request->room_type_ref]);

                    $respostas_ref = DB::table('respostas')
                    ->join('perg_resp','perg_resp.resp_id','=','respostas.id')
                    ->where('perg_resp.perg_id','=', $request->perg_reforco_id)
                    ->get();
                    $tipo_resp_ref = $request->tipo_resp_ref;
                    $resposta_ref = $request->resposta_ref;
                    $corret_ref = explode(',', $request->correto_ref);
                    $resp_ref_id = $request->resp_ref_id;

                    $ambiente_ref = $request->answer_boolean_ref;
                    $tamanho_ref1 = $request->tamanho_ref;
                    $largura_ref1 = $request->largura_ref;


                    if($ambiente_ref==1){
                        $tamanho_ref = rand(1,3);
                        $largura_ref = rand(1,3);
                    }else{
                        if($tamanho_ref1 == 1 ){
                            $tamanho_ref = rand(1,3);

                        }else if($tamanho_ref1 == 2 ){
                            $tamanho_ref = rand(4,6);

                        }else if($tamanho_ref1 == 3 ){
                            $tamanho_ref = rand(7,10);


                        }

                        if($largura_ref1 == 1 ){

                            $largura_ref = rand(1,3);

                        }else if($largura_ref1 == 2 ){

                            $largura_ref = rand(4,6);

                        }else if($largura_ref1 == 3 ){

                            $largura_ref = rand(7,10);

                        }


                    }


                    DB::table('paths')
                    ->where('id','=', $request->path_reforco_id)
                    ->update(['ambiente_perg' => $ambiente_ref,'tamanho' => $tamanho_ref,'largura' => $largura_ref]);

                    $ambiente_perg = $request->answer_boolean_perg;
                    $tamanho1 = $request->tamanho_perg;
                    $largura1 = $request->largura_perg;
                    $disponivel = true;

                    if($ambiente_perg==1){
                        $tamanho = rand(1,3);
                        $largura = rand(1,3);
                    }else{

                        if($tamanho1 == 1 ){
                            $tamanho = rand(1,3);

                        }else if($tamanho1 == 2 ){
                            $tamanho = rand(4,6);

                        }else if($tamanho1 == 3 ){
                            $tamanho = rand(7,10);


                        }

                        if($largura1 == 1){
                            $largura = rand(1,3);

                        }else if($largura1 == 2){
                            $largura = rand(4,6);
                        }else if($largura1 == 3){
                            $largura = rand(7,10);
                        }


                    }


                    DB::table('paths')
                    ->where('id','=', $request->path_errado_id)
                    ->update(['ambiente_perg' => $ambiente_perg,'tamanho' => $tamanho,'largura' => $largura]);

                    foreach($respostas_ref as $resp_ref){
                        $v=0;
                        for($i=0;$i<count($resposta_ref);$i++){
                            if($resp_ref_id[$i]==$resp_ref->id){
                                $v++;
                            }
                            if($i==(count($resposta_ref)-1)){
                                if($v==0){
                                    $deleteRespRef = Resposta::find($resp_ref->id);
                                    $deleteRespRef->delete();
                                }
                            }
                        }
                    }

                    for($count = 0; $count < count($resposta_ref); $count++)
                    {

                        $id_ref = DB::table('respostas')
                        ->where('id','=',$resp_ref_id[$count])
                        ->get();
                        if(count($id_ref)>0){
                            DB::table('respostas')
                            ->where('id','=', $resp_ref_id[$count])
                            ->update(['tipo_resp' => $tipo_resp_ref,'resposta' => $resposta_ref[$count],'corret' => $corret_ref[$count]]);
                        }else{

                            $resposta_id_ref = DB::table('respostas')->insertGetId(array(

                            'sala_id'  => $request->sala_id,
                            'tipo_resp' => $tipo_resp_ref,
                            'resposta' => $resposta_ref[$count],
                            'corret' => $corret_ref[$count]


                            ));

                            DB::table('perg_resp')->insert(array('perg_id' => $request->perg_reforco_id, 'resp_id' => $resposta_id_ref));

                        }


                    }

                }elseif($request->perg_reforco_id==0 && $request->perg_reforco==1){


                    $perg_ref = DB::table('perg_ref')
                    ->where('perg_id','=',$request->perg_id)
                    ->get();

                    if(count($perg_ref)>0){
                        DB::table('perguntas')
                        ->where('id','=', $perg_ref[0]->ref_id)
                        ->update(['tipo_perg' => $request->question_type_ref,'pergunta' => $request->reforco,'room_type' => $request->room_type_ref]);

                        $ambiente_perg = $request->answer_boolean_perg;
                        $tamanho1 = $request->tamanho_perg;
                        $largura1 = $request->largura_perg;
                        $disponivel = true;
                        $largura = 0;

                        if($ambiente_perg==1){
                            $tamanho_perg = rand(1,3);
                            $largura_perg = rand(1,3);
                        }else{

                            if($tamanho1 == 1 ){
                                $tamanho = rand(1,3);

                            }else if($tamanho1 == 2 ){
                                $tamanho = rand(4,6);

                            }else if($tamanho1 == 3 ){
                                $tamanho = rand(7,10);


                            }

                            if($largura1 == 1){
                                $largura = rand(1,3);

                            }else if($largura1 == 2){
                                $largura = rand(4,6);
                            }else if($largura1 == 3){
                                $largura = rand(7,10);
                            }


                        }

                        DB::table('paths')
                        ->join('path_perg', 'paths.id', '=', 'path_perg.path_id')
                        ->where('path_perg.perg_id','=', $perg_ref[0]->ref_id)
                        ->update(['path.ambiente_perg' => $ambiente_perg,'path.tamanho' => $tamanho,'path.largura' => $largura]);

                        $respostas_ref = DB::table('respostas')
                        ->join('perg_resp','perg_resp.resp_id','=','respostas.id')
                        ->where('perg_resp.perg_id','=', $perg_ref[0]->ref_id)
                        ->get();
                        foreach($respostas_ref as $resp_ref){
                            $deleteRespRef = Resposta::find($resp_ref->id);
                            $deleteRespRef->delete();
                        }

                        $tipo_resp_ref = $request->tipo_resp_ref;
                        $resposta_ref = $request->resposta_ref;
                        $corret_ref = explode(',', $request->correto_ref);
                        for($count = 0; $count < count($resposta_ref); $count++)
                        {
                            $resposta_id_ref = DB::table('respostas')->insertGetId(array(

                            'sala_id'  => $request->sala_id,
                            'tipo_resp' => $tipo_resp_ref,
                            'resposta' => $resposta_ref[$count],
                            'corret' => $corret_ref[$count]


                            ));

                            DB::table('perg_resp')->insert(array('perg_id' => $perg_ref[0]->ref_id, 'resp_id' => $resposta_id_ref));
                        }



                    }else{

                        //  ////////////////Patch errado da Pergunta/////////
                        $ambiente_perg = $request->answer_boolean_perg;
                        $tamanho1 = $request->tamanho_perg;
                        $largura1 = $request->largura_perg;
                        $disponivel = true;
                        $largura = 0;

                        if($ambiente_perg==1){
                            $tamanho_perg = rand(1,3);
                            $largura_perg = rand(1,3);
                        }else{

                            if($tamanho1 == 1 ){
                                $tamanho_perg = rand(1,3);

                            }else if($tamanho1 == 2 ){
                                $tamanho_perg = rand(4,6);

                            }else if($tamanho1 == 3 ){
                                $tamanho_perg = rand(7,10);


                            }

                            if($largura1 == 1){
                                $largura_perg = rand(1,3);

                            }else if($largura1 == 2){
                                $largura_perg = rand(4,6);
                            }else if($largura1 == 3){
                                $largura_perg = rand(7,10);
                            }


                        }
                        $disponivel_perg = false;

                        ////////Perguntas///////////

                        $sala_id_ref = $request->sala_id;
                        $tipo_perg_ref = $request->question_type_ref;
                        $pergunta_ref = $request->reforco;
                        $room_type_ref = $request->room_type_ref;


                        /////Resposta2////////////
                        $tipo_resp_ref = $request->tipo_resp_ref;
                        $resposta_ref = $request->resposta_ref;
                        $corret_ref = explode(',', $request->correto_ref);


                        ////////////////PatchReforco/////////
                        $ambiente_ref = $request->answer_boolean_ref;
                        $tamanho_ref1 = $request->tamanho_ref;
                        $largura_ref1 = $request->largura_ref;
                        $largura_ref = 0;


                        if($ambiente_ref==1){
                            $tamanho_ref = 3;
                            $largura_ref = 2;
                        }else{
                            if($tamanho_ref1 == 1 ){
                                $tamanho_ref = rand(1,3);
                            }else if($tamanho_ref1 == 2 ){
                                $tamanho_ref = rand(4,6);


                            }else if($tamanho_ref1 == 3 ){
                                $tamanho_ref = rand(7,10);

                            }

                            if($largura_ref1 == 1 ){
                                $largura_ref = rand(1,3);

                            }else if($largura_ref1 == 2 ){
                                $largura_ref = rand(4,6);

                            }else if($largura_ref1 == 3 ){
                                $largura_ref = rand(7,10);

                            }


                        }
                        $disponivel_ref = true;


                        ////////////Tabela Path ambiente errado//////////////////
                        $pathidperg = DB::table('paths')->insertGetId(array(
                        'ambiente_perg' =>  $ambiente_perg,
                        'tamanho' =>   $tamanho_perg,
                        'largura' => $largura_perg,
                        'disp' => $disponivel_perg
                        ));

                        ////////////Tabela Path//////////////////
                        $pathidref = DB::table('paths')->insertGetId(array(
                        'ambiente_perg' =>  $ambiente_ref,
                        'tamanho' =>   $tamanho_ref,
                        'largura' => $largura_ref,
                        'disp' => $disponivel_ref
                        ));

                        ////////Tabela Pergunta ////////////////////////
                        $pergid2 = DB::table('perguntas')->insertGetId(array(
                        'sala_id' => $sala_id,
                        'tipo_perg' => $tipo_perg_ref,
                        'pergunta' => $pergunta_ref,
                        'room_type' => $room_type_ref
                        ));

                        DB::table('path_perg')->insert(array('perg_id' => $request->perg_id, 'path_id' =>  $pathidperg));

                        DB::table('path_perg')->insert(array('perg_id' => $pergid2, 'path_id' =>  $pathidref));

                        DB::table('perg_ref')->insert(array('perg_id' => $request->perg_id, 'ref_id' => $pergid2));


                        ////////////////Tabela Resposta2//////////////////////

                        for($i = 0; $i < count($resposta_ref); $i++)
                        {
                            $reforcoid = DB::table('respostas')->insertGetId(array(

                            'sala_id'  =>  $sala_id,
                            'tipo_resp' => $tipo_resp_ref,
                            'resposta' => $resposta_ref[$i],
                            'corret' => $corret_ref[$i]


                            ));


                            DB::table('perg_resp')->insert(array('perg_id' => $pergid2, 'resp_id' => $reforcoid));

                        }
                    }
                }
                else{

                    $paths_perg = DB::table('path_perg')
                    ->where('perg_id','=',$request->perg_id)
                    ->get();

                    if(count($paths_perg)>1){
                        $perg_ref = DB::table('perg_ref')
                        ->where('perg_id','=',$request->perg_id)
                        ->get();

                        if(count($perg_ref)>0){
                            $repostas_ref = DB::table('perg_resp')
                            ->where('perg_id','=',$perg_ref[0]->ref_id)
                            ->get();
                            $paths_ref = DB::table('path_perg')
                            ->where('perg_id','=',$perg_ref[0]->ref_id)
                            ->get();
                            DB::table('perguntas')
                            ->where('id','=',$perg_ref[0]->ref_id)
                            ->delete();

                            foreach($repostas_ref as $resp_ref){
                                $deleteRespRef = Resposta::find($resp_ref->resp_id);
                                $deleteRespRef->delete();
                            }

                            $deletePathRef = Path::find($paths_ref[0]->path_id);
                            $deletePathRef->delete();

                        }


                        $x=0;
                        foreach($paths_perg as $path){
                            if($x==1)
                                DB::table('paths')->where('id', $path->path_id)->delete();
                            $x++;
                        }

                    }
                }






                return response()->json(['success' => 'Pergunta alterada com sucesso!']);

            }
        }
        }

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
        $resp = DB::table('perg_resp')
        ->select('resp_id')
        ->where('perg_id', '=', $id)
        ->get();

        $perguntaref = DB::table('perg_ref')
        ->where('perg_id', '=', $id)
        ->get();


        $path = DB::table('path_perg')
        ->select('path_id')
        ->where('perg_id', '=', $id)
        ->get();


        $perg = Pergunta::find($id);


        if(count($path)> 0){

            foreach ($path as $path_id) {
                DB::table('paths')->where('id', '=', $path_id->path_id)->delete();
            }

        }


        if(count($perguntaref)> 0){

           $ref = $perguntaref[0]->ref_id;
           $resp2 = DB::table('perg_resp')
           ->select('resp_id')
           ->where('perg_id', '=', $ref)
           ->get();
           $path_ref = DB::table('path_perg')
           ->where('perg_id', '=', $perguntaref[0]->ref_id)
           ->get();
           DB::table('paths')->where('id', '=', $path_ref[0]->path_id)->delete();
           DB::table('perguntas')->where('id', $ref)->delete();

           foreach ($resp2 as $resp_id2) {
            DB::table('respostas')->where('id', $resp_id2->resp_id)->delete();
        }

    }



    DB::table('perg_resp')->where('perg_id', '=', $id)->delete();
    DB::table('perguntas')->where('id', '=', $id)->delete();


    foreach ($resp as $resp_id) {
        DB::table('respostas')->where('id', '=', $resp_id->resp_id)->delete();
    }

    $notification = array(
        'message' => 'Pergunta deletada com sucesso!',
        'alert-type' => 'danger'
    );
    return redirect('admin/visualizar/'. $perg->sala_id)->with($notification);
}

public function indexJson($id)
{

      // $pergunta =  Pergunta::select('id','tipo_perg','pergunta','room_type')->where('sala_id', $id)->whereNotNull('ordem')->orderBy('ordem')->get();



      //   foreach ($pergunta as $value ) {

      //       $id_perg = $value->id;
      //       $resp_rel = DB::table('perg_resp')->select('resp_id') ->where('perg_id',$id_perg)->get();



      //        foreach ($resp_rel as $key ) {

      //           $resposta[] =  Resposta::select('id','tipo_resp','resposta','corret')->where('id', $key->resp_id)->get();



      //            $res = array(

      //           'perg_id' =>  $id_perg,
      //           'perguntas'=> $resposta
      //        );


      //        }

      //        $respjsn[] = $res;
      //        unset($resposta);


      //   }

      //       return json_encode($respjsn);



      //       }

   $respostas =  Resposta::select('id','tipo_resp','corret','resposta')->get();
   return $respostas->toJson();
}


}
