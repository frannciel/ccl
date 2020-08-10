@extends('layouts.index')

@section('content')
<div class="panel panel-default mt-4">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2 class="center">NOVO ITEM</h2>
			</div>
		</div><!-- / row -->

		<div class="row">
			<div class="col-md-12">
				<h3>
					<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
					<a href="{{route('requisicaoExibir', [$requisicao->uuid])}}">Requisição n° {{$requisicao->ordem ?? '' }}</a>
				</h3>
				<p><label> Objeto:</label> {{$requisicao->descricao ?? ''}}</p>
			</div>
		</div><!-- / row -->
	</div><!-- / panel-heading -->

	<div class="panel-body">
		{{Form::open(['url' => 'item/store', 'method' => 'post', 'class' => 'form-padrao'])}}
			{{ Form::hidden('requisicao', $requisicao->uuid)}}
			<div class="row">
				@include('form.number', [
				'input' => 'quantidade',
				'label' => 'Quantidade',			
				'largura' => 4, 
				'value' => old($input ?? ''),
				'attributes' => ['id' => 'quantidade', 'required' => '' ]])

				@include('form.number', [
				'input' => 'codigo',
				'label' => 'Código', 
				'largura' => 4, 
				'value' => old($input ?? ''),
				'attributes' => ['id' => 'codigo' ]])
				
				@include('form.select', [
				'input' => 'unidade', 
				'label' => 'Unidade',
				'largura' => 4,  
				'selected' => old($input ?? ''), 
				'options' => $unidades, 
				'attributes' => ['id' => 'unidade', 'required' => '']])
			</div>

			<div class="row">
				@include('form.text', [
				'input' => 'objeto',
				'label' => 'Objeto',
				'value' => old($input ?? ''),
				'attributes' => ['id' => 'objeto', 'required' => '']])
			</div>

			<div class="row">
				@include('form.textarea', [
				'input' => 'descricao', 
				'label' => 'Descricao Detalhada', 
				'value' => old($input ?? ''),
				'attributes' => ['id' => 'descricao', 'required' => '' ]])
			</div>
		   
			<div class="row mt-2">
				@include('form.button', [
				'value' => 'Cancelar',
				'largura' 	=> 3,
				'class'		=> 'btn btn-primary btn-block',
				'url' 		=> 	route('requisicaoExibir', [$requisicao->uuid]),
				'recuo' 	=> 3 ])

				@include('form.submit', [
				'input' => 'Salvar',
				'largura' => 3 ])
			</div>	
		{{Form::close()}}
	</div><!-- / panel-body -->
</div>
@endsection

 