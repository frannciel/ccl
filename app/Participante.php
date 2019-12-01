<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Participante extends Pivot
{
	protected $table = 'cidade_uasg';

	public function cidade()
	{
		return $this->belongsTo('App\Cidade', 'cidade_id');
	}

	public function item()
	{
		return $this->belongsTo('App\Item', 'item_id');
	}

	public function uasg()
	{
		return $this->belongsTo('App\Uasg', 'uasg_id');
	}
}
