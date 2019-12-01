<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FornecedorRequest;
use App\Fornecedor;
use App\Cidade;
use App\Estado;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	
		return view('fornecedor.show')->with('fornecedores', Fornecedor::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = array();
        foreach (Estado::orderBy('nome', 'asc')->get() as $value)
            $estados += [$value->id => $value->nome];
		return view('fornecedor.create', compact('estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FornecedorRequest $request)
    {
        $cidade = Cidade::firstOrCreate(['nome' => $request->cidade, 'estado_id'=> $request->estado]); 
        $fornecedor = Fornecedor::create([
            'cpf_cnpj' 	    => $request->cpf_cnpj,
            'razao_social' 	=> $request->razao_social,
            'telefone' 		=> $request->telefone,
           	'email' 		=> $request->email,
            'representante' => $request->representante,
            'endereco' 		=> $request->endereco,
            'cep'           => $request->cep,
            'cidade_id'     => $cidade->id
        ]);
        //$fornecedor->cidade()->save($cidade);
        return redirect()->route('fornecedorEditar', [ $fornecedor->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $fornecedor = Fornecedor::find($uuid);
        return response()->json(['fornecedor' => $fornecedor]);
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
        foreach (Estado::orderBy('nome', 'asc')->get() as $value)
            $estados += [$value->id => $value->nome];
        return view('fornecedor.edit', compact('estados'))->with('fornecedor', Fornecedor::findByUuid($uuid));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(FornecedorRequest $request)
    {
		$cidade = Cidade::firstOrCreate(['nome' => $request->cidade, 'estado_id'=> $request->estado]); 
        $fornecedor = Fornecedor::find($request->fornecedor);
        $fornecedor->cpf_cnpj 		= $request->cpf_cnpj;
        $fornecedor->razao_social 	= $request->razao_social;
        $fornecedor->telefone 		= $request->telefone;
        $fornecedor->email 			= $request->email;
        $fornecedor->representante 	= $request->representante;
        $fornecedor->endereco 		= $request->endereco;
		$fornecedor->cep            = $request->cep;
        $fornecedor->cidade_id      = $cidade->id;
        $fornecedor->save();
         
		return redirect()->route('fornecedorEditar', [ $fornecedor->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Fornecedor::destroy($id);
    }
	
	    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request)
    {
        return response()->json(['fornecedor' => Fornecedor::where('cpf_cnpj', '=', $request->cpf_cnpj)->first()]);
    }
}
