<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UnidadeRequest;
use App\Unidade;

class UnidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('unidade.index')->with('unidade', Unidade::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('unidade.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnidadeRequest $request)
    {
        Unidade::create([
          'nome' => $request['nome'],
          'sigla' => $request['sigla'], 
        ]);
  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unidade = Unidade::find($id);
        return response()->json(['unidade' => $unidade]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('unidade.edit')->with('unidade', Unidade::find($id);
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
        $unidade = Unidade::find($id);
        $unidade->nome 	= $request::input('nome');
        $unidade->sigla = $request::input('sigla');
        $unidade->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Unidade::destroy($id);

   }
}
