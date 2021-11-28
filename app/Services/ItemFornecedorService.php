<?php

namespace App\Services;

use Session;
use App\Item;
use App\Cidade;
use App\Estado;
use App\Licitacao;
use App\Fornecedor;
use App\Requisicao;
use App\PessoaFisica;
use App\PessoaJuridica;
use Illuminate\Http\Request;
use App\Services\ConversorService;

class ItemFornecedorService
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
     * Método que prepara os dados pra exibição na interface de vizualização de importação de dados 
     * do resultados por fornecedor. 
     * Os dados são salvos na sessão para utilização no método de registro na base de dados
     *
     * @param Array  $data  
     * @param \App\Licitacao  $licitacao 
     */
    public function importPreview(array $data, $licitacao)
	{
        try{

            $itens = [];
            $tamanho = 0;
            $celulas = explode("&", $data['texto']);
            $primeiro = '';
            $quantidade = count($celulas);
            for ($i = 0; $i < $quantidade; $i++){
                $tamanho = strlen($celulas[$i]);
                if($tamanho < 10){
                    if ($quantidade > $i + 8){
                        array_push($itens, [
                            'fornecedor' 	=> $primeiro, 
                            'item' 			=> $celulas[$i], 
                            'objeto' 		=> $celulas[$i+1], 
                            'unidade' 		=> $celulas[$i+2],
                            'quantidade' 	=> $celulas[$i+3],
                            'valor' 		=> $celulas[$i+5],
                            'descricao' 	=> $celulas[$i+7]
                        ]); 
                        $i = $i + 7; 
                    }
                } elseif($tamanho > 10 && $tamanho < 25) {
                    if ($quantidade > $i + 2)
                        $i = $i +  2; 
                } else {	
                    if ($quantidade > $i + 7){
                        $primeiro = $celulas[$i];
                        $i = $i + 7;
                    }
                }	
            }
            /* Prepara a coleção a ser visualizada na tela de pré-visualização de importação */
            $resultado = collect();
            foreach ($itens as $value) {
                $fornecedor = $this->getFornecedor($value['fornecedor']); //  Nome e cnpj/cpf do fornecedor
                $marcaModelo = $this->getMarcaModelo($value['descricao']); // marca e modelo do item
                $resultado->push([
                    "cnpj" 			=> trim($fornecedor['cpfCnpj']), 
                    "razaoSocial" 	=> trim($fornecedor['razaoSocial']),
                    "ordem"			=> trim($value['item']),
                    "descricao"		=> trim($value['descricao']),
                    "unidade"		=> trim($value['unidade']),
                    "quantidade"	=> trim($value['quantidade']),
                    "marca" 		=> trim($marcaModelo['marca']),
                    "modelo" 		=> trim($marcaModelo['modelo']),
                    "valor" 		=> trim($value['valor'])
                ]);
            }
            Session::put('resultado', $resultado);
            //return view('registro_de_preco.importe', compact('resultado', 'licitacao'));
            return [
                'status' => true,
                'message' => 'Sucesso',
                'data' => [ 'resultado' => $resultado, 'licitacao' => $licitacao]
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
	 * Método que separa o marca é modelo da string importada no método importPreview
	 *
	 * @param  String $valor
	 * @return array
	 */
	private function getMarcaModelo($valor)
	{
		if (strlen($valor) > 20 )  {
			$quebrado = explode("Descrição Detalhada", $valor, 2);
			$removido = str_replace(["Marca:", "Fabricante", "Modelo / Versão"], "", $quebrado[0]);
			$vetor = explode(":", $removido);
			return ['marca' => $vetor[0], 'modelo' => $vetor[2] ?? ''];
		}
	}
	
	/**
	 * Método que separa o cnpj e a razão social da string importada no método importePreview
	 *
	 * @param  String $valor
	 * @return array
	 */
	private function getFornecedor($valor)
	{
		if (strlen($valor) > 20 )  {
			$vetor = explode("-", $valor, 3);
			return ['cpfCnpj' => $vetor[0]."-".$vetor[1], 'razaoSocial' => $vetor[2]] ;
		}
	}
    
    /**
     * Metodo que armazena na base de dados a relação item com fornecedor e incluir as dados na tabela pivot desta relação
     * Os dados a armazenar são retirados da sessão de acordo a realçao de itens recebidos no parâmetro data.
     *
     * @param  array $data
     * @param  App\Licitacao $licitacao
     * @return void
     */
    public function importStore(array $data, $licitacao)
    {  
        try{

            $resultado = Session::get('resultado');
            $ordemItens = $data['itens'];
            // Verifica se os Array de dados oriundos da View possuem os mesmos tamanhos
            if (count($ordemItens) > 0 && count($resultado) > 0 && count($ordemItens) <= count($resultado)) {
                foreach ($ordemItens as $key => $ordem) {
                    $item = Item::where('ordem', $ordem)->where('licitacao_id', $licitacao->id)->first();
                    $array = $resultado->where('ordem', $ordem)->first();
                    $PJuridica = PessoaJuridica::firstOrCreate(['cnpj' =>  $array["cnpj"]], ['razao_social' => $array["razaoSocial"]]);
                    $fornecedor;
                    //Verifica se existe, se está vinculado a licitação e se a quantidade a ser viculada está dispoível
                    if($item != null && $item->quantidadeTotalDisponivel >= $array["quantidade"]){
                        // verifica se existe, caso contrário cria uma PessoaJuridica e um Ojeto Fornecedor a ela ralacionado
                        if ($PJuridica->fornecedor != null) {
                            $fornecedor = $PJuridica->fornecedor;
                        } else{
                            // Cria um Objeto Fornecedor com atributos todos nulos
                            $fornecedor = $PJuridica->fornecedor()->create([]);
                        }
                        // Relaciona o fornecedor com o item 
                        $item->fornecedores()->attach($fornecedor->id, [
                            'marca' => $array["marca"], 
                            'modelo' => $array["modelo"], 
                            'quantidade' => $array["quantidade"], 
                            'valor' => ConversorService::stringToFloat(trim(str_replace('R$', '', $array["valor"])))
                            //$this->getFloat(trim(str_replace('R$', '', $array["valor"])))
                        ]);
                    }
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
}