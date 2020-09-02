@extends('layouts.index')

@section('content')
<div class="panel panel-default mt-4">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2 class="center">ALTERAR OU EXCLUIR ITEM</h2>
			</div>
		</div><!-- / row -->

		<div class="row">
			<div class="col-md-12">
				<h3>
					<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
					<a href="{{route('requisicaoShow', [$item->requisicao->uuid])}}">Requisição n° {{$item->requisicao->ordem ?? '' }}</a>
				</h3>
				<p><label> Objeto:</label> {{$item->requisicao->descricao ?? ''}}</p>
			</div>
		</div><!-- / row -->
	</div><!-- / panel-heading -->

	<div class="panel-body">
	{{Form::open(['url' => '/item/update', 'method' => 'post', 'class' => 'form-padrao'])}}
		{{ Form::hidden('item', old($input ?? '') ?? $item->uuid)}}

		<div class="row">
			@include('form.number', [
			'input' => 'numero',
			'label' => 'Número',			
			'largura' => 3, 
			'value' =>  old($input ?? '') ??  $item->numero ,
			'attributes' => ['id' => 'numero', 'disabled' => '' ]])

			@include('form.number', [
			'input' => 'quantidade',
			'label' => 'Quantidade', 
			'largura' => 3, 
			'value' => old($input ?? '') ?? $item->quantidade,
			'attributes' => ['id' => 'quantidade', 'required' => '' ]])
			
			@include('form.number', [
			'input' => 'codigo',
			'label' => 'Código', 
			'largura' => 3, 
			'value' => old($input ?? '') ?? $item->codigo,
			'attributes' => ['id' => 'codigo', 'required' => '' ]])
			
			@include('form.select', [
			'input' => 'unidade', 
			'label' => 'Unidade', 
			'largura' => 3, 
			'selected' => old($input ?? '') ?? $item->unidade->id, 
			'options' => $unidades, 
			'attributes' => ['id' => 'unidade', 'required' => '']])
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
			'value' => old($input ?? '') ??  $item->descricao,
			'attributes' => ['id' => 'descricao', 'required' => '' ]])
		</div>

		<div class="row mt-2">
			@include('form.button', [
			'value' => 'Voltar',
			'largura' 	=> 3,
			'class'		=> 'btn btn-primary btn-block',
			'url' 		=> 	route('requisicaoShow',[$item->requisicao->uuid]),
			'recuo' 	=> 1 ])

			@include('form.submit', [
			'input' => 'Salvar',
			'largura' => 3 ])

			<div class="col-md-3">
				<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#mediumModalLabel">Excluir</button>
			</div>
		</div>
	{{Form::close()}} 
</div>

<div class="modal fade" id="mediumModalLabel" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-md-6">
						<h4 class="modal-title" id="mediumModalLabel">Apagar item</h4>
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
							Tem certeza que deseja excluir definitivamente este item?
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
						<form action="{{url('item/apagar', $item->uuid)}}" method="post">
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
@endsection