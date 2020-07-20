<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Cotacao extends Model
{
    use HasUuid;
    protected $table = 'cotacoes';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'fonte', 'valor', 'data', 'item_id'
    ];

    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id');
    }

    /**
     * Método que retona a hora da cotação
     *
     * @return     <String>  The hora attribute.
     */
    public function getHoraAttribute()
    {
        return date('H:i', strtotime(str_replace("/", "-", $this->data)));
    }

    public function getDataAttribute($value)
    {
        if ($value == NULL) {
           return $value = '--/--/----';
        } else {
            return date('d/m/Y H:i', strtotime($value));
        }
    }

    /**
     * Retorna o valor da cotação em formato de moeda 0.000,00
     *
     * @return     <String>  The contabil attribute.
     */
    public function getContabilAttribute()
    {
        return number_format($this->valor, 2, ',', '.');
    }
    
    public function setDataAttribute($value)
    {
        if ($value == NULL) {
            $this->attributes['data'] = NULL;
        } else {
            $this->attributes['data'] = date_format(date_create(str_replace("/", "-", $value)), 'Y-m-d H:i:s');
        }
    }

    /**
     * Método que convert o valor no formato String para Float antes da inserção no banco de dados
     *
     * @param      <String>  $valor
     */
    public function setValorAttribute($value) { 
        if(strstr($value, ",")) 
            $value = str_replace(",", ".", str_replace(".", "", $value)); // remove o ponto e em seguida convert virgula em ponto
    
        if(preg_match("#([0-9\.]+)#", $value, $match)) {
            $this->attributes['valor'] = floatval($match[0]); 
        } else { 
            $this->attributes['valor'] = floatval($value); 
        }
    }

}
