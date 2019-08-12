<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Pregao extends Licitacao
{
    use HasUuid;
    protected $table = 'pregoes';

    protected $fillable = [
        'tipo', 'forma', 'srp', 'licitacao_id'
    ];

    public function licitacao()
    {
        return $this->hasOne('App\Licitacao', 'licitacao_id');
    }

}
