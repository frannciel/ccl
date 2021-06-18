@extends('site.layouts.index')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Atas de Registro de Preços</h1>
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
			'label' => 'Licitacao', 
			'largura' => 3,
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'processo']])

			@include('form.select', [
			'input' => 'tipo', 
			'label' => 'Fornecedor', 
			'selected' => old($input ?? ''), 
			'largura' => 3,
			'options' => $modalidades ?? '',
			'attributes' => ['id' => 'tipo']])

			@include('form.number', [
			'input' => 'numero',
			'label' => 'Status', 
			'largura' => 2,
			'value' =>' $requisicao->numero' ?? '',
			'attributes' => ['id' => 'numero', 'required' => '']])
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
						<th class="center">Numero</th>
						<th class="center">vigência</th>
						<th class="center">Pregão Eletônico</th>
						<th class="center">Fornecedor</th>
						<th class="center">Status</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($registroDePrecos as $ata)
						<tr class="pointer" onclick="location.href ='{{url('/registro/precos/documento', $ata->uuid)}}'; target='_blank';">
							<td class="center">{{$ata->numero}}/{{$ata->ano}}</td>
							<td class="center">{{$ata->vigencia_inicio}} - {{$ata->vigencia_fim}}</td>
							<td class="center">{{$ata->licitacao->numero}}/{{$ata->licitacao->ano}}</td>
							<td class="justificado">{{$ata->fornecedor->nome}}</td>
							<td class="center">Vigente</td>
						</tr>
					@empty
						<tr><td><center><i> Nenhuma Contratação  Encontrada </i></center></td></tr>
					@endforelse
				</tbody>
			</table> 
		</div>
	</div>
@endsection
