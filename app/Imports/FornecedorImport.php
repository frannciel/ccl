<?php

namespace App\Imports;

use App\Fornecedor;
use Maatwebsite\Excel\Concerns\ToModel;

class FornecedoresImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cidade = Cidade::firstOrCreate([
            'nome' => $request->cidade, 
            'estado_id'=> Estado::where('sigla', $request->estado)->first()->id
        ]); 
        
        $fornecedor ;
        if(strlen(preg_replace("/[^0-9]/", "", $request->cpf_cnpj)) == 11){
            $fornecedor = $this->storePessoaFisica($request);
        } elseif (strlen(preg_replace("/[^0-9]/", "", $request->cpf_cnpj)) == 14) {
            $fornecedor = $this->storePessoaJuridica($request);
        }

        return $fornecedor->fornecedor()->create([
            'endereco'      => $request->endereco,
            'cep'           => $request->cep,
            'cidade_id'     => $cidade->id,
            'email'         => $request->email,
            'telefone_1'    => $request->telefone1,
            'telefone_2'    => $request->telefone2
        ]);
    }

    protected function storePessoaFisica($request)
    {   
        return PessoaFisica::create([
            'cpf'    => $request['cpf_cnpj'],
            'nome'   => $request['razaoSocial']
        ]);
    }

    protected function storePessoaJuridica($request)
    {
        return PessoaJuridica::create([
            'cnpj'          => $request['cpf_cnpj'],
            'razao_social'  => $request['razaoSocial'],
            'representante' => $request['representante']
        ]);
    }
}
