<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class PessoaJuridica extends Model
{
    use HasUuid;
    protected $table = 'pessoas_juridicas';
    public $timestamps = false;

    protected $fillable = [
        'cnpj', 'razao_social', 'representante'
    ];

    public function fornecedor()
    {
        return $this->morphOne('App\Fornecedor', 'fornecedorable');
    }
}
