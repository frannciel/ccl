<?php

namespace App\Http\Controllers\Pregao;

use App\Item;
use App\Unidade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemPregaoUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Item $item)
    {
        $this->validate($request, [
            'quantidade' => 'required|integer',
            'codigo'     => 'integer|nullable',
            'objeto'     => 'required|string|max:100',
            'descricao'  => 'required|string',
            'unidade'    => 'required|string|exists:unidades,uuid',
        ]);

        try {
           
            $item->quantidade   = $request->quantidade;
            $item->codigo       = $request->codigo;
            $item->objeto       = $request->objeto;
            $item->descricao    = nl2br($request->descricao);
            $item->unidade_id   = Unidade::findByUuid($request->unidade)->id;
            //$item->grupo_id   = $request->grupo;
            $item->save();

            return redirect()->route('pregao.show', $item->licitacao->uuid)
                ->with(['codigo' => 200,'mensagem' => 'O item '.$item->ordem.' foi alterado com sucesso!']);
        } catch (Exception $e) {
            return redirect()->route('pregao.show', $item->licitacao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error durante o alteração do item, tente novamente ou contate o administrador!']);

        }    
    }
}
