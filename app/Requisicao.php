<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Requisicao extends Model
{
    use HasUuid;
    protected $table = 'requisicoes';
    protected $fillable = [
        'numero', 'ano', 'descricao', 'justificativa', 'requisitante_id',
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
}