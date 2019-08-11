<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisitante extends Model
{
   	protected $table = 'requisitantes';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'nome', 'sigla', 'ramal','email'
    ];

    public function requisicoes()
    {
        return $this->belongsToMany('App\Requisicao', 'requisicao_requisitante');
    }
}
