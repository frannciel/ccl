<?php

namespace App\Http\Controllers;

use Excel;
use App\Uasg;
use App\Cidade;
use App\Estado;
use App\Requisicao;
use Illuminate\Http\Request;
use App\Imports\CotacoesImport;
use Maatwebsite\Excel\HeadingRowImport;

class ImporteExcelController extends Controller
{
	public function licitcaoCreate(Licitacao $licitacao)
	{
		return view('licitacao.import',  compact('requisicao'));
	}

	public function fornecedorCreate()
	{
		return view('fornecedor.import');
	}

	public function importe(Request $request)
    {	
    	$return = [];
		switch ($request->tipo) {
			case '1': 
				//$return = $this->cotacaoService->importar($request);
				$this->importeFileCotacao($request);
		}

        if ($return['status']) {
            return redirect()->route('requisicaoShow', $request->requisicao)
                ->with(['codigo' => 200,'mensagem' => 'Dados importados com sucesso!']);
        } else {
            return redirect()->route('locacaoEdit', $request->requisicao->uuid)
                ->with(['codigo' => 500,'mensagem' => 'Ocorreu um durante a importação dos dados, tente novamente ou contate o administrador']);
        }
    }

    public function importarIrp (Request $request, Licitacao $licitacao)
	{
		// retorna um array de array com as linhas da tabela
		$tabela = Excel::toArray([], request()->file('arquivo'));
		//$array = (new IrpImport)->toArray(request()->file('arquivo'));
		foreach ($tabela[0] as $key => $linha) {
			if ($linha[0] != null && $linha[4] != null && $linha[5] != null && $linha[6] != null) {
				$uasg_nome = explode("-", $linha[4], 2);
				$cidade_uf = explode("/", $linha[5], 2);
				if($this->gerenciador != intval($uasg_nome[0])) {// Não é possivel ao gerenciador subrogar ou participar de seus itens
					if ($linha[7] != null) { // Verifica se o item foi subrogado e precisa ser duplicado
						$item = $licitacao->itens()->where('ordem', '=', $linha[7])->first(); // busca item a ser duplicado
						$subrogado = $licitacao->itens()->where('ordem', '=', $linha[0])->first();
						if($item != null){
							if($subrogado == null){
								$duplicado = $licitacao->itens()->create([
							        'numero'        => 20000, // este número indicara itens mesclados nas  licitcaoes, eles não pertencem a nenhuma requisicão
							        'quantidade'    => 0,
							        'codigo'        => $item->codigo,
							        'objeto'        => $item->objeto,
							        'descricao'     => $item->descricao,
							        'unidade_id'    => $item->unidade_id,
							        'ordem'         => $linha[0] // Ordem é numero do item na licitação
							    ]);
							    foreach ($item->cotacoes as $cotacao) {
							    	$duplicado->cotacoes()->create([
							    		'fonte' => $cotacao->fonte,
							    		'valor' => $cotacao->valor,
							    		'data'  => $cotacao->data
							    	]);
							    }
								// O array uasg_nome contem na posição 0 o código uasg e na posição 1 o nome da entidade
								// Retorna ou  cria um novo objeto Uasg que representa uma entidade participante
								$participante = Uasg::firstOrCreate(['codigo' => intval($uasg_nome[0])],['nome' => $uasg_nome[1]]); 
								// O array cidade_uf contem na posição 0 o nome da cidadena posição 1 a sigla da uf
								$cidade = Cidade::firstOrCreate(['nome' => $cidade_uf[0], 'estado_id' => Estado::where('sigla', $cidade_uf[1])->first()->id]); 
								// Relação de item cidade e participante no banco de dados
								$participante->cidades()->attach($cidade->id, ['item_id' => $duplicado->id, 'quantidade' =>  $linha[6]]);
							} else{
								// O array uasg_nome contem na posição 0 o código uasg e na posição 1 o nome da entidade
								// Retorna ou  cria um novo objeto Uasg que representa uma entidade participante
								$participante = Uasg::firstOrCreate(['codigo' => intval($uasg_nome[0])],['nome' => $uasg_nome[1]]); 
								// O array cidade_uf contem na posição 0 o nome da cidadena posição 1 a sigla da uf
								$cidade = Cidade::firstOrCreate(['nome' => $cidade_uf[0], 'estado_id' => Estado::where('sigla', $cidade_uf[1])->first()->id]); 
								// Relação de item cidade e participante no banco de dados
								$participante->cidades()->attach($cidade->id, ['item_id' => $subrogado->id, 'quantidade' =>  $linha[6]]);
							}
						}
					} else {
						$item = $licitacao->itens()->where('ordem', '=', $linha[0])->first();
						if ($item != null) {
							// O array uasg_nome contem na posição 0 o código uasg e na posição 1 o nome da entidade
							// Retorna ou  cria um novo objeto Uasg que representa uma entidade participante
							$participante = Uasg::firstOrCreate(['codigo' => intval($uasg_nome[0])],['nome' => $uasg_nome[1]]); 
							// O array cidade_uf contem na posição 0 o nome da cidadena posição 1 a sigla da uf
							$cidade = Cidade::firstOrCreate(['nome' => $cidade_uf[0], 'estado_id' => Estado::where('sigla', $cidade_uf[1])->first()->id]); 
							// Relação de item cidade e participante no banco de dados
							$participante->cidades()->attach($cidade->id, ['item_id' => $item->id, 'quantidade' =>  $linha[6]]);
						}
						
					}
				}
			}
		}			
		//return back();
		return redirect()->route('licitacaoShow',  $licitacao->uuid);
	}

	public function importExcel (Request $request)
    {
    	$data = [];
        if($request->hasFile('arquivo')){
            Excel::load($request->file('arquivo')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $row) {

                	$data.push([
			            'item'          => $row[0],
			            'descircao'     => $row[1],
			            'unidade'       => $row[2],
			            'valor'         => $row[3],
			            'entidade'      => $row[4],
			            'cidade'        => $row[5],
			            'quantidade'    => $row[6]
			        ]);
                }
            });
        }
        var_dump($data);
    }

	/**
    * @return \Illuminate\Support\Collection
    */
    public function fileExport() 
    {
        //return Excel::download(new UsersExport, 'users-collection.xlsx');
    } 

    /**
     * Importação utilizando o método collection
     * 
     * @return type
     */
    public function import() 
	{
	    Excel::import(new UsersImport, 'users.xlsx');
	}
}
