<?php

namespace App\Http\Controllers;

use App\Pregao;
use App\Item;
use App\Participante;
use App\Informacao;
use App\Unidade;
use Illuminate\Http\Request;

//https://github.com/YourAppRocks/eloquent-uuid
class PregaoController extends Controller
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
    public function create()
    {
        $tipos = array();
        $formas = array();
        foreach (Informacao::where('classe', 1)->get() as $value)
            $formas +=  [$value->id => $value->dado];
        foreach (Informacao::where('dado', 'Menor Preço')->get() as $value)
            $tipos +=  [$value->id => $value->dado];
        return view('licitacao.pregao.create', compact('formas', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pregao = Pregao::create([
            'srp'              => $request['srp'],
            'tipo'          => $request['tipo'],
            'forma'         => $request['forma'],
        ]);
        $pregao->licitacao()->create([
            'numero'        => $request['numero'],
            'ano'           => $request['ano'],
            'processo'      => $request['processo'],
            'objeto'        => nl2br($request['objeto']),
        ]);
        return redirect()->route('pregaoNovo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $tipos = array();
        $formas = array();
        $licitacao = Pregao::findByUuid($uuid)->licitacao;
        foreach (Informacao::where('classe', 1)->get() as $value)
            $formas +=  [$value->id => $value->dado];
        foreach (Informacao::where('dado', 'Menor Preço')->get() as $value)
            $tipos +=  [$value->id => $value->dado];
        return view('licitacao.pregao.show', compact('formas', 'tipos', 'licitacao'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function itemEdit($uuid){
        $item = Item::findByUuid($uuid);
        $licitacao = $item->licitacao()->first();
        $fornecedores = $item->fornecedores()->get();

        $participantes = array();
        $uasgs = Participante::with(['cidade','uasg'])->where('item_id', $item->id)->get();
        foreach ($uasgs as  $uasg) {
            $participante += [
            'quantidade' => $uasg->quantidade,
            'cidade' => $uasg->cidade->nome,
            'estado' => $uasg->cidade->estado,
            'nome' => $uasg->uasg->nome,
            'nome' => $uasg->uasg->codigo ];
        }

        $unidades = array();
        foreach (Unidade::all() as $value)
            $unidades += [$value->id => $value->nome];
        return view('licitacao.pregao.itemEdit',  compact('item', 'licitacao', 'fornecedores', 'participantes', 'unidades'));
    }
}
