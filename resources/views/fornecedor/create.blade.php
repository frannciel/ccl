@extends('layouts.index')

@section('content')
<div class="panel panel-default mt-2">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h1 Class="center">Novo Fornecedor</h1>
			</div>
		</div>
	</div>

	<div class="panel-body">
		{{Form::open(['url' => 'fornecedor/store', 'method' => 'post', 'class' => 'form-padrao'])}}
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
			</div>
		   
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
				'value' => old($input ?? ''),
				'attributes' => ['id' => 'cidade', 'required' => '']])
			</div>
		   
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
				'attributes' => ['id' => 'telefone1', 'required' => '']])

				@include('form.text', [
				'input' => 'telefone2',
				'label' => 'Telefone 02',
				'largura' => 3, 
				'value' => old($input ?? ''),
				'attributes' => ['id' => 'telefone2', 'placeholder' => 'Opcional...']])
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
				'attributes' => ['id' => 'representante', 'placeholder' => 'Apanas pessoa jurídica.']])
			</div>
		   
			<div class="row">
				<div class="col-md-3  col-md-offset-3 mt-2">
					<a href="{{route('fornecedor')}}" class="btn btn-primary btn-block" type="button">Voltar</a>
				</div>

				@include('form.submit', [
				'input' => 'Cadastrar',
				'largura' => 3 ])
			</div>	
		{{Form::close()}} 
	</div>
</div>
@endsection

 