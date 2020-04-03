<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pergunta extends Model
{
    use Notifiable;
    
    
    protected $fillable = [
        'sala_id', 'tipo_perg', 'pergunta', 'ordem', 'room_type',
    ];


   public function salas() {
        return $this->belongsTo("App\Sala");
    }

   public function respostas() {
        return $this->belongsToMany("App\Resposta");
    }

    public function paths() {
        return $this->belongsToMany("App\path");
    }
    
    
}

