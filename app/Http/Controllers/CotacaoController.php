<?php

namespace App\Http\Controllers;

use PDF;
use App\Item;
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
        //$requisicao = Requisicao::findByUuid($uuid);
        $itens = $requisicao->itens()->orderBy('numero', 'asc')->get();
        $array = array();

        foreach ($itens as $item)
            $array += [$item->id => $item->numero];
        return view('pesquisa.create',  compact('itens', 'array', 'requisicao'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // valida os dados antes da salvar
        $this->validate($request, [
            'fonte'  => 'required|string|max:60',
            'valor'  => 'required|string',
            'data'   => 'required|date_format:d/m/Y',
            'hora'   => 'nullable|date_format:H:i',
            'item'   => 'required|integer'
        ]);
        $item = Item::find($request->item);
        $cotacao = $item->cotacoes()->create([
            'fonte' => $request['fonte'],
            'valor' => $request['valor'],
            'data'  => $request['data'].$request['hora'],
        ]);
        return redirect()->route('cotacaoNovo', ['requsicao' => $request->requisicao, 'cotacao' => $cotacao, 'item' => $item->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cotacao = Cotacao::find($id);
        return response()->json(['Cotacao' => $cotacao]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cotacao = Cotacao::find($id);
        $item = $cotacao->item;
        $requisicao =  $item->requisicao;
        return view('pesquisa.edit',  compact("cotacao", "item", "requisicao"));
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
        return view('pesquisa.edit', compact("cotacao", "item", "requisicao"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cotacao::destroy($id);
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
        return $pdf->download('Oficializacao_de_demanda_'.$requisicao->ordem.'.pdf');
    }
}
