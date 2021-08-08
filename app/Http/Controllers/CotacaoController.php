<?php

namespace App\Http\Controllers;

use PDF;
use Excel;
use Session;
use App\Item;
use App\Cotacao;
use App\Requisicao;
use Illuminate\Http\Request;
use App\Imports\CotacoesImport;
use App\Services\CotacaoService;
use Maatwebsite\Excel\HeadingRowImport;

class CotacaoController extends Controller
{
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CotacaoService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Requisicao $requisicao)
    {
        $itens = $requisicao->itens()->orderBy('numero', 'asc')->paginate(20);
        $array = array();
        foreach ($itens as $item)
            $array += [$item->uuid => $item->numero." - ".$item->objeto];
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']); 
        return view('site.cotacao.create',  compact('itens', 'array', 'requisicao', 'comunica'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'item'   => 'required|exists:itens,uuid',
            'fonte'  => 'required|string|max:100',
            'valor'  => 'required|string',
            'data'   => 'required|date_format:d/m/Y',
            'hora'   => 'nullable|date_format:H:i',
        ]);

        $return = $this->service->store($request);
        if ($return['status']){
            //return redirect()->route('cotacao.create', $requisicao->uuid)
                return back()->with(['codigo' => 200,'mensagem' => 'Cotacão de preços cadastrada com sucesso item  !']);
        } else {
            return redirect()->back()
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error durante a execução, tente novamente ou contate o administrador']); 
        }
   }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cotacao  $cotacao
     * @return \Illuminate\Http\Response
     */
    public function show(Cotacao $cotacao) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cotacao  $cotacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Cotacao $cotacao) {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cotacao  $cotacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cotacao $cotacao)
    {
        $return = $this->service->destroy($cotacao);
        $requisicao = $cotacao->item->requisicao->uuid;
        if ($return['status']){
            return redirect()->back()
                ->with(['codigo' => 200,'mensagem' => 'Cotação de preços excluída com sucesso!']);
        } else {
            return redirect()->back()
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error durante a execução, tente novamente ou contate o administrador']); 
        }
    }

    public function relatorio(Requisicao $requisicao)
    {   
        return view('site.cotacao.doc.relatorio')->with('requisicao', $requisicao);
    }

    public function redirecionar(Request $request){
        return redirect()->route('cotacao.create', ['requsicao_id' => $request->requisicao]);
    }

    public function relatorioPdf(Requisicao $requisicao)
    {
        view()->share('requisicao', $requisicao);
        $pdf = PDF::loadView('site.cotacao.pdf.relatorio', compact('requisicao'));
        $pdf->setPaper('A4');
        return $pdf->download('Pesquisa_preços__'.$requisicao->ordem.'.pdf');
    }

    /**
     * Importa cotação de preços a partir de planilhas do Excel
     * 
     * @param Request $request 
     * @param Requisicao $requisicao 
     * @return type
     */
    public function importarExcel(Request $request, Requisicao $requisicao)
    {
        $headings = (new HeadingRowImport)->toArray($request->file('arquivo'));
        $headings = $headings[0][0];
        if ($headings[0]=='item'&&$headings[1]=='fonte'&&$headings[2]=='valor'&&$headings[3]=='data'&&$headings[4]=='hora') {
            Excel::import(new CotacoesImport($requisicao), $request->file('arquivo'));
            return redirect()->route('requisicaoShow', $requisicao->uuid)
                ->with(['codigo' => 200,'mensagem' => 'Dados importados com sucesso!']);
        } else {
            return redirect()->route('requisicao.importar', $requisicao->uuid)
                ->with(['codigo' => 500,'mensagem' => 'Favor verificar a linha de cabeçalho da planilha e tente novamente']);
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
                ->with(['codigo' => 200,'mensagem' => 'Cotações de preços importadas com sucessos!']);
        } else {
            return redirect()->route('requisicao.show', $requisicao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error durante a execução, tente novamente ou contate o administrador']); 
        }
    }
}
