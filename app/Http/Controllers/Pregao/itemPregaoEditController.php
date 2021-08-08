<?php

namespace App\Http\Controllers\Pregao;

use Session;
use App\Item;
use App\Unidade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemPregaoEditController extends Controller
{
    /**
     * retorna wiew para edição de itens relacionado ao pregão
     *
     * @param  mixed $item
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Item $item)
    {
        $licitacao = $item->licitacao;
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']); 
        $unidades = array();
        foreach (Unidade::all()->sortBy('nome') as $value)
            $unidades += [$value->uuid => $value->nome];
        return view('site.licitacao.compras.pregao.itemEdit',  compact('item', 'licitacao', 'comunica', 'unidades'));
    }
}
