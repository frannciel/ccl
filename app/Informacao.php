<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Informacao extends Model
{
	protected $table = 'informacoes';

	protected $fillable = [
        'dado', 'valor', 'tipo'
    ];

}

