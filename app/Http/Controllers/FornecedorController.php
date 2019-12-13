<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FornecedorRequest;
use App\Fornecedor;
use App\PessoaJuridica;
use App\PessoaFisica;
use App\Cidade;
use App\Estado;
use GuzzleHttp\Client;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	
		return view('fornecedor.show')->with('fornecedores', Fornecedor::orderBy('created_at', 'desc')->get());
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
            $estados += [$value->sigla => $value->nome];
		return view('fornecedor.create', compact('estados'));
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
            'cpf_cnpj'      =>'required|string|between:11,18', // se 11 cpf ou 14 cnpj max 18 pois pode incluir pontos 
            'razaoSocial'   =>'required|string',
            'telefone1'     =>'required|string|between:10,15',
            'endereco'      =>'required|string',
            'cidade'        =>'required|string',
            'estado'        =>'required|numeric',
            'cep'           =>'string|nullable|max:9',
            'telefone2'     =>'string|nullable|between:10,15',
            'email'         =>'email|nullable',
            'representante' =>'string|nullable',
        ]);
        
        $cidade = Cidade::firstOrCreate(['nome' => $request->cidade, 'estado_id'=> $request->estado]); 

        $fornecedor ;
        if(strlen(preg_replace("/[^0-9]/", "", $request->cpf_cnpj)) == 11){
            $fornecedor = $this->storePessoaFisica($request);
        } elseif (strlen(preg_replace("/[^0-9]/", "", $request->cpf_cnpj)) == 14) {
            $fornecedor = $this->storePessoaJuridica($request);
        }
        $fornecedor->fornecedor()->create([
            'endereco'      => $request->endereco,
            'cep'           => $request->cep,
            'cidade_id'     => $cidade->id,
            'email'         => $request->email,
            'telefone_1'    => $request->telefone1,
            'telefone_2'    => $request->telefone2
        ]);
        return redirect()->route('fornecedor');
    }

    protected function storePessoaFisica($request)
    {   

        $fornecedor = PessoaFisica::create([
            'cpf'    => $request['cpf_cnpj'],
            'nome'   => $request['razaoSocial']
        ]);
        return $fornecedor;
    }

    protected function storePessoaJuridica($request)
    {
        $fornecedor = PessoaJuridica::create([
            'cnpj'          => $request['cpf_cnpj'],
            'razao_social'  => $request['razaoSocial'],
            'representante' => $request['representante']
        ]);
        return $fornecedor;
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
            $estados += [$value->sigla => $value->nome];
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
     * Método que retorno uma a razão social ou nome do fornecedor PJ ou PF e o UUId da entidade Fornecedor, usando como parâmetro de busca o cpf_cnpj
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFornecedor(Request $request)
    {
         $cpf_cnpj = preg_replace("/[^0-9]/", "", $request->cpf_cnpj);
         if (strlen($cpf_cnpj) === 11) {
            $fornecedor = PessoaFisica::where('cpf', '=', $request->cpf_cnpj)->first();
            if ($fornecedor) 
                return response()->json(['fornecedor' => $fornecedor->nome, 'uuid' => $fornecedor->fornecedor->uuid]); // retorna o uuid de Fornecedor
         } elseif (strlen($cpf_cnpj) === 14) {
            $fornecedor = PessoaJuridica::where('cnpj', '=', $request->cpf_cnpj)->first();
            if ($fornecedor)
                return response()->json(['fornecedor' => $fornecedor->razao_social, 'uuid' => $fornecedor->fornecedor->uuid]); // retorna o uuid de Fornecedor
         }
        return response()->json(['fornecedor' => true]);
    }
    
    /**
     * Metodo que retorna o endereço tendo como parâmetro de busca o CEP. 
     * Os dados serão consumidos da da API ViaCEP. 
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     \Illuminate\Http\Response
     */
    public function buscarCEP(Request $request)
    {
        // composer require guzzlehttp/guzzle
            $cep = preg_replace("/[^0-9]/", "", $request->cep);
            if (strlen($cep) === 8) {
                $client = new Client();
                $response = $client->request('GET', 'viacep.com.br/ws/'.$cep.'/json/');
                return response($response->getBody());
            } else{
                return response(true);
            }
        /*  echo $res->getStatusCode(); //   "200"
        echo $res->getHeader('content-type')[0]; // 'application/json; charset=utf8'
        echo $res->getBody(); // {"type":"User"...'
        */
    }   

}
