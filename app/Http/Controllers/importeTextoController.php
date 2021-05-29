<?php

namespace App\Http\Controllers;

use App\Item;
use App\Uasg;
use DateTime;
use App\Cidade;
use App\Estado;
use App\Unidade;
use App\Licitacao;
use App\Fornecedor;
use App\Requisicao;
use App\PessoaJuridica;
use Illuminate\Http\Request;
use App\Services\CotacaoService;
use Illuminate\Support\Facades\Session;

class ImporteTextoController extends Controller
{
	private $gerenciador = 158410;
    protected $cotacaoService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CotacaoService $cotacaoService)
    {
        $this->cotacaoService = $cotacaoService;
    }

	/**
	 * { function_description }
	 *
	 * @param      <String>  $uuid     The identifier
	 * @return     <Vie>  ( description_of_the_return_value )
	 */
	public function create(String $uuid = '')
	{
		$opcoes = [
			'1' => '1 - Item',
			'2' => '2 - Pesquisa de Preços', 
			'3' => '3 - Unidade Participante',
			'4' => '4 - Fornecedor', 
			'5' => '5 - Ata de Registro de Preços'
		];

		if ($uuid == '') {
			$opcoes = ['4' => '4 - Fornecedor'];
		}
		return view('importe',  compact('opcoes', 'uuid'));
	}

	public function requisicaoCreate(Requisicao $requisicao)
	{
		return view('requisicao.import',  compact('requisicao'));
	}

	public function licitcaoCreate(Licitacao $licitacao)
	{
		return view('licitacao.import',  compact('requisicao'));
	}

	public function fornecedorCreate()
	{
		return view('fornecedor.import');
	}

	/**
	 * { function_description }
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 */
	public function store(Request $request)
	{
		$celulas = explode("&", substr($request->dados,  0, -1)); // remove o ultimo caracter e quebra a texto em celulas
		switch ($request->tipo) {
			case '1': 
				return $this->setItem(array_chunk($celulas,5), $request->uuid); 
			case '2':
				return $this->setCotacao(array_chunk($celulas,5), $request->uuid); 
			case '3': 
				return $this->setParticipante(array_chunk($celulas,4), $request->uuid); 
			case '4': 
				return $this->setFornecedor(array_chunk($celulas,10)); 
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
	protected function setItem($dados, $uuid)
	{
		$requisicao = Requisicao::findByUuid($uuid);
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
		            'numero' 		=> intval($valor[0]), // convert em inteiro
		            'descricao' 	=> nl2br($descricao), // inserir as quebas de linha
		            'objeto' 		=> trim($objeto),
		            'codigo' 		=> $valor[2] == ''? 0 : intval($valor[2]),
		            'unidade_id'	=> $unidade_id,
		            'quantidade' 	=> trim($valor[4])
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
		return redirect()->route('requisicaoShow', $requisicao->uuid);
	}

	/**
	 * { function_description }
	 *
	 * @param      Array  $dados   dados dos itens para importação
	 * @param      Integer  $id     requisição
	 */
	protected function setCotacao($dados, $uuid)
	{
		$requisicao = Requisicao::findByUuid($uuid);
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
		return redirect()->route('requisicaoShow', $uuid);
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $dados  The dados
	 * @param      <type>  $id     The identifier
	 */
	protected function setParticipante($dados, $uuid)
	{	
		# Implementar se o participante ja existe antes de importar
		$licitacao = Licitacao::findByUuid($uuid);
		$itens = $licitacao->itens;
		foreach ($dados as $valor) {
			$uasg_nome = explode("-", $valor[1], 2);
			$cidade_uf = explode("/", $valor[2], 2);
			// verifica se á uasg é diferente do orgão gerenciador
			if($this->gerenciador != $uasg_nome[0]) {
				$item = $itens->where('ordem', $valor[0])->first();
				// Verifica se o item não é nulo, ou seja, se ele existe no banco de dados
				if ($item != null) {
					// Quebra o conteúdo da celula 02 da linha dividindo a informação em código e nome da Uasg e busca ou cria o objeto participante
					$participante = Uasg::firstOrCreate(['codigo' => intval($uasg_nome[0])],['nome' => $uasg_nome[1]]); 
					// Quebra o conteúdo da celula 03 da linha divididndo a informação em cidade e estado e busca ou cria objeto cidade
					$cidade = Cidade::firstOrCreate(['nome' => $cidade_uf[0], 'estado_id' => Estado::where('sigla', $cidade_uf[1])->first()->id]); 
					// faz a relação de item cidade e participante no banco de dados
					$participante->cidades()->attach($cidade->id, ['item_id' => $item->id, 'quantidade' =>  $valor[3]]);
				}
			}
		}
		return redirect()->route('licitacaoShow',  $requisicao->uuid);
	}
	
	protected function setFornecedor($dados)
	{
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
			} else{
				$fornec->endereco 	= trim($valor[2]);
				$fornec->cep 		= trim($valor[3]);
				$fornec->cidade_id 	= $cidade->id;
				$fornec->email 		= trim($valor[6]);
				$fornec->telefone_1 = trim($valor[7]);
				$fornec->telefone_2 = trim($valor[8]);
				$fornec->save();
			}


			/*
			$fornecedor = Fornecedor::updateOrCreate(
				['cpf_cnpj' 	=> trim($valor[0])],
				['razao_social' => trim($valor[1]),
				'endereco' 		=> trim($valor[2]),
				'cep' 			=> trim($valor[3]),
				'email' 		=> trim($valor[6]),
				'telefone' 		=> trim($valor[7]),
				'representante' => trim($valor[8])]
			);

			$fornecedor->cidade()->associate(
				Cidade::firstOrCreate(['nome' => $valor[4], 'estado_id' => $estado->id])
			);
			$fornecedor->save();
			*/
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
		$resultado = collect();
		$licitacao = Licitacao::findByUuid($uuid);
/*
		$item = Item::where('ordem', trim($value['item']))->where('licitacao_id', $licitacao->id)->first();
		$fornecedor = Fornecedor::firstOrCreate(['cpf_cnpj' => trim($fornec['cpfCnpj']), 'razao_social' => trim($fornec['razaoSocial'])]);
		$item->fornecedores()->attach($fornecedor->id, [
			'marca' => trim($marcaModelo['marca']), 
			'modelo' => trim($marcaModelo['modelo']), 
			'quantidade' => trim($value['quantidade']), 
			'valor' => $this->getFloat(trim(str_replace('R$', '', $value['valor'])))
		]);*/

		//  http://www.comprasnet.gov.br/livre/pregao/FornecedorResultadoDecreto.asp?prgCod=822373
		
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
        return view('registro_de_preco.importe', compact('resultado', 'licitacao'));
	}
	/**
	 * Método que realiza o registro na base de dodos as informações da relação itens com fornecedores.
	 * Este método recebe da view um Array de itens a serem relacionados e o uuid da licitação.
	 * Retira da sessão os dados do resultado da licitação e que serão utilizados no registro
	 *
	 * @param      \Illuminate\Http\Request  $request  
	 */
	public function AtaSrpStore (Request $request)
    {    		
       $licitacao = Licitacao::findByUuid($request->licitacao); // 
       $resultado = Session::get('resultado');
       $ordemItens = $request->itens;

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
	                    'valor' => $this->getFloat(trim(str_replace('R$', '', $array["valor"])))
	                ]);
	            }
        	}
        }
        //35121414
        //81384243

        	/*
         	
         	for ($i=0; $i < count($ordemItens) ; $i++) {
                $item = Item::where('ordem', $request->ordem[$i])->where('licitacao_id', $licitacao->id)->first();
                $PJuridica = PessoaJuridica::firstOrCreate(['cnpj' => $request->cnpj[$i], 'razao_social' => $request->razaoSocial[$i]]);
				$fornecedor;
				//Verifica se o  item existe se está vinculado a licitação e se a quantidade a ser viculado está dispoível
				if(count($item) == 1 && $item->quantidadeTotalDisponivel >= $request->quantidade[$i]){
					// veriica se a pessoa jurrídica existe, cso contrário cria um Objeto pessoa PessoaJuridica e um Ojeto Fornecedor a ela ralacionado
					if (count($PJuridica->fornecedor) == 1) {
						$fornecedor = $PJuridica->fornecedor;
					} else{
						// Cria um Objeto Fornecedor com atributos todos nulos
						$fornecedor = $PJuridica->fornecedor()->create([]);
					}
					// Relaciona o fornecedor com o item 
	                $item->fornecedores()->attach($fornecedor->id, [
	                    'marca' => $request->marca[$i], 
	                    'modelo' => $request->modelo[$i], 
	                    'quantidade' =>$request->quantidade[$i], 
	                    'valor' => $this->getFloat(trim(str_replace('R$', '', $request->valor[$i])))
	                ]);
	            }               
            }*/
       	return redirect()->route('pregaoShow',$licitacao->licitacaoable->uuid);
    }
	
	/** 
	 * função que converte string para o valor numérico float
	 *
	 * @param String $valor,
	 * @return float 
	 */
	protected function getFloat($string) 
	{ 
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
	protected function getDate($data, $hora)
	{ 
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

	protected function getMarcaModelo($valor)
	{
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
	protected function getUF($sigla)
	{
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