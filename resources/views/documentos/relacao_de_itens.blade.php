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
                  <th align="center" class="center">Local Entrega</th>
                  <th align="center" class="center">Quantidade</th>
                  <th align="center" class="center">Quantidade Total</th>
                  <th align="center" class="center">Valor Unitário</th>
                  <th align="center" class="center">Valor Total</th>
               </tr>
            </thead>
            <tbody>
                  @foreach ($licitacao->itens->sortBy('ordem') as $item)
                        @if($item->participantes()->exists())
                           @if($item->quantidade > 0)
                              @php $qtd = $item->participantes()->count()+1; @endphp
                              <tr>
                                 <td align="center" class="center" rowspan="{{$qtd}}">{{$item->ordem}}</td>
                                 <td align="justify" class="justificado" rowspan="{{$qtd}}">
                                    @php print($item->descricaoCompleta) @endphp
                                 </td>
                                 <td align="center" class="center" rowspan="{{$qtd}}">{{$item->codigo =='0'?'': $item->codigo}}</td>
                                 <td align="center" class="center" rowspan="{{$qtd}}">{{$item->unidade->nome}}</td>
                                 <td> Eunápolis/BA </td>
                                 <td align="center" class="center">({{$item->quantidade}})</td>
                                 <td align="center" class="center" rowspan="{{$qtd}}">({{$item->quantidadeTotal}})</td>
                                 <td align="center" class="center" rowspan="{{$qtd}}">{{$item->valorMedio}}</td>
                                 <td align="center" class="center" rowspan="{{$qtd}}">{{number_format(number_format($item->media, 2, '.', "") * $item->quantidadeTotal, 2, ',', '.')}}</td>
                              </tr>
                              @foreach($item->participantes as $participante)
                                 <tr>
                                    <td>{{$participante->pivot->cidade->nome }}/{{ $participante->pivot->cidade->estado->sigla}}</td>
                                    <td align="center" class="center">{{$participante->pivot->quantidade}}</td>
                                 </tr>
                              @endforeach
                           @else
                              @php $qtd = $item->participantes()->count(); @endphp
                              <tr>
                                 <td align="center" class="center" rowspan="{{$qtd}}">{{$item->ordem}}</td>
                                 <td align="justify" class="justificado" rowspan="{{$qtd}}">
                                 @php print($item->descricaoCompleta) @endphp
                                 </td>
                                 <td align="center" class="center" rowspan="{{$qtd}}">{{$item->codigo =='0'?'': $item->codigo}}</td>
                                 <td align="center" class="center" rowspan="{{$qtd}}">{{$item->unidade->nome}}</td>
                                 @php $participante = $item->participantes->first()@endphp
                                 <td>{{$participante->pivot->cidade->nome }}/{{ $participante->pivot->cidade->estado->sigla}}</td>
                                 <td align="center" class="center">{{$participante->pivot->quantidade}}</td>
                                 <td align="center" class="center" rowspan="{{$qtd}}">({{$item->quantidadeTotal}})</td>
                                 <td align="center" class="center" rowspan="{{$qtd}}">{{$item->valorMedio}}</td>
                                 <td align="center" class="center" rowspan="{{$qtd}}">{{number_format(number_format($item->media, 2, '.', "") * $item->quantidadeTotal, 2, ',', '.')}}</td>
                              </tr>
                              @for($i = 1; $i < $item->participantes->count(); $i++)
                                 @php $participante = $item->participantes @endphp
                                 <tr>
                                    <td>{{$participante->get($i)->pivot->cidade->nome }}/{{ $participante->get($i)->pivot->cidade->estado->sigla}}</td>
                                    <td align="center" class="center">{{$participante[$i]->pivot->quantidade}}</td>
                                 </tr>
                              @endfor
                           @endif
                        @else
                        <tr>
                           <td align="center" class="center">{{$item->ordem}}</td>
                           <td align="justify" class="justificado">@php print($item->descricaoCompleta) @endphp</td>
                           <td align="center" class="center">{{$item->codigo =='0'?'': $item->codigo}}</td>
                           <td align="center" class="center">{{$item->unidade->nome}}</td>
                           <td> Eunápolis/BA </td>
                           <td align="center" class="center">{{$item->quantidade}}</td>
                           <td align="center" class="center">({{$item->quantidade}})</td>
                           <td align="center" class="center">{{$item->valorMedio}}</td>
                           <td align="center" class="center">{{$item->valorTotal }}</td>
                        </tr>
                        @endif
                     @endforeach
               <tr>
                  <td align="right" colspan="8">TOTAL GERAL</td>
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