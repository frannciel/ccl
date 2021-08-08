<?php

namespace App\Http\Controllers;

use DB;
use Session;
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
    public function index() { }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Requisicao $requisicao)
    {   
        $unidades = array();
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']);
        foreach (Unidade::orderBy('nome', 'asc')->get() as $unidade)
            $unidades += [$unidade->uuid => $unidade->nome];
        return view('site.item.create', compact('unidades', 'requisicao', 'comunica'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Requisicao $requisicao, $novo = null)
    {
        $this->validate($request, [
            'quantidade' => 'required|integer',
            'codigo'     => 'nullable|integer',
            'objeto'     => 'required|string|max:300',
            'descricao'  => 'required|string',
            'unidade'    => 'required|string|exists:unidades,uuid',
        ]);

        $return =  $this->service->store($request->all(), $requisicao);
        if ($return['status']) {
            if ($novo){ // se verdaderio retorna o formulário para cadastrar novo item
                return redirect()->route('item.create', $requisicao->uuid)
                    ->with(['codigo' => 200,'mensagem' => 'O item '.$return['data']->numero.' foi cadastrado com sucesso!']);
            }
            return redirect()->route('requisicao.show', $requisicao->uuid)
                ->with(['codigo' => 200,'mensagem' => 'O item '.$return['data']->numero.' foi cadastrado com sucesso!']);
        } else {
            return redirect()->route('requisicao.show', $requisicao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error durante o cadastro, tente novamente ou contate o administrador!']);
        }
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
    public function edit(Item $item)
    {     
        $unidades = array();
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']);
        foreach (Unidade::all() as $unidade)
            $unidades += [$unidade->uuid => $unidade->nome];
        return view('site.item.edit', compact('unidades', 'item', 'comunica'))->with('requisicao', $item->requisicao);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $this->validate($request, [
            'quantidade' => 'required|integer',
            'codigo'     => 'nullable|integer',
            'objeto'     => 'required|string|max:300',
            'descricao'  => 'required|string',
            'unidade'    => 'required|string|exists:unidades,uuid',
        ]);

        $return =  $this->service->update($request->all(), $item);
        if ($return['status']) {
            return redirect()->route('requisicao.show', $item->requisicao->uuid)
                ->with(['codigo' => 200,'mensagem' => 'O item '.$return['data']->numero.' foi alterado com sucesso!']);
        } else {
            return redirect()->route('requisicao.show',$item->requisicao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error durante o alteração do item, tente novamente ou contate o administrador!']);
        }
    }


    /**
     * Remove the specified resource from storage.
     * 
     * @param Item $item 
     * @return type
     */
    public function destroy(Item $item)
    {
        $return =  $this->service->destroy($item);
        if ($return['status']) {
            return redirect()->route('requisicao.show', $item->requisicao->uuid)
                ->with(['codigo' => 200,'mensagem' => 'O item foi apagado com sucesso!']);
        } else {
            return redirect()->route('requisicao.show', $item->requisicao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error durante o exclusão do item, tente novamente ou contate o administrador!']);
        }
    }

    public function deleteAll(Request $request)
    {
        $this->validate($request, [
            "itens" => 'required|array|min:1',
            'itens.*' => 'string|exists:itens,uuid',
        ], [
            'required' => 'Selecione pelo menos um item a ser excluido',
        ]);

        $return = $this->service->deleteAll($request->itens);
        if ($return['status']){
            return redirect()->route('requisicao.show', $return['data']->uuid)
                ->with(['codigo' => 200,'mensagem' => 'Item(ns) selecionado(s) apagados com sucesso !']);
        } else {
            return redirect()->route('requisicao.show', $return['data']->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error ao excluir item(ns), tente novamente ou contate o administrador']); 
        }
    }
    
    /**
     * método para duplicar itens da requisicão. Recebe como parametro um array de uuid 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function duplicar(Request $request)
    {
        $this->validate($request, [
            "itens" => 'required|array|min:1',
            'itens.*' => 'string|exists:itens,uuid'
        ],[
            'required' => 'Selecione pelo menos um item a ser duplicado',
        ]);

        $return = $this->service->duplicar($request->itens);
        if ($return['status']){
            return redirect()->route('requisicao.show',  $return['data']->uuid)
                ->with(['codigo' => 200,'mensagem' => 'Item(ns) duplicado com sucesso !']);
        } else {
            return redirect()->route('requisicao.show',  $return['data']->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error ao duplicar item(ns), tente novamente ou contate o administrador']); 
        }
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
        return view('site.item.atribuir', compact('itens', 'licitacao'));
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
    	return view('site.item.fornecedor');
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
            return redirect()->route('item.fornecedorShow', ['fornecedor' => $request->fornecedor, 'item' => $item[0]]);
        } else{
            return redirect()->route('item.fornecedorCreate');

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
		return redirect()->route('item.fornecedorShow', ['fornecedor' => $request->fornecedor, 'item' => $request->item]);
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
     * Importar cotação de preços  a partir de tabela em formato de texto
     *
     * @param Request  $request
     * @param Requisicao  $requisicao
     */
    protected function importarTexto(Request $request,  Requisicao $requisicao)
    {
        $return = $this->service->importar($request->all(), $requisicao);
        if ($return['status']){
            return redirect()->route('requisicao.show', $requisicao->uuid)
                ->with(['codigo' => 200,'mensagem' => 'Itens importados com sucessos!']);
        } else {
            return redirect()->route('requisicao.show', $requisicao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error durante a importação, tente novamente ou contate o administrador']); 
        }
    }
}
