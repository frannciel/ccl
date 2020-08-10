@extends('layouts.index')

@section('content')
<div class="panel panel-default mt-4">
   <div class="panel-heading">
      <div class="row">
         <div class="col-md-12 text-center">
            <h2 class="center">RELAÇÃO DE ITENS DA REQUISIÇÃO</h2>
         </div>
      </div><!-- / row -->

      <div class="row">
         <div class="col-md-12">
            <h3>
               <span class="glyphicon glyphicon-link" aria-hidden="true"></span>
               <a href="{{route('requisicaoExibir', [$requisicao->uuid])}}">Requisição n° {{$requisicao->ordem ?? '' }}</a>
            </h3>
            <p><label> Objeto:</label> {{$requisicao->descricao ?? ''}}</p>
         </div>
      </div><!-- / row -->
   </div><!-- / panel-heading -->

   <div class="panel-body">
      <div class="text-center panel panel-default">
         <h4 class="font-weight-bold">TOTAL GERAL R$ {{$requisicao->valorTotal}}</h4>
      </div>

      <div class="table-responsive div-tabela">
         <table class="table table-striped table-tabela">
            <thead>
               <tr>
                  <th width="10%" align="center" class="center th-tabela">Item</th>
                  <th width="40%" align="center" class="center th-tabela">Descrição Detalhada</th>
                  <th width="10%" align="center" class="center th-tabela">Código</th>
                  <th width="10%" align="center" class="center th-tabela">Unidade</th>
                  <th width="10%" align="center" class="center th-tabela">Quantidade</th>
                  <th width="10%" align="center" class="center th-tabela">Valor</th>
                  <th width="10%" align="center" class="center th-tabela">Total</th>
               </tr>
            </thead>
            <tbody>
               @forelse ($requisicao->itens->sortBy('numero') as $item)
               <tr>
                  <td align="center" class="center">{{$item->numero}}</td>
                  <td align="center" class="justificado">@php print($item->descricaoCompleta) @endphp</td>
                  <td align="center" class="center">{{$item->codigo =='0'?'': $item->codigo}}</td>
                  <td align="center" class="center">{{$item->unidade->nome}}</td>
                  <td align="center" class="center">{{$item->quantidade}}</td>
                  <td align="center" class="center">{{$item->valorMedio}}</td>
                  <td align="center" class="center">{{$item->valorTotal}}</td>
               </tr>
               @empty
               <tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
               @endforelse
            </tbody>
         </table>
      </div>
   </div>

   <div class="panel-footer">

      <div class="row p-2">
         @include('form.button', [
         'value' => 'Voltar',
         'largura'   => 3,
         'class'     => 'btn btn-primary btn-block',
         'url'       =>    route('requisicaoExibir',[$item->requisicao->uuid]),
         'recuo'  => 3 ])

         <div class="col-md-3">
            <a class="btn btn-default btn-block" type="button" href="{{url('contratacao/pdf', $item->requisicao->uuid)}}" role="button" target="_black">
               Exportar PDF
            </a> 
         </div>
      </div>
   </div>
</div>
@endsection