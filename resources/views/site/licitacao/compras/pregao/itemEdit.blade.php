@extends('site.layouts.index')

@section('content')
<div class="flex">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb mb-0">
			<li class="breadcrumb-item"><a href="{{route('.home')}}">Home</a></li>
			<li class="breadcrumb-item"><a href="{{route('licitacao.index')}}">Licitações</a></li>
			<li class="breadcrumb-item"><a href="{{route('licitacao.show',  $licitacao->uuid)}}">Pregão nº {{$licitacao->ordem ?? '' }}</a></li>
			<li class="breadcrumb-item active" aria-current="page">Alterar ou Remover</li>
		</ol>
	</nav>
	<h1 Class="page-header page-title">Alterar ou remover item</h1>
</div><!-- / flex -->

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h3>
					<i class="fa fa-shopping-cart "></i>
					Pregão n° {{$licitacao->ordem ?? '' }}
				</h3>
				<p><label> Objeto:</label> {{$licitacao->objeto ?? ''}}</p>
			</div><!-- / col -->
		</div><!-- / row -->
	</div><!-- / panel-heading -->
</div><!-- / panel -->

{{Form::open(['route' => ['pregao.item.update', $item->uuid], 'method' => 'post', 'class' => 'form-padrao'])}}

	@include('form.hidden', ['input' => '_method', 'value' => 'PUT', 'attributes' => [] ])

	<div class="row">
		@include('form.number', [
		'input' => 'numero',
		'label' => 'Número',			
		'largura' => 2, 
		'value' =>  old($input ?? '') ??  $item->ordem ,
		'attributes' => ['id' => 'numero', 'disabled' => '' ]])

		@include('form.number', [
		'input' => 'quantidade',
		'label' => 'Quantidade', 
		'largura' => 2, 
		'value' => old($input ?? '') ?? $item->quantidade,
		'attributes' => ['id' => 'quantidade', 'required' => '' ]])
		
		@include('form.number', [
		'input' => 'codigo',
		'label' => 'Código', 
		'largura' => 2, 
		'value' => old($input ?? '') ?? $item->codigo,
		'attributes' => ['id' => 'codigo', 'required' => '' ]])
		
		@include('form.select', [
		'input' => 'unidade', 
		'label' => 'Unidade', 
		'largura' => 3, 
		'selected' => old($input ?? '') ?? $item->unidade->uuid, 
		'options' => $unidades, 
		'attributes' => ['id' => 'unidade', 'required' => '']])

		@include('form.select', [
		'input' => 'grupo', 
		'label' => 'Grupo', 
		'largura' => 3, 
		'selected' => old($input ?? '') ?? $item->grupo, 
		'options' => $grupos ?? '', 
		'attributes' => ['id' => 'grupo', 'disabled' => '']])
	</div>

	<div class="row">
		@include('form.text', [
		'input' => 'objeto',
		'label' => 'Objeto',
		'value' => old($input ?? '') ?? $item->objeto,
		'attributes' => ['id' => 'objeto', 'autocomplete' => 'off' ]])
	</div>

	<div class="row">
		@include('form.textarea', [
		'input' => 'descricao', 
		'label' => 'Descrição Detalhada', 
		'value' => old($input ?? '') ??  strip_tags($item->descricao),
		'attributes' => ['id' => 'descricao', 'required' => '' ]])
	</div>

	<div class="row centered mt-2">
		<div class="font-weight-bold col-md-3 col-6">
			<a type="button" class="btn btn-primary btn-block font-weight-bold" href="{{route('licitacao.show', $licitacao->uuid)}}">Voltar</a>
		</div>

		@include('form.submit', [
		'input' => 'Salvar',
		'largura' => 3 ])

		<div class="col-md-3">
			<button type="button" class="btn btn-warning btn-block font-weight-bold" data-toggle="modal" data-target="#mediumModalLabel">Remover</button>
		</div>
	</div>
{{Form::close()}}

<div class="panel panel-default mt-3">
	<div class="panel-heading" data-toggle="collapse" href="#collapsePreco" role="button" aria-expanded="false" aria-controls="collapsePreco">
		<h3 class="page-title center">Pesquisa de preços</h3>
		<p class="panel-text center mb-2">Clique para adicionar ou excluir cotação de preços</p>
	</div>
	<div class="panel-body collapse" id="collapsePreco">
		<table class="table table-striped table-bordered t-w10 mt-2">
			<tr>
				<th class="center">#</th>
				<th class="center">Fonte:</th>
				<th class="center">Valor Unitário</th>
				<th class="center">Data/Hora:</th>
				<th class="center">
					<button class="btn btn-success" title="Adicionar pesquisa de preços" data-toggle="modal" data-target="#mediumModalLabel">
						<i class="fa fa-plus-square" aria-hidden="true"></i>
					</button>
				</th>
			</tr>
			@forelse ($item->cotacoes as $key => $cotacao)
				<tr >
					<td class="center">{{$key + 1}}</td>
					<td class="left">{{$cotacao->fonte ?? '' }}</td>
					<td class="center">{{$cotacao->contabil ?? '' }}</td>
					<td class="center">{{$cotacao->data  ?? ''}}</td>
					<td class="center">
						<button class="btn btn-default" title="Apagar cotação" data-modal="cotacao-delete" data-route="{{route('cotacao.destroy', $cotacao->uuid)}}">
							<i class="glyphicon glyphicon-trash text-red"></i>
						</button>
					</td>	
				</tr>
				@empty
					<tr><td colspan=4 class="center"><i> Nenhuma Uasg participante encontrada </i></td></tr>
				@endforelse
		</table>  
	</div>
</div>

<div class="panel panel-default mt-3">
	<div class="panel-heading" data-toggle="collapse" href="#collapseParticipante" role="button" aria-expanded="false" aria-controls="collapseParticipante">
		<h3 class="page-title center">Relação de unidades participantes</h3>
		<p class="panel-text center mb-2">Clique aqui para ver as unidades participante de registro de preços deste item</p>
	</div>
	<div class="panel-body collapse" id="collapseParticipante">
		<table class="table table-bordered table-striped">
			<thead>
				<tr class="table-dark">
					<th class="center">Código Uasg</th>
					<th class="center">Nome da Uasg</th>
					<th class="center">Local de Entrega </th>
						<th class="center">Quantidade </th>
					</tr>
			</thead>
			<tbody>
				@forelse ($item->participantes as $uasg)
					<tr onclick="location.href ='{{route('item.edit', [$item->id])}}'; target='_blank';" style="cursor: hand;">
						<td class="center">{{$uasg->codigo}}</td>
						<td class="center">{{$uasg->nome}}</td>
						<td class="center">{{$uasg->pivot->cidade->nome}} - {{$uasg->pivot->cidade->estado->nome}}</td>
							<td class="center">{{$uasg->pivot->quantidade}}</td>
					</tr>
				@empty
					<tr><td colspan=4 class="center"><i> Nenhuma Uasg participante encontrada </i></td></tr>
				@endforelse
				</tbody>
		</table>
	</div>
</div>

<div class="panel panel-default mt-3">
	<div class="panel-heading" data-toggle="collapse" href="#collapseFornecedor" role="button" aria-expanded="false" aria-controls="collapseFornecedor">
		<h3 class="page-title center">Relação de fornecedores</h3>
		<p class="panel-text center mb-2">Clique para ver os fornecedores vencedores deste item</p>
	</div>
	<div class="panel-body collapse" id="collapseFornecedor">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th class="center">CPF/CNPJ</th>
					<th class="center">Nome / Razão Social</th>
					<th class="center">Quantidade</th>
					<th class="center">Valor unit. proposta</th>
					</tr>
			</thead>
			<tbody>
				@forelse ($item->fornecedores as $value)
					<tr onclick="location.href ='{{route('item.fornecedorShow', [$value->uuid, $item->uuid])}}'; target='_blank';" style="cursor: hand;">
						<td class="center">{{$value->cpfCnpj}}</td>
						<td class="center">{{$value->nome}}</td>
						<td class="center">{{$value->pivot->quantidade}}</td>
							<td class="center">{{number_format($value->pivot->valor, 4, ',', '.')}}</td>
					</tr>
				@empty
					<tr><td colspan=4><center><i> Nenhum fornecedor encontrado </i></center></td></tr>
				@endforelse
				</tbody>
		</table>
	</div>
</div>

<div class="modal modal-success fade" id="mediumModalLabel" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<div class="row">
					<div class="col-md-6 col-xs-6">
						<h4 class="modal-title font-weight-bold" id="mediumModalLabel">Nova pesquisa de preços</h4>
					</div>
					<div class="col-md-6 col-xs-6">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>	
			</div><!-- /.modal-header -->
			{{Form::open(['route' => 'cotacao.store', 'method' => 'post', 'class' => 'form-padrao'])}}
				<div class="modal-body">
					<div class="row p-2">
						<input type="hidden" name="item" value="{{$item->uuid}}">
				
						@include('form.text', [
						'input' => 'data',
						'label' => 'Data da Cotação',
						'largura' => 4, 
						'value' => old($input ?? ''),
						'attributes' => ['id' => 'data', 'placeholder' => 'DD/MM/AAAA', 'autocomplete' => 'off', 'required' => '']])
				
						@include('form.text', [
						'input' => 'hora',
						'label' => 'Hora',
						'largura' => 4, 
						'value' => old($input ?? ''),
						'attributes' => ['id' => 'hora', 'placeholder' => 'HH:MM', 'autocomplete' => 'off']])
									
						@include('form.text', [
						'input' => 'valor',
						'label' => 'Valor Cotado', 
						'largura' => 4, 
						'value' => old($input ?? ''), 
						'attributes' => ['id' => 'valor', 'required' => '', 'autocomplete' => 'off' ]])
		
						@include('form.text', [
						'input' => 'fonte',
						'label' => 'Fonte de Pesquisa',			
						'largura' => 12, 
						'value' => old($input ?? ''),
						'attributes' => ['id' => 'fonte', 'required' => '' ]])
					</div>
				</div><!-- /.modal-body -->
				<div class="modal-footer">
					<div class="row centered">
						<div class="col-md-3">
							<button type="button" class="btn btn-primary btn-block font-weight-bold" data-dismiss="modal">Cancelar</button>
						</div>

						<div class="col-md-3">
							<button type="button" id="limpar" class="btn btn-warning btn-block font-weight-bold">Limpar</button>
						</div>

						@include('form.submit', [
						'input' => 'Salvar',
						'largura' => 3])
						</div>
					</div>
				</div><!-- /.modal-footer -->
			{{Form::close()}}
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
