<?php

namespace App\Services;

use DB;
use PDF;
use Session;
use App\Item;
use App\Licitacao;
use App\Requisicao;
use App\Contratacao;
use Illuminate\Http\Request;
use App\Services\ConversorService;

class ContratacaoService
{
    /**
     * Função que salva uma nova cotação na base de dados
     *
     * @param Array  $data  
     */
    public function create(Licitacao $licitacao)
    {
        try{

            $itens;
            if($licitacao->licitacaoable->srp == 1){ // verifica se é uma licitação registro de preços
                $itens = $licitacao->itens()->has('registrosDePrecos')->orderBy('ordem')->get();
            } else{
                $itens = $licitacao->itens()->has('fornecedores')->orderBy('ordem')->get();
            }
    
            $dados = collect();
            foreach ($itens as $item) {
               if ($item->quantidade > 0) { // Item com quantidade 0 pertence aos participantes
                    $qtd_total_empenhada = DB::table('contratacao_item')->where('item_id', $item->id)->sum('quantidade');
                    $dados->push([
                        'item'      => $item, 
                        'empenhado' => $qtd_total_empenhada,
                        'valor'     => number_format($item->fornecedores()->first()->pivot->valor, 2, ',', '.'),
                        'saldo'     => $item->quantidade - $qtd_total_empenhada
                    ]);
                }
            }
            $contratacoes = $licitacao->contratacoes;

            return [
                'status' => true,
                'message' => 'Sucesso',
                'data' => ['dados' => $dados, 'contratacoes' =>  $contratacoes]
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu um error durante a execução',
               'error' => $e
            ];
        }
    } /**
     * Função que salva uma nova cotação na base de dados
     *
     * @param Array  $data  
     */
    public function store(Request $request, Licitacao $licitacao)
    {
        try{

            $conteudo = collect();
            foreach ($request->itens as $key => $item) {
                $item = Item::findByUuid($item);
                $conteudo->push([
                    'itemId'        => $item->id, 
                    'fornecedorId'  => $item->fornecedores->first()->id,
                    'valor'         => $item->fornecedores->first()->pivot->valor,
                    'quantidade'    => $request->quantidades[$key],
                ]);
            }
            $agrupados = $conteudo->groupBy('fornecedorId');
    
            foreach ($agrupados->toArray() as $key => $grupo) {
                $contratacao = $licitacao->contratacoes()->create([
                    'observacao'    => nl2br($request->observacao),
                    'contrato'      => $request->contrato,
                    'fornecedor_id' => $key,
                ]);
    
                foreach ($grupo as $elemento) {
                    $contratacao->itens()->attach($elemento['itemId'],
                       ['quantidade' => $elemento['quantidade'], 'valor' => $elemento['valor']]
                    );
                }
            }

            return [
                'status' => true,
                'message' => 'Sucesso',
                'data' => ''
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu um error durante a execução',
               'error' => $e
            ];
        }
    }

    

    public function default(array $data)
    {
        try{

            return [
                'status' => true,
                'message' => 'Sucesso',
                'data' => $data
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a execução',
               'error' => $e
            ];
        }
    }

    /**
     * Método que delete uma contratação específica
     * 
     * @param \App\Contratacao $contratacao
     * @return type
     */
    public function destroy(Contratacao $contratacao)
    {
        try {
            
            $contratacao->delete();

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

   
}