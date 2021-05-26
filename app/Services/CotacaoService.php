<?php

namespace App\Services;

use App\Item;
use Validator;
use App\Cotacao;
use App\Requisicao;
use Illuminate\Http\Request;
use Excel;
use App\Services\ConversorService;

class CotacaoService
{
    /**
     * Função que salva uma nova cotação na base de dados
     *
     * @param Array  $data  
     * @param \App\Requisicao  $requisicao   
     */
    public function store(Request $request, Requisicao $requisicao)
    {
        $item = Item::findByUuid($request->item);
        if ($this->comparable($request->all(), $item)){
            abort(
                redirect()
                ->route('cotacao.create', $requisicao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Esta cotação de preços já existe para este item'])
                ->withInput()
            ); 
        }

        try{

            $cotacao = Cotacao::create([
                'fonte'    => $request->fonte,
                'valor'    => ConversorService::stringToFloat($request->valor), 
                'data'     => ConversorService::dataHoraToDatetime($request->data, $request->hora),
                'item_id'  =>  $item->id
            ]);

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