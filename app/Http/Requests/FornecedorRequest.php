<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FornecedorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cpf_cnpj'     =>'required|string|min:11|max:18',
            'razao_social'   =>'required|string',
            'telefone'      =>'string|nullable|min:10',
            'email'         =>'email|nullable',
            'representante' =>'string|nullable',
            'endereco'      =>'string|nullable',
            'cidade'        =>'string|nullable',
            'estado'        =>'string|nullable',
            'cep'           =>'string|nullable|max:10'
        ];
    }
}
