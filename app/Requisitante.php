<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Requisitante extends Model
{
    use HasUuid;
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
        return $this->hasMany('App\Requisicao');
    }
}
