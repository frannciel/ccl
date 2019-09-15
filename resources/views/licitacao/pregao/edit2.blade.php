@extends('layouts.index')

@section('content')
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Novo Pregão</h1>
		</div>
	</div>

	{{ Form::open(['url' => 'pregao/store', 'method' => 'post', 'class' => 'form-padrao']) }}
		<div class="row">
			@include('form.select', [
			'input' => 'tipo', 
			'label' => 'Tipo', 
			'selected' => old($input ?? '') ?? '', 
			'largura' => 3,
			'options' => ['1' => 'Pregão', '2' => 'Dispensa', '3' => 'Inexigibilidade', '4' => 'Concorrência', '5' => 'Tomada de Preços'],
			'attributes' => ['id' => 'tipo']])

			@include('form.number', [
			'input' => 'numero',
			'label' => 'Número*', 
			'largura' => 4,
			'value' =>' $requisicao->numero',
			'attributes' => ['id' => 'numero', 'required' => '']])

			@include('form.number', [
			'input' => 'ano',
			'label' => 'Ano*', 
			'largura' => 4,
			'value' => '$requisicao->ano',
			'attributes' => ['id' => 'ano', 'required' => '']])

			@include('form.text', [
			'input' => 'processo',
			'label' => 'Processo*',
			'value' => old($input ?? ''),
			'largura' => 4, 
			'attributes' => ['id' => 'processo', 'required' => '']])
		</div>

	   	<div class="row">
	   		@include('form.radioButton', [
			'input' => 'srp',
			'label' => 'Registro de Preços*',
			'value' => old($input ?? ''),
			'largura' => 3, 
			'options' => ['1' => 'SIM', '2' => 'NÃO',], 
			'attributes' => ['id' => 'srp', 'required' => '']])

			@include('form.radioButton', [
			'input' => 'forma', 
			'label' => 'Forma*', 
			'selected' => old($input ?? '') ?? '', 
			'largura' => 3,
			'options' => $formas ?? '', 
			'attributes' => ['id' => 'forma', 'required' => '']])

			@include('form.select', [
			'input' => 'tipo', 
			'label' => 'Tipo*', 
			'selected' => old($input ?? '') ?? '3', 
			'largura' => 3,
			'options' => $tipos ?? '', 
			'attributes' => ['id' => 'tipo', 'readonly' => '']])

			@include('form.text', [
			'input' => 'processoOrigem',
			'label' => 'Processo Original',
			'value' => old($input ?? ''),
			'largura' => 3, 
			'attributes' => ['id' => 'processoOrigem', 'placeholder' => 'Processo Externo']])
		</div>

		<div class="row">
			@include('form.text', [
			'input' => 'objeto',
			'label' => 'Objeto*',
			'value' => old($input ?? ''),
			'largura' => 12, 
			'attributes' => ['id' => 'objeto', 'required' => '']])
	    </div>

		<div class="row">
			@include('form.submit', [
			'input' => 'Salvar', 
			'largura' => 6,
			'recuo' => 3])
		</div>
	{{ Form::close() }} 
@endsection

 