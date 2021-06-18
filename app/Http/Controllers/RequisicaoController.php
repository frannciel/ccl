<?php

namespace App\Http\Controllers;

use PDF;
use Session;
use App\Item;
use App\Fornecedor;
use App\Requisicao;
use App\Requisitante;
use Illuminate\Http\Request;
use App\Services\RequisicaoService;
use App\Http\Requests\RequisicaoRequest;


class RequisicaoController extends Controller
{
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RequisicaoService $service)
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
        $requisicoes = Requisicao::orderBy('updated_at', 'desc')->paginate(20);
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']); 
        return view('requisicao.index', compact( 'requisicoes', 'comunica'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $requisitantes = array();
        foreach (Requisitante::orderBy('nome', 'asc')->get() as $value)
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
            'justificativa' => 'nullable|string',
            'requisitante'  => 'required|exists:requisitantes,uuid',
        ]);

        $return = $this->service->store($request->all());
        if ($return['status']){
            return redirect()->route('requisicaoShow', $return['data']->uuid)
                ->with(['codigo' => 200,'mensagem' => 'Requisicão cadsatrada com sucesso!']);
        } else {
            return redirect()->route('requisicao')
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error ao cadastrar a requisição, tente novamente ou contate o administrador']); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Requisicao  $requisicao
     * @return \Illuminate\Http\Response
     */
    public function show(Requisicao $requisicao)
    {
        $requisitante = array();
        foreach (Requisitante::all() as $value)
            $requisitante += [$value->uuid => $value->nome];
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']);
        return view('requisicao.show', compact('requisitante', 'requisicao', 'comunica'));                          
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid){}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requisicao  $requisicao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requisicao $requisicao)
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
            'justificativa' => 'nullable|string',
            'requisitante'  => 'required|exists:requisitantes,uuid',
        ]);

        $return = $this->service->update($request->all(), $requisicao);
        if ($return['status']){
            return redirect()->route('requisicaoShow', $return['data']->uuid)
                ->with(['codigo' => 200,'mensagem' => 'Requisicão alterada com sucesso!']);
        } else {
            return redirect()->route('requisicaoShow', $requisicao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error ao editar a requisição, tente novamente ou contate o administrador']); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Requisicao  $requisicao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisicao $requisicao)
    {
        $return = $this->service->destroy($requisicao);
        if ($return['status']){
            return redirect()->route('requisicao')
                ->with(['codigo' => 200,'mensagem' => 'Requisição '.$requisicao->ordem.' excluída com sucesso.']);
        } else {
            return redirect()->route('requisicao', $requisicao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error ao excluir requisição, tente novamente ou contate o administrador']); 
        }
    }
	
    /**
     * retorna uma requsisição baseada na pesquisa por número/ano para uma requisição assíncrona
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Json
     */
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
    }

    public function pesquisa(Requisicao $requisicao)
    {
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']);
       return  view('documentos.pesquisa', compact('requisicao', 'comunica'));
    }

    public function pesquisaPdf(Requisicao $requisicao)
    {
        $return = $this->service->pesquisaPrecosPDF($requisicao);
        if ($return['status']){
            return $return['data'];
        } else {
            return back()
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error ao baixar o arquivo, tente novamente ou contate o administrador']); 
        }
    }

    public function formalizacao(Requisicao $requisicao)
    {
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']);
       return  view('documentos.formalizacao', compact('requisicao', 'comunica'));
    }

    public function formalizacaoPdf(Requisicao $requisicao)
    {
        $return = $this->service->formalizacaoDemandaPDF($requisicao);
        if ($return['status']){
            return $return['data'];
        } else {
            return back()
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error ao baixar o arquivo, tente novamente ou contate o administrador']); 
        }
    }

    public function duplicarItem(Request $request)
    {
        $this->validate($request, [
            "itens" => 'required|array|min:1',
            'itens.*' => 'string|exists:itens,uuid',
            'requisicao'  => 'required|exists:requisicoes,uuid'
        ]);

        $return = $this->service->duplicarItens($request->all());
        if ($return['status']){
            return redirect()->route('requisicaoShow', $request->requisicao)
                ->with(['codigo' => 200,'mensagem' => 'Item(ns) duplicado com sucesso !']);
        } else {
            return redirect()->route('requisicaoShow', $request->requisicao)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error ao duplicar item(ns), tente novamente ou contate o administrador']); 
        }
    }

    public function removeItens(Request $request)
    {
        $this->validate($request, [
            "itens" => 'required|array|min:1',
            'itens.*' => 'string|exists:itens,uuid',
            'requisicao'  => 'required|exists:requisicoes,uuid'
        ]);

        $return = $this->service->deleteItens($request->all());
        if ($return['status']){
            return redirect()->route('requisicaoShow', $request->requisicao)
                ->with(['codigo' => 200,'mensagem' => 'Item(ns) removidos com sucesso !']);
        } else {
            return redirect()->route('requisicaoShow', $request->requisicao)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error ao remover item(ns), tente novamente ou contate o administrador']); 
        }
    }

    public function importar(Requisicao $requisicao)
    {
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']); 
        return view('requisicao.import',  compact('requisicao', 'comunica'));
    }
}