@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Novo Fornecedor</h1>
		</div>
	</div>

	{{Form::open(['url' => 'fornecedor/store', 'method' => 'post', 'class' => 'form-padrao'])}}
		<div class="row">
			@include('form.text', [
			'input' => 'cpf_cnpj',
			'label' => 'CPF/CNPJ',			
			'largura' => 3, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'cpf_cnpj', 'required' => '' ]])

			@include('form.text', [
			'input' => 'razaosocial',
			'label' => 'Razão Social', 
			'largura' => 9, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'razao_social' ]])
		</div>
	   
		<div class="row">

			@include('form.textButton', [
			'input' => 'cep',
			'label' => 'CEP',
			'largura' => 4, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'cep', 'required' => '', 'placeholder' => 'Buscar...']])

			@include('form.text', [
			'input' => 'endereco',
			'label' => 'Endereço',
			'largura' => 8, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'endereco', 'required' => '']])
		</div>
	   
		<div class="row">
			@include('form.text', [
			'input' => 'cidade',
			'label' => 'Cidade',
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

			@include('form.text', [
			'input' => 'telefone',
			'label' => 'Telefone',
			'largura' => 3, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'telefone', 'required' => '']])
		</div>
	   
		<div class="row">
			@include('form.text', [
			'input' => 'email',
			'label' => 'Email',
			'largura' => 6, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'email', 'required' => '']])
			
			@include('form.text', [
			'input' => 'representante',
			'label' => 'Representante Legal',
			'largura' => 6, 
			'value' => old($input ?? ''),
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

 