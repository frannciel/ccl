@extends('layouts.index')

@section('content')
<div class="panel panel-default mt-3">
	<div class="panel-heading text-center">
		<h2>REQUISIÇÕES</h1>
	</div>
	
	<div class="panel-body">
		{{ Form::open(['url' => '/requisicao', 'method' => 'post', 'class' => 'form-padrao']) }}
			<div class="row row-fluid">
				@include('form.text', [
				'input' => 'buscado',
				'label' => 'Objeto', 
				'largura' => 6,
				'attributes' => ['id' => 'buscado', 'required' => '' ]
				])

				@include('form.submit', [
				'input' => 'Buscar', 
				'largura' => 3 ])
				
				@include('form.button', [
				'value' => 'Nova Requisição',
				'largura' 	=> 3,
				'class'		=> 'btn btn-primary btn-block',
				'url' 		=> 	route('requisicaoNova')])
			</div>
		{{ Form::close() }} 
	</div>

	<div class="panel-footer">
		<div class="row">
			<div class="col-md-12">
				<table id="tabela" class="table table-hover tablesorter">
					<thead>
						<tr>
							<th class="text-left">Numero</th>
							<th class="text-left w-6">Objeto</th>
							<th class="text-left">Solicitante</th>
							<th class="text-left">Data</th>
						</tr>
					</thead>
					<tbody>
						@forelse ($requisicoes as $requisicao)
							<tr onclick="location.href ='{{url('/requisicao/exibir', $requisicao->uuid)}}'; target='_blank';" style="cursor: hand;">
								<td>{{$requisicao->ordem ?? 'error'}}</td>
								<td>{{$requisicao->descricao ?? 'error'}}</td>
								<td>{{$requisicao->requisitante->sigla ?? 'error'}}</td>
								<td>{{$requisicao->data ?? 'error'}}</td>
							</tr>
						@empty
							<tr><td><center><i> Nenhuma Requisição encontrada </i></center></td></tr>
						@endforelse
					</tbody>
				</table> 
			</div>
		</div>

		<div class="row">
			<div class="col-md-6" style="float: none; margin: 0 auto;">
				{{ $requisicoes->links() }}
			</div>
		</div>
	</div>

@endsection
