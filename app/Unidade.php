<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Unidade extends Model
{
    use HasUuid;
    protected $fillable = [
        'nome', 'sigla'
    ];

    public function itens()
    {
        return $this->hasMany('App\Item');
    }

}
