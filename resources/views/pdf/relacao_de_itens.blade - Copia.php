<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>CCL_DOD_PDF</title>
   <style type="text/css">
      b {  font-weight: bold;}
      .w25 {
         width: 25%;
         vertical-align: text-top;
      }
      .w45 {
         width: 45%;
      }
      .w35 {
         width: 35%;
      }
      table{
         width: 100%;
         margin-top: 5px;
      }
      .borda th {
         padding-left: 5px;
         text-align: left;
         border: 1px solid #000;
         background: #f5f5f5;
      }
      pre {
         margin-top: 30px;
         margin-bottom: 30px;
         font-weight: bold;
         font-size: large;
         text-decoration: underline;
      }
      .titulo-1 {
         margin-top: 30px;
         margin-bottom: 30px;
         font-weight: bold;
         font-size: large;
         width: 100%;
         background: #bfbfbf;
      }
   </style>;
</head>
<body>
   @include('pdf.cabecalho')
   <h3 align="center">{{strtoupper($licitacao->licitacaoable_type)}} Nº {{$licitacao->ordem ?? ''}} @if ($licitacao->licitacaoable->srp == 1) (SRP) @endif
      <br/>RELAÇÃO DE ITENS
   </h3>

   <div class="titulo-1">1. Objeto da Licitação</div>
   <p>{{$licitacao->objeto ?? ''}}</p>

   @if ($licitacao->itens()->exists()) <!-- Verifica se a licitação já contpem itens -->

         <div class="titulo-1">2. Itens da Licitação</div>   
         @foreach ($licitacao->itens->sortBy('ordem') as $item)
            <table cellspacing="0" cellpadding="1">
               <tr class="borda">
                  <th colspan="2">{{$item->ordem}} - {{$item->objeto}}</th>
               </tr>
               <tr>
                  <td class="w25"><b>Descrição Detalhada:</b></td>
                  <td>@php print($item->descricao) @endphp</td>
               </tr>
             </table>
            <table>
               <tr>
                  <td class="w45"><b>Quantidade Total:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$item->quantidadeTotal}}</td>
                  <td><b>Unidade de Fornecimento:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$item->unidade->nome}}</td>
               </tr>
               <tr>
                  <td><b>Valor Unitário:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$item->valorMedio}}</td>
                  <td><b>Valor Total:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$item->valorTotal}}</td>
               </tr>
            </table>
            <table>
               <tr>
                  <td class="w35"><b>Local de Entrega (Quantidade):</b></td>
                  <td>
                     @if($item->quantidade > 0)
                        Eunápolis/BA ({{$item->quantidade}})
                     @endif
                  </td>
               </tr>
            </table>
         @endforeach
         <div class="titulo-1">3. Requisições Relacionadas</div> 
         <table cellspacing="0" cellpadding="1">
            <tr class="borda">
               <th align="center">Numero</th>
               <th align="center">Descrição da Requisição</th>
               <th align="center">Requisitante</th>
            </tr>
            @foreach($licitacao->requisicoes->sortBy('numero') as $requisicao)
               <tr>
                  <td align="center">{{$requisicao->ordem}}</td>
                  <td>{{$requisicao->descricao}}</td>
                  <td align="center">{{$requisicao->requisitante->sigla}}</td>
               </tr>
            @endforeach
         </table>
         <div class="titulo-1">4. Entidades Participantes</div>   

         <table width='100%' border="1" cellspacing="0" cellpadding="2"  class="table table-striped table-bordered w-10">
            <thead>
               <tr bgcolor="#F5F5F5">
                  <th align="center" class="center">Item</th>
                  <th align="center" class="center" width="50%">Descrição Detalhada</th>
                  <th align="center" class="center">Código</th>
                  <th align="center" class="center">Unidade</th>
                  <th align="center" class="center">Quantidade Total</th>
                  <th align="center" class="center">Valor Unitário</th>
                  <th align="center" class="center">Valor Total</th>
               </tr>
            </thead>
            <tbody>
               @if($participante) <!-- Verifica se a licitação tem participantes-->
                  @foreach ($licitacao->itens->sortBy('ordem') as $item)
                     <tr>
                        <td align="center" class="center">{{$item->ordem}}</td>
                        <td align="justify" class="justificado">
                           @php print($item->descricaoCompleta) @endphp
                           <p>
                              <b><br/> Local de entrega (Quantidade):</b>
                              @if($item->quantidade > 0)
                              Eunápolis/BA ({{$item->quantidade}})
                              @endif
                             
                              @if($item->participantes()->exists())
                                 @foreach($item->participantes as $participante)
                                  {{ $participante->pivot->cidade->nome }}/{{ $participante->pivot->cidade->estado->sigla}}
                                  ({{$participante->pivot->quantidade}})
                                 @endforeach
                              @endif
                           </p>
                        </td>
                        <td align="center" class="center">{{$item->codigo =='0'?'': $item->codigo}}</td>
                        <td align="center" class="center">{{$item->unidade->nome}}</td>
                        <td align="center" class="center">{{$item->quantidadeTotal}}</td>
                        <td align="center" class="center">{{$item->valorMedio}}</td>
                        <td align="center" class="center">{{number_format($item->media * $item->quantidadeTotal, 2, ',', '.')}}</td>
                     </tr>
                  @endforeach
               @else
                  @foreach ($licitacao->itens->sortBy('ordem') as $item)
                        <tr>
                           <td align="center" class="center">{{$item->ordem}}</td>
                           <td align="justify" class="justificado">
                              @php print($item->descricaoCompleta) @endphp
                           </td>
                           <td align="center" class="center">{{$item->codigo =='0'?'': $item->codigo}}</td>
                           <td align="center" class="center">{{$item->unidade->nome}}</td>
                           <td align="center" class="center">{{$item->quantidade}}</td>
                           <td align="center" class="center">{{$item->valorMedio}}</td>
                           <td align="center" class="center">{{$item->valorTotal }}</td>
                        </tr>
                  @endforeach
               @endif
               <tr>
                  <td align="right" colspan="6">TOTAL GERAL</td>
                  <td align="center">{{$licitacao->valorTotalEstimado}}</td>
               </tr>
            </tbody>
         </table>

         <br/>
      </div>
   @else   
      <table align="center"><tr><td><font size="3"><i> Esta licitação ainda não possui itens!</i></font></td></tr></table>
   @endif
   </body>
</html>
