@extends('layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Atribuir Fornecedor</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<label for="cpf_cnpj" class="control-label">CPF/CNPJ Do Fornecedor</label>
			<div class="input-group custom-search-form">
				<input type="text" name="cpf_cnpj"  id="cpf_cnpj" class="form-control form-control-sm">
				<span class="input-group-btn">
					<button class="btn btn-success" type="button" onclick="getRazaoSocial('cpf_cnpj')">
						<i class="fa fa-search"></i>
					</button>
				</span>
			</div>
		</div>


		@include('form.text', [
		'input' => 'razao_social',
		'label' => 'Razão Social', 
		'largura' => 8, 
		'value' => old($input ?? ''),
		'attributes' => ['id' => 'razao_social', 'disabled' => '']])
	</div>
		
	<div class="row">
		<div class="col-md-3">
			<label for="numeroAno" class="control-label">Numero e Ano da Requisição</label>
			<div class="input-group custom-search-form">
				<input type="text" name="numeroAno"  id="numeroAno" class="form-control form-control-sm" placeholder="Exemplo 012019 ...">
				<span class="input-group-btn">
					<button class="btn btn-success" type="button" onclick="getDescricao('numeroAno')">
						<i class="fa fa-search"></i>
					</button>
				</span>
			</div>
		</div>
		
		@include('form.text', [
		'input' => 'descricao',
		'label' => 'Objeto', 
		'largura' => 8, 
		'value' => old($input ?? ''),
		'attributes' => ['id' => 'descricao', 'disabled' => '']])
	</div>
		
	<div class="row">
		<div class="col-md-4 col-md-offset-4" style="margin-top:20px;">
			<button class="btn btn-success btn-block" type="button" onclick="getItensTabela()">Buscar Itens</button>
		</div>
	</div>

	{{Form::open(['url' => '/item/fornecedor/store', 'method' => 'post', 'class' => 'form-padrao'])}}
	{{Form::close()}} 
</div>
@endsection
