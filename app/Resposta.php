<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Resposta extends Model
{
    use Notifiable;
    
    
    protected $fillable = [
        'sala_id', 'tipo_resp', 'resposta', 'corret',
    ];
    
    public function perguntas() {
        return $this->belongsToMany("App\Pergunta");
    }
    
}


