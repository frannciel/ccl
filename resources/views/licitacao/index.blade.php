@extends('layouts.index')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Consultar Procedimentos</h1>
		</div>
	</div>

	{{ Form::open(['url' => '/requisicao', 'method' => 'post', 'class' => 'form-padrao']) }}
		<div class="row">
			@include('form.number', [
			'input' => 'numero',
			'label' => 'Número', 
			'largura' => 2,
			'value' =>' $requisicao->numero' ?? '',
			'attributes' => ['id' => 'numero', 'required' => '']])

			@include('form.number', [
			'input' => 'ano',
			'label' => 'Ano', 
			'largura' => 2,
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'ano']])

			@include('form.text', [
			'input' => 'processo',
			'label' => 'Processo', 
			'largura' => 3,
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'processo']])

			@include('form.select', [
			'input' => 'tipo', 
			'label' => 'Tipo', 
			'selected' => old($input ?? ''), 
			'largura' => 3,
			'options' => $modalidades ?? '',
			'attributes' => ['id' => 'tipo']])
		</div>

		<div class="row">

			@include('form.submit', [
			'input' => 'Buscar', 
			'largura' => 3,
			'recuo' => 3 ])

			<div class="col-md-3" style="margin-top:20px;">
				<a href="{{route('pregaoNovo')}}" class="btn btn-primary btn-block" type="button">Novo</a>
			</div>
		</div>
	{{ Form::close() }} 

	<div class="row">
		<div class="col-md-12">
			<table id="tabela" class="table table-hover tablesorter">
				<thead>
					<tr>
						<th>Numero</th>
						<th>Ano</th>
						<th>Modalidade</th>
						<th>Situação</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($licitacoes as $licitacao)
						<tr onclick="location.href ='{{url('/pregao/exibir', $licitacao->licitacaoable->uuid)}}'; target='_blank';" style="cursor: hand;">
							<td>{{$licitacao->numero}}</td>
							<td>{{$licitacao->ano}}</td>
							<td>{{$licitacao->licitacaoable_type}}</td>
							<td>"Em analise"</td>
						</tr>
					@empty
						<tr><td><center><i> Nenhuma Contratação  Encontrada </i></center></td></tr>
					@endforelse
				</tbody>
			</table> 
		</div>
	</div>
@endsection
