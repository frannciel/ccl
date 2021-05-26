<?php

namespace App\Services;

use App\Item;


class ItemService
{
    protected $postal;

    function __construct( )
    {

    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    public public function importar(array $data)
    {

        
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


   public function search(array $data)
   {
      try {

         }

         return [
            'status' => true,
            'message' => 'Sucesso',
            'data' => $data
         ];
      } catch (Exception $e) {
         return [
           'status' => false,
           'message' => 'Ocorreu durante a execução',
           'error' => $e
         ];
      }
   }

    public function recente(){ 
       return Cliente::orderBy('updated_at', 'desc')->take(10)->get();
    }
	/**
     * Salva um novo telefone na base de dados
     *
     * @param Array $data 
     * @param \App\Cliente $id
     * @return \App\telefone $telefone
     */
    public function store(array $data, Item $item)
    {
        try {

            return [
               'status' => true,
               'message' => 'cadastrado com sucesso',
               'data' => $data
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a execução',
               'error' => $e
            ];
        }
    }

    public function delete(Item $item)
    {
        try {

            $item->delete();
            
            return [
                'status' => true,
                'message' => 'Locação Excluida  com sucesso',
                'data' => $item
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ocorreu durante a tetiva de excluir a locação',
               'error' => $e
            ];
        }
    }

    public function update(array $data, Item $item)
    {
        try {
           
            $item->numero = $data['numero'];
            $item->save();

            return [
                'status' => true,
                'message' => 'Item alterado com sucesso',
                'data' => $data
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Ocorreu um erro durante a execucao',
                'error' => $e
            ];
        }
    }

}
