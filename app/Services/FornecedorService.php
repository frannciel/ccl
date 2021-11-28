<?php

namespace App\Services;

use Excel;
use App\Item;
use App\Cidade;
use App\Estado;
use App\Fornecedor;
use App\PessoaFisica;
use App\PessoaJuridica;
use Illuminate\Http\Request;
use App\Services\ConversorService;

class FornecedorService
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
    public function destroy(Fornecedor $fornecedor)
    {
        try {
            
            $fornecedor->delete();

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

    public function importar(array $data)
    {
        try{

            $dados = array_chunk(explode("&", substr($data['texto'],  0, -1)), 10);// remove o ultimo caracter e quebra a texto em celulas e organiza por linhas
            foreach ($dados as $valor) {
                $fornecedor ;
                if(strlen(preg_replace("/[^0-9]/", "", trim($valor[0]))) == 11){
                    $fornecedor = PessoaFisica::firstOrCreate([
                        ['cpf'    => trim($valor[0])],
                        ['nome'   => trim($valor[1])]
                    ]);
                } elseif (strlen(preg_replace("/[^0-9]/", "", trim($valor[0]))) == 14){
                    $fornecedor = PessoaJuridica::firstOrCreate(
                        ['cnpj'         => trim($valor[0])],
                        ['razao_social' => trim($valor[1]), 'representante' => trim($valor[9])]
                    );
                    // atualiza o representante caso este esteja vazio
                    if ($fornecedor->representante == '') {
                        $fornecedor->representante = trim($valor[9]);
                        $fornecedor->save();
                    }
                }

                // realiza a validação de estado e realiza a consulta na base de dados retornando incosiste caso não encontrado
                $estado = null;
                if (strlen(trim($valor[5])) == 2) {
                    $estado = Estado::where('sigla', strtoupper(trim($valor[5])))->first();
                } elseif ($estado === null) {
                    $estado = Estado::where('nome', $valor[5])->first();
                } elseif ($estado === null) {
                    $estado = Estado::where('nome', 'Inconsistente')->first();
                }
                // consulta a cidade criando uma cidade caso esta não esteja presente na base de dados
                $cidade = Cidade::firstOrCreate(['nome' =>trim($valor[4]), 'estado_id'=> $estado->id]); 

                $fornec = $fornecedor->fornecedor;
                if ($fornec == null) {
                    $fornecedor->fornecedor()->updateOrCreate([
                        'endereco'      => trim($valor[2]),
                        'cep'           => trim($valor[3]),
                        'cidade_id'     => $cidade->id,
                        'email'         => trim($valor[6]),
                        'telefone_1'    => trim($valor[7]),
                        'telefone_2'    => trim($valor[8])
                    ]);
                } else {
                    $fornec->endereco   = trim($valor[2]);
                    $fornec->cep        = trim($valor[3]);
                    $fornec->cidade_id  = $cidade->id;
                    $fornec->email      = trim($valor[6]);
                    $fornec->telefone_1 = trim($valor[7]);
                    $fornec->telefone_2 = trim($valor[8]);
                    $fornec->save();
                }
            }
            return [
                'status' => true,
                'message' => 'Fornecedor(es) cadastrado(s) com sucesso',
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