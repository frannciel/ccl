<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use App\Item;
use App\Unidade;
Use App\Estado;
use App\Requisicao;
use App\Fornecedor;
use DB;


class ItemController extends Controller
{
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
            'numero'        => $requisicao->max('numero') + 1,
            'quantidade'    => $request['quantidade'],
            'codigo'        => $request['codigo'],
            'objeto'        => $request['objeto'],
            'descricao'     => nl2br($request['descricao']),
            'unidade_id'    => $request['unidade'],
        ]);
        return redirect()->route('requisicaoExibir', ['uuid' => $requisicao->uuid]);
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
            'grupo'      => 'integer|nullable'
        ]);

        $item = Item::findByUuid($request->item);
        $item->quantidade 	= $request->quantidade;
        $item->codigo 		= $request->codigo;
        $item->objeto       = $request->objeto;
        $item->descricao 	= $request->descricao;
        $item->unidade_id 	= $request->unidade;
        //$item->grupo_id 	= $request->grupo;
        $item->save();

        return redirect()->route('requisicaoExibir', ['uuid' => $item->requisicao->uuid]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::destroy($id);
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
}
