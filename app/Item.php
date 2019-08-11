<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'itens';

    protected $fillable = [
        'numero', 'quantidade', 'codigo', 'objeto', 'descricao', 'unidade_id', 'requisicao_id'
    ];

    public function requisicao()
    {
        return $this->belongsTo('App\Requisicao', 'requisicao_id');
    }

    public function licitacoes()
    {
        return $this->belongsToMany('App\Licitacao', 'item_licitacao')->withPivot('numero');
    }

    public function unidade()
    {
        return $this->belongsTo('App\Unidade', 'unidade_id');
    }

    public function uasgs()
    {
        return $this->belongsToMany('App\Uasg', 'cidade_uasg')->withPivot('quantidade');
    }
	
	public function cidades()
    {
        return $this->belongsToMany('App\Cidade', 'cidade_uasg')->withPivot('quantidade');
    }

    public function fornecedores()
    {
        return $this->belongsToMany('App\Fornecedor', 'fornecedor_item')->withPivot('quantidade', 'valor', 'marca', 'modelo' )->withTimestamps();
    }

    public function cotacoes()
    {
        return $this->hasMany('App\Cotacao');
    }

    public function getValorTotalAttribute()
    {
        return number_format($this->total, 2, ',', '.');
    }

    public function getDescricaoCompletaAttribute()
    {
        $objeto = $this->objeto != "" ? "<strong>Objeto: </strong>".$this->objeto."<br/><br/><strong>Descrição Detalhada: </strong>": "";
        return $objeto.$this->descricao;
    }

    public function getValorMedioAttribute()
    {
        return number_format($this->media, 2, ',', '.');
    }

    public function getTotalAttribute()
    {
        return $this->media * $this->quantidade;
    }

    public function getMediaAttribute()
    {
        $cotacoes = $this->cotacoes;
        $tamanho = count($cotacoes);
        $soma  = 0;
        if ($tamanho > 0) {
            foreach ($cotacoes as $cotacao)
                $soma += $cotacao->valor;
            return  $soma / $tamanho;
        } else {
            return 0;
        }
    }
}
	