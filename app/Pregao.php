<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Pregao extends Model
{
    use HasUuid;
    protected $table = 'pregoes';

    protected $fillable = [
        'tipo', 'forma', 'srp'
    ];

    public function licitacao()
    {
        return $this->morphOne('App\Licitacao', 'licitacaoable');
    }

}
