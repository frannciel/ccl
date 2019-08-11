<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Uasg extends Model
{
    //use HasUuid;
	protected $table = 'uasgs';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [ 'nome', 'codigo', 'cidade_id'];

    public function itens()
    {
        return $this->belongsToMany('App\Item', 'cidade_uasg')->withPivot('quantidade');
    }

    public function cidades()
    {
        return $this->belongsToMany('App\Cidade', 'cidade_uasg')->withPivot('quantidade');
    }

    public function processos()
    {
        return $this->hasMany('App\Processo');
    }
}
