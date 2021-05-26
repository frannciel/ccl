<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class IrpImport implements ToModel
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return [
            'item'          => $row[0],
            'descircao'     => $row[1],
            'unidade'       => $row[2],
            'valor'         => $row[3],
            'entidade'      => $row[4],
            'cidade'        => $row[5],
            'quantidade'    => $row[6]
        ];
    }
}
