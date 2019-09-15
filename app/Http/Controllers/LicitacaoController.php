<?php

namespace App\Http\Controllers;
use App\Informacao;
use App\Licitacao;
use Illuminate\Http\Request;

class LicitacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //https://github.com/YourAppRocks/eloquent-uuid
        $licitacoes = Licitacao::all();
        return view('licitacao.index', compact('licitacoes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modalidades = array();
        foreach (Informacao::where('classe', 3)->get() as $value)
            $modalidades +=  [$value->id => $value->dado];
        return view('licitacao.create', compact('modalidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->modalidade == 7) {
            return redirect()->action('PregaoController@store')->with($request);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Licitacao  $licitacao
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $licitacao = Licitacao::findByUuid($uuid);
        return $licitacao;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Licitacao  $licitacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Licitacao $licitacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Licitacao  $licitacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Licitacao $licitacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Licitacao  $licitacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Licitacao $licitacao)
    {
        //
    }


            /**
     * Get User by scope query.
     */
    public function modalidade(Request $request)
    {
        if ($request->opcao == 7) {
            $tipos = array();
            $formas = array();
            foreach (Informacao::where('classe', 1)->get() as $value)
                $formas +=  [$value->id => $value->dado];
            foreach (Informacao::where('classe', 2)->get() as $value)
                $tipos +=  [$value->id => $value->dado];
            return view('licitacao.ajax',  compact("tipos", "formas"))->with('etapa', 7);
        }
    }
}
