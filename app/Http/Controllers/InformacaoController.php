<?php

namespace App\Http\Controllers;

use App\Informacao;
use App\Enquadramento;
use Illuminate\Http\Request;

class InformacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Enquadramento $enquadramento)
    {
        return view('enquadramento.index')->with('enquadramentos', $enquadramento->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $normativas = array();
        $classificacoes = array();
        $informacoes = Informacao::where('tipo', '=', 'classificacao')->orWhere('tipo', '=', 'normativa')->get();
        foreach ($informacoes->where('tipo', 'normativa') as  $value)
            $normativas += [$value->valor => $value->dado];
        foreach ($informacoes->where('tipo', 'classificacao') as  $value)
            $classificacoes += [$value->valor => $value->dado];
        return view('enquadramento.create',  compact("normativas", "classificacoes"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $extenso = $this->valorExtenso($request->valor);
        Enquadramento::create([
            'processo'      => $request->processo,
            'numero'        => $request->numero,
            'objeto'        => $request->descricao,
            'valor'         => $request->valor,
            'classificacao' => $request->objeto ?? '0',
            'normativa'     => $request->normativa ?? '0',
            'modalidade'    => $request->modalidade ?? '0',

        ]);
        return view('enquadramento.formulario', compact('request','extenso'))->with('dados', Informacao::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\informacao  $informacao
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('enquadramento.exibir')->with('enquadramentos', $enquadramento->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\informacao  $informacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Informacao $informacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\informacao  $informacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Informacao $informacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\informacao  $informacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Informacao $informacao)
    {
        //
    }

    public function informacao(Request $request){
        $opcao = $request->opcao; // indica qual a opção escolhida pelo usuário
        $selecao = $request->selecao; // representa o id do formulário que fez a requisição
        if ($selecao == 'normativa') { 
            if ($opcao == '0') { // fundamentado na lei 8666/93
                $modalidades = array();
                foreach (Informacao::where('tipo', '=', 'modalidade')->get(array('dado', 'valor')) as  $value)
                    $modalidades += [$value->valor => $value->dado];
                return view('enquadramento.ajax', compact('modalidades'))->with('etapa',0);
            } elseif ($opcao == '2') { // funadamentado do na lei 10520/02
                $tipos = array(); // indica a forma de julgamento da proposta ex: menor preço
                $formas = array(); // indica se o pregão e ou não presencial eletônico e srp 
                $dados = Informacao::where('tipo', '=', 'forma')->orWhere('tipo', '=', 'tipo')->get();
                foreach ($dados->where('tipo', 'tipo') as  $value)
                    $tipos += [$value->valor => $value->dado];
                foreach ($dados->where('tipo', 'forma') as  $value)
                    $formas += [$value->valor => $value->dado];
                return view('enquadramento.ajax',  compact("tipos", "formas"))->with('etapa', 1);
            }
        } elseif ($selecao == 'modalidade') { 
            if($opcao == '0' || $opcao == '1' || $opcao == '2'){ // licitações tradionais concorrencia, tomada de preços e convite
                $tipos = array();
                foreach (Informacao::where('tipo', '=', 'tipo')->get(array('dado', 'valor')) as  $value)
                    $tipos += [$value->valor => $value->dado];
                return view('enquadramento.ajax',  compact("tipos"))->with('etapa', 3);
            }elseif ($opcao == '5') { // Dispensa de licitação
                $incisos = array();
                foreach (Informacao::where('tipo', '=', '866624')->get(array('dado', 'valor')) as  $value)
                    $incisos += [$value->valor => $value->dado];
                return view('enquadramento.ajax',  compact("incisos"))->with('etapa', 2);
            } elseif ($opcao == '6') { // Inexigibilidade
                $incisos = array();
                foreach (Informacao::where('tipo', '=', '866625')->get(array('dado', 'valor')) as  $value)
                    $incisos += [$value->valor => $value->dado];
                return view('enquadramento.ajax',  compact("incisos"))->with('etapa', 2);
            }  
        }
        return '';
    }

    /**
    * Método que converte o valor númerio em valor por extenso em pt-br
    * 
    * @param  String $valor
    * @return String $valorExtenso
    * @author Gustavo Henrique Silva
    */
    public function valorExtenso($valor=0) {

        $valor = str_replace(",", '.', str_replace(".", "", $valor)); 

        $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
     
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
     
        $z=0;
        $rt = '';
        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        for($i=0;$i<count($inteiro);$i++)
            for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
                $inteiro[$i] = "0".$inteiro[$i];
     
        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
        for ($i=0;$i<count($inteiro);$i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
        
            $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
            $t = count($inteiro)-1-$i;
            $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000")$z++; elseif ($z > 0) $z--;
            if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
            if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
     
        return($rt ? $rt : "zero");
    }

    public function getEndereco($cep)
    {
        $json_file = file_get_contents("http://viacep.com.br/ws/45823431/json/ ");   
        $json_str = json_decode($json_file);
        //$itens = $json_str['nodes'];
        return response()->json($json_str->logradouro);
    }
}
 /*
insert into informacoes values ('', 'Concorrência', '0', 'modalidade');
insert into informacoes values ('', 'Tomada de Preço', '1', 'modalidade');
insert into informacoes values ('', 'Convite', '2', 'modalidade');
insert into informacoes values ('', 'Concurso', '3', 'modalidade');
insert into informacoes values ('', 'Leilão', '4', 'modalidade');
insert into informacoes values ('', 'Dispensa', '5', 'modalidade');
insert into informacoes values ('', 'Inexigibilidade', '6', 'modalidade');
insert into informacoes values ('', 'Obra ou Serviço de Engenharia', '0', 'classificacao');
insert into informacoes values ('', 'Serviço', '1', 'classificacao');
insert into informacoes values ('', 'Compra', '2', 'classificacao');
insert into informacoes values ('', 'Alienação', '3', 'classificacao');
insert into informacoes values ('', 'Obras, serviços e compras de grande vulto', '4', 'classificacao');
insert into informacoes values ('', 'Concessão de Uso', '5', 'classificacao');
insert into informacoes values ('', 'Serviço com fornecimento de materiais', '6', 'classificacao');
insert into informacoes values ('', 'Lei 8666/93 - Licitações', '0', 'normativa');
insert into informacoes values ('', 'Lei 11.947/09 - Alimentação Escolar', '1', 'normativa');
insert into informacoes values ('', 'Lei 10.520/02 - Pregão', '2', 'normativa');
insert into informacoes values ('', 'I','0', '866624');
insert into informacoes values ('', 'II','1', '866624');
insert into informacoes values ('', 'III','2', '866624');
insert into informacoes values ('', 'IV','3', '866624');
insert into informacoes values ('', 'V','4', '866624');
insert into informacoes values ('', 'VI','5', '866624');
insert into informacoes values ('', 'VII','6', '866624');
insert into informacoes values ('', 'VIII','7', '866624');
insert into informacoes values ('', 'IX','8', '866624');
insert into informacoes values ('', 'X','9', '866624');
insert into informacoes values ('', 'XI','10', '866624');
insert into informacoes values ('', 'XII','11', '866624');
insert into informacoes values ('', 'XIII','12', '866624');
insert into informacoes values ('', 'XIV','13', '866624');
insert into informacoes values ('', 'XV','14', '866624');
insert into informacoes values ('', 'XVI','15', '866624');
insert into informacoes values ('', 'XVII','16', '866624');
insert into informacoes values ('', 'XVIII','17', '866624');
insert into informacoes values ('', 'XIX','18', '866624');
insert into informacoes values ('', 'XX','19', '866624');
insert into informacoes values ('', 'XXI','20', '866624');
insert into informacoes values ('', 'XXII','21', '866624');
insert into informacoes values ('', 'XXIII','22', '866624');
insert into informacoes values ('', 'XXIV','23', '866624');
insert into informacoes values ('', 'XXV','24', '866624');
insert into informacoes values ('', 'XXVI','25', '866624');
insert into informacoes values ('', 'XXVII','26', '866624');
insert into informacoes values ('', 'XXVIII','27', '866624');
insert into informacoes values ('', 'XXIX','28', '866624');
insert into informacoes values ('', 'XXX','29', '866624');
insert into informacoes values ('', 'XXXI','30', '866624');
insert into informacoes values ('', 'XXXII','31', '866624');
insert into informacoes values ('', 'XXXIII','32', '866624');
insert into informacoes values ('', 'XXXIV','33', '866624');
insert into informacoes values ('', 'XXXV','34', '866624');
insert into informacoes values ('', 'Caput','0', '866625');
insert into informacoes values ('', 'I','1', '866625');
insert into informacoes values ('', 'II','2', '866625');
insert into informacoes values ('', 'III','3', '866625');
insert into informacoes values ('', 'Presencial', '0','forma');
insert into informacoes values ('', 'Eletrônico', '1', 'forma');
insert into informacoes values ('', 'Eletrônico - Registro de Preços', '2', 'forma');
insert into informacoes values ('', 'Presencial  - Registro de Preços', '3', 'forma');
insert into informacoes values ('', 'Menor Preço', '0', 'tipo');
insert into informacoes values ('', 'Melhor Técnica', '1', 'tipo');
insert into informacoes values ('', 'Técnica e Preço', '2','tipo');
insert into informacoes values ('', 'Maior Lance ou Oferta', '3', 'tipo');
*/