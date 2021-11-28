<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    /**
     * Metodo que retorna o endereço tendo como parâmetro de busca o CEP. 
     * Os dados serão consumidos da da API ViaCEP. 
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     \Illuminate\Http\Response
     */
    public function enderecoViaCep($cep)
    {
        // composer require guzzlehttp/guzzle
        $cep = preg_replace("/[^0-9]/", "", $cep);
        if (strlen($cep) === 8) {
            $client = new Client();
            $response = $client->request('GET', 'viacep.com.br/ws/'.$cep.'/json/');
            return response($response->getBody());
        } else{
            return response(true);
        }
    }
}
