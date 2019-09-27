@extends('layouts.index')

<!-- View de atualização de Itens da Licitação -->
@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Alterar Item</h1>
		</div>
	</div>

	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Requisição n° <a href="{{route('requisicaoExibir', [$item->requisicao->uuid])}}">{{$item->requisicao->numero ?? '' }} / {{$item->requisicao->ano ?? ''}}</a></h3>
		</div>
		<div class="panel-body">
			<label> Objeto:</label> {{$item->requisicao->descricao ?? ''}}
		</div>
	</div>

	{{Form::open(['url' => '/item/update', 'method' => 'post', 'class' => 'form-padrao'])}}

		@include('item.edit') <!-- Inclui os demais campus do formulário -->
		<div class="row">
			<div class="col-md-3 col-6 col-md-offset-3 mt-2">
				<a href="{{route('requisicaoExibir', [$item->requisicao->uuid])}}" class="btn btn-primary btn-block" type="button">Voltar</a>
			</div>

			@include('form.submit', [
			'input' => 'Salvar Alteração',
			'largura' => 3 ])
		</div>
	{{Form::close()}} 
</div>
@endsection