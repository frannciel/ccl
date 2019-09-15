@extends('layouts.index')

@section('content')
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Incluir Contratação</h1>
		</div>
	</div>

	{{ Form::open(['url' => 'licitacao/store', 'method' => 'post', 'class' => 'form-padrao']) }}
		<div class="row">
			@include('form.select', [
			'input' => 'modalidade', 
			'label' => 'Modalidade da Contratação', 
			'selected' => old($input ?? '') ?? '', 
			'largura' => 4,
			'options' => $modalidades ?? '',
			'attributes' => ['id' => 'modalidade', 'required' => '']])

			@include('form.number', [
			'input' => 'numero',
			'label' => 'Número*', 
			'largura' => 3,
			'value' => old($input ?? '') ?? '',
			'attributes' => ['id' => 'numero', 'required' => '']])

			@include('form.number', [
			'input' => 'ano',
			'label' => 'Ano*', 
			'largura' => 3,
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'ano', 'required' => '']])
		</div>

		<div class="row">
			@include('form.text', [
			'input' => 'processo',
			'label' => 'Processo*',
			'value' => old($input ?? ''),
			'largura' => 4, 
			'attributes' => ['id' => 'processo', 'required' => '']])

			@include('form.text', [
			'input' => 'processoOrigem',
			'label' => 'Processo Original',
			'value' => old($input ?? ''),
			'largura' => 4, 
			'attributes' => ['id' => 'processoOrigem', 'placeholder' => 'Processo Externo']])
		</div>

	   	<div id="adicioanis"></div>

		<div class="row">
			@include('form.textarea', [
			'input' => 'objeto',
			'label' => 'Objeto*',
			'value' => old($input ?? ''),
			'largura' => 10, 
			'attributes' => ['id' => 'objeto', 'required' => '',  'rows'=>'5']])
	    </div>

		<div class="row">
			@include('form.submit', [
			'input' => 'Salvar', 
			'largura' => 6,
			'recuo' => 3])
		</div>
	{{ Form::close() }} 
@endsection