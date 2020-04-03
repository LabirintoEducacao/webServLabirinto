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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $salas = DB::table('salas')
        ->where('prof_id','=',Auth::user()->id)
        ->get();
        
        
        $y = 0;
        $w = 0;
        $n = 0;
        $acertos = null;
        $m = 0;
        $erros = null;
        $pergs = array();
        $grafico = array();
        
            $salas = DB::table('salas')->where('prof_id',Auth::user()->id)->get();
            if(count($salas)>0){
                foreach($salas as $sala){
                    $perguntas = DB::table('perguntas')->where('sala_id','=',$sala->id)->get();
                    if(count($perguntas)>0){
                        foreach($perguntas as $pergunta){
                            
                                //acertos na 1ª tentativa
                                $sql =  'select count(d.wrong_count) as total from data d';
                                $sql .= ' JOIN perguntas p ON p.id = d.question_id';
                                $sql .= ' WHERE d.event = "question_end" AND wrong_count = 0 AND p.sala_id = '.$sala->id.' AND question_id = ' . $pergunta->id;
                                $sql .= ' GROUP BY d.question_id;';
                                $qtd0 = DB::select($sql);
                                if($qtd0 == NULL)
                                    $n = 0;
                                else
                                    $n = $qtd0[0]->total;
                            
                                //acertos na segunda e/ou terceira tentativa(s)
                                $sql =  'select count(d.wrong_count) as total from data d';
                                $sql .= ' JOIN perguntas p ON p.id = d.question_id';
                                $sql .= ' WHERE d.event = "question_end" AND wrong_count != 0 AND p.sala_id = '.$sala->id.' AND question_id = ' . $pergunta->id;
                                $sql .= ' GROUP BY d.question_id;';
                                $qtd0 = DB::select($sql);
                                if($qtd0 == NULL)
                                    $m = 0;
                                else
                                    $m = $qtd0[0]->total;
                        }

                        if($acertos==null)
                            $acertos = (float) $n;
                        else
                            $acertos = (float) ($n + $acertos)/2;
                        
                        if($erros==null)
                            $erros = (float) $m;
                        else
                            $erros = (float) ($m + $erros)/2;
                    }
                    
                    $sql =  'select count(user_id) as alunos from sala_user';
                    $sql .= ' WHERE sala_id = '.$sala->id;
                    $alunos = DB::select($sql);
                    $y++;
                    
                    if($acertos==null)
                        $acertos = 0;
                    
                    if($erros==null)
                        $erros = 0;
                    
                    $grafico[$w] = ['sala_id' => $sala->id, 'sala_nome' => $sala->name, 'acertos' => $acertos, 'erros' => $erros, 'alunos' => $alunos[0]->alunos];
                    $w++;

                    }
                
                
            }

            
            $json = json_encode($grafico);
           
        
        
        
        return view('home')->with(['dados' => $json]);
    }
}
