<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'nome', 'sigla'
    ];

    public function itens()
    {
        return $this->hasMany('App\Item');
    }

}
