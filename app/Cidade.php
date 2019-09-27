<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Cidade extends Model
{
    use HasUuid;
    protected $table = 'cidades';

	protected $fillable = ['nome', 'estado_id'];

    public function estado()
    {
        return $this->belongsTo('App\Estado', 'estado_id');
    }

    public function fornecedores()
    {
        return $this->hasMany('App\Fornecedor');
    }
/*
    public function uasgs()
    {
        return $this->belongsToMany('App\Uasg', 'cidade_uasg')->withPivot('quantidade');
    }
	
	public function itens()
    {
        return $this->belongsToMany('App\Item', 'cidade_participante')->withPivot('quantidade');
    }
*/
    public function participantes()
    {
        return $this->belongsToMany('App\Participante');
    }
}
