<?php

namespace App\Http\Controllers;
use App\Informacao;
use App\Licitacao;
use App\Item;
use App\Requisicao;
use App\Participante;
use App\Http\Controllers\Redirect;
use Illuminate\Http\Request;
use App\Unidade;

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
      switch ($licitacao->licitacaoable_type) {
         case 'App\Pregao':
            return redirect()->action('PregaoController@show', [$licitacao->licitacaoable()->first()->uuid]);
         case 'App\Dispensa':
            return redirect()->action('PregaoController@itemEdit', [$uuid]);
      }
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

    public function itemEdit($uuid){

      $licitacao = Item::findByUuid($uuid)->licitacao()->first();
      switch ($licitacao->licitacaoable_type) {
         case 'App\Pregao':
            return redirect()->action('PregaoController@itemEdit', [$uuid]);
         case 'App\Dispensa':
            return redirect()->action('PregaoController@itemEdit', [$uuid]);
      }
    }

    public function atribuirRequisicao(Request $request){
        $lista = $request->itens;
        $requisicao = Requisicao::findByUuid($request->requisicao);
        $licitacao = Licitacao::findByUuid($request->licitacao);

        if ($requisicao != null) {
            $this->atribuirItem($requisicao->itens()->get(), $licitacao);
            $licitacao->requisicoes()->attach($requisicao);

        } else if($lista != null){
            $itens = collect(); // define uma coleção de itens
            foreach ($lista as $uuid) 
                $itens->push(Item::findByUuid($uuid)); // busca todos os objetos item a partir de seus respectivos uuid
            $this->atribuirItem($itens, $licitacao); // invoca o método para atribuir itens
            foreach ($itens as $item) { 
                if (!$licitacao()->contains($item->requisicao)) // verifica se a requisição já esta associada á licitação
                    $licitacao->requisicoes()->attach($item->requisicao); // associa a requisição á licitação casa esta relação ainda não exista
            }
        }
        return redirect()->action('PregaoController@show', [ $licitacao->licitacaoable->uuid]);
    }

    protected function atribuirItem($itens, $licitacao)
    {
        $max = $licitacao->itens()->max('ordem')+1;
        foreach ($itens as $item){
            $item->ordem = $max; // atualiza o campo ordem com próximo número de ordem da licitação
            $item->save();
            $licitacao->itens()->save($item); // associa item com a licitação
            $max += 1; // incrementa o número da ordem
        }
    }

    public function atribuir(Request $request)
    {
        $requisicao = Requisicao::findByUuid($request->requisicao);
        $licitacao  = Licitacao::findByUuid($request->licitacao);
        $licitacao->requisicoes()->attach($requisicao);
        
        $max = $licitacao->itens()->max('ordem')+1;
        foreach ($requisicao->itens()->get() as $item){
            $licitacao->itens()->save($item, ['ordem' => $max]);
            $max += 1;
        }
        $max = null;
        return redirect()->action('PregaoController@show', [ $licitacao->licitacaoable->uuid]);
    }

    /**
     * Método que recebe um ou mais itens e os mescla criando um novo item na licitação e desassocia os itens mescladdos
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function mesclarStore(Request $request)
    {

        $this->validate($request,  # validações dos caompus principal e itens 
            [
            'principal' => 'required',
            'itens' => 'required|min:2',
            ], [ 
            'principal.required' => 'Clique no item que terá as características mantidas!',
            'itens.min' => 'É necessários no mínimos dois itens de requisicoes diferentes para realizar a mescla.'
        ]);

        $itens  = $request->itens; // uuid dos itens a serem mesclados nesta licitacao
        $index = $request->principal; // indice do array itens para o item que doara as características para o item mesclado, não pode ser nulo
        
        # Verifica se o item principal foi enviado junto aos demais utens a serem mesclados
        if ($itens[$index] == null)
            return back()->withErrors(['principal' => ['O item que terá as características mantidas, deve ser um dos itens selecionados!']])->withInput();

        $principal = Item::findByUuid($itens[$index]); // retorna o objeto item, principal para a mescla
        $licitacao = $principal->licitacao()->first();
        $quantidade = 0; // soma as quantidade dos itens a serem mesclados
        $itens_id = array();  //relacao de ids dos itens mesclados para desassociação da licitação

        foreach ($itens as $value) { // calcula a quantidade
            if ( $value != null) {
                $item = Item::findByUuid($value);
                $quantidade += $item->quantidade;
                $itens_id[] = $item->id;
            }
        }
        $licitacao->itens()->detach($itens_id); // remove os registro dos itens mesclado da tabela 'item_licitacao'

        $mesclado = $licitacao->itens()->create([
            'numero'        => 10000, // este número indicara itens mesclados nas  licitcaoes, eles não pertencem a nenhuma requisicão
            'quantidade'    => $quantidade,
            'codigo'        => $principal->codigo,
            'objeto'        => $principal->objeto,
            'descricao'     => nl2br($principal->descricao),
            'unidade_id'    => $principal->unidade_id,
        ], ['ordem' => $licitacao->itens()->max('ordem')+1]);

        $array_attach = array(); // prepara o array para registro dos itens na tabela mesclado
        foreach ($itens_id as  $value)
            $array_attach += [$value => ['licitacao_id' => $licitacao->id]];
        $mesclado->itens()->attach($array_attach); // insere os registros do itens que foram mescados na tebela 'mesclado'

        return redirect()->action('LicitacaoController@mesclarCreate', [ $licitacao->uuid]);
        //return response()->json(['item' => $itens]);
    }

    public function mesclarCreate($uuid)
    {

        $objetos = array();
        $licitacao = Licitacao::findByUuid($uuid); // busca a licitacao pelo uuid
        $itens =  $licitacao->itens()->get();  // reorna todos os itens associado a esta licitação
        $requisicoes = $licitacao->requisicoes()->get(); // retorna todas as requisições associaddas a esta aquisicao
        $itens_array = array(); # array de arrays contendo itens com atributos uuid e numero concatenado com objetos item
        $mesclados = $licitacao->mesclados()->distinct()->get();
        # separa os itens por requisicao e insere no array de tens
        foreach ($requisicoes as  $requisicao) { 
            $lista = array();
            foreach ($itens as $item) {
                if ($item->requisicao_id == $requisicao->id) {
                    $concat = $item->numero.' - '.$item->objeto; // Conacate numero do item com objeto do item
                    $lista += [$item->uuid => substr_replace($concat, (strlen($concat) > 40 ? '...' : ''), 40)]; // adiciona mais concatenado na array de itens por requisicao
                }
            }
            if(sizeof($lista) > 0){
                $objetos[] = $requisicao->numero.'/'.$requisicao->ano.' - '.$requisicao->descricao; // concatena o item como objeto da requisicao
                $itens_array[] = $lista;  // insere mais um array na lista de arrays
            }
        }
/*


        foreach ($licitacao->requisicoes()->get() as $requisicao){
            $lista = array();
            foreach ($requisicao->itens()->where() as $item) {
                $concat = $item->numero.' - '.$item->objeto; // Conacate numero do item com objeto do item
                $lista += [$item->uuid => substr_replace($concat, (strlen($concat) > 30 ? '...' : ''), 30)]; // exibe apenas 40 caracteres da string concatenada
            }
            $objetos[] = $requisicao->numero.'/'.$requisicao->ano.' - '.$requisicao->descricao;
            $itens[] = $lista;
        }*/

        return view('licitacao.mesclarCreate', compact('itens_array', 'objetos', 'mesclados', 'licitacao'));
    }

    public function itemDuplicar(Request $request){

        $array_itens = $request->itens; // array contendo os uuid dos itens a serem duplicados
        $licitacao = Item::findByUuid($array_itens[0])->licitacao()->first();

       foreach ($array_itens as  $uuid) {
            $item = Item::findByUuid($uuid);

            $mesclado = $licitacao->itens()->create([
                'numero'        => 20000, // este número indicara itens mesclados nas  licitcaoes, eles não pertencem a nenhuma requisicão
                'quantidade'    => 0,
                'codigo'        => $item->codigo,
                'objeto'        => $item->objeto,
                'descricao'     => $item->descricao,
                'unidade_id'    => $item->unidade_id,
            ], ['ordem' => $licitacao->itens()->max('ordem')+1]); // Ordem é um pivot da tabela item_licitação
        }
    }
 
}
