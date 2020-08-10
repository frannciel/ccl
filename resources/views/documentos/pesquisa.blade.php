@extends('layouts.index')

@section('content')
<h2 align="center">SOLICITAÇÃO DE PESQUISA DE PREÇOS</h2>
<br/>
<div id="pesquisa">
   <table bgcolor="#333"  width='100%' align="center" frame="box">
      <tr>
         <td><label>REQUISIÇÃO:</label></td>
         <td>{{$requisicao->ordem}}</td>
      </tr>
      <tr>
         <td><label>SOLICITANTE:</label></td>
         <td>{{$requisicao->requisitante->nome}}</td>
      </tr>
      <tr>
         <td><label>RAMAL:</label></td>
         <td>{{$requisicao->requisitante->ramal}}</td>
      </tr>
      <tr>
         <td><label>E-MAIL:</label></td>
         <td>{{$requisicao->requisitante->email}}</td>
      </tr>
      <tr>
         <td><label>OBJETO:</label></td>
         <td>{{$requisicao->descricao}}</td>
      </tr>
   </table> 
   <br/>

   <table class="table table-striped table-bordered w-10">
      <thead>
         <tr>
            <th align="center" class="center">Item</th>
            <th align="center" class="center">Descrição detalhada dos materiais ou serviços</th>
            <th align="center" class="center">Código</th>
            <th align="center" class="center">Unidade</th>
            <th align="center" class="center">Quantidade</th>
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
         </tr>
         @empty
         <tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
         @endforelse
      </tbody>
   </table>
   <br/>
   <br/>
</div> 

<div class="row">
   <div class="col-md-3 col-md-offset-1">
      <a class="btn btn-primary btn-block" type="button" href="{{url('requisicao/exibir', $item->requisicao->uuid)}}" >Voltar</a>
   </div>
   <div class="col-md-3">
      <button class='btn btn-block btn-success' data-clipboard-action='copy' data-clipboard-target='#pesquisa'>Copiar </button>
   </div>
   <div class="col-md-3">
      <a class="btn btn-default btn-block" type="button" href="{{url('requisicao/pesquisa/pdf', $item->requisicao->uuid)}}" role="button" target="_black">
         Exportar PDF
      </a> 
   </div>
</div>
@endsection