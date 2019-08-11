@extends('layouts.index')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h1 Class="page-header">Dados da Requisição</h1>
	</div>
</div>

{{ Form::open(['url' => '/requisicao/update', 'method' => 'post', 'class' => 'form-padrao']) }}
	{{ Form::hidden('requisicao', $requisicao->id)}}
	<div class="row">
		@include('form.text', [
		'input' => 'numero',
		'label' => 'Número', 
		'largura' => 3,
		'value' => $requisicao->numero,
		'attributes' => ['id' => 'numero', 'disabled' => '' ]])

		@include('form.text', [
		'input' => 'ano',
		'label' => 'Ano', 
		'largura' => 3,
		'value' => $requisicao->ano,
		'attributes' => ['id' => 'ano', 'disabled' => '']])

		@include('form.select', [
		'input' => 'requisitante', 
		'label' => 'Requisitante', 
		'largura' => 6,
		'selected' => $requisicao->requisitantes, 
		'options' => $requisitantes, 
		'attributes' => ['id' => 'requisitante']])
	</div>

	<div class="row">
		@include('form.text', [
		'input' => 'descricao',
		'label' => 'Objeto', 
		'value' =>  $requisicao->descricao,
		'attributes' => ['id' => 'descricao', 'required' => '', 'autocomplete' => 'off']])
	</div>

	<div class="row">
		@include('form.submit', [
		'input' => 'Salvar', 
		'recuo' => 3,
		'largura' => 6,
		])
	</div>
{{ Form::close() }} 

<div class="row mt-4 p-2">
	<div class="col-md-3 col-6">
		<a href="{{route('itemNovo', ['id' => $requisicao->id])}}" class="btn btn-primary btn-outline btn-block" type="button">
		   	<i class="fa fa-plus fa-3x"></i><br>Incluir Item
		</a>
	</div>
	<div class="col-md-3 col-6">
		<a href="{{route('importarNovo', ['id' => $requisicao->id])}}" class="btn btn-primary btn-outline btn-block" type="button">
		   	<i class="fa fa-upload fa-3x"></i><br>Importar
		</a>
	</div>
	<div class="col-md-3 col-6">
		<a href="{{route('cotacaoNovo', ['id' => $requisicao->id])}}" class="btn btn-primary btn-outline btn-block" type="button">
		   	<i class="fa fa-shopping-cart fa-3x"></i><br>Pesquisa de Preços
		</a>
	</div>
	<div class="col-md-3 col-6">
		<a href="{{route('cotacaoRelatorio', ['id' => $requisicao->id])}}" class="btn btn-primary btn-outline btn-block" type="button">
		   	<i class="fa fa-list-alt fa-3x"></i><br>Relatório de Pesquisa
		</a>
	</div>
	<div class="col-md-3 col-6 mt-2">
		<a href="{{route('documento', ['id' => $requisicao->id])}}" class="btn btn-primary btn-outline btn-block" type="button">
		   	<i class="fa fa-list-alt fa-3x"></i><br>Tabela de Itens
		</a>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<h2 Class="page-header">Relação de Itens</h2>
	</div>
</div>

<table class="w-10">
	<thead>
		<tr>
			<th class="w-1 center">Número</th>
			<th class="w-4 center">Descrição Detalhada</th>
			<th class="w-2 center">Unidade</th>
			<th class="w-1 center">Código</th>
			<th class="w-1 center">Quantidade</th>
			<th class="w-1 center">Grupo</th>
		</tr>
	</thead>
</table>
<div class="row t-body table-responsive">
   <table class="table table-striped table-bordered">
      <tbody>
         @forelse ($requisicao->itens as $item)
         <tr onclick="location.href ='{{route('itemEditar', $item->id)}}'; target='_blank';" style="cursor: hand;">
            <td class="w-1 center">{{$item->numero}}</td>
            <td class="w-4 justicado">@php print($item->descricaoCompleta) @endphp</td>
            <td class="w-2 center">{{$item->unidade->nome}}</td>
            <td class="w-1 center">{{$item->codigo =='0'?'': $item->codigo}}</td>
            <td class="w-1 center">{{$item->quantidade}}</td>
            <td class="w-1 center"></td>
            <!--<td>isset($item->grupo->numero) ? $item->grupo->numero : ''</td>-->
         </tr>
         @empty
         <tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
         @endforelse
      </tbody>
   </table>
</div>
@endsection