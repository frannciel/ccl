<?php

namespace App\Services;

use Excel;
use App\Item;
use App\Cotacao;
use App\Requisicao;
use App\Requisitante;
use PDF;
use Illuminate\Http\Request;
use App\Services\ConversorService;

class RequisicaoService
{
    /**
     * Função que salva a requisição na base de dados
     *
     * @param Array  $data  
     * @param \App\Requisicao  $requisicao   
     */
    public function store(array $request)
    {
        try{

            $requisicao = Requisicao::create([
                'numero'        => Requisicao::where('ano', date('Y'))->max('numero') + 1,// Retona o número da ultima requisção e acarescenta mais um
                'ano'           => date('Y'),
                'tipo'          => $request['tipo'],
                'prioridade'    => $request['prioridade'],
                'renovacao'     => $request['renovacao'],
                'capacitacao'   => $request['capacitacao'],
                'pac'           => $request['pac'],
                'metas'         => $request['metas'],
                'descricao'     => $request['descricao'],
                'justificativa' => $request['justificativa']
            ]);
            $requisicao->data = $request['previsao']; // formata o campo previsão em formato de data
            $requisicao->requisitante()->associate(Requisitante::findByUuid($request['requisitante'])); // representa o  requisitante
            $requisicao->save();

            return [
                'status' => true,
                'message' => 'Requisicão criado com sucesso!',
                'data' => $requisicao
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu um error durante a execução',
               'error' => $e
            ];
        }
    }

    public function update(array $request, Requisicao $requisicao)
    {
        try{

            $requisicao->descricao      = $request['descricao'];
            $requisicao->justificativa  = $request['justificativa'];
            $requisicao->prioridade     = $request['prioridade'];
            $requisicao->tipo           = $request['tipo'];
            $requisicao->renovacao      = $request['renovacao'];
            $requisicao->capacitacao    = $request['capacitacao'];
            $requisicao->pac            = $request['pac'];
            $requisicao->data           = $request['previsao'];
            $requisicao->metas          = $request['metas'];
            $requisicao->requisitante()->dissociate(); // remove todas as relações
            $requisicao->requisitante()->associate(Requisitante::findByUuid($request['requisitante'])); // refaz as relaçoes
            $requisicao->save();

            return [
                'status' => true,
                'message' => 'Sucesso',
                'data' => $requisicao
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
     * Método que remove uma cotação específica
     * 
     * @param \App\Cotacao $cotacao 
     * @return type
     */
    public function destroy(Requisicao $requisicao)
    {
        try {
            
            $requisicao->delete();

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

    public function pesquisaPrecosPDF(Requisicao $requisicao)
    {
        try{

            view()->share('requisicao', $requisicao);
            $pdf = PDF::loadView('site.requisicao.pdf.pesquisa', compact('requisicao'));
            $pdf->setPaper('A4');
            $dados = $pdf->download('Requisicao_'.$requisicao->ordem.'_solicitação_de_cotação_.pdf');

            return [
                'status' => true,
                'message' => 'Sucesso',
                'data' => $dados
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a execução',
               'error' => $e
            ];
        }
    }

    public function formalizacaoDemandaPDF(Requisicao $requisicao)
    {
        try{

            view()->share('requisicao', $requisicao);
            $pdf = PDF::loadView('site.requisicao.pdf.formalizacao', compact('requisicao'));
            $pdf->setPaper('A4', 'landscape' );
            $dados = $pdf->download('Requisicao_'.$requisicao->ordem.'_oficializacao_de_demanda.pdf');

            return [
                'status' => true,
                'message' => 'Sucesso',
                'data' => $dados
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a execução',
               'error' => $e
            ];
        }
    }

    public function duplicarItens(array $request)
    {
        try {
            
            $itens = $request['itens'];
            if (empty($itens)) {
                    abort(
                        redirect()
                        ->route('requisicao.show', $request['requisicao'])
                        ->with(['codigo' => 500, 'mensagem' => 'Nenhum item duplicado, selecione um ou mais itens e tente novamente.'])
                        ->withInput()
                    ); 
            } else {
                $requisicao = Requisicao::findByUuid($request['requisicao']);
                foreach ($itens as  $uuid) {
                    $item = Item::findByUuid($uuid);
                    if ($requisicao->uuid == $item->requisicao->uuid) { // verifica se o item pertence a requisição
                       $requisicao->itens()->create([
                            'numero'        => $requisicao->itens()->max('numero')+1, // este número indicara itens mesclados nas  licitcaoes, eles não pertencem a nenhuma requisicão
                            'quantidade'    => $item['quantidade'],
                            'codigo'        => $item['codigo'],
                            'objeto'        => $item['objeto'],
                            'descricao'     => $item['descricao'],
                            'unidade_id'    => $item['unidade_id'],
                        ]);
                    }
                }   
            }

            return [
                'status' => true,
                'message' => 'Itens duplicado com sucesso',
                'data' => $itens
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a tentiva duplicar itens',
               'error' => $e
            ];
        }
    }

    public function deleteItens(array $request)
    {
        try {
            
            foreach ($request['itens'] as  $uuid) {
                $item = Item::findByUuid($uuid);
                if ($request['requisicao'] == $item->requisicao->uuid) { // verifica se o item pertence a requisição
                    if (!$item->licitacao) { // verifica se o item não está relacionado a uma licitação
                        $item->delete();
                    }
                }
            }
            $this->ordenar(Requisicao::findByUuid($request['requisicao']));

            return [
                'status' => true,
                'message' => 'Itens duplicado com sucesso',
                'data' => null
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a tentiva remover itens',
               'error' => $e
            ];
        }
    }

    public function ordenar(Requisicao $requisicao)
    {
        try {
            
            $numero = 1;
            foreach ($requisicao->itens()->orderBy('numero', 'asc')->get() as $item) {
                $item->numero = $numero;
                $item->save();
                $numero += 1;
            }

            return [
                'status' => true,
                'message' => 'Itens da requisição ordenado com sucesso!',
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a tentiva de ordenação  dos itens da requisição',
               'error' => $e
            ];
        }
    }

    public function importar(array $data, Requisicao $requisicao)
    {
        try{

            $dados = array_chunk(explode("&", substr($data['texto'],  0, -1)), 5);// remove o ultimo caracter e quebra a texto em celulas e organiza por linhas

            foreach ($dados as $linha) {
                $item = $requisicao->itens()->where('numero', $linha[0])->first();
                if ($item != null && !$this->comparable(['fonte'=>$linha[1],'valor'=>$linha[2],'data'=>$linha[3],'hora'=>$linha[4]], $item)) {
                    $cotacao = Cotacao::create([
                        'fonte'    => $linha[1],
                        'valor'    => ConversorService::stringToFloat($linha[2]), 
                        'data'     => ConversorService::dataHoraToDatetime($linha[3], $linha[4]),
                        'item_id'  => $item->id
                    ]);
                }
            }

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
}