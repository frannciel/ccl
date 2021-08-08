<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Requisicao extends Model
{
    use HasUuid;
    protected $table = 'requisicoes';
    protected $fillable = [
        'numero', 'ano', 'descricao', 'tipo', 'prioridade', 'renovacao','pac', 'capacitacao', 'previsao', 'metas', 'justificativa', 'requisitante_id'
    ];

    public function itens()
    {
        return $this->hasMany('App\Item');
    }

    public function requisitante()
    {
       return $this->belongsTo('App\Requisitante', 'requisitante_id');
    }

    public function licitacoes()
    {
        return $this->belongsToMany('App\Licitacao', 'licitacao_requisicao');
    }

    public function getValorTotalAttribute()
    {
        return number_format($this->total, 2, ',', '.');
    }

    public function getTotalAttribute()
    {
        $soma = 0;
        foreach ( $this->itens as  $item) 
            $soma += $item->total;
        return $soma;
    }

    protected function getDataAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['created_at']));
    }

    protected function getOrdemAttribute()
    {
        return $this->numero.'/'. $this->ano;
    }

    public function setDataAttribute($value)
    {
        $this->attributes['previsao'] = date_format(date_create(str_replace("/", "-", $value)), 'Y-m-d');
    }

    protected function getPrevisaoAttribute()
    {
        if ($this->attributes['previsao'] == "0000-00-00") {
            return '';
        } else{
            return date('d/m/Y', strtotime($this->attributes['previsao']));
        }
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