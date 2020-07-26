<?php

namespace App\Http\Controllers;
use PDF;
use App\Item;
use App\Contratacao;
use App\Licitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratacaoController extends Controller
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
     * @param  \App\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function create(Licitacao $licitacao)
    {
        $itens = $licitacao->itens()->has('registrosDePrecos')->orderBy('ordem', 'asc')->get();
        $contratacoes = $licitacao->contratacoes()->get();
       /*
       foreach ($contratacoes as $contratacao) {
            $licitacao->contratacoes()->itens()->where('item_id', $item_id)->sum('quantidade');
       }
        $email = DB::table('contratacao_item')->where('item_id', $item_id)->value('email');*/
        $dados = collect();
        foreach ($itens as $item) {
        $empenhado = DB::table('contratacao_item')->where('item_id', $item->id)->sum('quantidade');
        $quatidade = $item->quantidade;
        $valor = $item->fornecedores()->first()->pivot->valor;
           /*
           verificar quantidade do campus eunápolis menos dos participantes
           */
           if ($item->quantidade > 0) {
                $dados->push([
                    'item' => $item, 
                    'empenhado' => $empenhado,
                    'valor' => number_format($valor, 2, ',', '.'),
                    'saldo' => $quatidade - $empenhado
                ]);
            }
           // dd( $contratacoes->first()->total);
            //$empenhado = Contratacao::where('item_id', $item->id)->sum('quantidade');
            //$empenhado = $licitacao->contratacoes()->itens()->where('item_id', $item_id)->sum('quantidade');
        }
        //dd( $dados);
        //$requisicao->itens->sortBy('numero')
        return  view('contratacao.create', compact('dados', 'licitacao', 'contratacoes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $licitacao = Licitacao::findByUuid($request->licitacao);

        $conteudo = collect();
        foreach ($request->itens as $key => $item) {
            $item = Item::findByUuid($item);
            $conteudo->push([
                'itemId' =>  $item->id, 
                'fornecedorId' => $item->fornecedores->first()->id,
                'valor' =>  $item->fornecedores->first()->pivot->valor,
                'quantidade' =>  $request->quantidades[$key],
            ]);
        }
        $agrupados = $conteudo->groupBy('fornecedorId');

        foreach ($agrupados->toArray() as $key => $grupo) {
            $contratacao = $licitacao->contratacoes()->create([
                'observacao'    => nl2br($request->observacao),
                'contrato'      => $request->contrato,
                'fornecedor_id' => $key,
            ]);

            foreach ($grupo as $elemento) {
                $contratacao->itens()->attach($elemento['itemId'],
                   [ 
                        'quantidade' => $elemento['quantidade'],
                        'valor' => $elemento['valor']
                ]);
            }
  
        }
        return redirect()->action('ContratacaoController@create', $licitacao);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function show(Contratacao $contratacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Contratacao $contratacao)
    {
        //
    }

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
            'contrato' => 'nullable|string|max:8'
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
        return redirect()->action('ContratacaoController@create', $contratacao->licitacao);
    }
    /**
     * Retorna um docuemnto de solicitação de empenho específico em formato copiável
     *
     * @param  \App\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function documento(Contratacao $contratacao)
    {   
        return view('documentos.contratacao', compact('contratacao'));
    }

    public function downloadPdf(Contratacao $contratacao)
    {   
        view()->share('contratacao', $contratacao);
        $pdf = PDF::loadView('pdf.contratacao', compact('contratacao'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download($contratacao->fornecedor->nome.'.pdf');
    }
}
