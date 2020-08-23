<?php

namespace App\Http\Controllers;

use PDF;
use App\Item;
use Session;
use App\Cotacao;
use App\Requisicao;
use Illuminate\Http\Request;
use App\Services\FileService;

class CotacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Requisicao $requisicao)
    {
        $itens = $requisicao->itens()->orderBy('numero', 'asc')->get();
        $array = array();
        foreach ($itens as $item)
            $array += [$item->uuid => $item->numero." - ".$item->objeto];
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']); 
        return view('cotacao.create',  compact('itens', 'array', 'requisicao', 'comunica'));
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
            'fonte'  => 'required|string|max:100',
            'valor'  => 'required|string',
            'data'   => 'required|date_format:d/m/Y',
            'hora'   => 'nullable|date_format:H:i',
            'item'   => 'required|string'
        ]);
        $item = Item::findByUuid($request->item);
        $cotacao = $item->cotacoes()->create([
            'fonte' => $request['fonte'],
            'valor' => $request['valor'],
            'data'  => $request['data'].$request['hora'],
        ]);
        return redirect()->route('cotacaoCreate', $request->requisicao)
            ->with(['codigo' => 200,'mensagem' => 'Cotacão de preços cadastrada com sucesso.']);
   }

    /**
     * Display the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show(Cotacao $cotacao)
    {
        return response()->json(['Cotacao' => $cotacao]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  String  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit(Cotacao $cotacao)
    {
        $item = $cotacao->item;
        $requisicao =  $item->requisicao;
        return view('cotacao.edit',  compact("cotacao", "item", "requisicao"));
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
            'fonte'  => 'required|string|max:60',
            'valor'  => 'required|string',
            'data'   => 'required|date_format:d/m/Y',
            'hora'   => 'required|date_format:H:i',
        ]);

        $cotacao = Cotacao::find($request->cotacao);
        $item = $cotacao->item;
        $requisicao =  $item->requisicao;
        $cotacao->fonte     = $request->fonte;
        $cotacao->valor     = $request->valor;
        $cotacao->data      = $request->data.$request->hora;
        $cotacao->save();
        return view('cotacao.edit', compact("cotacao", "item", "requisicao"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cotacao $cotacao)
    {
        $requisicao = $cotacao->item->requisicao->uuid;
        $cotacao->delete();
        return redirect()->route('cotacaoCreate', $requisicao)
            ->with(['codigo' => 200,'mensagem' => 'Cotação de preços excluída com sucesso.']);
    }

    public function relatorio(Requisicao $requisicao)
    {   
        return view('documentos.cotacao')->with('requisicao', $requisicao);
    }

    public function redirecionar(Request $request){
        return redirect()->route('cotacaoNovo', ['requsicao_id' => $request->requisicao]);
    }

    public function relatorioPdf(Requisicao $requisicao)
    {
        view()->share('requisicao', $requisicao);
        $pdf = PDF::loadView('pdf.cotacao', compact('requisicao'));
        $pdf->setPaper('A4');
        return $pdf->download('Pesquisa_preços__'.$requisicao->ordem.'.pdf');
    }
}
