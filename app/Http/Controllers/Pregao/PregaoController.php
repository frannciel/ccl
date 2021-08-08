<?php

namespace App\Http\Controllers\Pregao;

use App\Item;
use App\Pregao;
use App\Unidade;
use App\Licitacao;
use App\Fornecedor;
use App\Informacao;
use App\Participante;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

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
        return view('site.licitacao.compras.pregao.create', compact('formas', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $numero; $ano;
        if (empty($request->ordem)) {
            $numero = Licitacao::where('licitacaoable_type', '=', 'Pregão Eletrônico')
                ->where('ano', '=', date('Y'))->max('numero') +1;
            $ano = date('Y');
        } else{
            $ordem = explode("/", $request->ordem);
            $numero = $ordem[0];
            $ano = $ordem[1];
        }
        $pregao = Pregao::create([
            'srp'           => $request->srp,
            'tipo'          => $request->tipo,
            'forma'         => $request->forma,
        ]);
        $pregao->licitacao()->create([
            'numero'        => $numero,
            'ano'           => $ano,
            'processo'      => $request->processo,
            'objeto'        => nl2br($request->objeto),
        ]);
        return redirect()->route('pregao.show', $pregao->uuid);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Licitacao $licitacao)
    {
        $tipos = array();
        $formas = array();

        $itens = $licitacao->itens()->has('fornecedores')->with('fornecedores')->get();
        $lista = collect();
        foreach ($itens as  $item) {
            foreach ($item->fornecedores as  $fornecedor) {
                $lista->push([$fornecedor->uuid, $fornecedor->cpfCnpj, $fornecedor->nome]);
            }
        }
        $lista = $lista->unique()->sortBy('razao_social');

        $itens = $licitacao->itens()->has('participantes')->get();
        $uasgs = collect();
        foreach ($itens as $item) {
            foreach ($item->participantes as $participante){
                    $uasgs->push(['codigo' => $participante->codigo, 'nome' => $participante->nome]);
            }
        }
        $uasgs = $uasgs->unique()->sortBy('nome');

        foreach (Informacao::where('classe', 1)->get() as $value)
            $formas +=  [$value->id => $value->dado];
        foreach (Informacao::where('dado', 'Menor Preço')->get() as $value)
            $tipos +=  [$value->id => $value->dado];
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']);    
        return view('site.licitacao.compras.pregao.show', compact('formas', 'tipos', 'licitacao', 'lista', 'uasgs', 'comunica'));
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
        $licitacao = $item->licitacao;
        $fornecedores = $item->fornecedores()->get();
        $uasgs = $item->participantes;

        /*$participantes = array();

        //$participantes = $item->participantes;
        $uasgs = Participante::with(['cidade','uasg'])->where('item_id', $item->id)->get();
        foreach ($uasgs as  $uasg) {
            $participante += [
                'quantidade' => $uasg->quantidade,
                'cidade' => $uasg->cidade->nome,
                'estado' => $uasg->cidade->estado,
                'nome' => $uasg->uasg->nome,
                'codigo' => $uasg->uasg->codigo 
            ];
        }
*/
        $unidades = array();
        foreach (Unidade::all() as $value)
            $unidades += [$value->id => $value->nome];
        return view('site.licitacao.compras.pregao.itemEdit',  compact('item', 'licitacao', 'fornecedores', 'uasgs', 'unidades'));
    }
}
