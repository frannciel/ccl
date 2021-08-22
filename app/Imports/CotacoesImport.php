<?php

namespace App\Imports;

use Session;
use App\Cotacao;
use App\Requisicao;
use Illuminate\Validation\Rule;
use App\Services\ConversorService;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class CotacoesImport implements WithMapping, ToCollection, WithHeadingRow, WithValidation
{
    protected $requisicao;

    public function __construct(Requisicao $requisicao){
        $this->requisicao = $requisicao;
    }

    public function map($row): array
    {      
        if(gettype($row['data']) == 'integer')  
            $row['data'] = Date::excelToDateTimeObject($row['data'])->format('Y-m-d');
        if(gettype($row['hora']) == 'double')  
            $row['hora'] = Date::excelToDateTimeObject($row['hora'])->format('H:i');
        return $row;
    }

    public function rules(): array
    {
        return [
            '*.item'  => 'required|numeric',
            '*.fonte' => 'required|max:150',
            '*.valor' => 'required|numeric',
            '*.data'  => 'required|date_format:Y-m-d',
            '*.hora'  => 'nullable|date_format:H:i'
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.item.required'   => 'Falha na linha :row: A coluna "Item" não pode ser vazia.',
            '*.item.numeric'    => 'Falha na linha :row: A coluna "Item" deve ser um número, sem caracter especial.',
            '*.fonte.required'  => 'Falha na linha :row: A coluna "Fonte" não pode ser vazia.',
            '*.fonte.max'       => 'Falha na linha :row: O tamanho máximo da coluna "Fonte" é 150 caracteres.',
            '*.valor.required'  => 'Falha na linha :row: A coluna "Valor" não pode ser vazia.',
            '*.valor.numeric'   => 'Falha na linha :row: A coluna "Valor" deve ser um número.',
            '*.data.required'   => 'Falha na linha :row: A coluna "Data" não pode ser vazia.',
            '*.data.date_format'  => 'Falha na linha :row: A coluna "Data" deve estar no formato DD/MM/AAAA.'
        ];
    }

    public function collection(Collection $rows)
    {
        $pulados = collect(); // itens pulados por já estarem cadastrados
        foreach ($rows as $key => $row)
        {
            if ($this->comparable($row->toArray())) {
                Cotacao::create([
                    'fonte'    => $row['fonte'],
                    'valor'    => ConversorService::stringToFloat($row['valor']), 
                    'data'     => $row['hora'] == null ? $row['data'] : $row['data'].$row['hora'],
                    'item_id'  => $this->requisicao->itens()->where('numero', $row['item'])->first()->id
                ]);
            } else{
                $linha = $key+2;
                $pulados->push("O registro da linha ".$linha." já consta cadastrado para o item ".$row['item']);
            }
        }
        Session::put('pulados', $pulados);
    }

    private function comparable(array $row)
    {
        $novo = new Cotacao([
            'fonte'    => $row['fonte'],
            'valor'    => ConversorService::stringToFloat($row['valor']), 
            'data'     => $row['hora'] == null ? $row['data'] : $row['data'].$row['hora'],
            'item_id'  => $this->requisicao->itens()->where('numero', $row['item'])->first()->id
        ]);
    
        $item = $this->requisicao->itens()->where('numero', $row['item'])->first();
        foreach ($item->cotacoes as $cotacao) 
            if($novo->equals($cotacao))
                return false;
        return true;
    }
}
