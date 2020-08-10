<?php

namespace App\Http\Controllers;

use App\Item;
use App\Fornecedor;
use App\Requisicao;
use App\Requisitante;
use PDF;
use Illuminate\Http\Request;
use App\Http\Requests\RequisicaoRequest;

class RequisicaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('requisicao.index')->with('requisicoes', Requisicao::orderBy('updated_at', 'desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $requisitantes = array();
        foreach (Requisitante::all() as $key => $value)
            $requisitantes += [$value->uuid => $value->nome];
        return view('requisicao.create')->with('requisitantes', $requisitantes);
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
            'tipo'          => 'required|integer',
            'prioridade'    => 'required|integer',
            'renovacao'     => 'required|integer',
            'capacitacao'   => 'required|integer',
            'pac'           => 'required|integer',
            'previsao'      => 'required|date_format:d/m/Y',
            'metas'         => 'nullable|string',
            'descricao'     => 'required|string',
            'justificativa' => 'required|string',
            'requisitante'  => 'required|exists:requisitantes,uuid',
        ]);

		$requisicao = Requisicao::create([
            'numero'        => Requisicao::where('ano', date('Y'))->max('numero') + 1,// Retona o número da ultima requisção e acarescenta mais um
            'ano'           => date('Y'),
            'tipo'          => $request['tipo'],
            'prioridade'    => $request['prioridade'],
            'renovacao'     => $request['renovacao'],
            'capacitacao'   => $request['capacitacao'],
            'pac'           => $request['pac'],
            'metas'         => $request['metas'],
            'descricao'     => $request['descricao'],
            'justificativa' => $request['justificativa']
        ]);
        $requisicao->data = $request->previsao; // formata o campo previsão em formato de data
        $requisicao->requisitante()->associate(Requisitante::findByUuid($request->requisitante)); // representa o  requisitante
        $requisicao->save();
        return redirect()->route('requisicaoExibir', [ $requisicao->uuid]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Requisicao $requisicao)
    {
        $requisitante = array();
        foreach (Requisitante::all() as $value)
            $requisitante += [$value->uuid => $value->nome];
        return view('requisicao.show', compact('requisitante', 'requisicao'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $requisitante = array();
        foreach (Requisitante::all() as $value)
            $requisitante += [$value->uuid => $value->nome];
        return view('requisicao.edit', compact('requisitante'))->with('requisicao', Requisicao::findByUuid($uuid));
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
            'tipo'          => 'required|integer',
            'prioridade'    => 'required|integer',
            'renovacao'     => 'required|integer',
            'capacitacao'   => 'required|integer',
            'pac'           => 'required|integer',
            'previsao'      => 'nullable|date_format:d/m/Y',
            'metas'         => 'nullable|string',
            'descricao'     => 'required|string',
            'justificativa' => 'required|string',
            'requisitante'  => 'required|exists:requisitantes,uuid',
            'requisicao'    => 'required|exists:requisicoes,uuid'
        ]);

        $requisicao = Requisicao::findByUuid($request->requisicao);
        $requisicao->descricao      = $request->descricao;
        $requisicao->justificativa  = $request->justificativa;
        $requisicao->prioridade     = $request->prioridade;
        $requisicao->tipo           = $request->tipo;
        $requisicao->renovacao      = $request->renovacao;
        $requisicao->capacitacao    = $request->capacitacao;
        $requisicao->pac            = $request->pac;
        $requisicao->data           = $request->previsao;
        $requisicao->metas          = $request->metas;
        $requisicao->requisitante()->dissociate(); // remove todas as relações
        $requisicao->requisitante()->associate(Requisitante::findByUuid($request->requisitante)); // refaz as relaçoes
        $requisicao->save();
        return redirect()->route('requisicao');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisicao $requisicao)
    {
        $requisicao->delete();
        return redirect()->route('requisicao');
    }

    public function removeItens(Request $request)
    {
        $itens = $request->itens;
        foreach ($itens as  $uuid) {
            $item = Item::findByUuid($uuid);
            if ($request->requisicao == $item->requisicao->uuid) { // verifica se o item pertence a requisição
                if (!$item->licitacao) { // verifica se o item não está relacionado a uma licitação
                    $item->delete();
                }
            }
        }
        return redirect()->route('requisicao');
    }
	
	public function ajax(Request $request)
	{
		$ano = substr($request->numeroAno, -4);	
		$numero = substr($request->numeroAno, 0, -4);
        return response()->json(['requisicao' => Requisicao::where([['ano', '=', $ano], ['numero', '=', $numero ]])->first()]);
    }
	
	public function ataShow($id)
	{
		$requisicao = Requisicao::find($id);
		$itens = $requisicao->itens()->has('fornecedores')->get();
		$forncedores = collect();
		$opcoes = array();
		foreach($itens as $item)
			$forncedores = $item->fornecedores()->get()->merge($forncedores);
	
		//$forncedores = $forncedores->unique('cpf_cnpj');
		foreach ($forncedores as $fornecedor)
            $opcoes += [$fornecedor->id => $fornecedor->razao_social];
		
		return view('requisicao.geradorAta', compact('requisicao', 'opcoes'));
    }	
	
	public function ataCreate(Request $request)
	{
		$requisicao = Requisicao::find($request->requisicao);
		$fornecedor = Fornecedor::find($request->fornecedor);
		$itens = $fornecedor->itens()->where('requisicao_id', $request->requisicao)->get();
        $participante = Item::has('uasgs')->where('requisicao_id', $request->requisicao)->get(); // retona todos os participantes
		$dados = [
			'processo' 	=> $request->processo,
			'pregao' 	=> $request->pregao,
			'numero' 	=> $request->numero,
			'data'		=> $request->data,
			'objeto' 	=> $request->objeto,
			'publicacao'=> $request->publicacao
		];
		
		$total = 0;
		foreach($itens as $item){
			$quantidade = $item->fornecedores()->where('fornecedor_id', $fornecedor->id)->first()->pivot->quantidade;
			$valor = $item->fornecedores()->where('fornecedor_id', $fornecedor->id)->first()->pivot->valor;
			$total +=  floatval($valor) * intval($quantidade);

		}
		return view('documentos.ata', compact('fornecedor', 'itens', 'dados', 'total'))->with('participante', count($participante));
    }

    public function consultar($acao)
    {
        return view('requisicao.consultar', compact('acao'));
    }

    public function documento(Requisicao $requisicao)
    {
       return  view('requisicao.relacao', compact('requisicao'));

      // return  view('documentos.requisicao')->with('requisicao', Requisicao::findByUuid($uuid));
    }

    public function pesquisa(Requisicao $requisicao)
    {
       return  view('documentos.pesquisa', compact('requisicao'));
    }

    public function pesquisaPdf(Requisicao $requisicao)
    {
        view()->share('requisicao', $requisicao);
        $pdf = PDF::loadView('pdf.pesquisa', compact('requisicao'));
        $pdf->setPaper('A4');
        return $pdf->download('Requisicao_'.$requisicao->ordem.'.pdf');
    }

    public function formalizacao(Requisicao $requisicao)
    {
       return  view('documentos.formalizacao', compact('requisicao'));
    }

    public function formalizacaoPdf(Requisicao $requisicao)
    {
        view()->share('requisicao', $requisicao);
        $pdf = PDF::loadView('pdf.formalizacao', compact('requisicao'));
        $pdf->setPaper('A4', 'landscape' );
        return $pdf->download('Oficializacao_de_demanda_'.$requisicao->ordem.'.pdf');
    }

    public function duplicarItem(Request $request)
    {
        $itens = $request->itens;
        $requisicao = Requisicao::findByUuid($request->requisicao);
        foreach ($itens as  $uuid) {
            $item = Item::findByUuid($uuid);
            if ($request->requisicao == $item->requisicao->uuid) { // verifica se o item pertence a requisição
               $requisicao->itens()->create([
                    'numero'        => $requisicao->itens()->max('numero')+1, // este número indicara itens mesclados nas  licitcaoes, eles não pertencem a nenhuma requisicão
                    'quantidade'    => $item->quantidade,
                    'codigo'        => $item->codigo,
                    'objeto'        => $item->objeto,
                    'descricao'     => $item->descricao,
                    'unidade_id'    => $item->unidade_id,
                ]);
            }
        }
        return redirect()->action('RequisicaoController@show', [$requisicao]);
    }
}
