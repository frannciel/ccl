<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
	protected $table = 'cidade_uasg';
	protected $fillable = ['quantidade'];

	public function uasg()
	{
		return $this->belongsTo('App\Uasg', 'uasg_id');
	}

	public function item()
	{
		return $this->belongsTo('App\Item', 'item_id');
	}

	public function cidade()
	{
		return $this->belongsTo('App\Cidade', 'cidade_id');
	}

}
