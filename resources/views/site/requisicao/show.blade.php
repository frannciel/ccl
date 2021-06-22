@extends('site.layouts.index')

@section('content')
	<div class="flex">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item"><a href="{{route('requisicao.index')}}">Requisicao</a></li>
				<li class="breadcrumb-item active" aria-current="page">Alterar</li>
			</ol>
		</nav>
		<h1 Class="page-header page-title">Alterar ou excluir requisição</h1>
	</div>

	{{ Form::open(['route' => ['requisicao.update', $requisicao->uuid], 'method' => 'post', 'class' => 'form-padrao']) }}			
		<div class="row">
			@include('form.text', [
			'input' => 'ordem',
			'label' => 'Número', 
			'largura' => 2,
			'value' => $requisicao->ordem ?? '',
			'attributes' => ['id' => 'ordem', 'disabled' => '' ]])

			@include('form.select', [
			'input' => 'requisitante', 
			'label' => 'Requisitante', 
			'largura' => 5,
			'selected' => old($input ?? '') ?? $requisicao->requisitante->uuid, 
			'options' => $requisitante, 
			'attributes' => ['id' => 'requisitante']])

			<div class="col-md-5 {{$errors->has('tipo') ? ' has-error' : '' }}">
				<label for="tipo">Tipo de Contratação *</label>
				<select name="tipo" class="form-control" selected="{{old('tipo' ?? '')}}" required>
					<option noSelected></option>
					<optgroup label="Material">
						<option value="1" {{$requisicao->tipo == 1 ? "selected":""}}>Permanente</option>
						<option value="2" {{$requisicao->tipo == 2 ? "selected":""}}>Consumo</option>
					</optgroup>
					<optgroup label="Serviço">
						<option value="3" {{$requisicao->tipo == 3 ? "selected":""}}>Não Continuado</option>
						<option value="4" {{$requisicao->tipo == 4 ? "selected":""}}>Continuado</option>
						<option value="5" {{$requisicao->tipo == 5 ? "selected":""}}>Tempo Indeterminado</option>
					</optgroup>
					<option value="6" {{$requisicao->tipo == 6 ? "selected":""}} class="font-weight-bold">Obra</option>
					<option value="7" {{$requisicao->tipo == 7? "selected":""}} class="font-weight-bold">Serviço de Engenharia</option>
				</select>
				@if ($errors->has('tipo'))
				<span class="help-block">
					<strong>{{ $errors->first('tipo') }}</strong>
				</span>
				@endif	
			</div>
		</div>

		<div class="row">
			@include('form.radioButton', [
			'input' => 'prioridade',
			'label' => 'Grau de Prioridade*',
			'value' => old($input ?? '') ?? $requisicao->prioridade,
			'largura' => 3, 
			'options' => ['1' => 'Alta', '2' => 'Média', '3' => 'Baixa' ], 
			'attributes' => ['id' => 'prioridade', 'required' => '']])

			@include('form.radioButton', [
			'input' => 'renovacao',
			'label' => 'Renovação de Contrato*',
			'value' => old($input ?? '') ?? $requisicao->renovacao,
			'largura' => 3, 
			'options' => ['1' => 'Sim', '2' => 'Não' ], 
			'attributes' => ['id' => 'renovacao', 'required' => '']])

			@include('form.radioButton', [
			'input' => 'capacitacao',
			'label' => 'Necessita Capacitação*',
			'value' => old($input ?? '') ?? $requisicao->capacitacao,
			'largura' => 3, 
			'options' => ['1' => 'Sim', '2' => 'Não' ], 
			'attributes' => ['id' => 'capacitacao', 'required' => '']])

			@include('form.radioButton', [
			'input' => 'pac',
			'label' => 'Registrado no PAC*',
			'value' => old($input ?? '') ?? $requisicao->pac,
			'largura' => 3, 
			'options' => ['1' => 'Sim', '2' => 'Não' ], 
			'attributes' => ['id' => 'pac', 'required' => '']])
		</div>

		<div class="row">
			@include('form.text', [
			'input' => 'descricao',
			'label' => 'Objeto', 
			'value' => old($input ?? '') ?? $requisicao->descricao ?? 'error',
			'attributes' => ['id' => 'descricao', 'required' => '', 'autocomplete' => 'off']])

			@include('form.textarea', [
			'input' => 'justificativa',
			'label' => 'Justificativa da Contratação*',
			'value' => old($input ?? '') ?? $requisicao->justificativa,
			'largura' => 12, 
			'attributes' => ['id' => 'justificativa',  'rows'=>'5']])
		</div>

		<div class="row">
			@include('form.text', [
			'input' => 'previsao',
			'label' => 'Data da Necessidade',
			'value' => old($input ?? '') ?? $requisicao->previsao,
			'largura' => 4, 
			'attributes' => ['id' => 'data']])

			@include('form.text', [
			'input' => 'metas',
			'label' => 'Código da(s) Meta(s) do PMI, separdas por vírgula',
			'value' => old($input ?? '') ?? $requisicao->metas,
			'largura' => 8, 
			'attributes' => ['id' => 'metas']])
		</div>

		<div class="row mt-2">
			<div class="col-md-3  col-md-offset-1">
				<a href="{{route('requisicao.index')}}" class="btn btn-primary btn-block font-weight-bold" type="button">Voltar</a>
			</div>

			@include('form.submit', [
			'input' => 'Salvar', 
			'largura' => 3 ])

			<div class="col-md-3">
				<button type="button" class="btn btn-danger btn-block font-weight-bold" data-toggle="modal" data-target="#mediumModalLabel">Excluir</button>
			</div>
		</div>
	{{ Form::close() }}


<div class="modal fade" id="mediumModalLabel" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-md-6">
						<h4 class="modal-title" id="mediumModalLabel">Apagar Requisição</h4>
					</div>
					<div class="col-md-6">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>	
			</div><!-- /.modal-header -->
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<h5>
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							Tem certeza que deseja excluir definitivamente esta Requisição? Isso também apaga todos os dados dos itens relacionados a ela.
						</h5>
					</div>
				</div>
			</div><!-- /.modal-body -->
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-3 col-md-offset-6">
						<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
					</div>
					<div class="col-md-3">
						<form action="{{route('requisicao.destroy', $requisicao->uuid)}}" method="post">
							{{csrf_field() }}
							<input type="hidden" name="_method" value="DELETE">
							<button type="submit" class="btn btn-danger btn-block">Excluir</button>
						</form>
					</div>
				</div>
			</div><!-- /.modal-footer -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{ Form::open(['url' => '', 'method' => 'POST', 'class' => 'form-padrao mt-4', 'id' => "form-requisicao-itens"]) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
				<div class="btn-group" role="group">
					<a type="button" class="btn btn-success btn-outline" title="Adicionar Novo Item" href="{{route('item.create', $requisicao->uuid)}}"><i class="glyphicon glyphicon-plus"></i></a>
				</div>
				<div class="btn-group" role="group">
					<a type="button"  class="btn btn-success btn-outline" title="Pesquisa de Preços" href="{{route('cotacao.create', ['requisicao' => $requisicao->uuid])}}"><i class="glyphicon glyphicon-usd"></i></a>
				</div>
				<div class="btn-group" role="group">
					<a type="button" class="btn btn-success btn-outline" title="Importar Dados" href="{{route('requisicao.importar', $requisicao->uuid)}}"><i class="fa fa-upload"></i></a>
				</div>
				<div class="btn-group" role="group">
					<a type="button" class="btn btn-success btn-outline" title="Relação de Itens" href="{{route('requisicao.documento', $requisicao->uuid)}}"><i class="glyphicon glyphicon-list"></i></a>
				</div>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-success btn-outline" data-modal="itens-duplicar" data-route="{{route('item.duplicar')}}" title="Duplicar itens"><i class="glyphicon glyphicon-duplicate"></i></button>
				</div>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-danger btn-outline" data-modal="itens-delete" data-route="{{route('item.deleteAll')}}" title="Excluir itens"><i class="glyphicon glyphicon-trash"></i></button>
				</div>
			</div>

			<div class="row text-center">
				<div class="col-md-12 mt-2 mb-2">
					<a type="button" class="btn btn-outline btn-primary rounded-pill" href="{{route('cotacao.relatorio', $requisicao->uuid)}}">
						Relatório de Pesquisa de Preços
					</a>
					<a type="button" class="btn btn-outline btn-primary rounded-pill" href="{{route('requisicao.pesquisa', $requisicao->uuid)}}" >
						Solicitação de Pesquisa de Preços
					</a>
					<a type="button" class="btn btn-outline btn-primary rounded-pill" href="{{route('requisicao.formalizacao', $requisicao->uuid)}}">
						Formalização de Demanda
					</a>
				</div>
			</div>
		</div><!-- panel-heading -->

		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered dataTable">
					<thead>
						<tr>
							<th class=" center"><input type="checkbox" id="ckAll" name="example1"></th>
						    <th class=" center">Número</th>
						    <th class=" center">Descrição Detalhada</th>
						    <th class=" center">Código</th>
						    <th class=" center">Unidade</th>
						    <th class=" center">Quantidade</th>
						</tr>
					</thead>

					<tbody>
						@forelse ($requisicao->itens->sortBy('numero') as $item)
						<tr>
							<td>
								<div class="input-group">
									<span class="input-group-addon">
										<input type="checkbox" class="chk" name="itens[]" value="{{$item->uuid}}" data-object="{{$item->numero}} - {{$item->objeto}}">
									</span>
									<a class="btn btn-default" href="{{route('item.edit', $item->uuid)}}" role="button">Detalhar</a>
								</div>
							</td>
							<td class="center">{{$item->numero}}</td>
							<td class="justificado">@php print($item->descricaoCompleta) @endphp</td>
							<td class="center">{{$item->codigo =='0'?'': $item->codigo}}</td>
							<td class="center">{{$item->unidade->nome}}</td>
							<td class="center">{{$item->quantidadeTotal}}</td>
						</tr>
						@empty
						<tr><td colspan=7><center><i> Nenhum item encontrado </i></center></td></tr>
						@endforelse
					</tbody>
				</table>
			</div><!-- table-responsive -->
		</div><!-- panel-body -->
	</div><!-- /.panel -->
{{ Form::close() }}
@endsection