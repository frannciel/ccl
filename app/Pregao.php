<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregao extends Model
{
    use HasUuid;
    protected $table = 'pregoes';

    protected $fillable = [
        'numero', 'ano', 'objeto', 'processo', 'classificacao', 'forma'
    ];

    public function itens()
    {
        return $this->belongsToMany('App\Item', 'item_pregao')->withPivot('numero');
    }

    public function processoOrigem()
    {
    	return $this->belongsTo('App\Processo');
    }

    public function getValorTotalEstimadoAttribute()
    {
        return number_format($this->total, 2, ',', '.');
    }

    public function getTotaEstimadolAttribute()
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
