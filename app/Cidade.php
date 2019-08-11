<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
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

    public function uasgs()
    {
        return $this->belongsToMany('App\Uasg', 'cidade_uasg')->withPivot('quantidade');
    }
	
	public function itens()
    {
        return $this->belongsToMany('App\Item', 'cidade_participante')->withPivot('quantidade');
    }
}
