<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Enquadramento extends Model
{
	use HasUuid;
	protected $fillable = [
        'processo', 'numero', 'objeto', 'valor', 'classificacao', 'normativa', 'modalidade' 
    ];
}
