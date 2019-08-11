<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
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

    public function getHoraAttribute()
    {
        return date('H:i', strtotime(str_replace("/", "-", $this->data)));
    }

    public function getContabilAttribute()
    {
        return number_format($this->valor, 2, ',', '.');
    }

    public function getDataAttribute($value)
    {
        if ($value == NULL) {
           return $value = '--/--/----';
        } else {
            return date('d/m/Y H:i', strtotime($value));
        }
     
    }
    
    public function setDataAttribute($value)
    {
        if ($value == NULL) {
            $this->attributes['data'] = NULL;
        } else {
            $this->attributes['data'] = date_format(date_create(str_replace("/", "-", $value)), 'Y-m-d H:i:s');
        }
    }

    public function setValorAttribute($value) { 
        if(strstr($value, ",")) { 
            $value = str_replace(",", ".", str_replace(".", "", $value));
        } 
        if(preg_match("#([0-9\.]+)#", $value, $match)) {
            $this->attributes['valor'] = floatval($match[0]); 
        } else { 
            $this->attributes['valor'] = floatval($value); 
        }
    }

}
