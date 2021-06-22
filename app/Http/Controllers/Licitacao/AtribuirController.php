<?php

namespace App\Http\Controllers\Licitacao;

use Session;
use App\Item;
use App\Licitacao;
use App\Requisicao;
use Illuminate\Http\Request;
use App\Services\LicitacaoService;
use App\Http\Controllers\Controller;

class AtribuirController extends Controller
{
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LicitacaoService $service)
    {
        $this->service = $service;
    }

    /**
     * Retorno a view que permite a inclusão e remoção de itens da relação de itens da licitação.
     * 
     * @param Licitacao $licitacao 
     * @param Requisicao|null $requisicao 
     * @return type
     */
    public function create(Licitacao $licitacao, Requisicao $requisicao = null)
    {
        $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']);
        return view('site.licitacao.compras.atrubuirItem',  compact('licitacao', 'requisicao', 'comunica'));
    }
    /**
     * Adiciona à relação de itens da licitação um ou mais itens informados no array de itens.
     * 
     * @param Licitacao $licitacao 
     * @param Requisicao $requisicao 
     * @return type
     */
    public function store(Request $request, Licitacao $licitacao)
    {

        $this->validate($request, [
                'itens'      => 'required|array|min:1',
                'itens.*'    => 'string|exists:itens,uuid',
            ], [ 
                'itens.min' => 'Nenhum item atribuido, selecione um ou mais itens e tente novamente.'
        ]);

        $max = $licitacao->itens()->max('ordem')+1; // retorna o maior número de ordem dos itens da licitação
        $marcador = true; // indica se a requisição foi relacionada a licitção
        $ignorados = ""; // indica que itens já relacioandos à licitação foi encaminhado

        foreach ($request->itens as $uuid) {
            $item = Item::findByUuid($uuid);
            if(!$item->licitacao()->exists()){ // verifica se o item não está associado a uma licitação
                $item->ordem = $max; // atualiza o atributo "ordem" do item com o próximo número de ordem da licitação
                $item->save();
                $licitacao->itens()->save($item); // associa item com a licitação
                $max += 1; // incrementa o número da ordem
                if($marcador){
                    if (!$licitacao->requisicoes->contains($item->requisicao)){ // verifica se a requisição já esta associada à licitação
                        $licitacao->requisicoes()->attach($item->requisicao); // associa a requisição à licitação
                        $marcador = false;
                    }
                }
            }else{
                $ignorados .= $item->numero.", "; // relaciona os item ignorados por já estarem associados com uma licitação
            }
        }
        if (strlen($ignorados) > 0)// verifica se algum item foi ignorado
            return redirect()->route('licitacao.atribuir.create', [$licitacao->uuid, $request->requisicao])
                ->with(['codigo' => 500, 'mensagem' => 'Item(ns) ignorado(s) '.$ignorados.' por já esta(rem) associado(s) a uma licitação.']);

        return redirect()->route('licitacao.atribuir.create', [$licitacao->uuid, $request->requisicao])
            ->with(['codigo' => 200,'mensagem' => 'Os item selecionados foram atribuidos com sucesso!']);
    }

    /**
     * Remove da relação de itens da licitação um ou mais itens informados no array de itens.
     * 
     * @param Request $request 
     * @param Licitacao $licitacao 
     * @return type
     */
    public function remove (Request $request, Licitacao $licitacao)
    {
       $this->validate($request, [
                'itens'      => 'required|array|min:1',
                'itens.*'    => 'string|exists:itens,uuid',
            ], [ 
                'itens.min' => 'Nenhum item atribuido, selecione um ou mais itens e tente novamente.'
        ]);          

        $return =  $this->service->remove($request->itens, $licitacao);
        if ($return['status']) {
            return redirect()->route('licitacao.show', $licitacao->uuid)
                ->with(['codigo' => 200,'mensagem' => 'Todos os itens da requisição '.$licitacao->ordem.' foram removidos desta licitação com sucesso']);
        } else {
            return redirect()->route('licitacao.show', $licitacao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Nenhum item da requisição '.$licitacao->ordem.' está atribuido a esta licitação']);
        }
    }
    
    /**
     * Método que adiciona todos os itens da requisição na relação de itens da licitação.
     * 
     * @param Licitacao $licitacao 
     * @param Requisicao $requisicao 
     * @return type
     */
    public function atribuirRequisicao(Licitacao $licitacao, Requisicao $requisicao){
        $lista = $request->itens;
        if ($requisicao != null) {
            $this->atribuirItem($requisicao->itens->sortBy('numero'), $licitacao);
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

    /**
     * Remove todos os itens de uma requisição da relação de itens da licitação, por fim invoca o metodo ordenar.
     * 
     * @param Licitacao $licitacao 
     * @param Requisicao $requisicao 
     * @return view
     */
    public function removerRequisicao(Licitacao $licitacao, Requisicao $requisicao)
    {
      if ($requisicao->licitacoes()->where('licitacao_id',  $licitacao->id)->first()) {
           foreach (Item::where('licitacao_id','=', $licitacao->id)->where('requisicao_id','=',$requisicao->id)->get() as $item) {
                $item->licitacao()->dissociate();
                $item->ordem = null;
                $item->save();
            }
            $licitacao->requisicoes()->detach($requisicao);
            $this->ordenador($licitacao);
            return redirect()->route('licitacao.atribuir.create', $licitacao->uuid)
                ->with(['codigo' => 200,'mensagem' => 'Todos os itens da requisição '.$requisicao->ordem.' foram removidos desta licitação com sucesso']);
        }
        return redirect()->route('licitacao.atribuir.create', [$licitacao->uuid, $requisicao->uuid])
                ->with(['codigo' => 500, 'mensagem' => 'Nenhum item da requisição '.$requisicao->ordem.' está atribuido a esta licitação']);
    }

    /**
     * Ordena a ordem dos itens de uma licitação, método utilizado apos a remoção ou mesclagem de itens.
     * 
     * @param Licitacao $licitacao 
     * @return type
     */
    public function ordenador(Licitacao $licitacao)
    {
        $ordem = 1;
        foreach ($licitacao->itens->sortBy('ordem') as  $item){
            $item->ordem = $ordem;
            $item->save();
            $ordem += 1;
        }
    }
}
