<?php

namespace App\Services;
use Auth;
use App\Item;
use App\Unidade;
use App\Requisicao;
use App\Services\RequisicaoService;

class ItemService
{
    protected $requisicaoService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RequisicaoService $requisicaoService)
    {
        $this->requisicaoService = $requisicaoService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importar(array $data, Requisicao $requisicao)
    {
        try{
            // remove o ultimo caracter e quebra a texto em celulas e organiza por linhas
            $dados = array_chunk(explode("&", substr($data['texto'],  0, -1)), 5);
            array_shift ($dados); // remove a linha de cabeçalho;

            //$itens = $requisicao->itens; // retona tosdos os item relacionados com a requisição
            foreach ($dados as $valor) {

                /*caso o número do item não seja informado o sistema cadastra o item no final da requisição */
                if ($valor[0] == "")
                    $valor[0] = $requisicao->itens()->max('numero') + 1;
                
                if (!$requisicao->itens()->where('numero', intval($valor[0]))->exists()) { // verifica se já existe item com mesmo número

                    $descricao = ''; //recebe a descricao detalhada do item
                    $objeto = ''; // recebe ojeto do item

                    // Divide a descrição do item em objeto e decrição detalhada.
                    // Caso nenhuma das opções abaixo esteja presente na descrição o item ficará com o objeto vazio.
                    if(strpos($valor[1], "Descrição Detalhada:") != false) {
                        $descricao = explode("Descrição Detalhada:", $valor[1], 2);
                    } elseif(strpos($valor[1], "Descricão Detalhada:") !== false){
                        $descricao = explode("Descricão Detalhada:", $valor[1], 2);
                    } elseif(strpos($valor[1], "Descriçao Detalhada:") !== false){
                        $descricao = explode("Descriçao Detalhada:", $valor[1], 2);
                    } elseif(strpos($valor[1], "Descricao Detalhada:") !== false){
                        $descricao = explode("Descricao Detalhada:", $valor[1], 2);
                    } elseif(strpos($valor[1], "Descrição detalhada:") !== false){
                        $descricao = explode("Descrição detalhada:", $valor[1], 2);
                    } elseif(strpos($valor[1], "Descricão detalhada:") !== false){
                        $descricao = explode("Descricão detalhada:", $valor[1], 2);
                    } elseif(strpos($valor[1], "Descriçao detalhada:") !=  false){
                        $descricao = explode("Descriçao detalhada:", $valor[1], 2);
                    } elseif(strpos($valor[1], "Descricao detalhada:") !== false){
                        $descricao = explode("Descricao detalhada:", $valor[1], 2);
                    } elseif(strpos($valor[1], "descrição detalhada:") !== false){
                        $descricao = explode("descrição detalhada:", $valor[1], 2);
                    } elseif(strpos($valor[1], "descrição detalhada") !== false){
                        $descricao = explode("descricão detalhada", $valor[1], 2);
                    } elseif(strpos($valor[1], "Descrição detalhada") !== false){
                        $descricao = explode("Descrição detalhada", $valor[1], 2);
                    } elseif(strpos($valor[1], "Descricao Detalhada") !== false){
                        $descricao = explode("Descricao Detalhada", $valor[1], 2);
                    } elseif(strpos($valor[1], "Descrição Complementar:") !== false){
                        $descricao = explode("Descrição Complementar:", $valor[1], 2);
                    } elseif(strpos($valor[1], "Descrição Complementar") !== false){
                        $descricao = explode("Descrição Complementar", $valor[1], 2);
                    } elseif(strpos($valor[1], "Descrição complementar:") !== false){
                        $descricao = explode("Descrição complementar:", $valor[1], 2);
                    } 
                
                    // prepara o objeto do desrição infomada
                    if(!isset($descricao[1])) {
                        $descricao = $valor[1];
                        $objeto = "";
                    } else {

                        if (strpos($descricao[0], "Objeto:") !== false) {
                            $objeto = explode("Objeto:", $descricao[0]);
                        } elseif (strpos($descricao[0], "objeto:") !== false){
                            $objeto = explode("objeto:", $descricao[0]);
                        } elseif (strpos($descricao[0], "OBJETO:") !== false){
                            $objeto = explode("OBJETO:", $descricao[0]);
                        }

                        if (!isset($objeto[1])) {
                            $objeto = $descricao[0];
                        } else {
                            $objeto = $objeto[1];
                        }
                        $descricao = $descricao[1];
                    }


                    $item = Item::create([
                        'numero'        => intval($valor[0]), // convert em inteiro
                        'descricao'     => nl2br($descricao), // inserir as quebas de linha
                        'objeto'        => trim($objeto),
                        'codigo'        => $valor[2] == ''? 0 : intval($valor[2]),
                        'unidade_id'    => Unidade::where('nome', trim($valor[3]))->first()->id ?? 1, // retorn o id da unidade ou determina como indefinido.
                        'quantidade'    => trim($valor[4]),
                        'requisicao_id' => $requisicao->id
                    ]);
                }
            }

            return [
                'status' => true,
                'message' => 'Sucesso',
                'data' => $dados
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a execução',
               'error' => $e
            ];
        }
    }

    public function search(array $data)
    {
            try {

                $locacoes = collect();
                switch ($data['filtro']) {
                    case '1':
                        $locacoes = Cotacao::whereHas('cliente', function($query) use ($data){ 
                            $query->where('nome', 'like', '%'.$data['palavra'].'%')->orderBy('nome', 'asc')->take(50);
                        })->get();
                       break;
                    case '2':
                       $locacoes = Cotacao::whereHas('produtos', function($query) use ($data){
                          $query->where('nome', 'like',  '%'.$data['palavra'].'%')->orderBy('updated_at', 'desc')->take(50);
                       })->get();
                       break;            
                    case '3':
                       $locacoes = Cotacao::whereHas('endereco', function($query) use ($data){
                          $query->where('bairro', 'like',  '%'.$data['palavra'].'%')->orderBy('updated_at', 'desc')->take(50);
                       })->get();
                       break;
                }

                return [
                    'status' => true,
                    'message' => 'Sucesso',
                    'data' => $locacoes
                ];
            } catch (Exception $e) {
                return [
                   'status' => false,
                   'message' => 'Ocorreu durante a execução',
                   'error' => $e
                ];
            }
    }

	/**
     * Salva um novo telefone na base de dados
     *
     * @param Array $data 
     * @param \App\Cliente $id
     * @return \App\telefone $telefone
     */
    public function store(array $data, Requisicao $requisicao)
    {
        try {

            $item = $requisicao->itens()->create([
                'numero'        => $requisicao->itens()->max('numero') + 1,
                'quantidade'    => $data['quantidade'],
                'codigo'        => $data['codigo'],
                'objeto'        => $data['objeto'],
                'descricao'     => nl2br($data['descricao']),
                'unidade_id'    => Unidade::findByUuid($data['unidade'])->id
            ]);

            return [
               'status' => true,
               'message' => 'Item cadastrado com sucesso',
               'data' => $item
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante o cadastro do item',
               'error' => $e
            ];
        }
    }

    public function destroy(Item $item)
    {
        try {

            if ($item->licitacao()->exists()){
                abort(
                    redirect()
                    ->route('item.edit', $item->uuid)
                    ->with(['codigo' => 500, 'mensagem' => 'Item associado a uma licitacão não pode ser apagado.'])
                    ->withInput()
                ); 
            } else {

                $requisicao = $item->requisicao;
                if (Auth::user()->requisitante->is($requisicao->requisitante) || Auth::user()->isAc) { 
                    $item->delete();
                    $this->requisicaoService->ordenar($item->requisicao);  
                } else {
                    abort(
                        redirect()
                            ->route('item.edit', $item->uuid)
                            ->with(['codigo' => 500, 'mensagem' => 'O usuário não tem autorização para apagar este item.'])
                            ->withInput()
                    );
                }
            } 
            
            return [
                'status' => true,
                'message' => 'Item Excluído  com sucesso',
                'data' => $item->requisicao
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a tentiva de excluir o item',
               'error' => $e
            ];
        }
    }

    public function deleteAll(array $itens)
    {
        try {

            $requisicao = "";
            foreach ($itens as  $uuid) {
                $item = Item::findByUuid($uuid);
                $requisicao = $item->requisicao;
                if (Auth::user()->requisitante->is($requisicao->requisitante) || Auth::user()->isAc) { // verifica se o usuário pertence ao mesmo requisitante da requisicão
                    if (!$item->licitacao()->exists()) { // verifica se o item não está relacionado a uma licitação
                        $item->delete();
                    }
                } else {
                   abort(
                        redirect()
                            ->route('requisicao.show', $requisicao->uuid)
                            ->with(['codigo' => 500, 'mensagem' => 'O usuário não tem autorização para apagar o item '.$item->numero.' da requisicao '.$requisicao->ordem])
                            ->withInput()
                    ); 
                }
            }
            $this->requisicaoService->ordenar($requisicao);

            return [
                'status' => true,
                'message' => 'Itens excluidos com sucesso',
                'data' => $requisicao
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a tentiva remover itens',
               'error' => $e
            ];
        }
    }

    public function update(array $data, Item $item)
    {
        try {
           
            $item->quantidade   = $data['quantidade'];
            $item->codigo       = $data['codigo'];
            $item->objeto       = $data['objeto'];
            $item->descricao    = nl2br($data['descricao']);
            $item->unidade_id   = Unidade::findByUuid($data['unidade'])->id;
            $item->save();

            return [
                'status' => true,
                'message' => 'Item alterado com sucesso',
                'data' => $item
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Ocorreu um erro durante a alteração de item',
                'error' => $e
            ];
        }
    }

    public function duplicar(array $itens)
    {
        try {
            
            $requisicao = "";
            foreach ($itens as  $uuid) {
                $item = Item::findByUuid($uuid);
                $requisicao = $item->requisicao;
                if (Auth::user()->requisitante->is($requisicao->requisitante) || Auth::user()->isAc) { // verifica se o usuário pertence ao mesmo requisitante da requisicão
                   $requisicao->itens()->create([
                        'numero'        => $requisicao->itens()->max('numero')+1, 
                        'quantidade'    => $item['quantidade'],
                        'codigo'        => $item['codigo'],
                        'objeto'        => $item['objeto'],
                        'descricao'     => $item['descricao'],
                        'unidade_id'    => $item['unidade_id'],
                    ]);
                } else {
                   abort(
                        redirect()
                            ->route('requisicao.show', $requisicao->uuid)
                            ->with(['codigo' => 500, 'mensagem' => 'O usuário não tem autorização para alterar esta requisicao.'])
                            ->withInput()
                    ); 
                }
            }   

            return [
                'status' => true,
                'message' => 'Itens duplicado com sucesso',
                'data' => $requisicao
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a tentiva duplicar itens',
               'error' => $e
            ];
        }
    }
}
