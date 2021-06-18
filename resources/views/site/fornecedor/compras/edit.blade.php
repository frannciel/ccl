@extends('site.layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')

	<div class="flex">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item"><a href="{{route('fornecedor.index')}}">Fornecedor</a></li>
				<li class="breadcrumb-item active" aria-current="page">Alterar</li>
			</ol>
		</nav>
		<h1 Class="page-header page-title">Alterar ou excluir fornecedor</h1>
	</div>

	{{Form::open(['route' => ['fornecedor.update', $fornecedor->uuid], 'method' => 'post', 'class' => 'form-padrao'])}}
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
			'input' => 'telefone1',
			'label' => 'Telefone 01',
			'largura' => 3, 
			'value' => old($input ?? '')  ?? $fornecedor->telefone_1 ?? '',
			'attributes' => ['id' => 'telefone1', 'required' => '', 'class' => 'form-control form-control-sm telefone']])

			@include('form.text', [
			'input' => 'telefone2',
			'label' => 'Telefone 02',
			'largura' => 3, 
			'value' => old($input ?? '') ?? $fornecedor->telefone_2 ?? '',
			'attributes' => ['id' => 'telefone2', 'placeholder' => 'Opcional...', 'class' => 'form-control form-control-sm telefone']])

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
	   
		<div class="row mt-2">
			@include('form.button', [
			'value' => 'Voltar',
			'largura' 	=> 3,
			'class'		=> 'btn btn-primary btn-block',
			'url' 		=> 	route('fornecedor.index'),
			'recuo' 	=> 3 ])

			@include('form.submit', [
			'input' => 'Salvar',
			'largura' => 3 ])
		</div>
	{{Form::close()}} 

@endsection
