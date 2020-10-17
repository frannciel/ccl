@extends('layouts.index')

@section('content')
<style type="text/css">
   b {  font-weight: bold;}
</style>

<div class="panel panel-default mt-4">
   <div class="panel-heading">
      <div class="row">
         <div class="col-md-12 text-center">
            <h2 class="center">RELAÇÃO DE ITENS DA LICITAÇÃO</h2>
         </div><!-- / col-md-12  -->
      </div><!-- / row -->

      <div class="row">
         <div class="col-md-12">
            <h3>
               <span class="glyphicon glyphicon-link" aria-hidden="true"></span>
               <a href="{{route('licitacaoShow', $licitacao->uuid)}}">Licitação n° {{$licitacao->ordem ?? '' }}</a>
            </h3>
            <p><label> Objeto:</label> {{$licitacao->objeto ?? ''}}</p>
         </div><!-- / col-md-12  -->
      </div><!-- / row -->
   </div><!-- / panel-heading -->
</div>
   @if ($licitacao->itens()->exists()) <!-- Verifica se a licitação já contpem itens -->
      <div id="relacao">
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

      <div class="row mt-1">
         <div class="col-md-3 col-md-offset-1">
            <a class="btn btn-primary btn-block" type="button" href="{{url('licitacao/exibir', $licitacao->uuid)}}" >Voltar</a>
         </div>
         <div class="col-md-3">
            <button class='btn btn-block btn-success' data-clipboard-action='copy' data-clipboard-target='#relacao'>Copiar </button>
         </div>
         <div class="col-md-3">
            <a class="btn btn-default btn-block" type="button" href="{{route('licitacaorelacaoDeItemPdf', $licitacao->uuid)}}" role="button" target="_black">
               Exportar PDF
            </a> 
         </div>
      </div>
   @else   
      <table align="center"><tr><td><font size="3"><i> Esta licitação ainda não possui itens!</i></font></td></tr></table>
      <div class="row mt-1">
         <div class="col-md-3 col-md-offset-1">
            <a class="btn btn-primary btn-block" type="button" href="{{url('licitacao/exibir', $licitacao->uuid)}}" >Voltar</a>
         </div>
      </div>
   @endif
@endsection
   <!-- class="table table-striped table-bordered w-10" -->