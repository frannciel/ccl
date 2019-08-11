<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Processo extends Model
{
    use HasUuid;
    protected $table = 'processos';

    protected $fillable = [
        'numero', 'uasg_id', 'licitacao_id'
    ];

    public function uasg()
    {
        return $this->belongsTo('App\Uasg', 'uasg_id');
    }

    public function licitacao()
    {
    	return $this->hasOne('App\Licitacao', 'licitacao_id');
    }

}
