@extends('layouts.index')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Incluir Pregão</h1>
		</div>
	</div>

	{{ Form::open(['url' => 'pregao/store', 'method' => 'post', 'class' => 'form-padrao']) }}
		@include('licitacao.forms.licitacao_create')

		<div class="row">
			@include('form.radioButton', [
			'input' => 'forma', 
			'label' => 'Forma*', 
			'selected' => old($input ?? '') ?? '', 
			'largura' => 3,
			'options' => $formas ?? '', 
			'attributes' => ['id' => 'forma', 'required' => '']])

			@include('form.radioButton', [
			'input' => 'srp',
			'label' => 'Registro de Preços*',
			'value' => old($input ?? ''),
			'largura' => 3, 
			'options' => ['1' => 'SIM', '2' => 'NÃO',], 
			'attributes' => ['id' => 'srp', 'required' => '']])

			@include('form.radioButton', [
			'input' => 'srp_externo',
			'label' => 'Adesão/Participação',
			'value' => old($input ?? ''),
			'largura' => 3, 
			'options' => ['1' => 'Carona', '2' => 'Participante',], 
			'attributes' => ['id' => 'srp_externo']])

			@include('form.select', [
			'input' => 'tipo', 
			'label' => 'Tipo', 
			'selected' => old($input ?? '') ?? '3', 
			'largura' => 3,
			'options' => $tipos ?? '', 
			'attributes' => ['id' => 'tipo', 'readonly' => '']])
		</div>

		@include('licitacao.forms.objeto_create')
	{{ Form::close() }} 
@endsection