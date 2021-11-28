<?php

namespace App\Http\Controllers;

use PDF;
use Session;
use App\Item;
use App\Licitacao;
use App\Contratacao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ContratacaoService;


class ContratacaoController extends Controller
{

    protected $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ContratacaoService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {  }

    /**
     * Show the form for creating a new resource.
     * @param  \App\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function create(Licitacao $licitacao)
    {
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']); 

        $return = $this->service->create($licitacao);
        if ($return['status']){
            return  view('site.contratacao.create', compact('licitacao', 'comunica'))
                ->with(['dados' => $return['data']['dados'],'contratacoes'=> $return['data']['contratacoes']]);
        } else {
            return redirect()->back()->with($comunica); 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Licitacao $licitacao)
    {
        $return = $this->service->store($request, $licitacao);
        if ($return['status']){
            return  redirect()->route('contratacao.create', compact('licitacao'))
                ->with(['codigo' => 200,'mensagem' => 'Contratação(ões) registradas com sucesso!']);
        } else {
            return redirect()->back()
            ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error durante a execução, tente novamente ou contate o administrador']); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function show(Contratacao $contratacao){ }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Contratacao $contratacao) { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        /*Aprimorar validação do reposta e na view*/
        $validator = $request->validate([
            'observacao' => 'nullable|string',
            'contrato' =>   'nullable|string|max:8'
        ]);

        $contratacao = Contratacao::findByUuid($request->contratacao);
        $contratacao->contrato   = $request->contrato;
        $contratacao->observacao = $request->observacao;
        $contratacao->save();
        return response()->json(['ok' => 100]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contratacao $contratacao)
    {
        $contratacao->delete();
        return redirect()->route('contratacao.create', $contratacao->licitacao);
    }
    /**
     * Retorna um docuemnto de solicitação de empenho específico em formato copiável
     *
     * @param  \App\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function documento(Contratacao $contratacao)
    {   
        return view('site.contratacao.doc.contratacao', compact('contratacao'));
    }

    public function downloadPdf(Contratacao $contratacao)
    {   
        view()->share('contratacao', $contratacao);
        $pdf = PDF::loadView('site.contratacao.pdf.contratacao', compact('contratacao'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download($contratacao->fornecedor->nome.'.pdf');
    }
}
