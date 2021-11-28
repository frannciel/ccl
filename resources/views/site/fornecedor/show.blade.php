@extends('site.layouts.index')

@section('content')

	<div class="flex">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item"><a href="{{route('fornecedor.index')}}">Fornecedor</a></li>
				<li class="breadcrumb-item active" aria-current="page">Novo</li>
			</ol>
		</nav>
		<h1 Class="page-header page-title">Dados do fornecedor</h1>
	</div>

	<div class="row">
		@include('form.text', [
		'input' => 'cpf_cnpj',
		'label' => 'CPF ou CNPJ',			
		'largura' => 3, 
		'value' => old($input ?? '') ?? $fornecedor->fornecedorable->cpf ?? $fornecedor->fornecedorable->cnpj,
		'attributes' => ['id' => 'cpf_cnpj' ]])

		@include('form.text', [
		'input' => 'razaoSocial',
		'label' => 'Nome ou Razão Social', 
		'largura' => 9, 
		'value' => old($input ?? '') ?? $fornecedor->fornecedorable->nome ?? $fornecedor->fornecedorable->razao_social,
		'attributes' => ['id' => 'razaoSocial'  ]])
	</div><!-- / row-->
	
	<div class="row">
		@include('form.text', [
		'input' => 'cep',
		'label' => 'CEP',
		'largura' => 3, 
		'value' => old($input ?? '')  ?? $fornecedor->cep ?? '',
		'attributes' => ['id' => 'cep']])

		@include('form.text', [
		'input' => 'estado',
		'label' => 'Estado',
		'largura' => 3, 
		'selected' => old($input ?? '') ?? $fornecedor->cidade->estado->sigla ?? '',
		'attributes' => ['id' => 'estado' ]])
		
		@include('form.text', [
		'input' => 'cidade',
		'label' => 'Cidade',
		'largura' => 6, 
		'class' => 'telefone',
		'value' => old($input ?? '') ?? $fornecedor->cidade->nome ?? '',
		'attributes' => ['id' => 'cidade' ]])
	</div><!-- / row-->
	
	<div class="row">
		@include('form.text', [
		'input' => 'endereco',
		'label' => 'Endereço',
		'largura' => 6, 
		'value' => old($input ?? '') ?? $fornecedor->endereco ?? '',
		'attributes' => ['id' => 'endereco']])

		@include('form.text', [
		'input' => 'telefone1',
		'label' => 'Telefone 01',
		'largura' => 3, 
		'value' => old($input ?? '')  ?? $fornecedor->telefone_1 ?? '',
		'attributes' => ['id' => 'telefone1', 'class' => 'form-control form-control-sm telefone']])

		@include('form.text', [
		'input' => 'telefone2',
		'label' => 'Telefone 02',
		'largura' => 3, 
		'value' => old($input ?? '') ?? $fornecedor->telefone_2 ?? '',
		'attributes' => ['id' => 'telefone2', 'placeholder' => 'Opcional...', 'class' => 'form-control form-control-sm telefone']])
	</div><!-- / row-->
	
	<div class="row">
		@include('form.text', [
		'input' => 'email',
		'label' => 'Email',
		'largura' => 6, 
		'value' => old($input ?? '') ?? $fornecedor->email ?? '',
		'attributes' => ['id' => 'email']])
		
		@include('form.text', [
		'input' => 'representante',
		'label' => 'Representante Legal',
		'largura' => 6, 
		'value' => old($input ?? '') ?? $fornecedor->fornecedorable->representante ?? '',
		'attributes' => ['id' => 'representante', 'placeholder' => 'Apanas pessoa jurídica.']])
	</div><!-- / row-->
	
	<div class="row mt-2">
		@include('form.button', [
		'value' => 'Voltar',
		'largura' 	=> 3,
		'class'		=> 'btn btn-primary btn-block',
		'url' 		=> 	route('fornecedor.index'),
		'recuo' 	=> 3 ])

	</div>	<!-- / row-->
@endsection

 