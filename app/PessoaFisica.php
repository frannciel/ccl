<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class PessoaFisica extends Model
{
    use HasUuid;
    protected $table = 'pessoas_fisicas';
    protected $fillable = ['cpf', 'nome'];

    public $timestamps = false;
    
    public function fornecedor()
    {
        return $this->morphOne('App\Fornecedor', 'fornecedorable');
    }

}
