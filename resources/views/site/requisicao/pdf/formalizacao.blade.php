<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>CCL_DOD_PDF</title>
   <style type="text/css">
      b {  font-weight: bold;}
   </style>
</head>
<body>
   @include('site.pdf.cabecalho')
<h2 align="center">Documento de Oficialização de Demanda</h2>
@if (count($requisicao->itens) > 0)
   <br/>
   <table width="100%" border="1" cellspacing="0" cellpadding="2">
      <tr bgcolor="#F5F5F5" >
         <th  colspan="2"><center>DO SOLICITANTE</center></th>
      </tr>
      <tr>
         <td colspan="2"><b>REQUISIÇÃO:</b>&nbsp;{{$requisicao->ordem}}</td>
      </tr>
       <tr>
         <td colspan="2"><b>OBJETO:</b>&nbsp;{{$requisicao->descricao}}</td>
      </tr>
      <tr>
         <td colspan="2"><b>UNIDADE REQUISITANTE:</b>&nbsp;{{$requisicao->requisitante->nome}}</td>
      </tr>
      <tr>
         <td><b>REQUISITANTE:</b>&nbsp;</td>
         <td><b>CHEFIA IMEDIATA:</b>&nbsp;</td>
      </tr>
      <tr>
         <td><b>RAMAL:</b>&nbsp;{{$requisicao->requisitante->ramal}}</td>
         <td><b>RAMAL:</b>&nbsp;</td>
      </tr>
      <tr>
         <td><b>E-MAIL:</b>&nbsp;{{$requisicao->requisitante->email}}</td>
         <td><b>E-MAIL:</b>&nbsp;</td>
      </tr>
   </table>

   <br/>
   <table width="100%" border="1" cellspacing="0" cellpadding="2">
      <tr bgcolor="#F5F5F5" >
         <th><center>TIPO DE CONTRATAÇÃO</center></th>
      </tr>
      <tr>
         <td>
            <ul>
               @if($requisicao->tipo == 0)
               @elseif($requisicao->tipo == 1)
               <li>MATERIAL PERMANENTE</li>
               @elseif($requisicao->tipo == 2)
               <li>MATERIAL DE CONSUMO</li>
               @elseif($requisicao->tipo == 3)
               <li>SERVIÇO NÃO CONSTINUADO</li>
               @elseif($requisicao->tipo == 4)
               <li>SERVIÇO CONTINUADO</li>
               @elseif($requisicao->tipo == 5)
               <li>SERVIÇO POR TEMPO INDETERMINADO</li>
               @elseif($requisicao->tipo == 6)
               <li>OBRA</li>
               @elseif($requisicao->tipo == 7)
               <li>SERVIÇO DE ENGENHARIA</li>
               @endif
            </ul>
         </td>
      </tr>
   </table> 

   <br/>
   <table width='100%' border="1" cellspacing="0" cellpadding="2">
      <thead>
         <tr bgcolor="#F5F5F5">
            <th colspan="7"><center>RELAÇÃO DE ITENS DA REQUISIÇÃO</center></th>
         </tr>
         <tr bgcolor="#F5F5F5">
            <th align="center" class="center">Item</th>
            <th align="center" class="center" width="50%">Descrição Detalhada</th>
            <th align="center" class="center">Código</th>
            <th align="center" class="center">Unidade</th>
            <th align="center" class="center">Quantidade</th>
            <th align="center" class="center">Valor Unitário</th>
            <th align="center" class="center">Valor Total</th>
         </tr>
      </thead>
      <tbody>
         @forelse ($requisicao->itens->sortBy('numero') as $item)
         <tr>
            <td align="center" class="center">{{$item->numero}}</td>
            <td align="justify" class="justificado">@php print($item->descricaoCompleta) @endphp</td>
            <td align="center" class="center">{{$item->codigo =='0'?'': $item->codigo}}</td>
            <td align="center" class="center">{{$item->unidade->nome}}</td>
            <td align="center" class="center">{{$item->quantidade}}</td>
            <td align="center" class="center">{{$item->valorMedio}}</td>
            <td align="center" class="center">{{$item->valorTotal}}</td>
         </tr>
         @empty
         <tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
         @endforelse
         <tr>
            <td align="right" colspan="5"><font size="4"><b>TOTAL GERAL: </b></font></td>
            <td align="center" colspan="2"><font size="4"><b>R$ {{$requisicao->valorTotal}}</b></font></td>
         </tr>
      </tbody>
   </table>

   <br/>
   <table width='100%' border="1" cellspacing="0" cellpadding="2">
      <tr bgcolor="#F5F5F5">
         <th><center>INFORMAÇÕES GERENCIAIS</center></th>
      </tr>
      <tr>
         <td><b>Grau de prioridade:</b>&nbsp;
            @if($requisicao->prioridade == 1)
               Alta
            @elseif($requisicao->tipo == 2)
               Média
            @elseif($requisicao->tipo == 1)
               Baixa
            @endif
         </td>
      </tr>
      <tr>
         <td>
            <b>Data estimada da necessidade:</b>&nbsp;
            {{$requisicao->previsao}}
         </td>
      </tr>
      <tr>
         <td><b>Código(s) da(s) meta(s) no PMI:</b>&nbsp;{{$requisicao->metas}}</td>
      </tr>
      <tr>
         <td><b>Necessidade registrada no PAC?:</b>&nbsp;
            @if($requisicao->pac == 1)
               Sim
            @else
               Não
            @endif
         </td>
      </tr>
      <tr>
         <td><b>Renovação de contrato?</b>&nbsp;
            @if($requisicao->renovacao == 1)
               Sim
            @else
               Não
            @endif
         </td>
      </tr>
      <tr>
         <td><b>Necessita capacitação de servidor?</b>&nbsp;
            @if($requisicao->capacitacao == 1)
               Sim
            @else
               Não
            @endif
         </td>
      </tr>
   </table> 

   <br/>
   <table width='100%' border="1" cellspacing="0" cellpadding="1">
      <tr bgcolor="#F5F5F5" >
         <th><center>JUSTIFICATIVA DA CONTRATAÇÃO</center></th>
      </tr>
      <tr>
         <td>{{$requisicao->justificativa}}</td>
      </tr>
   </table> 
   
   <br/>
@else   
   <table align="center"><tr><td><font size="3"><i> Requisição Não Encontrada </i></font></td></tr></table>
@endif
</body>
</html>
