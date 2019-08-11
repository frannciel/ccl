<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enquadramento extends Model
{
	protected $fillable = [
        'processo', 'numero', 'objeto', 'valor', 'classificacao', 'normativa', 'modalidade' 
    ];
}
