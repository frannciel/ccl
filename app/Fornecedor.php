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

    public function cidade()
    {
        return $this->belongsTo('App\Cidade', 'cidade_id', 'id');
    }

    public function fornecedorable()
    {
        return $this->morphTo();
    }
}
	