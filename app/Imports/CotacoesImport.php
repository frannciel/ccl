<?php

namespace App\Imports;

use App\Cotacao;
use App\Requisicao;
use Illuminate\Validation\Rule;
use App\Services\ConversorService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\HeadingRowImport;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class CotacoesImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $requisicao;

    public function __construct(Requisicao $requisicao){
        $this->requisicao = $requisicao;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Cotacao([
            'fonte'    => $row['fonte'],
            'valor'    => ConversorService::stringToFloat($row['valor']), 
            'data'     => Date::excelToDateTimeObject($row['data'])->format('Y-m-d').Date::excelToDateTimeObject($row['hora'])->format('H:i'),
            'item_id'  => $this->requisicao->itens()->where('numero', $row['item'])->first()->id
        ]);
    }

    /**
     * Tweak the data slightly before sending it to the validator
     * @param $data
     * @param $index
     * @return mixed
     */
    public function prepareForValidation($data, $index)
    {
        $data['data'] = Date::excelToDateTimeObject($row['data'])->format('Y-m-d');
        $data['hora'] = Date::excelToDateTimeObject($row['hora'])->format('H:i');
    }

    public function rules(): array
    {
        return [
            'fonte'     => 'required',
            'valor'     => 'required',
            'data'      => 'required',
            'hora'      => 'required',
            'item'      => 'required'
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if ($this->comparable($row->toArray())) {
                Cotacao::create([
                    'fonte'    => $row['fonte'],
                    'valor'    => ConversorService::stringToFloat($row['valor']), 
                    'data'     => Date::excelToDateTimeObject($row['data'])->format('Y-m-d').Date::excelToDateTimeObject($row['hora'])->format('H:i'),
                    'item_id'  => $this->requisicao->itens()->where('numero', $row['item'])->first()->id
                ]);
            }
        }
    }

    private function comparable(array $row)
    {
        $novo = new Cotacao([
            'fonte'    => $row['fonte'],
            'valor'    => ConversorService::stringToFloat($row['valor']), 
            'data'     => Date::excelToDateTimeObject($row['data'])->format('Y-m-d').Date::excelToDateTimeObject($row['hora'])->format('H:i'),
            'item_id'  => $this->requisicao->itens()->where('numero', $row['item'])->first()->id
        ]);
    
        $item = $this->requisicao->itens()->where('numero', $row['item'])->first();
        foreach ($item->cotacoes as $cotacao) 
            if($novo->equals($cotacao))
                return false;
        return true;
    }

}
