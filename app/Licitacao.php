<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Licitacao extends Model
{
    use HasUuid;
    protected $table = 'licitacoes';

    protected $fillable = [
        'numero', 'ano', 'objeto', 'processo'
    ];

    public function itens()
    {
        return $this->belongsToMany('App\Item', 'item_licitacao')->withPivot('numero');
    }

    public function processoOrigem()
    {
    	return $this->belongsTo('App\Processo');
    }

    public function licitacaoable()
    {
        return $this->morphTo();
    }

    public function getValorTotalEstimadoAttribute()
    {
        return number_format($this->total, 2, ',', '.');
    }

    public function getTotalEstimadolAttribute()
    {
        $soma = 0;
        foreach ( $this->itens as  $item) 
            $soma += $item->total;
        return $soma;
    }

    public function getValorTotalLicitadoAttribute()
    {
        return number_format('');
    }

    public function getTotalLicitadoAttribute()
    {
        $soma = 0;
        return $soma;
    }
}
