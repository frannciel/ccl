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
		<h1 Class="page-header page-title">Cadastrar fornecedor</h1>
	</div>


	{{Form::open(['route' => 'fornecedor.store', 'method' => 'post', 'class' => 'form-padrao'])}}
		<div class="row">
			@include('form.text', [
			'input' => 'cpf_cnpj',
			'label' => 'CPF ou CNPJ *',			
			'largura' => 3, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'cpf_cnpj', 'required' => '' ]])

			@include('form.text', [
			'input' => 'razaoSocial',
			'label' => 'Nome ou Razão Social *', 
			'largura' => 9, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'razaoSocial', 'required' => '' ]])
		</div><!-- / row-->
	   
		<div class="row">
			@include('form.textButton', [
			'input' => 'cep',
			'label' => 'CEP *',
			'largura' => 3, 
			'buttonId' => 'buscarCep',
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'cep', 'required' => '', 'placeholder' => 'Buscar...']])

			@include('form.select', [
			'input' => 'estado',
			'label' => 'Estado *',
			'largura' => 3, 
			'selected' => old($input ?? ''),
			'options' => $estados ?? '',
			'attributes' => ['id' => 'estado', 'required' => '']])
			
			@include('form.text', [
			'input' => 'cidade',
			'label' => 'Cidade *',
			'largura' => 6, 
			'class' => 'telefone',
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'cidade', 'required' => '']])
		</div><!-- / row-->
	   
		<div class="row">
			@include('form.text', [
			'input' => 'endereco',
			'label' => 'Endereço *',
			'largura' => 6, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'endereco', 'required' => '',]])

			@include('form.text', [
			'input' => 'telefone1',
			'label' => 'Telefone 01 *',
			'largura' => 3, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'telefone1', 'required' => '', 'class' => 'form-control form-control-sm telefone']])

			@include('form.text', [
			'input' => 'telefone2',
			'label' => 'Telefone 02',
			'largura' => 3, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'telefone2', 'placeholder' => 'Opcional...', 'class' => 'form-control form-control-sm telefone']])
		</div><!-- / row-->
	   
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
			'attributes' => ['id' => 'representante', 'placeholder' => 'Apanas pessoa jurídica.']])
		</div><!-- / row-->
	   
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
		</div>	<!-- / row-->
	{{Form::close()}} 
@endsection

 