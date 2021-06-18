@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Novo Participante</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			Requisição: {{$item->requisicao->numero}} / {{$item->requisicao->ano}}
			<br />
			Objeto: {{$item->requisicao->descricao}} 
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			Item: {{$item->numero}}
			<br />
			Objeto: {{$item->descricao}} 
		</div>
	</div>

	{{Form::open(['url' => 'participante/store', 'method' => 'post', 'class' => 'form-padrao'])}}
		{{ Form::hidden('item', $item->id)}}
		<div class="row">
			@include('form.number', [
			'input' => 'uasg',
			'label' => 'Código Uasg',			
			'largura' => 3, 
			'value' => old($input ?? '') ,
			'attributes' => ['id' => 'uasg', 'required' => '' ]])

			@include('form.text', [
			'input' => 'nome',
			'label' => 'Nome da Uasg', 
			'largura' => 9, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'nome' ]])
		</div>
		
		<div class="row">
			@include('form.text', [
			'input' => 'cidade',
			'label' => 'Local de Entrega',
			'largura' => 6, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'cidade', 'required' => '']])

			@include('form.select', [
			'input' => 'estado',
			'label' => 'Estado',
			'largura' => 3,
			'selected' => old($input ?? ''),
			'options' => $estados ?? '',
			'attributes' => ['id' => 'estado', 'required' => '']])

			@include('form.number', [
			'input' => 'quantidade',
			'label' => 'Quantidade',
			'largura' => 3, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'quantidade', 'required' => '']])
		</div>
		
		<div class="row">
			@include('form.submit', [
			'input' => 'Cadastrar',
			'largura' => 6,
			'recuo' => 3 ])
		</div>	
	{{Form::close()}} 
</div>
@endsection

 