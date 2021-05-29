<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use Maatwebsite\Excel\HeadingRowImport;

class CotacaoImporteController extends Controller
{
	public function create(Requisicao $requisicao)
	{
		$comunica = ['cod' => Session::get('codigo'), 'msg' => Session::get('mensagem')];
        Session::forget(['mensagem','codigo']); 
		return view('requisicao.import',  compact('requisicao', 'comunica'));
	}

	public function Excel(Request $request, Requisicao $requisicao)
    {
        $headings = (new HeadingRowImport)->toArray($request->file('arquivo'));
        $headings = $headings[0][0];
        if ($headings[0]=='item'&&$headings[1]=='fonte'&&$headings[2]=='valor'&&$headings[3]=='data'&&$headings[4]=='hora') {
	        Excel::import(new CotacoesImport($requisicao), $request->file('arquivo'));
	        return redirect()->route('requisicaoShow', $requisicao->uuid)
	            ->with(['codigo' => 200,'mensagem' => 'Dados importados com sucesso!']);
        } else {
        	return redirect()->route('importeText.requisicaoCreate', $requisicao->uuid)
            	->with(['codigo' => 500,'mensagem' => 'Favor verificar a linha de cabeçalho da planilha e tente novamente']);
        }
    }


}
