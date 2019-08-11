<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
   	protected $table = 'estados';

	protected $fillable = ['nome', 'sigla' ];

    public function cidades()
    {
        return $this->hasMany('App\Cidades');
    }

}
