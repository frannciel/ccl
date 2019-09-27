@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Novo Item</h1>
		</div>
	</div>

	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Requisição n° <a href="{{route('requisicaoExibir', [$requisicao->uuid])}}">{{$requisicao->numero ?? '' }} / {{$requisicao->ano ?? ''}}</a></h3>
		</div>
		<div class="panel-body">
			<label> Objeto:</label> {{$requisicao->descricao ?? ''}}
		</div>
	</div>

	{{Form::open(['url' => 'item/store', 'method' => 'post', 'class' => 'form-padrao'])}}
		{{ Form::hidden('requisicao', $requisicao->uuid)}}
		<div class="row">
			@include('form.number', [
			'input' => 'quantidade',
			'label' => 'Quantidade',			
			'largura' => 3, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'quantidade', 'required' => '' ]])

			@include('form.number', [
			'input' => 'codigo',
			'label' => 'Código', 
			'largura' => 3, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'codigo' ]])
			
			@include('form.select', [
			'input' => 'unidade', 
			'label' => 'Unidade',
			'largura' => 3,  
			'selected' => old($input ?? ''), 
			'options' => $unidades, 
			'attributes' => ['id' => 'unidade', 'required' => '']])

			@include('form.select', [
			'input' => 'grupo', 
			'label' => 'Grupo', 
			'largura' => 3,  
			'selected' => old($input ?? ''), 
			'options' => $grupos ?? '', 
			'attributes' => ['id' => 'grupo', 'disabled' => '']])
		</div>

		<div class="row">
			@include('form.text', [
			'input' => 'objeto',
			'label' => 'Objeto',
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'objeto', 'required' => '']])
		</div>

		<div class="row">
			@include('form.textarea', [
			'input' => 'descricao', 
			'label' => 'Descricao Detalhada', 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'descricao', 'required' => '' ]])
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

 