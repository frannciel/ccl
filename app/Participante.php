<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Participante extends Pivot
{
	protected $table = 'cidade_uasg';

	/**
	 * Método que retorna um objeto cidade na relação ternária Item Cidade Uasg
	 *
	 * @return   <Objeto>  Cidade
	 */
	public function cidade()
	{
		return $this->belongsTo('App\Cidade', 'cidade_id');
	}

	/**
	 * Método que retorna um objeto item na relação ternária Item Cidade Uasg
	 *
	 * @return   <Objeto>  Item
	 */
	public function item()
	{
		return $this->belongsTo('App\Item', 'item_id');
	}

	/**
	 * Método que retorna um objeto uasg na relação ternária Item Cidade Uasg
	 *
	 * @return   <Objeto>  Uasg
	 */
	public function uasg()
	{
		return $this->belongsTo('App\Uasg', 'uasg_id');
	}
}
