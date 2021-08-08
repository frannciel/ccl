<?php

namespace App\Http\Controllers\Licitacao;

use Session;
use App\Item;
use App\Licitacao;
use App\Requisicao;
use Illuminate\Http\Request;
use App\Services\LicitacaoService;
use App\Http\Controllers\Controller;

class MesclarItemController extends Controller
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
     * Método que recebe um ou mais itens e os mescla criando um novo item na licitação e desassocia os itens mescladdos
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'principal'  => 'required',
                'itens'      => 'required|array|min:2',
                //'itens.*'    => 'exists:itens,uuid',
            ], [ 
                'principal.required' => 'Clique no item que terá as características mantidas!',
                'itens.min' => 'São necessários no mínimos dois itens de requisições diferentes para realizar a mesclagem.'
        ]);

        try{
                # uuid dos itens a serem mesclados nesta licitacao #
                $uuids = $request->itens; 
                # indice do item do array que doara as características para o item mesclado, não pode ser nulo #
                $index = $request->principal; 
                # Verifica se o item principal foi enviado junto aos demais itens a serem mesclados #
                if ($uuids[$index] == null)
                    return back()
                            ->withErrors(['principal' => ['O item que terá as características mantidas, deve ser um dos itens selecionados!']])
                                ->withInput();

                # retorna o objeto item, principal para a mescla
                $principal = Item::findByUuid($uuids[$index]);
                $licitacao = $principal->licitacao;
                # soma as quantidade dos itens a serem mesclados
                $quantidade = 0;
                # relacao de ids dos itens mesclados para desassociação da licitação #
                $itens = collect();
                foreach ($uuids as $uuid) { // calcula a quantidade
                    if($uuid != null){
                        $item = Item::findByUuid($uuid);
                        $quantidade += $item->quantidade;
                        $itens->push($item);
                    }
                }

                $mesclado = $licitacao->itens()->create([
                    'numero'        => 10000, # este número indicara itens mesclados nas  licitcaoes, eles não pertencem a nenhuma requisicão #
                    'quantidade'    => $quantidade,
                    'codigo'        => $principal->codigo,
                    'objeto'        => $principal->objeto,
                    'descricao'     => $principal->descricao,//nl2br(
                    'unidade_id'    => $principal->unidade_id,
                    'ordem'         => $licitacao->itens()->max('ordem')+1
                ]);
                # copia as cotações do principal para o item mescado #
                foreach ($principal->cotacoes as $cotacao) {
                    $mesclado->cotacoes()->create([
                        'fonte' => $cotacao->fonte,
                        'valor' => $cotacao->valor,
                        'data'  => $cotacao->data
                    ]);
                 }
                # remove os registro dos itens mesclado da tabela 'item_licitacao' #
                foreach ($itens as $item) {
                    $item->ordem = null;
                    $item->licitacao()->dissociate();
                    $item->save();
                }

                $itensMesclar = array();
                foreach ($itens as $item) {
                    $itensMesclar += [$item->id => ['licitacao_id' => $licitacao->id]];
                }
                $mesclado->mesclados($licitacao)->attach($itensMesclar);
                # reordena a numeração dos item da licitacão licitacão #
                $this->service->ordenador($licitacao);

                return redirect()->route('licitacao.mesclar.create', $licitacao->uuid)
                    ->with(['codigo' => 200,'mensagem' => 'Os itens selecionados foram mesclados com sucesso, vide item '.$mesclado->ordem]);

        } catch (Exception $e) {
            return back()
                    ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error tentar ao mesclar itens, tente novamente ou contate o administrador'])
                    ->withInput();
        }

    }

    public function create(Licitacao $licitacao)
    {
        try{
            
            $requisicoes = array();
            $mesclados = $licitacao->mesclados()->get()->unique();//()->get()->unique();
            # Array de arrays, contendo itens com atributos uuid e numero concatenado com objetos item #
            $selectItens = array(); 
            # retorna todos os itens da licitação agrupados por pela requisição #
            $gruposItem = Item::where('licitacao_id', $licitacao->id)->get()->groupBy('requisicao_id');

            foreach ($gruposItem as $key =>  $grupo) { 
                if ($key != null) {
                    $lista = array();
                    foreach ($grupo as $item) {
                        if(!$item->itens()->exists()){// verifica se o item não está associado a uma licitação
                            $concatenado = $item->numero.' - '.$item->objeto; // Conacate numero do item com objeto do item
                            $lista += [$item->uuid => substr_replace($concatenado, (strlen($concatenado) > 40 ? '...' : ''), 40)]; 
                        }
                    }
                    $selectItens[] = $lista;  // insere mais um array na lista de arrays
                    $requisicao = Requisicao::find($key);
                    $concatenado = $requisicao->ordem.' - '.$requisicao->descricao; // Conacate numero do item com objeto do item
                    $requisicoes[] = substr_replace($concatenado, (strlen($concatenado) > 100 ? '...' : ''), 100);//$requisicao->ordem.' - '.$requisicao->descricao; // concatena o item como objeto da requisicao
                }
            }

            $comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
            Session::forget(['mensagem','codigo']); 
            return view('site.licitacao.compras.mesclarItem', compact('selectItens', 'requisicoes', 'mesclados', 'licitacao', 'comunica'));

        } catch (Exception $e) {
            return redirect()->route('licitacao.show', $licitacao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error, tente novamente ou contate o administrador']);
        }

    }

    public function separar(Item $item)
    {
        $return =  $this->service->separar($item);
        if ($return['status']) {
            return redirect()->route('licitacao.mesclar.create', $item->licitacao->uuid)
                ->with(['codigo' => 200,'mensagem' => 'O item informado foi separado com sucesso !']);
        } else {
            return redirect()->route('licitacao.mesclar.create', $item->licitacao->uuid)
                ->with(['codigo' => 500, 'mensagem' => 'Ocorreu um error ao separar itens, tente novamente ou contate o administrador']);
        }
    }
}
