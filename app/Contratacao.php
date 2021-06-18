<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Contratacao extends Model
{
    use HasUuid;
    protected $table = 'contratacoes';
    protected $fillable = [
        'observacao', 'contrato', 'user_id', 'licitacao_id', 'fornecedor_id'
    ];

    /**
     * Metódo que retorna o usuário que solicitou a contratação
     * 
     * @return <Objeto>  App\User
     */
    public function usuario()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    /**
     * Método que retorna o fornecedor da contratação
     * @return <Objeto>  App\Fornecedor
     */
    public function fornecedor()
    {
        return $this->belongsTo('App\Fornecedor', 'fornecedor_id');
    }
    /**
     * Método que retorna a licitação
     * @return <Objeto> App\Licitacao
     */
    public function licitacao()
    {
        return $this->belongsTo('App\Licitacao', 'licitacao_id');
    }
    /**
     * Método que retorna os itens da contratação, com a quantidade contratada e o valor unitário atual
     * @return <Collect>  App\Item
     */
    public function itens()
    {
        return $this->belongsToMany('App\Item', 'contratacao_item', 'contratacao_id', 'item_id')
        	->withPivot(['quantidade', 'valor']);
    }

    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->itens as $item) {
           $total += $item->pivot->quantidade * $item->pivot->valor;
        }
        return number_format($total, 2, ',', '.');
    }

    public function getDataAttribute($value)
    {
        return date('d/m/Y', strtotime($this->created_at));
    }

}
