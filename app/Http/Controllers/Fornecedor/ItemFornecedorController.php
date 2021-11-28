<?php

namespace App\Http\Controllers\Fornecedor;

use App\Item;
use App\Licitacao;
use App\Fornecedor;
use App\Requisicao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ItemFornecedorService;
use App\Services\ConversorService;

class ItemFornecedorController extends Controller
{
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ItemFornecedorService $service)
    {
        $this->service = $service;
    }

    /**
     *  Método que retorna a view que permnite a vincular item ao fornecedor
     *
     *  @param  Request  $request  The request
     *  @param  Licitacao $licitacao
     *  @return View
     */
    public function create (Request $request, Licitacao $licitacao)
    {
        $lista = $request->itens;  // lista de itens selecionados na view de 
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
        return view('site.fornecedor.compras.atribuir.create', compact('itens', 'licitacao'));
    }

    public function updateAjax (Request $request, Item $item, Fornecedor $fornecedor)
    {
        if (!isset($fornecedor) ) {
            return response()->json(['codigo' =>  500, 'message' => 'Fornecedor inválido ou não encontrado !!!']);
        } elseif (!isset($item)) {
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

            //$fornecedor = Fornecedor::findByUuid($request->fornecedor);
            if ($fornecedor == null)
                return response()->json(['codigo' =>  300, 'message' => 'Fornecedor não encontrado 2 !!!']);

           // $item = Item::findByUuid($request->item);
            if ($item == null) 
                return response()->json(['codigo' =>  300, 'message' => 'Item não encontrado !!!']);

            if (!$item->licitacao->uuid === $request->licitacao) 
                return response()->json(['codigo' =>  200, 'message' => 'Item não pertence a esta licitação ou licitação não encontrada']);

            if ($item->quantidadeTotalDisponivel >= $request->quantidade) {
                $atributos = [
                    'marca' => $request->marca,
                    'modelo'   => $request->modelo ?? '',
                    'quantidade'  => $request->quantidade,
                    'valor' =>  ConversorService::stringToFloat($request->valor)
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
     *  Método que retorna a view que permnite a vincular item ao fornecedor
     *
     *  @param  Request  $request  The request
     *  @param  Licitacao $licitacao
     *  @return View
     */
    public function edit (Fornecedor $fornecedor, Licitacao $licitacao, Item $item = NULL)
    {
        // Retorna todos os itens de um memos fornecedor na licitação informada
        $itens = $fornecedor->itens()->where('licitacao_id', $licitacao->id)->orderBy('ordem')->get();
        if($item ==! NULL){
            if(!$itens->contains($item)){
                return redirect()->back()->with(['codigo' => 500, 'mensagem' => 'Este item não está atribuido ao fornecedor'.$fornecedor->nome]);
            }
            $fornecedor = $item->fornecedores()->find($fornecedor->id);           
        } else{
            $item = $itens->first();
            $fornecedor = $item->fornecedores()->find($fornecedor->id);
        }
        return view('site.fornecedor.compras.atribuir.edit', compact('itens', 'licitacao', 'fornecedor', 'item'));
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
    /*public function atribuir()
    {
    	return view('site.item.fornecedor');
    }*/

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
	 * @param      Request  $request  The request
	 * @return     <type>    Retona para a tela de edição e cadastro de pivot
	 */
	public function update(Request $request, Fornecedor $fornecedor, Item $item)
    {
		$atributos = [
			'marca'  		=> $request['marca'],
			'modelo'  		=> $request['modelo'],
			'quantidade'  	=> $request['quantidade'],
			'valor'  		=> ConversorService::stringToFloat($request['valor'])
		];
		$item->fornecedores()->updateExistingPivot($fornecedor->id, $atributos);
		return redirect()->route('fornecedor.item.edit', [$fornecedor->uuid, $item->licitacao->uuid]);
    }
	
	/**
	 *  Retorna a view responsável pelo registro dos atributos adcionais da relação item / forncedor
	 *
	 * @param      int  $fornecedor_id  The fornecedor identifier
	 * @param      int  $item_id        The item identifier
	 * @return     View  view de cadastro dos pivot da realção item / fornecedor
	 */
	public function fornecedorShow(Fornecedor $fornecedor, Item $item)
	{
        /* VERIFICAR OS PARAMETROS DE ENTRADA E REDIRECIONAR*/
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
        return view('site.item_fornecedor.pivotStore', compact('anterior', 'proximo', 'fornecedor', 'requisicao', 'item'));
	}
    
    /**
     * realiza o chamado da classe de serviço para pré-visualizar os dados a serem importados do resultaodo por fornecedor do Comparasnet
     *
     * @param  Request $request
     * @param  App\Licitacao $licitacao
     * @return view
     */
    public function importarPreVisualizar (Request $request, Licitacao $licitacao)
    {
        $return = $this->service->importPreview($request->all(), $licitacao);
        if ($return['status']){
            return view('site.fornecedor.compras.atribuir.importe')
                ->with(['licitacao' => $return['data']['licitacao'], 'resultado' => $return['data']['resultado']]);
        } else {
            return redirect()->route('licitacao.importar', $licitacao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error durante a execução, tente novamente ou contate o administrador']); 
        }
    }
    
    /**
     * Realiza o chamado da classe de serviço para salvar os dados importados da Resultado do Fornecedor do Comprasnet
     *
     * @param  Request $request
     * @param  App\Licitacao $licitacao
     * @return Response
     */
    public function importarStore(Request $request, Licitacao $licitacao)
    {
        $return = $this->service->importStore($request->all(), $licitacao);
        if ($return['status']){
            return redirect()->route('pregao.show', $licitacao->uuid)
                ->with(['codigo' => 200,'mensagem' => 'Resultado por fornecedor importado com sucesso.']);
        } else {
            return redirect()->route('licitacao.importar', $licitacao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error durante a execução, tente novamente ou contate o administrador']); 
        }
    }
}
