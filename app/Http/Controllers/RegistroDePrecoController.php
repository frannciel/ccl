<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Licitacao;
use App\Fornecedor;
use App\RegistroDePreco;

class RegistroDePrecoController extends Controller
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
     *  @param String $uuid <Licitacao>
     * @return \Illuminate\Http\Response
     */
    public function create($uuid)
    {
        $licitacao = Licitacao::findByUuid($uuid);
        $itens = $licitacao->itens()->has('fornecedores')->get();
        $forncedores = collect();
        $empresas = array();
        $ata_numero;
        $ata_ano;

        $ata = RegistroDePreco::where('licitacao_id', $licitacao->id)->orderBy('numero', 'desc')->first();
       
        if ($ata === null) {
            $ata_numero = '001';
            $ata_ano = date("Y");;
        } else {
            $ata_numero = $ata->numero + 1;
            $ata_ano = $ata->ano;
        }
       
        foreach($itens as $item)
            $forncedores = $item->fornecedores()->get()->merge($forncedores);
    
        //$forncedores = $forncedores->unique('cpf_cnpj');

        foreach ($forncedores as $fornecedor)
            $empresas += [$fornecedor->uuid => $fornecedor->nome];
        return view('requisicao.geradorAta', compact('licitacao', 'empresas', 'ata_numero', 'ata_ano'));
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
            'numero'        => 'required|string',
            'ano'           => 'required|integer',
            'assinatura'    => 'required|date_format:d/m/Y',
            'inicio'        => 'required|date_format:d/m/Y',
            'fim'           => 'required|date_format:d/m/Y',
            'publicacao'    => 'required|date_format:d/m/Y',
            'fornecedor'    => 'required|exists:fornecedores,uuid',
            'licitacao'     => 'required|exists:licitacoes,uuid'
        ]);
       
        $licitacao = Licitacao::findByUuid($request->licitacao);
        $licitacao->publicacao = $request->publicacao;
        $licitacao->save();
        $fornecedor = Fornecedor::findByUuid($request->fornecedor);

        $ata = RegistroDePreco::create([
            'numero'            => $request->numero,
            'ano'               => $request->ano,
            'assinatura'        => $request->assinatura,
            'vigencia_inicio'   => $request->inicio,
            'vigencia_fim'      => $request->fim,
            'licitacao_id'      => $licitacao->id,
            'fornecedor_id'     => $fornecedor->id
        ]);

        $itens = $fornecedor->itens()->where('licitacao_id', $licitacao->id)->get();
        foreach ($itens  as $item)
            $ata->itens()->attach($item);
        //return redirect()->action('PregaoController@show', [ $licitacao->licitacaoable->uuid]);
        return redirect()->action('RegistroDePrecoController@documentoCreate', [$ata->uuid]);

    }

    protected function date($data){
        return date_format(date_create(str_replace("/", "-", $data)), 'Y-m-d');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function documentoCreate($uuid)
    {
        $ata = RegistroDePreco::findByUuid($uuid);

        //$requisicao = Requisicao::find($request->requisicao);
        //$fornecedor = Fornecedor::find($request->fornecedor);
        //$itens = $fornecedor->itens()->where('requisicao_id', $request->requisicao)->get();
        //$participante = Item::has('uasgs')->where('requisicao_id', $request->requisicao)->get(); // retona todos os participantes
   /*     $dados = [
            'processo'  => $request->processo,
            'pregao'    => $request->pregao,
            'numero'    => $request->numero,
            'data'      => $request->data,
            'objeto'    => $request->objeto,
            'publicacao'=> $request->publicacao
        ];*/
        $itens = $ata->itens()->get();
        $total = 0;
        foreach($itens as $item){
            $quantidade = $item->fornecedores()->where('fornecedor_id', $ata->fornecedor->id)->first()->pivot->quantidade;
            $valor      = $item->fornecedores()->where('fornecedor_id', $ata->fornecedor->id)->first()->pivot->valor;
            $total +=  floatval($valor) * intval($quantidade);
        }
        $participantes = $ata->itens()->has('participantes')->count();
        return view('documentos.ata', compact('ata', 'total', 'participantes'));
        //return view('documentos.ata', compact('fornecedor', 'itens', 'dados', 'total'))->with('participante', count($participante));
    }
}
