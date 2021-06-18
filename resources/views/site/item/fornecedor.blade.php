@extends('site.layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Atribuir Fornecedor</h1>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">

			<div class="row">
				<div class="col-md-6">
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

				@include('form.textarea', [
				'input' => 'razao_social',
				'label' => 'Razão Social *',
				'value' => old($input ?? '') ?? $fornecedor->razao_social ?? '',
				'largura' => 12, 
				'attributes' => ['id' => 'razao_social', 'required' => '',  'rows'=>'2', 'disabled' => '']])
			</div>
		
			<div class="row">
				<div class="col-md-6">
					<label for="numeroAno" class="control-label">Numero da Licitação</label>
					<div class="input-group custom-search-form">
						<input type="text" name="numeroAno"  id="numeroAno" class="form-control form-control-sm" placeholder="Exemplo 012019 ...">
						<span class="input-group-btn">
							<button class="btn btn-success" type="button" onclick="getDescricao('numeroAno')">
								<i class="fa fa-search"></i>
							</button>
						</span>
					</div>
				</div>

				@include('form.textarea', [
				'input' => 'objeto',
				'label' => 'Objeto da Licitação *',
				'value' => old($input ?? '') ?? $licitacao->objeto ?? '',
				'largura' => 12, 
				'attributes' => ['id' => 'objeto', 'required' => '',  'rows'=>'2', 'disabled' => '']])
			</div>
		
			<div class="row">
				<div class="col-md-4 col-md-offset-4" style="margin-top:20px;">
					<button class="btn btn-success btn-block" type="button" onclick="getItensTabela()">Buscar Itens</button>
				</div>
			</div>
		</div><!-- / panel-heading -->

		<div class="panel-body">
			{{Form::open(['url' => '/item/fornecedor/store', 'method' => 'post', 'class' => 'form-padrao'])}}
		
			{{Form::close()}} 
		</div><!-- / panel-body -->
	</div> <!-- / panel  -->
</div>
@endsection
