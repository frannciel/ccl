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

    public function participantes()
    {
        return $this->belongsToMany('App\Uasg', 'cidade_uasg','cidade_id', 'uasg_id')
            ->using('App\Participante')
            ->withPivot('item_id')
            ->withPivot('quantidade');
    }
	
	public function itens()
    {
        return $this->belongsToMany('App\Item', 'cidade_uasg','cidade_id', 'item_id')
            ->using('App\Participante')
            ->withPivot('uasg_id')
            ->withPivot('quantidade');
    }

    /**
     * Indica as unidades administrativas de serviços gerais sediadas na cidade
     *
     * @return     <Collect>  (de objetos cidades)
     */
    public function uasgs()
    {
        return $this->hasMany('App\Uasg');
    }
}
