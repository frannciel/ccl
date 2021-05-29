<?php

namespace App\Services;

use Excel;
use App\Item;
use App\Cotacao;
use App\Requisicao;
use App\Requisitante;
use Illuminate\Http\Request;
use App\Services\ConversorService;

class RequisicaoService
{
    /**
     * Função que salva uma nova cotação na base de dados
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

    protected function comparable(array $dados, Item $item)
    {
        $novo = new Cotacao([
            'fonte'    => $dados['fonte'],
            'valor'    => ConversorService::stringToFloat($dados['valor']), 
            'data'     => ConversorService::dataHoraToDatetime($dados['data'], $dados['hora']),
            'item_id'  => $item->id
        ]);
    
        foreach ($item->cotacoes as $cotacao) 
            if($novo->equals($cotacao))
                return true;
        return false;
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
     * Método que remove uma cotação específica
     * 
     * @param \App\Cotacao $cotacao 
     * @return type
     */
    public function destroy(Cotacao $cotacao)
    {
        try {
            
            $cotacao->delete();

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