<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>CCL - PDF</title>
</head>
<body>
   @include('pdf.cabecalho')
   <h2 align="center">Relatório de Pesquisa de Preços</h2>
   <br/>
   @if (count($requisicao->itens) > 0)

      <div id="pesquisa">
         <table align="center" style="border: 1px solid black;width:95%;background:#f0f0f5;">
             <tr>
               <td>
                  <div><b>REQUISIÇÃO:</b> {{$requisicao->ordem}}</div>
                  <div><b>SETOR REQUISITANTE:</b> {{$requisicao->requisitante->nome}}</div>
                  <div><b>OBJETO:</b> {{$requisicao->descricao}}</div>
               </td>
            </tr>
         </table> 
        
         <br/>
         <table align="center" style="border: 1px solid black;width:80%;background:#f0f0f5;text-align: justify;">
            <tr><td><font size="2">
                  Pesquisa de preços em conformidade com a Instrução Normativa Nº 5 de 27 de Junho de 2014 alterada pela Instrução Normativa nº 3, de 20 de abril de 2017. Os preços constantes no presente relatório atendem aos seguntes incisos Art. 2º: Inciso I - Painel de Preços - (http://paineldeprecos.planejamento.gov.br), Inciso III - pesquisa publicada em mídia especializada, sítios eletrônicos especializados ou de domínio amplo (...) e Inciso IV - pesquisa com os fornecedores. O resultado da pesquisa será a média dos preços obtidos conforme Art. 2º Paragrafo §2º.
            </font></td></tr>
         </table>
         <br/>

         @foreach ($requisicao->itens as $item)
            <table width='95%' align="center" align="center" style="border: 1px solid black">
               <tr bgcolor="#f0f0f5">
                  <td width='50%'> Item: {{$item->numero}} - {{$item->objeto}} </td>
                  <td width='13%'> Quantidade: {{$item->quantidade}}</td>
                  <td width='18%'> Valor Médio: {{$item->valorMedio}}</td>
                  <td width='20%'> Valor Total: {{$item->valorTotal}} </td>
               </tr>
            </table>
            @if ($item->media > 0)
            <table frame="box"  width="80%"  align="center" style="border: 1px solid black">
         		<tr bgcolor="#12E0E4">
         			<th width="10%" align="center" class="center">#</th>
         			<th width="50%" align="center" class="center">Fonte dos dados</th>
         			<th width="25%" align="center" class="center">Data e hora</th>
         			<th width="15%" align="center" class="center">Valor</th>
         		</tr>
         		@foreach ($item->cotacoes as  $key => $cotacao)
         			<tr bgcolor="#fff">
         				<td width="10%" align="center">{{$key + 1}}</td>
         				<td width="50%" align="left">{{$cotacao->fonte ?? ''}}</td>
         				<td width="20%" align="center">{{$cotacao->data ?? ''}}</td>
         				<td width="20%" align="center">{{$cotacao->contabil ?? ''}}</td> 
         			</tr> 
         		@endforeach
            </table>
            @endif
            <br/>
         @endforeach

         <table align="center" style="border: 1px solid black;width:95%;background:#f0f0f5;text-align: center;">
            <tr>
               <td><h4> Total Geral: R$ {{$requisicao->valorTotal}}</h4></td>
            </tr>
         </table>
      </div>
   @else   
      <table align="center"><tr><td><font size="3"><i> Nenhuma Cotação Encontrada </i></font></td></tr></table>
   @endif
</body>
</html>