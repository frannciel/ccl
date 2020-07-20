<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Estado extends Model
{
	use HasUuid;
   	protected $table = 'estados';

	protected $fillable = ['nome', 'sigla' ];

    public function cidades()
    {
        return $this->hasMany('App\Cidades');
    }

    public function uasgs()
    {
        return $this->hasManyThrough('App\Uasg', 'App\Cidade',
            'estado_id', // Foreign key on users table...
            'cidade_id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'id' // Local key on users table...
        );
    }

    public function fornecedores()
    {
        return $this->hasManyThrough('App\Fornecedor', 'App\Cidade',
            'estado_id', // Foreign key on users table...
            'cidade_id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'id' // Local key on users table...
        );
    }

}
