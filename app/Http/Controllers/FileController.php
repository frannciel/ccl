<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use App\Requisicao;
use App\Licitacao;
use App\Unidade;
use App\Estado;
use App\Cidade;
use App\Item;
use App\Participante;
use App\Fornecedor;
use App\PessoaJuridica;
use DateTime;
class FileController extends Controller
{

	private $gerenciador = 158410;

	/**
	 * { function_description }
	 *
	 * @param      <type>  $id     The identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function create($uuid)
	{
		return view('importe')->with('uuid', $uuid);
	}

	public function redirecionar(Request $request){
        return redirect()->route('importarNovo', ['requsicao_id' => $request->requisicao]);
    }

	/**
	 * { function_description }
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 */
	public function store(Request $request)
	{
		$celulas = explode("&", substr($request->dados,  0, -1)); // remove o ultimo caracter e quebra a texto em ceelulas
		switch ($request->tipo) {
			case '1': 
				return $this->setItem(array_chunk($celulas,5), $request->uuid); 
			case '2':
				return $this->setCotacao(array_chunk($celulas,5), $request->uuid); 
			case '3': 
				return $this->setParticipante(array_chunk($celulas,4), $request->uuid); 
			case '4': 
				return $this->setFornecedor(array_chunk($celulas,9)); 
			case '5': 
				return $this->AtaSrpShow($request->dados, $request->uuid); 	
		}
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $dados  The dados
	 * @param      <type>  $id     The identifier
	 */
	protected function setItem($dados, $id)
	{
		$requisicao = Requisicao::find($id);
		$itens = $requisicao->itens; // retona tosdos os item relacionados com a requisição
		foreach ($dados as $valor) {

			/*caso o número do item não seja informado o sistema retorna o numero do ultimo item e acrescenta um
			ou seja, cadastra o item no final da requisição */
			if ($valor[0] == "") {
				$valor[0] = $itens->max('numero') + 1;
			}
			
			if (!$itens->contains('numero', $valor[0])) { // verifica se já existe item com mesmo número
				$unidade_id = Unidade::where('nome', trim($valor[3]))->first()->id ?? 1; // busca a unidade na collection

				$descricao = ''; //recebe a descricao detalhada do item
				$objeto = ''; // recebe ojeto do item

				// separa descrição detalhada da descrição informada pelo usuário
				if(strpos($valor[1], "Descrição Detalhada:") != false){
					$descricao = explode("Descrição Detalhada:", $valor[1], 2);
				} elseif(strpos($valor[1], "Descricão Detalhada:") !== false){
					$descricao = explode("Descricão Detalhada:", $valor[1], 2);
				} elseif(strpos($valor[1], "Descriçao Detalhada:") !== false){
					$descricao = explode("Descriçao Detalhada:", $valor[1], 2);
				} elseif(strpos($valor[1], "Descricao Detalhada:") !== false){
					$descricao = explode("Descricao Detalhada:", $valor[1], 2);
				} elseif(strpos($valor[1], "Descrição detalhada:") !== false){
					$descricao = explode("Descrição detalhada:", $valor[1], 2);
				} elseif(strpos($valor[1], "Descricão detalhada:") !== false){
					$descricao = explode("Descricão detalhada:", $valor[1], 2);
				} elseif(strpos($valor[1], "Descriçao detalhada:") !=  false){
					$descricao = explode("Descriçao detalhada:", $valor[1], 2);
				} elseif(strpos($valor[1], "Descricao detalhada:") !== false){
					$descricao = explode("Descricao detalhada:", $valor[1], 2);
				} elseif(strpos($valor[1], "descrição detalhada:") !== false){
					$descricao = explode("descrição detalhada:", $valor[1], 2);
				} elseif(strpos($valor[1], "descrição detalhada") !== false){
					$descricao = explode("descricão detalhada", $valor[1], 2);
				} elseif(strpos($valor[1], "Descrição detalhada") !== false){
					$descricao = explode("Descrição detalhada", $valor[1], 2);
				} elseif(strpos($valor[1], "Descricao Detalhada") !== false){
					$descricao = explode("Descricao Detalhada", $valor[1], 2);
				} elseif(strpos($valor[1], "Descrição Complementar:") !== false){
					$descricao = explode("Descrição Complementar:", $valor[1], 2);
				} elseif(strpos($valor[1], "Descrição Complementar") !== false){
					$descricao = explode("Descrição Complementar", $valor[1], 2);
				} elseif(strpos($valor[1], "Descrição complementar:") !== false){
					$descricao = explode("Descrição complementar:", $valor[1], 2);
				} 

			
				// prepara o objeto do desrição infomada
				if(!isset($descricao[1])){
					$descricao = $valor[1];
					$objeto = "";
				} else {

					if (strpos($descricao[0], "Objeto:") !== false) {
						$objeto = explode("Objeto:", $descricao[0]);
					} elseif (strpos($descricao[0], "objeto:") !== false){
						$objeto = explode("objeto:", $descricao[0]);
					} elseif (strpos($descricao[0], "OBJETO:") !== false){
						$objeto = explode("OBJETO:", $descricao[0]);
					}

					if (!isset($objeto[1])) {
						$objeto = $descricao[0];
					} else {
						$objeto = $objeto[1];
					}
					$descricao = $descricao[1];
				}


				$item = $requisicao->itens()->create([
		            'numero' => intval($valor[0]), // convert em inteiro
		            'descricao' => nl2br($descricao), // inserir as quebas de linha
		            'objeto' => trim($objeto),
		            'codigo' => $valor[2] == ''? 0 : intval($valor[2]),
		            'unidade_id' => $unidade_id,
		            'quantidade' =>  trim($valor[4])
	         	]);

				// Insere um grupo no item ou cria caso o grupo ainda não exista no banco
				/*if (!($valor[5] == 0)) {
					$grupo = $requisicao->grupos()->where('numero','=', $valor[5])->first(); // $valor[5]
					if(empty($grupo)){
						$grupo = $requisicao->grupos()->create(['numero' => $valor[5],]);		
					}
					$grupo->itens()->save($item);
				}*/
			}

		}
		return redirect()->route('requisicaoExibir', ['id' => $requisicao->id]);
	}

	/**
	 * { function_description }
	 *
	 * @param      Array  $dados   dados dos itens para importação
	 * @param      Integer  $id     requisição
	 */
	protected function setCotacao($dados, $id)
	{
		$requisicao = Requisicao::find($id);
		$itens = $requisicao->itens;
		foreach ($dados as $valor) {
			$item = $itens->where('numero', $valor[0])->first();
			if ($item != null) {
				$item->cotacoes()->create([
				'fonte' => $valor[1], 
				'valor' =>  $this->getFloat($valor[2]), 
				'data' => $this->getDate($valor[3], $valor[4])
				]);
			}
		}
		return redirect()->route('requisicaoExibir', ['id' => $id]);
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $dados  The dados
	 * @param      <type>  $id     The identifier
	 */
	protected function setParticipante($dados, $id)
	{	
		# Implementar se o participante ja existe antes de importar
		$requisicao = Requisicao::find($id);
		$itens = $requisicao->itens;
		$estados = Estado::all();
		foreach ($dados as $valor) {
			$uasg_nome = explode("-", $valor[1], 2);
			$cidade_uf = explode("/", $valor[2], 2);
			// verifica se á uasg é diferente do orgão geenciador
			if($this->gerenciador != $uasg_nome[0]) {
				$item = $itens->where('numero', $valor[0])->first();
				// Verifica se o item não é nulo, ou seja, se ele existe no banco de dados
				if ($item != null) {
					// Quebra o conteúdo da celula 02 da linha dividindo a informação em código e nome da Uasg e busca ou cria o objeto participante
					$participante = Participante::firstOrCreate(['uasg' => intval($uasg_nome[0]), 'nome' => $uasg_nome[1]]); 
					// Quebra o conteúdo da celula 03 da linha divididndo a informação em cidade e estado e busca ou cria objeto cidade
					$cidade = Cidade::firstOrCreate(['nome' => $cidade_uf[0], 'estado_id' => $estados->where('sigla', $cidade_uf[1])->first()->id]); 
					// faz a relação de item cidade e participante no banco de dados
					$participante->cidades()->attach($cidade->id, ['item_id' => $item->id, 'quantidade' =>  $valor[3]]);
				}
			}

			/*
			
			//$item = $requisicao->itens()->where('numero','=', $valor[0])->first();
			$item = $itens->where('numero', $valor[0])->first();
			//echo "Item nº".$item->numero."<BR/> ";
			if (!empty($item)) {
				$cidade_uf = explode("/", $valor[1]);
				$local = Local::firstOrCreate([
				'cidade' => $cidade_uf[0], 
				//'estado' =>  $this->getUF($cidade_uf[1])]);
				//$item->locais()->firstOrCreate(['cidade' => $local[0], 'estado' =>  $this->getUF($local[1])],['quantidade' => $valor[2]]);
				//$item->locais()->attach($local->id,[ 'quantidade' => $valor[2]]);
			}*/
		}
		return redirect()->route('requisicaoExibir', ['id' => $requisicao->id]);
	}
	
	protected function setFornecedor($dados)
	{
		$estados = Estado::all();
		foreach ($dados as $valor) {
			$fornecedor = Fornecedor::updateOrCreate(
				['cpf_cnpj' 	=> trim($valor[0])],
				['razao_social' 	=> trim($valor[1]),
				'endereco' 		=> trim($valor[2]),
				'cep' 			=> trim($valor[3]),
				'email' 		=> trim($valor[6]),
				'telefone' 		=> trim($valor[7]),
				'representante' => trim($valor[8])]
			);

			$estado;
			if (strlen($valor[5]) == 2) {
				$estado = $estados->where('sigla', strtoupper($valor[5]))->first();
				if ($estado === null)
					$estado = $estados->where('nome', 'Inconsistente')->first();
			} else {
				$estado = $estados->where('nome', $valor[5])->first();
				if ($estado === null)
					$estado = $estados->where('nome', 'Inconsistente')->first();
			}

			$fornecedor->cidade()->associate(
				Cidade::firstOrCreate(['nome' => $valor[4], 'estado_id' => $estado->id])
			);
			$fornecedor->save();
		}
		return redirect()->route('fornecedor');
	}

	protected function setAta($dados, $id)
	{
		/*$itens = [];
		$tamanho = 0;
		$celulas = explode("&", $dados);
		$primeiro = '';
		$quantidade = count($celulas);

		for ($i = 0; $i < $quantidade;$i++){
			$tamanho = strlen($celulas[$i]);	
			if($tamanho < 10){
				if ($quantidade > $i + 8){
					array_push($itens, [
						'fornecedor' 	=> $primeiro, 
						'item' 			=> $celulas[$i], 
						'objeto' 		=> $celulas[$i+1], 
						'unidade' 		=> $celulas[$i+2],
						'quantidade' 	=> $celulas[$i+3],
						'valor' 		=> $celulas[$i+4],
						'descricao' 	=> $celulas[$i+7]
					]); 
					$i = $i + 8; 
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

		foreach ($itens as $value) {
			$fornec = $this->getFornecedor($value['fornecedor']); //  Nome e cnpj/cpf do fornecedor
			$marcaModelo = $this->getMarcaModelo($value['descricao']); // marca e modelo do item
			$item = Item::where('numero', trim($value['item']))->where('requisicao_id', $id)->first();
			$fornecedor = Fornecedor::firstOrCreate(['cpf_cnpj' => trim($fornec['cpfCnpj']), 'razao_social' => trim($fornec['razaoSocial'])]);
			$item->fornecedores()->attach($fornecedor->id, [
				'marca' => trim($marcaModelo['marca']), 
				'modelo' => trim($marcaModelo['modelo']), 
				'quantidade' => trim($value['quantidade']), 
				'valor' => $this->getFloat(trim(str_replace('R$', '', $value['valor'])))
			]);
		}*/
	}

	protected function AtaSrpShow($dados, $uuid)
	{

		$itens = [];
		$tamanho = 0;
		$celulas = explode("&", $dados);
		$primeiro = '';
		$quantidade = count($celulas);

		for ($i = 0; $i < $quantidade;$i++){
			$tamanho = strlen($celulas[$i]);	
			if($tamanho < 10){
				if ($quantidade > $i + 8){
					array_push($itens, [
						'fornecedor' 	=> $primeiro, 
						'item' 			=> $celulas[$i], 
						'objeto' 		=> $celulas[$i+1], 
						'unidade' 		=> $celulas[$i+2],
						'quantidade' 	=> $celulas[$i+3],
						'valor' 		=> $celulas[$i+4],
						'descricao' 	=> $celulas[$i+7]
					]); 
					$i = $i + 8; 
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

		$ata = collect();
		$licitacao = Licitacao::findByUuid($uuid);
		foreach ($itens as $value) {

			/*$item = Item::where('ordem', trim($value['item']))->where('licitacao_id', $licitacao->id)->first();
			$fornecedor = Fornecedor::firstOrCreate(['cpf_cnpj' => trim($fornec['cpfCnpj']), 'razao_social' => trim($fornec['razaoSocial'])]);
			$item->fornecedores()->attach($fornecedor->id, [
				'marca' => trim($marcaModelo['marca']), 
				'modelo' => trim($marcaModelo['modelo']), 
				'quantidade' => trim($value['quantidade']), 
				'valor' => $this->getFloat(trim(str_replace('R$', '', $value['valor'])))
			]);*/

			$fornecedor = $this->getFornecedor($value['fornecedor']); //  Nome e cnpj/cpf do fornecedor
			$marcaModelo = $this->getMarcaModelo($value['descricao']); // marca e modelo do item
			$ata->push([
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
        return view('ata', compact('ata', 'licitacao'));
	}

	public function AtaSrpStore (Request $request)
    {
        $licitacao = Licitacao::findByUuid($request->licitacao);
        // Verifica se os Array de dados possuem os mesmos tamanhos
        if (count($request->ordem) == count($request->unidade) && 
            count($request->quantidade) == count($request->valor) &&    
            count($request->marca) ==  count($request->modelo) &&
            count($request->razaoSocial) == count($request->cnpj))
        {
         	for ($i=0; $i < count($request->ordem) ; $i++) {
                $item = Item::where('ordem', $request->ordem[$i])->where('licitacao_id', $licitacao->id)->first();
                $PJuridica = PessoaJuridica::firstOrCreate(['cnpj' => $request->cnpj[$i], 'razao_social' => $request->razaoSocial[$i]]);
				$fornecedor;
				if(count($item) == 1 && $item->quantidadeTotalDisponivel >= $request->quantidade[$i]){
					if (count($PJuridica->fornecedor) == 1) {
						$fornecedor = $PJuridica->fornecedor;
					} else{
						$fornecedor = $PJuridica->fornecedor()->create([]);
					}
	                $item->fornecedores()->attach($fornecedor->id, [
	                    'marca' => $request->marca[$i], 
	                    'modelo' => $request->modelo[$i], 
	                    'quantidade' =>$request->quantidade[$i], 
	                    'valor' => $this->getFloat(trim(str_replace('R$', '', $request->valor[$i])))
	                ]);
	            }               
            }
        }
        return redirect()->route('pregaoExibir', ['uuid' => $licitacao->licitacaoable->uuid]);
    }
	
	/** 
	 * função que converte string para o valor numérico float
	 *
	 * @param String $valor,
	 * @return float 
	 */
	protected function getFloat($string) { 
	  	if(strstr($string, ",")) { 
		    $string = str_replace(",", ".", str_replace(".", "", $string));
	  	} 
	   // search for number that may contain '.' 
	    if(preg_match("#([0-9\.]+)#", $string, $match)) {
		    return floatval($match[0]); 
	    } else { 
	    	// take some last chances with floatval 
	    	return floatval($string); 
	  	}
	}
	
	/**
	 * Função que converte string data e hora no formato datetime para o banco de dados
	 *
	 * @param String $data, String $hora
	 * @return datetime 
	 */
	protected function getDate($data, $hora) { 
		$hora = preg_replace("/[^0-9]/", "", $hora);
		$data = preg_replace("/[^0-9]/", "", $data);
		if(strlen($data) == 8){
			$data = preg_replace('/^([0-9]{2})([0-9]{2})([0-9]{4})$/', '$1-$2-$3', $data);
		} elseif (strlen($data) == 6) {
			$data = preg_replace('/^([0-9]{2})([0-9]{2})([0-9]{2})$/', '$1-$2-20$3', $data); // acrescenta 20 caso a data tenha formato dd/mm/aa
		} else {
			$data = NULL;  // data invalida é definada como nula
		}

		if(strlen($hora) == 4){
			$hora = preg_replace('/^([0-9]{2})([0-9]{2})$/', '$1:$2', $hora);
		} else {
			$hora = '00:00';
		}

		if($data == NULL){
			return NULL;
		} else {
			return date_format(date_create($data.$hora), 'Y-m-d H:i');
		}
	}

	protected function getMarcaModelo($valor){
		if (strlen($valor) > 20 )  {
			$quebrado = explode("Descrição Detalhada", $valor, 2);
			$removido = str_replace(["Marca:", "Fabricante", "Modelo / Versão"], "", $quebrado[0]);
			$vetor = explode(":", $removido);
			return ['marca' => $vetor[0], 'modelo' => $vetor[2] ?? ''];
		}
	}

	protected function getFornecedor($valor)
	{
		if (strlen($valor) > 20 )  {
			$vetor = explode("-", $valor, 3);
			//$razaoSocial = '';
			// ($i=2; $i < count($vetor); $i++)
				//$razaoSocial .= $vetor[$i];
			return ['cpfCnpj' => $vetor[0]."-".$vetor[1], 'razaoSocial' => $vetor[2]] ;
		}
	}

	/**
     * função que converte a UF abreviada pelo nome completado da UF
	 * 
	 * @param  String $sigla da federação 
	 * @return String nome do estado outrocaso retorna incosistente
	 */
	protected function getUF($sigla){
		switch (strtoupper($sigla)) {
			case 'AC': return 'Acre';
			case 'AL': return 'Alagoas';
			case 'AP': return 'Amapá';
			case 'AM': return 'Amazonas';
			case 'BA': return 'Bahia';
			case 'CE': return 'Ceará';
			case 'DF': return 'Distrito Federal';
			case 'ES': return 'Espírito Santo';
			case 'GO': return 'Goiás';
			case 'MA': return 'Maranhão';
			case 'MT': return 'Mato Grosso';
			case 'MS': return 'Mato Grosso do Sul';
			case 'MG': return 'Minas Gerais';
			case 'PA': return 'Pará';
			case 'PB': return 'Paraíba';
			case 'PR': return 'Paraná';
			case 'PE': return 'Pernambuco';
			case 'PI': return 'Piauí';
			case 'RJ': return 'Rio de Janeiro';
			case 'RN': return 'Rio Grande do Norte';
			case 'RS': return 'Rio Grande do Sul';
			case 'RO': return 'Rondônia';
			case 'RR': return 'Roraima';
			case 'SC': return 'Santa Catarina';
			case 'SP': return 'São Paulo';
			case 'SE': return 'Sergipe';
			case 'TO': return 'Tocantins';
			default: return 'Inconsistente';
			/*case 'AC': return 1;
			case 'AL': return 2;
			case 'AP': return 3;
			case 'AM': return 4;
			case 'BA': return 5;
			case 'CE': return 6;
			case 'DF': return 7;
			case 'ES': return 8;
			case 'GO': return 9;
			case 'MA': return 10;
			case 'MT': return 11;
			case 'MS': return 12;
			case 'MG': return 13;
			case 'PA': return 14;
			case 'PB': return 15;
			case 'PR': return 16;
			case 'PE': return 17;
			case 'PI': return 18;
			case 'RJ': return 19;
			case 'RN': return 20;
			case 'RS': return 21;
			case 'RO': return 22;
			case 'RR': return 23;
			case 'SC': return 24;
			case 'SP': return 25;
			case 'SE': return 26;
			case 'TO': return 27;*/
		}
	}

	public function leitor(Request $request)
	{
		// SplFileInfo
		$file = $request->file('arquivo');
		if (empty($file)) {
			abort(400, 'Nenhum arquivo foi enviado.');
		}
		// SplFileObject Abre o arquivo 
		$arquivo = $file->openFile();
		// Lê e retorna como string todos os dados do arquivo convertendo pat utf-8
		$conteudo = utf8_encode ($arquivo->fread($arquivo->getSize()));
		// retorno um array quebrando em linhas o conteúdo da tabela
		$tudo = explode(";", $conteudo);
		// matriz que receberá cada uma das linhas da tabela em formato de array
		$ojetos = array_chunk($tudo, 5);
		print_r(nl2br($ojetos[0][1]));
		//print_r(array_chunk($linhas, 5));
		//print_r(array_chunk($linhas, 5, true));
		/*$dados = array();
		foreach ($linhas as $key => $value) {
			array_push($dados, explode("\t", $value));
		}
		$arquivo = null;
		//var_dump($dados);
		return $dados ;*/
	}

	public function upload(Request $request)
	{
		// SplFileInfo
		$file = $request->file('arquivo');
		if (empty($file)) {
			abort(400, 'Nenhum arquivo foi enviado.');
		}
		// SplFileObject Abre o arquivo 
		$arquivo = $file->openFile();
		// Lê e retorna como string todos os dados do arquivo convertendo pat utf-8
		$conteudo = utf8_encode ($arquivo->fread($arquivo->getSize()));
		// retorno um array quebrando em linhas o conteúdo da tabela
		$linhas = explode("\n", $conteudo);
		// matriz que receberá cada uma das linhas da tabela em formato de array
		$dados = array();
		foreach ($linhas as $key => $value) {
			array_push($dados, explode("\t", $value));
		}
		$arquivo = null;
		//var_dump($dados);
		return $dados ;
	}
}