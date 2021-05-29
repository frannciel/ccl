<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Licitacao extends Model
{
    use HasUuid;
    protected $table = 'licitacoes';
    protected $fillable = [
        'numero', 'ano', 'objeto', 'processo', 'publicacao'
    ];

/*  public function itens()
    {
        return $this->belongsToMany('App\Item', 'item_licitacao', 'licitacao_id', 'item_id')->withPivot('ordem');
    }
    */

    public function itens()
    {
        return $this->hasMany('App\Item');
    }

    public function contratacoes()
    {
        return $this->hasMany('App\Contratacao');
    }

    public function processoOrigem()
    {
    	return $this->belongsTo('App\Processo');
    }

    public function licitacaoable()
    {
        return $this->morphTo();
    }

    public function requisicoes()
    {
        return $this->belongsToMany('App\Requisicao', 'licitacao_requisicao')->withTimestamps();
    }

    public function registroDePrecos()
    {
        return $this->hasMany('App\RegistroDePreco');
    }

    /**
     * Metodo que retorna a collection de itens mesclados da licitação
     *
     * @return     <Collect>  App\Item
     */
    public function mesclados()
    {
        return $this->belongsToMany('App\Item', 'mesclados', 'licitacao_id', 'mesclado_id')
            ->withPivot('item_id');
    }

    protected function getOrdemAttribute()
    {
        return $this->numero.'/'. $this->ano;
    }

    public function getValorTotalEstimadoAttribute()
    {
        return number_format($this->totalEstimado, 2, ',', '.');
    }

    public function getTotalEstimadoAttribute()
    {
        $soma = 0;
        foreach ( $this->itens as  $item) 
            $soma += $item->totalGeral;
        return $soma;
    }
/*
    public function getValorTotalLicitadoAttribute()
    {
        return number_format('');
    }

    public function getTotalLicitadoAttribute()
    {
        $soma = 0;
        return $soma;
    }*/

    protected function setPublicacaoAttribute($value)
    {
        $this->attributes['publicacao'] = date_format(date_create(str_replace("/", "-", $value)), 'Y-m-d');
    }

    protected function getPublicacaoAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['publicacao']));
    }

    /**
     * Get the route key for the model. 
     * Método para definir a chave usada na injeção de dependêcia dos model através das rotas
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
