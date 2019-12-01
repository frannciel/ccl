<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Uasg extends Model
{
    use HasUuid;
	protected $table = 'uasgs';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [ 'nome', 'codigo', 'cidade_id'];
    
    public function cidades()
    {
        return $this->belongsToMany('App\Cidades', 'cidade_uasg', 'uasg_id','cidade_id')
            ->using('App\Participante')
            ->withPivot('item_id')
            ->withPivot('quantidade');
    }

    public function itens()
    {
        return $this->belongsToMany('App\Item', 'cidade_uasg', 'uasg_id','item_id')
            ->using('App\Participante')
            ->withPivot('cidade_id')
            ->withPivot('quantidade');
    }

    public function processos()
    {
        return $this->hasMany('App\Processo');
    }
}
