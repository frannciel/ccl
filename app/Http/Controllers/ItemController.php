<?php

namespace App\Http\Controllers;

use DB;
use App\Item;
use App\Unidade;
use App\Licitacao;
use App\Fornecedor;
use App\Requisicao;
use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Http\Requests\ItemRequest;


class ItemController extends Controller
{
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ItemService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($uuid)
    {
        $unidades = array();
        foreach (Unidade::orderBy('nome', 'asc')->get() as $value)
            $unidades += [$value->id => $value->nome];
        return view('item.create', compact('unidades'))->with('requisicao', Requisicao::findByUuid($uuid));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'requisicao' => 'required|string',
            'quantidade' => 'required|integer',
            'codigo'     => 'integer|nullable',
            'objeto'     => 'string|nullable|max:300',
            'descricao'  => 'required|string',
            'unidade'    => 'required|integer',
            'grupo'      => 'integer|nullable'
        ]);
        $requisicao = Requisicao::findByUuid($request->requisicao);

        $requisicao->itens()->create([
            'numero'        => $requisicao->itens()->max('numero') + 1,
            'quantidade'    => $request['quantidade'],
            'codigo'        => $request['codigo'],
            'objeto'        => $request['objeto'],
            'descricao'     => nl2br($request['descricao']),
            'unidade_id'    => $request['unidade'],
        ]);
        return redirect()->route('requisicaoShow', $requisicao->uuid);
        /*
        $item = Item::create([
            'numero' 		=> Item::where('requisicao_id', $request->requisicao)->max('numero') + 1,
            'quantidade' 	=> $request['quantidade'],
            'codigo' 		=> $request['codigo'],
            'objeto'        => $request['objeto'],
            'descricao' 	=> nl2br($request['descricao']),
            'unidade_id' 	=> $request['unidade'],
            'requisicao_id' => $request->requisicao
        ]);*/

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        return response()->json(['Item' => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $item = Item::findByUuid($uuid);
       /* $dados = DB::table('cidade_participante')
            ->join('participantes', 'participantes.id', '=', 'cidade_participante.participante_id')
            ->join('cidades', 'cidades.id', '=', 'cidade_participante.cidade_id')
            ->select('participantes.uasg', 'participantes.nome as participante' , 'cidades.nome', 'cidades.estado_id', 'cidade_participante.quantidade')
            ->where('cidade_participante.item_id', '=', $item->id)
            ->Join('estados', 'estados.id', '=', 'estado_id')
            ->select('participantes.uasg', 'participantes.nome as participante' , 'cidades.nome as cidade', 'estados.sigla as estado','cidade_participante.quantidade')
            ->get();*/
     
        $unidades = array();
        foreach (Unidade::all() as $value)
            $unidades += [$value->id => $value->nome];

        //$item->with('cidades', 'participantes')->where('id', '=', $item->id)->first();
        return view('requisicao.itemEdit', compact('unidades', 'item'));
    }

    /**
     * Mostra o formulário para editar um item específico relacionada a uma licitacão
     *
     * @param  Item  $item
     * @return \Illuminate\Http\Response
     */
    public function editItemLicitacao(Item $item){
        $licitacao = $item->licitacao;
        $fornecedores = $item->fornecedores;
        $uasgs = $item->participantes;
        $unidades = array();
        foreach (Unidade::all() as $value)
            $unidades += [$value->id => $value->nome];
        return view('licitacao.pregao.itemEdit',  compact('item', 'licitacao', 'fornecedores', 'uasgs', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'item'       => 'required|string',
            'quantidade' => 'required|integer',
            'codigo'     => 'integer|nullable',
            'objeto'     => 'string|nullable|max:100',
            'descricao'  => 'required|string',
            'unidade'    => 'required|integer',
        ]);

        $item = Item::findByUuid($request->item);
        $item->quantidade 	= $request->quantidade;
        $item->codigo 		= $request->codigo;
        $item->objeto       = $request->objeto;
        $item->descricao 	= nl2br($request->descricao);
        $item->unidade_id 	= $request->unidade;
        $item->save();
        return redirect()->route('requisicaoShow', $item->requisicao->uuid);
    }

    /**
     * Atualiza um ite específico relacionado a uma licitação
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateItemLicitacao(Request $request, Item $item)
    {
        $this->validate($request, [
            'item'       => 'required|string',
            'quantidade' => 'required|integer',
            'codigo'     => 'integer|nullable',
            'objeto'     => 'string|nullable|max:100',
            'descricao'  => 'required|string',
            'unidade'    => 'required|integer',
        ]);
        $item->quantidade   = $request->quantidade;
        $item->codigo       = $request->codigo;
        $item->objeto       = $request->objeto;
        $item->descricao    = nl2br($request->descricao);
        $item->unidade_id   = $request->unidade;
        //$item->grupo_id   = $request->grupo;
        $item->save();
        return redirect()->route('licitacaoShow', $item->licitacao->uuid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('requisicaoExibir',  [ $item->requisicao->uuid]);
    }

    /**
     *  @Descrition método que retorna a interface que permnite a vincular item ao fornecedor
     *
     *  @param      \Illuminate\Http\Request  $request  The request
     *  @return     View
     */
    public function primeiro (Request $request)
    {
        $lista = $request->itens;  // lista de itens selecionados na view de 
        $licitacao = Licitacao::findByUuid($request->licitacao);
        $itens = collect();
        if ($lista == null) {
            $itens = $licitacao->itens()->doesntHave('fornecedores')->get(); // Itens não  vinculados a fornecedores 
            $vinculados = $licitacao->itens()->has('fornecedores')->get(); // Itens já vinculado a um ou mais fornecedores
            foreach ($vinculados as $item){
                if ($item->quantidadeTotalDisponivel > 0)
                    $itens->push($item);
            }

        } else { // lista de itens não vazia
            foreach ($lista as $value) {
                $item = Item::findByUuid($value);
                if ($licitacao->itens->contains($item)){
                    if ($item->quantidadeTotalDisponivel > 0) {
                        $itens->push($item);
                    } else{

                    }
                }
            }
        }   
        return view('item.atribuir', compact('itens', 'licitacao'));
    }


    public function segundo (Request $request)
    {
        if (!isset($request->fornecedor) ) {
            return response()->json(['codigo' =>  500, 'message' => 'Fornecedor inválido ou não encontrado !!!']);
            
        } elseif (!isset($request->item)) {
            return response()->json(['codigo' =>  500, 'message' => 'Item inválido ou não encontrado !!!']);
            
        } elseif (!isset($request->marca)) {
            return response()->json(['codigo' =>  500, 'message' => 'A marca deve ser informada !!!']);
            
        } elseif (!isset($request->quantidade)) {
            return response()->json(['codigo' =>  500, 'message' => 'A quantidade deve ser informada !!!']);
            
        } elseif (!isset($request->valor)) {
            return response()->json(['codigo' =>  500, 'message' => 'O valor deve ser informado !!!']);
            
        } elseif (!isset($request->licitacao)) {
            return response()->json(['codigo' =>  500, 'message' => 'Uma licitacão deve ser informada !!!']);
            
        } else{

            $fornecedor = Fornecedor::findByUuid($request->fornecedor);
            if ($fornecedor == null)
                return response()->json(['codigo' =>  300, 'message' => 'Fornecedor não encontrado 2 !!!']);

            $item = Item::findByUuid($request->item);
            if ($item == null) 
                return response()->json(['codigo' =>  300, 'message' => 'Item não encontrado !!!']);

            if (!$item->licitacao->uuid === $request->licitacao) 
                return response()->json(['codigo' =>  200, 'message' => 'Item não pertence a esta licitação ou licitação não encontrada']);

            if ($item->quantidadeTotalDisponivel >= $request->quantidade) {
                $atributos = [
                    'marca' => $request->marca,
                    'modelo'   => $request->modelo,
                    'quantidade'  => $request->quantidade,
                    'valor' => $this->getFloat($request->valor)
                ];
                $item->fornecedores()->attach($fornecedor, $atributos);
                return response()->json([
                    'codigo' => 100,
                    'item' => $item->uuid,
                    'quantidade' => Item::findByUuid($request->item)->quantidadeTotalDisponivel,
                    'message' => "Cadastrado com sucesso !!! \n Item: ".$item->ordem.' - '.$item->objeto."\n Quantidade:".$request->quantidade
                    ]);
            } else{
                return response()->json(['codigo' =>  200, 'message' => 'Verifique a quantidade informada !!!']);
            }
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request)
    {
        return view('item_fornecedor.tabelaItens')->with('requisicao', Requisicao::find($request->requisicao));
    }

    /**
     * Retorna a view que permite relacionar itens e fornecedores
     *
     * @return     View  relacionamentos de itens 
     */
    public function fornecedorCreate()
    {
    	return view('item.fornecedor');
    }

	/**
	 * Salva o relaciomento entre os itens e forncedores
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @return     View  redireconar para a tela de cadastro de pivot da relação
	 */
	public function fornecedorStore(Request $request)
    {
		if (isset($request->itens)) {
            $itens = $request->itens;
            foreach ($itens as $item){
                Item::find($item)->fornecedores()->attach($request->fornecedor);
            }
            return redirect()->route('itemFornecShow', ['fornecedor' => $request->fornecedor, 'item' => $item[0]]);
        } else{
            return redirect()->route('itemFornecNovo');

        }
    }

	/**
	 * Salva os atributos adicionais da relação
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @return     <type>    Retona para a tela de edição e cadastro de pivot
	 */
	public function fornecedorUpdate(Request $request)
    {
		$item = Item::find($request->item);
		$atributos = [
			'marca'  		=> $request['marca'],
			'modelo'  		=> $request['modelo'],
			'quantidade'  	=> $request['quantidade'],
			'valor'  		=> $this->getFloat($request['valor']),
		];
		$item->fornecedores()->updateExistingPivot($request->fornecedor, $atributos);
		return redirect()->route('itemFornecShow', ['fornecedor' => $request->fornecedor, 'item' => $request->item]);
    }
	
	/**
	 *  Retorna a view responsável pelo registro dos atributos adcionais da relação item / forncedor
	 *
	 * @param      int  $fornecedor_id  The fornecedor identifier
	 * @param      int  $item_id        The item identifier
	 * @return     View  view de cadastro dos pivot da realção item / fornecedor
	 */
	public function fornecedorShow($fornecedor_id, $item_id )
	{
        /* VERIFICAR OS PARAMETROS DE ENTRADA E REDIRECIONAR*/
        $fornecedor = Fornecedor::find($fornecedor_id);
        $item = Item::find($item_id);
        $requisicao = $item->requisicao;

        $itens = $fornecedor->itens()->where('requisicao_id', $requisicao->id)->get();
        $itens = $itens->sortBy('numero')->values();//->toArray();
        //$itens = $itens->values();
 
        $anterior; $proximo;
        for ($i=0; $i < $itens->count() ; $i++) { 
            if ($itens[$i]->numero === $item->numero) {
                if ($i == 0){
                    $anterior = 0;
                }else{
                    $anterior = $itens->get($i - 1)->id;
                }
                if ($i < $itens->count() - 1){ 
                    $proximo = $itens->get($i + 1)->id;
                }else{
                     $proximo = 0;
                    
                }
            }
        }
        return view('item_fornecedor.pivotStore', compact('anterior', 'proximo', 'fornecedor', 'requisicao', 'item'));
	}

	/**
	 * Receba o valor em string e retonar o  valor em float
	 *
	 * @param      String  $string  The string
	 * @return     Float  The float.
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
     * Importar cotação de preços  a partir de tabela em formato de texto
     *
     * @param Request  $request
     * @param Requisicao  $requisicao
     */
    protected function importarTexto(Request $request,  Requisicao $requisicao)
    {
        $return = $this->service->importar($request->all(), $requisicao);
        if ($return['status']){
            return redirect()->route('requisicaoShow', $requisicao->uuid)
                ->with(['codigo' => 200,'mensagem' => 'Itens importados com sucessos!']);
        } else {
            return redirect()->route('requisicaoShow', $requisicao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error durante a importação, tente novamente ou contate o administrador']); 
        }
    }
}
