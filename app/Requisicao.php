<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisicao extends Model
{
    protected $table = 'requisicoes';

    protected $fillable = [
        'numero', 'ano', 'descricao'
    ];

    public function itens()
    {
        return $this->hasMany('App\Item');
    }

    public function requisitantes()
    {
        return $this->belongsToMany('App\Requisitante', 'requisicao_requisitante');
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