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
        $role = DB::table('role_user')->select('role_id')->where('user_id', '=', Auth::user()->id)->first();

        $salas = array();

        if($role->role_id == 2){
            $salas = DB::table('salas')->select('salas.*')->where('prof_id',Auth::user()->id)->get();
        } elseif ($role->role_id == 3){
            $salas = DB::table('salas')->select('salas.*')->leftJoin('sala_user', 'salas.id' , '=', 'sala_user.sala_id')
                ->where('salas.public', '=', 1)
                ->orWhere('sala_user.user_id', '=', Auth::user()->id)->get();
        }

        $w = 0;
        $grafico = array();

            if(count($salas)>0){
                foreach($salas as $sala){
                    $acertos = 0;
                    $erros = 0;
                    $perguntas = DB::table('perguntas')->where('sala_id','=',$sala->id)->get();
                    if(count($perguntas)>0){
                        foreach($perguntas as $pergunta){

                                $n = DB::table('data')->select('*')
                                    ->join('perguntas', 'perguntas.id', '=', 'data.question_id')
                                    ->where('data.event', '=', "question_answer")
                                    ->where('data.correct', '=', 1)
                                    ->where('perguntas.sala_id', '=', $sala->id)
                                    ->where('data.question_id', '=', $pergunta->id);

                                if($role->role_id == 3){
                                    $n = $n->where('data.user_id', '=', Auth::user()->id);
                                }

                                $n = $n->count();

                                $m = DB::table('data')->select('*')
                                    ->join('perguntas', 'perguntas.id', '=', 'data.question_id')
                                    ->where('data.event', '=', "question_answer")
                                    ->where('data.correct', '=', -1)
                                    ->where('perguntas.sala_id', '=', $sala->id)
                                    ->where('data.question_id', '=', $pergunta->id);

                                if($role->role_id == 3){
                                    $m = $m->where('data.user_id', '=', Auth::user()->id);
                                }

                                $m = $m->count();

                                $acertos += $n;
                                $erros += $m;
                        }
                    }

                    $grafico[$w] = ['sala_id' => $sala->id, 'sala_nome' => $sala->name, 'acertos' => $acertos, 'erros' => $erros];
                    $w++;

                    }


            }



        return view('home')->with(['dados' => $grafico]);
    }
}
