@extends('site.layouts.index')

@section('content')
<div class="flex">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
         <li class="breadcrumb-item"><a href="{{route('.home')}}">Home</a></li>
         <li class="breadcrumb-item"><a href="{{route('requisicao.index')}}">Requisicões</a></li>
         <li class="breadcrumb-item"><a href="{{route('requisicao.show',  $requisicao->uuid)}}">Requisicao nº {{$requisicao->ordem ?? '' }}</a></li>
         <li class="breadcrumb-item active" aria-current="page">relação de itens</li>
      </ol>
   </nav>
   <h1 Class="page-header page-title">Relação de itens da requisição</h1>
</div>

<div class="panel panel-default">
   <div class="panel-heading">
      <div class="row">
         <div class="col-md-12">
            <h3>
               <i class="fa fa-shopping-cart "></i>
               Requisição n° {{$requisicao->ordem ?? '' }}
            </h3>
            <p><label> Objeto:</label> {{$requisicao->descricao ?? ''}}</p>
         </div>
      </div><!-- / row -->
   </div><!-- / panel-heading -->
</div>


      <div class="text-center panel panel-default">
         <h4 class="font-weight-bold">TOTAL GERAL R$ {{$requisicao->valorTotal}}</h4>
      </div>

      <div class="table-responsive div-tabela">
         <table class="table table-striped table-bordered table-tabela">
            <thead style="background-color: #f5f5f5;">
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


      <div class="row p-2">
         @include('form.button', [
         'value' => 'Voltar',
         'largura'   => 3,
         'class'     => 'btn btn-primary btn-block',
         'url'       =>    route('requisicao.show',$item->requisicao->uuid),
         'recuo'  => 3 ])

         <div class="col-md-3">
            <a class="btn btn-default btn-block" type="button" href="{{url('contratacao/pdf', $item->requisicao->uuid)}}" role="button" target="_black">
               Exportar PDF
            </a> 
         </div>
      </div>

@endsection