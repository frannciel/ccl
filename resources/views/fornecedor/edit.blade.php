@extends('layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')

<div class="panel panel-default mt-2">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h1 Class="center">Alterar Fornecedor</h1>
			</div>
		</div>
	</div>

	<div class="panel-body">
		{{Form::open(['url' => '/fornecedor/update', 'method' => 'post', 'class' => 'form-padrao'])}}
	      	{{ Form::hidden('fornecedor', $fornecedor->uuid)}}
			<div class="row">
				@include('form.text', [
				'input' => 'cpf_cnpj',
				'label' => 'CPF ou CNPJ',			
				'largura' => 3, 
				'value' => old($input ?? '') ?? $fornecedor->fornecedorable->cpf ?? $fornecedor->fornecedorable->cnpj,
				'attributes' => ['id' => 'cpf_cnpj', 'required' => '' ]])

				@include('form.text', [
				'input' => 'razao_social',
				'label' => 'Nome ou Razão Social', 
				'largura' => 9, 
				'value' => old($input ?? '') ?? $fornecedor->fornecedorable->nome ?? $fornecedor->fornecedorable->razao_social,
				'attributes' => ['id' => 'razao_social' ]])
			</div>
		   
			<div class="row">
				@include('form.textButton', [
				'input' => 'cep',
				'label' => 'CEP',
				'largura' => 3, 
				'buttonId' => 'buscarCep',
				'value' => old($input ?? '')  ?? $fornecedor->cep ?? '',
				'attributes' => ['id' => 'cep', 'required' => '', 'placeholder' => 'Buscar...']])

				@include('form.select', [
				'input' => 'estado',
				'label' => 'Estado',
				'largura' => 3, 
				'selected' => old($input ?? '') ?? $fornecedor->cidade->estado->sigla ?? '',
				'options' => $estados ?? '',
				'attributes' => ['id' => 'estado', 'required' => '']])

				@include('form.text', [
				'input' => 'cidade',
				'label' => 'Cidade',
				'largura' => 6, 
				'value' => old($input ?? '') ?? $fornecedor->cidade->nome ?? '',
				'attributes' => ['id' => 'cidade', 'required' => '']])
			</div>
		   
			<div class="row">
				@include('form.text', [
				'input' => 'endereco',
				'label' => 'Endereço',
				'largura' => 6, 
				'value' => old($input ?? '') ?? $fornecedor->endereco ?? '',
				'attributes' => ['id' => 'endereco', 'required' => '']])

				@include('form.text', [
				'input' => 'telefone',
				'label' => 'Telefone',
				'largura' => 3, 
				'value' => old($input ?? '')  ?? $fornecedor->telefone_1 ?? '',
				'attributes' => ['id' => 'telefone', 'required' => '']])

				@include('form.text', [
				'input' => 'telefone2',
				'label' => 'Telefone 02',
				'largura' => 3, 
				'value' => old($input ?? '') ?? $fornecedor->telefone_2 ?? '',
				'attributes' => ['id' => 'telefone2', 'placeholder' => 'Opcional...']])
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
				'value' => old($input ?? '') ?? $fornecedor->fornecedorable->representante ?? '',
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
</div>
@endsection
