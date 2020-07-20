<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class RegistroDePreco extends Model
{
    use HasUuid;
    protected $table = 'registro_precos';
    public $timestamps = true;

    protected $fillable = [
        'numero', 'ano', 'assinatura','vigencia_inicio', 'vigencia_fim', 'licitacao_id', 'fornecedor_id', 
    ];

    public function fornecedor()
    {
    	return $this->belongsTo('App\Fornecedor', 'fornecedor_id');
    }

    public function licitacao()
    {
    	return $this->belongsTo('App\Licitacao', 'licitacao_id');
    }

    public function itens()
    {
        return $this->belongsToMany('App\Item', 'item_registro_precos', 'registro_precos_id', 'item_id');
    }

    public function setAssinaturaAttribute($value)
    {
       $this->attributes['assinatura'] = $this->setData($value);
    }

    public function getAssinaturaAttribute()
    {
        return $this->getData($this->attributes['assinatura']);
    }

     public function setVigenciaInicioAttribute($value)
    {
        $this->attributes['vigencia_inicio'] = $this->setData($value);
    }
    
    public function getVigenciaInicioAttribute()
    {
        return  $this->getData($this->attributes['vigencia_inicio']);
    }

    public function setVigenciaFimAttribute($value)
    {
        $this->attributes['vigencia_fim'] =  $this->setData($value);
    }
    
    public function getVigenciaFimAttribute()
    {
        return  $this->getData($this->attributes['vigencia_fim']);
    }
     
    protected function setData($value)
    {
        return date_format(date_create(str_replace("/", "-", $value)), 'Y-m-d');
    }

    protected function getData($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    protected function getOrdemAttribute()
    {
        return $this->numero.'/'. $this->ano;
    }
}
