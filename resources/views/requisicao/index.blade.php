@extends('layouts.index')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Solicitações de Contratação</h1>
		</div>
	</div>

	{{ Form::open(['url' => '/requisicao', 'method' => 'post', 'class' => 'form-padrao']) }}
		<div class="row">
			@include('form.text', [
			'input' => 'buscado',
			'label' => 'Objeto', 
			'largura' => 6,
			'attributes' => ['id' => 'buscado', 'required' => '' ]
			])

			@include('form.submit', [
			'input' => 'Buscar', 
			'largura' => 3 ])
			
			<div class="col-md-3" style="margin-top:20px;">
				<a href="{{route('requisicaoNova')}}" class="btn btn-primary btn-block" type="button">Nova Requisição</a>
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
						<th>Objeto</th>
						<th>Solicitante</th>
						<th>Data</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($requisicoes as $requisicao)
						<tr onclick="location.href ='{{url('/requisicao/exibir', $requisicao->id)}}'; target='_blank';" style="cursor: hand;">
							<td>{{$requisicao->numero}}</td>
							<td>{{$requisicao->ano}}</td>
							<td>{{$requisicao->descricao}}</td>
							<td>{{$requisicao->requisitantes()->first()['sigla']}}</td>
							<td>{{$requisicao->created_at}}</td>
						</tr>
					@empty
						<tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
					@endforelse
				</tbody>
			</table> 
		</div>
	</div>
@endsection
