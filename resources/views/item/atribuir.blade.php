@extends('layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1>Atribuir Fornecedor</h1>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">

			<div class="alert alert-default" role="alert">
				<h3 >
					<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
					<a href="#">Pregão Eletrônico n°  001/2019</a>
				</h3>
				<p><label> Objeto da Licitação:</label>
				Icon classes cannot be directly combined with other components. They should not be used along with other classes on the same element. Instead, add a nested  and apply the icon classes to the.</p>
			</div> 

			<div class="row">
				<div class="col-md-6">
					<div class="input-group custom-search-form">
						<input type="text" name="cpf_cnpj"  id="cpf_cnpj" class="form-control form-control-sm">
						<span class="input-group-btn">
							<button class="btn btn-success" type="button" onclick="getRazaoSocial('cpf_cnpj')">
								<i class="fa fa-search"> Buscar Fornecedor</i>
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

<!-- 			<div class="row">
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
			</div> -->

		</div><!-- / panel-heading -->

		<div class="panel-body">

			{{Form::open(['url' => 'item/fornecedor/update', 'method' => 'post', 'class' => 'form-padrao'])}}
				<div class="row">
					@include('form.number', [
					'input' => 'numero',
					'label' => 'Número',			
					'largura' => 2, 
					'value' =>  old($input ?? '') ??  $item->numero ?? '' ,
					'attributes' => ['id' => 'numero', 'disabled' => '' ]])
		
					@include('form.text', [
					'input' => 'objeto',
					'label' => 'Objeto',
					'largura' => 10, 
					'value' => old($input ?? '') ?? $item->objeto ?? '',
					'attributes' => ['id' => 'objeto', 'autocomplete' => 'off', 'disabled' => '' ]])
				</div>

				<div class="row">
					@include('form.textarea', [
					'input' => 'descricao', 
					'label' => 'Descrição Detalhada', 
					'value' => old($input ?? '') ??  $item->descricao ?? '',
					'attributes' => ['id' => 'descricao',  'rows' => '4', 'disabled' => '' ]])

					@include('form.text', [
					'input' => 'unidade', 
					'label' => 'Unidade', 
					'largura' => 6, 
					'selected' => old($input ?? '') ?? $item->unidade->id ?? '', 
					'options' => $unidades ?? '', 
					'attributes' => ['id' => 'unidade', 'disabled' => '']])

					@include('form.text', [
					'input' => 'grupo', 
					'label' => 'Grupo', 
					'largura' => 6, 
					'selected' => old($input ?? '') ?? $item->grupo ?? '', 
					'options' => $grupos ?? '', 
					'attributes' => ['id' => 'grupo', 'disabled' => '']])
				</div>

				<nav aria-label="...">
					<ul class="pager">
						<li class="previous"><a href="#"><span aria-hidden="true">&larr;</span> Anterior</a></li>
						<li class="next disabled"><a href="#">Próximo <span aria-hidden="true">&rarr;</span></a></li>
					</ul>
				</nav>

				<div class="row">
					<div class="col-md-12">
						<h4 Class="center page-header">Preencha os campus abaixo de acordo com a proposta do fornecedor </h4>
					</div>
				</div>

				<div class="row">
				@include('form.text', [
					'input' => 'marca',
					'label' => 'Marca', 
					'largura' => 6, 
					'value' => old($input ?? '') ?? '',
					'attributes' => ['id' => 'marca','required' => '']])
				
					@include('form.text', [
					'input' => 'modelo',
					'label' => 'Modelo', 
					'largura' => 6, 
					'value' => old($input ?? '') ??'',
					'attributes' => ['id' => 'modelo', 'placeholder' => 'Opcional ...']])
				</div>
			
				<div class="row">
					<div class="col-md-6">
						<label for="numeroAno" class="control-label">Quantidade</label>
						<div class="input-group custom-search-form">
							<input type="text" name="cpf_cnpj"  id="quantidade" class="form-control form-control-sm">
							<span class="input-group-btn">
								<button class="btn btn-success" type="button" onclick="getRazaoSocial('cpf_cnpj')">
									<i class="glyphicon glyphicon-arrow-left"> Disponível 20</i>
								</button>
							</span>
						</div>
					</div>

					@include('form.text', [
					'input' => 'valor',
					'label' => 'Valor Unitário', 
					'largura' => 6, 
					'value' => old($input ?? '') ??  '',
					'attributes' => ['id' => 'valor', 'required' => '']])
				</div>

				<div class="row mt-2">
						<div class="col-md-3 col-6 col-md-offset-3 mt-2">
							<a href="#" class="btn btn-primary btn-block" type="button">Voltar</a>
						</div>

						@include('form.submit', [
						'input' => 'Cadastrar',
						'largura' => 3 ])
					</div>
			{{Form::close()}} 

<!-- 			<div class="row">
				<div class="col-md-4 col-md-offset-4" style="margin-top:20px;">
					<button class="btn btn-success btn-block" type="button" onclick="getItensTabela()">Buscar Itens</button>
				</div>
			</div> -->

			<ul>
				<li>Incluir funcionalidade de inserir a quantidade disponível no campo quantidade</li>
				<li><strike>Inserir os botões de navegação Avançar e Voltar, logo abaixo dos dados do item</strike></li>
				<li>Criar o jquery Javascript para inclui os dados dos itens da tabela no campos de item, clicando no item ou nos botões de navegação</li>
				<li>Criar a funcionalidade javascript que remove o item da tabela, ou atualiza a quantidade disponível</li>
				<li>Criar a função do controller que prepara a tabelas de itens</li>
				<li>Criar a função do controller que recebe via ajax item e fornecedor a serem incluido o no banco de dados, o retono desta função deverá indicar se a quantidade disponível do item deve ser atualizada ou se o item deverá ser removido da tabela de itens</li>
				<li>O termino da função Ajax deverá exibir uma mensagem de sucesso ou erro e limpar os dados dos campus de item, exceto o número do item</li>
			</ul>

		</div><!-- / panel-body -->

		<div class="panel-footer">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example" style="background: #fff">
					<thead>
						<tr>
							<th class="w-1 center">Número</th>
							<th class="w-4 center">Descrição Detalhada</th>
							<th class="w-2 center">Unidade</th>
							<th class="w-1 center">Quantidade</th>
							<th class="w-1 center">Grupo</th>
						</tr>
					</thead>

					<tbody>
						@forelse ($itens as $item)
						<tr data-disponivel-type="value" onclick="setQuantidadeDisponivel('{{$item->quantidadeTotalDisponivel}}')">
							<td class="w-1 center">{{$item->licitacao()->first()->pivot->ordem}}</td>
							<td class="w-4 justicado">@php print($item->descricaoCompleta) @endphp</td>
							<td class="w-2 center">{{$item->unidade->nome}}</td>
							<td class="w-1 center">{{$item->quantidadeTotal}}</td>
							<td class="w-1 center"></td>
							<!--<td>isset($item->grupo->numero) ? $item->grupo->numero : ''</td>-->
						</tr>
						@empty
						<tr><td colspan="7"><center><i> Nenhum item encontrado </i></center></td></tr>
						@endforelse

					</tbody>
				</table>
			</div><!-- table-responsive -->
		</div><!-- / panel-footer -->
	</div> <!-- / panel  -->
</div>
@endsection
