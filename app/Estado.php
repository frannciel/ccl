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

}
