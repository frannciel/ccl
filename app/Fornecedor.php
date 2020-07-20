<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Fornecedor extends Model
{
    use HasUuid;
    protected $table = 'fornecedores';
    protected $fillable = [
        'telefone_1', 'telefone_2', 'email',  'endereco', 'cep', 'cidade_id'
    ];

    public function itens()
    {
        return $this->belongsToMany('App\Item', 'fornecedor_item', 'fornecedor_id', 'item_id')
            ->withPivot('quantidade', 'valor', 'marca', 'modelo' )
            ->withTimestamps();
    }
    /**
     * Método que retorna a cidade onde o fornecedor está sediado
     * @return <Objeto>  App\Cidade
     */
    public function cidade()
    {
        return $this->belongsTo('App\Cidade', 'cidade_id', 'id');
    }
    /**
     * Método que retorna os todas os Registro de Preços do fornecedor
     * @return <Collect>  App\RegistroDePreco
     */
    public function registroDePrecos()
    {
        return $this->hasMany('App\RegistroDePreco');
    }
    /**
     * Método que retorna os todas as contratação de um fornecedor
     * @return <Collect>  App\Contratacao
     */
    public function contratacoes()
    {
        return $this->hasMany('App\Contratacao');
    }

    public function fornecedorable()
    {
        return $this->morphTo();
    }

    public function getNomeAttribute()
    {
        if ($this->fornecedorable_type == 'Pessoa Física')
            return $this->fornecedorable->nome;
        if ($this->fornecedorable_type == 'Pessoa Jurídica')
            return $this->fornecedorable->razao_social;
    }

    public function getCpfCnpjAttribute()
    {
        if ($this->fornecedorable_type == 'Pessoa Física')
            return $this->fornecedorable->cpf;
        if ($this->fornecedorable_type == 'Pessoa Jurídica')
            return $this->fornecedorable->cnpj;
    }
}
	