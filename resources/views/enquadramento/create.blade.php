@extends('layouts.index')

@section('content')

<div  style="padding: 20px;">
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Enquadramento de Material ou Serviço</h1>
		</div>
	</div>

	{{ Form::open(['url' => 'enquadramento/store', 'method' => 'POST', 'class' => 'form-padrao']) }}
		<div class="row">
			@include('form.text', [
			'input' => 'processo', 
			'label' => 'Processo Administrativo:', 
			'largura' => '6', 
			'attributes' => ['id' => 'processo', 'required' => '', 'class' => 'form-control form-control-sm', 'value' => '{{ old($input) }}', 'autocomplete' => 'off' ]
			])

			@include('form.text', [
			'input' => 'numero', 
			'label' => 'Número Ano:', 
			'largura' => '6', 
			'attributes' => ['id' => 'numero',  'class' => 'form-control form-control-sm', 'value' => '{{ old($input) }}', 'autocomplete' => 'off']
			])
		</div>

		<div class="row">
			@include('form.text', [
			'input' => 'descricao', 
			'label' => 'Objeto da Contratação:', 
			'largura' => '12', 
			'attributes' => ['id' => 'descricao', 'required' => '', 'class' => 'form-control form-control-sm', 'value' => '{{ old($input) }}' ]
			])
		</div>

		<div class="row">
			@include('form.text', [
			'input' => 'valor', 
			'label' => 'Valor Máximo:', 
			'largura' => '4', 
			'attributes' => ['id' => 'valor', 'required' => '', 'class' => 'form-control form-control-sm', 'value' => '{{ old($input) }}', 'autocomplete' => 'off' ]
			])

			@include('form.select', [
			'input' => 'objeto', 
			'label' => 'Classificação do Contratação:', 
			'largura' => '4', 
			'selected' => '{{ old($input) }}', 
			'options' => $classificacoes,
			'attributes' => ['id' => 'objeto', 'class' => 'form-control form-control-sm']])

			@include('form.select', [
			'input' => 'normativa', 
			'label' => 'Fundamentação Legal:', 
			'largura' => '4', 
			'selected' => '{{ old($input) }}', 
			'options' => $normativas,
			'attributes' => ['id' => 'normativa', 'class' => 'form-control form-control-sm', 'onchange' => 'enviar(name)']])
		</div>

		<div class="row">
			<div  id="conteudo"></div>
			<div id="complemento"></div>
		</div>

		<div class="row">
			@include('form.submit', [
			'input' => 'Cadastrar', 
			'largura' => '6', 
			'recuo' => 3,
			'attributes' => ['class' => 'btn btn-success btn-block']])
		</div>	
	{{ Form::close() }} 
</div>
@endsection