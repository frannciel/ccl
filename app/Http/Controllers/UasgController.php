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
     *
    public function create($id)
    {
        $estados = array();
        foreach (Estado::orderBy('nome', 'asc')->get() as $value)
            $estados += [$value->id => $value->nome];
        return view('participante', compact('estados'))->with('item', Item::find($id));
    }*/

    public function create()
    {
        $estados = array();
        foreach (Estado::orderBy('nome', 'asc')->get() as $estado)
            $estados += [$estado->sigla => $estado->nome];
        return view('uasg.create', compact('estados'));
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
            'nome'      => 'required|string',
            'codigo'    => 'required|integer|unique:uasgs,codigo',
            'telefone'  => 'nullable|string',
            'email'     => 'nullable|email',
            'cidade'    => 'nullable|string',
            'estado'    => 'nullable|string|max:2'
        ]);

        $cidade = Cidade::firstOrCreate(['nome' => $request->cidade, 'estado_id'=> Estado::where('sigla', $request->estado)->first()->id]); 

        $uasg = Uasg::create([
            'nome'       => $request['nome'],
            'codigo'     => $request['codigo'],
            'telefone'   => $request['telefone'],
            'email'      => $request['email'],
            'cidade_id' => $cidade->id
        ]);
        return redirect()->route('uasg');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function participanteStore(Request $request)
    {
		//http://comprasnet.gov.br/livre/uasg/Estrutura.asp?coduasg=158145
		$uasg = Uasg::firstOrCreate(['codigo' => $request->codigo, 'nome' => $request->nome]); 
		$cidade = Cidade::firstOrCreate(['nome' => $request->cidade, 'estado_id'=> $request->estado]); 
		$item = Item::findByUuid($request->item);
		
		//https://coredump.pt/questions/32655167/building-ternary-relationship-using-laravel-eloquent-relationships
		//$item->cidades()->attach($cidade->id => ['participante_id' => $participante->id], ['quantidade' =>  $request->quantidade]);
        $uasg->cidades()->attach($cidade->id, ['item_id' => $item->id, 'quantidade' =>  $request->quantidade]);
        return redirect()->route('itemEditar', [ 'item' => $item->uuid]);
    }

    /**
     * { function_description }
     * 
     * @return \Illuminate\Http\Response
     */
    public function participanteCreate()
    {
        $estados = array();
        foreach (Estado::orderBy('nome', 'asc')->get() as $estado)
            $estados += [$estado->sigla => $estado->nome];
        return view('uasg.create', compact('estados'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $uasg = Uasg::findByUuid($id);
        return response()->json(['uasg' => $uasg]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $estados = array();
        $uasg = Uasg::findByUuid($uuid);
        foreach (Estado::orderBy('nome', 'asc')->get() as $estado)
            $estados += [$estado->sigla => $estado->nome];
		return view('uasg.edit', compact('estados', 'uasg'));
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

        $this->validate($request, [
            'uasg'      => 'required|exists:uasgs,uuid', // verifica se o objeto existe no banco
            'nome'      => 'required|string',
            'codigo'    => 'required|integer', // verifica se o código é único
            'telefone'  => 'nullable|string',
            'email'     => 'nullable|email',
            'cidade'    => 'nullable|string',
            'estado'    => 'nullable|string|max:2'
        ]);

        $uasg = Uasg::findByUuid($request->uasg);
        $uasg->nome 		= $request->nome;
        $uasg->codigo 		= $request->codigo;
        $uasg->telefone     = $request->telefone;
        $uasg->email        = $request->email;
        $uasg->cidade_id 	= Cidade::firstOrCreate(['nome' => $request->cidade, 'estado_id'=> Estado::where('sigla', $request->estado)->first()->id])->id;
        $uasg->save();
        return redirect()->route('uasg')->with('uasg', $uasg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        Uasg::destroy(Uasg::findByUuid($uuid)->id);
    }

}
