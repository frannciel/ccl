@extends('layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Alterar Fornecedor</h1>
		</div>
	</div>

	{{Form::open(['url' => '/fornecedor/update', 'method' => 'post', 'class' => 'form-padrao'])}}
      	{{ Form::hidden('fornecedor', $fornecedor->id)}}
		<div class="row">
			@include('form.text', [
			'input' => 'cpf_cnpj',
			'label' => 'CPF/CNPJ',			
			'largura' => 3, 
			'value' => old($input ?? '') ?? $fornecedor->cpf_cnpj ?? '',
			'attributes' => ['id' => 'cpf_cnpj', 'required' => '' ]])

			@include('form.text', [
			'input' => 'razao_social',
			'label' => 'Razão Social', 
			'largura' => 9, 
			'value' => old($input ?? '') ?? $fornecedor->razao_social ?? '',
			'attributes' => ['id' => 'razao_social' ]])
		</div>
	   
		<div class="row">
			@include('form.textButton', [
			'input' => 'cep',
			'label' => 'CEP',
			'largura' => 4, 
			'value' => old($input ?? '')  ?? $fornecedor->cep ?? '',
			'attributes' => ['id' => 'cep', 'required' => '', 'placeholder' => 'Buscar...']])

			@include('form.text', [
			'input' => 'endereco',
			'label' => 'Endereço',
			'largura' => 8, 
			'value' => old($input ?? '') ?? $fornecedor->endereco ?? '',
			'attributes' => ['id' => 'endereco', 'required' => '']])
		</div>
	   
		<div class="row">
			@include('form.text', [
			'input' => 'cidade',
			'label' => 'Cidade',
			'largura' => 6, 
			'value' => old($input ?? '') ?? $fornecedor->cidade->nome ?? '',
			'attributes' => ['id' => 'cidade', 'required' => '']])

			@include('form.select', [
			'input' => 'estado',
			'label' => 'Estado',
			'largura' => 3, 
			'selected' => old($input ?? '') ?? $fornecedor->cidade->estado->id ?? '',
			'options' => $estados ?? '',
			'attributes' => ['id' => 'estado', 'required' => '']])

			@include('form.text', [
			'input' => 'telefone',
			'label' => 'Telefone',
			'largura' => 3, 
			'value' => old($input ?? '')  ?? $fornecedor->telefone ?? '',
			'attributes' => ['id' => 'telefone', 'required' => '']])
		</div>
	   
		<div class="row">
			@include('form.text', [
			'input' => 'email',
			'label' => 'Email',
			'largura' => 6, 
			'value' => old($input ?? '') ?? $fornecedor->email ?? '',
			'attributes' => ['id' => 'email', 'required' => '']])
			
			@include('form.text', [
			'input' => 'representante',
			'label' => 'Representante Legal',
			'largura' => 6, 
			'value' => old($input ?? '') ?? $fornecedor->representante ?? '',
			'attributes' => ['id' => 'representante', 'required' => '']])
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
