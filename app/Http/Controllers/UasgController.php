<?php

namespace App\Http\Controllers;

use Excel;
use Session;
use App\Uasg;
use App\Item;
use App\Estado;
use App\Cidade;
use App\Licitacao;
use App\Participante;
use Illuminate\Http\Request;
use App\Services\ConversorService as Conversor;

class UasgController extends Controller
{
    private $gerenciador = '158410';

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
     * importar
     *
     * @param  mixed $request
     * @param  mixed $licitacao
     * @return void
     */
    public function importar(Request $request, Licitacao $licitacao){
		// retorna um array de array com as linhas da tabela
        $itens = collect();
        $participantes = collect();
        $tabela = Excel::toArray([], request()->file('arquivo'));
        foreach ($tabela[0] as  $linha) {
            $uasg_nome = explode("-", $linha[5], 2);
            if($itens->contains('item', $linha[0])){ // se item já existe na lista incluir como participante
                $participantes->push($this->participante($linha));
            } else{ // senão existe um item precisa ser criado pois se trata do gerenciador
                $itens->push($this->item($linha, $licitacao));
                if($this->gerenciador != intval($uasg_nome[0]))
                    $participantes->push($this->participante($linha));
            }
        }
        foreach($itens as $item){
            if($item['subrogado']){
                foreach ($itens as $outro){
                    if($item['hash'] == $outro['hash'] && $item['item'] != $outro['item']){
                        $item->put('desmembrado', $outro['item']);
                    }
                }
            }
        }
        Session::put('itens', $itens);
        Session::put('participantes', $participantes);
        return view('site.uasg.importar', compact('participantes', 'itens', 'licitacao'));
    }

    private function participante($linha) {
        $uasg_nome = explode("-", $linha[5], 2);
        $cidade_uf = explode("/", $linha[6], 2);
        return collect([
            'item' => $linha[0],
            'uasg' => trim($uasg_nome[0]),
            'nome' => $uasg_nome[1],
            'cidade' => $cidade_uf[0],
            'estado' => strtoupper($cidade_uf[1]),
            'quantidade' => $linha[7],
        ]);
    }

    private function item($linha, $licitacao){
        $itens = collect([
            'item' => $linha[0],
            'objeto' => $linha[2],
            'unidade' => $linha[3],
            'preco' => $linha[4],
            'subrogado' => false,
            'hash' => hash('md5',$linha[2].$linha[3].$linha[4]),
            'desmembrado'=> ''
        ]);
        //$item = $licitacao->itens()->where('ordem', '=', $linha[0])->first(); 
        if (!$licitacao->itens()->where('ordem', '=', $linha[0])->exists()){ // significa que este item teve origem em um desmebramento de outro item
            $itens['subrogado'] = true; 
            $itens['quantidade'] = 0; 
        } else {
            $itens['quantidade'] = $linha[7]; 
        }
        return $itens;
    }

    public function importarStore(Request $request, Licitacao $licitacao){
        $participantes = Session::get('participantes');
        $itens = Session::get('itens');
        # Salva os itens desmembrados na base de dados #
        foreach($request->desmembrados as $key => $item){
            if($participantes->contains('item', $key)){
                $item = $licitacao->itens()->where('ordem', $item)->with('cotacoes')->first();
                $new_item = $item->replicate();
                $new_item->quantidade = 0;
                $new_item->codigo = 151514;
                $new_item->requisicao_id = null;
                $new_item->licitacao_id = $licitacao->id;
                $new_item->numero = 10000;
                $new_item->ordem = $key;
                $new_item->push();
    
                foreach ($item->getRelation('cotacoes') as $cotacao) {
                    $new_cotacao = $cotacao->replicate();
                    $new_cotacao->item_id = $new_user->id;
                    $new_cotacao->push();
                }
            }
        }
        # salva no base de dados os participantes #
        foreach($request->participantes as $key){
            $participante = $participantes[$key];
            $item_id = $licitacao->itens()->where('ordem', $participante['item'])->first()->id;
            $uasg = Uasg::firstOrCreate(['codigo' => $participante['uasg']], ['nome' => $participante['nome']]); 
            $cidade = Cidade::firstOrCreate(['nome' => $participante['cidade']], ['estado_id' => Estado::where('sigla', $participante['estado'])->first()->id]); 
            $uasg->cidades()->attach($cidade->id, ['item_id' =>  $item_id, 'quantidade' => $participante['quantidade']]);
        }
        Session::forget('participantes');
        Session::forget('itens');
        return redirect()->route('licitacao.show',  $licitacao->uuid);
        /*
        $array_itens = new array();
        $array_cotacoes = new array();
        foreach($request->desmebrados as $key => $item){
            $item = $licitacao->where('ordem', $item)->first();

            $licitacao->itens()->create([
                'numero'        => 10000, // este número indicara itens mesclados nas  licitcaoes, eles não pertencem a nenhuma requisicão
                'quantidade'    => 0, // quantidade do gerenciador em itens desdobrado
                'codigo'        => $principal->codigo,
                'objeto'        => $item->objeto,
                'descricao'     => $item->descricao,//nl2br(
                'unidade_id'    => $item->unidade_id,
                'ordem'         => $key//$licitacao->itens()->max('ordem')+1
            ]);

            foreach($item->cotacoes()->toArray() as $cotacao){
                array_push($cotacoes, $cotacao);
            }
           
        }
        $licitacao->itens()->createMany([[], []]);
		return redirect()->route('licitacaoShow',  $requisicao->uuid);
        */
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

    public function createDois()
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
