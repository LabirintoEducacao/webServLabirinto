<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
   public function perguntas() {
        return $this->hasMany('App\Pergunta');
    }
}
