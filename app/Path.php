<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
  protected $fillable = [
       'ambiente_perg', 'tamanho', 'largura', 'disp',
    ];

}
