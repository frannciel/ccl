<?php

namespace App\Services;

use Excel;
use App\Item;
use App\Licitacao;
use Illuminate\Http\Request;
use App\Services\ConversorService;

class LicitacaoService
{
    /**
     * Função que salva uma nova cotação na base de dados
     *
     * @param Array  $data  
     * @param \App\Requisicao  $requisicao   
     */
    public function store(Request $request, Requisicao $requisicao)
    {
        try{

            return [
                'status' => true,
                'message' => 'Sucesso',
                'data' => $cotacao
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu um error durante a execução',
               'error' => $e
            ];
        }
    }

    /**
     * Método que remove uma cotação específica
     * 
     * @param \App\Cotacao $cotacao 
     * @return type
     */
    public function destroy(Licitacao $licitacao)
    {
        try {
            
            $licitacao->delete();

            return [
                'status' => true,
                'message' => 'Locação Excluida  com sucesso',
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a tentiva de excluir a locação',
               'error' => $e
            ];
        }
    }

    public function ordenador(Licitacao $licitacao)
    {
        try{
             
            $ordem = 1;
            foreach ($licitacao->itens->sortBy('ordem') as  $item) {
                $item->ordem = $ordem;
                $item->save();
                $ordem += 1;
            }

            return [
                'status' => true,
                'message' => 'Item(ns) ordenados com sucesso.',
                'data' => $licitacao
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu um erro durante a ordenação de itens.',
               'error' => $e
            ];
        }
    } 

    public function separar(Item $item)
    {
        try{
             
            $licitacao = $item->licitacao;
            foreach ($item->mesclados as $value) {
                $value->ordem = $licitacao->itens()->max('ordem')+1;
                $value->licitacao()->associate($licitacao);
                $value->save();
            }
            $item->delete();
            $this->ordenador($licitacao);

            return [
                'status' => true,
                'message' => 'Item(ns) ordenados com sucesso',
                'data' => $licitacao
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu um erro durante a ordenação desmeclagem de item.',
               'error' => $e
            ];
        }
    }    

    public function remove ($itens, Licitacao $licitacao)
    {
        try{

            foreach ($itens as $item) {
                $item = Item::findByUuid($item);
                if($item->mesclados()->count() > 0) {
                    $this->separar($item);
                } elseif ($item->requisicao == null) {
                    $item->delete();
                } else {
                    $item->licitacao()->dissociate();
                    $item->ordem = null;
                    $item->save();
                }
            }

            foreach($licitacao->requisicoes as $requisicao)
                if (Item::where('licitacao_id','=', $licitacao->id)->where('requisicao_id','=',$requisicao->id)->count() == 0) 
                    $licitacao->requisicoes()->detach($requisicao);

            $this->ordenador($licitacao);

            return [
                'status' => true,
                'message' => 'Item(ns) removidos da licitação com sucesso.',
                'data' => $licitacao
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu um erro durante a remoção de item(ns) da licitação.',
               'error' => $e
            ];
        }
    }
}












