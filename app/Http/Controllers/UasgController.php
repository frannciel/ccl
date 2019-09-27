<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Uasg;
use App\Item;
use App\Estado;
use App\Cidade;
use App\Participante;

class UasgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = 1;

        $uasg = Participante::with(['cidade','uasg'])->where('item_id', $id)->first();
        #$comissoes = Participante::with(['item','uasg'])->where('cidade_id', $id)->get();
        #$comissoes = Participante::with(['item','uasg'])->where('cidade_id', $id)->get();
        /*
        $dados = array();
        foreach ($uasgs as  $uasg) {
            $dados += ['quantidade' => $uasg->quantidade, 'cidade' => $uasg->cidade->nome, 'uasg' => $uasg->uasg->nome ];
        }*/
        #https://www.schoolofnet.com/forum/topico/many-to-many-entre-3-tabelas-5831
        return response()->json(['quantidade' => $uasg->quantidade, 'cidade' => $uasg->cidade->nome, 'uasg' => $uasg->uasg->nome ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $estados = array();
        foreach (Estado::orderBy('nome', 'asc')->get() as $value)
            $estados += [$value->id => $value->nome];
        return view('participante', compact('estados'))->with('item', Item::find($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		//http://comprasnet.gov.br/livre/uasg/Estrutura.asp?coduasg=158145
		$uasg = Uasg::firstOrCreate(['codigo' => $request->codigo, 'nome' => $request->nome]); 
		$cidade = Cidade::firstOrCreate(['nome' => $request->cidade, 'estado_id'=> $request->estado]); 
		$item = Item::find($request->item);
		
		//https://coredump.pt/questions/32655167/building-ternary-relationship-using-laravel-eloquent-relationships
		//$item->cidades()->attach($cidade->id => ['participante_id' => $participante->id], ['quantidade' =>  $request->quantidade]);
        $uasg->cidades()->attach($cidade->id, ['item_id' => $item->id, 'quantidade' =>  $request->quantidade]);
        //$participante->cidades()->attach($cidade->id, ['quantidade' =>  $request->quantidade]);
        //$item->participantes()->attach($participante->id);
	
        return redirect()->route('itemEditar', [ 'item' => $item]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $uasg = Uasg::find($id);
        return response()->json(['uasg' => $uasg]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		return view('participante.edit')->with('uasg', Uasg::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) // corrigir método
    {
        $uasg = Uasg::find($request->uasg);
        $uasg->nome 		= $request->nome;
        $uasg->codigo 		= $request->uasg;
        $uasg->cidade 		= $request->cidade;
        $uasg->estado 		= $request->estado;
        $uasg->save();
        return view('participante.edit')->with('uasg', $uasg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Uasg::destroy($id);
    }

}
