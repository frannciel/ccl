@extends('site.layouts.index')

@section('content')
   <h2 align="center">Relação de Itens da Requisição</h2>
   <br/>
   @if (count($requisicao->itens) > 0)
      <table bgcolor="#f0f0f5"  width='100%' align="center" frame=box>
         <tr>
            <td width="10%" align="right"><h4>Objeto:</h4> </td>
            <td align="left">{{$requisicao->descricao}}</td>
         </tr>
      </table> 
      <br/>
      <div id="pesquisa">
         <table class="table table-striped table-bordered w-10">
            <thead>
               <tr>
                  <th width="10%" align="center" class="center">Item</th>
                  <th width="40%" align="center" class="center">Descrição Detalhada</th>
                  <th width="10%" align="center" class="center">Código</th>
                  <th width="10%" align="center" class="center">Unidade</th>
                  <th width="10%" align="center" class="center">Quantidade</th>
                  <th width="10%" align="center" class="center">Valor Unitário</th>
                  <th width="10%" align="center" class="center">Valor Total</th>
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
               <tr>
                  <td align="right" colspan="6">TOTAL GERAL</td>
                  <td align="center">{{$requisicao->valorTotal}}</td>
               </tr>
            </tbody>
         </table>
      </div>

      <div class="row  mt-2">
         <div class="col-md-6 col-md-offset-3">
            <button class='btn btn-block btn-success' data-clipboard-action='copy' data-clipboard-target='#pesquisa'>COPIAR RELATÓRIO</button>
         </div>
      </div>
   @else   
      <table align="center"><tr><td><font size="3"><i> Requisição Não Encontrada </i></font></td></tr></table>
   @endif
@endsection