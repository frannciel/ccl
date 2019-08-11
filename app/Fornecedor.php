<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';

    protected $fillable = [
        'cpf_cnpj', 'razao_social', 'telefone', 'email', 'representante', 'endereco', 'cep', 'cidade_id'
    ];

    public function itens()
    {
        return $this->belongsToMany('App\Item')->withPivot('quantidade', 'valor', 'marca', 'modelo' )->withTimestamps();
    }

    public function cidade()
    {
        return $this->belongsTo('App\Cidade', 'cidade_id', 'id');
    }
}
	