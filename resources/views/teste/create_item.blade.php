@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-12">
					<h1 class="center">Cadastrar Item</h1>
				</div>
			</div><!-- / row -->

			<div class="alert alert-default" role="alert">
				<h3>
					<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
					<a href="{{route('requisicaoExibir', [$requisicao->uuid])}}">Requisição n° {{$requisicao->numero ?? '' }} / {{$requisicao->ano ?? ''}}</a>
				</h3>
				<p><label> Objeto:</label> {{$requisicao->descricao ?? ''}}</p>
			</div> 
			<input type='hidden' id='licitacao' name='licitacao' value="{{$licitacao->uuid ?? ''}}">
		</div><!-- / panel-heading -->

		<div class="panel-body">
			{{Form::open(['url' => 'item/store', 'method' => 'post', 'class' => 'form-padrao'])}}
				{{ Form::hidden('requisicao', $requisicao->uuid)}}
				<div class="row">
					@include('form.number', [
					'input' => 'quantidade',
					'label' => 'Quantidade',			
					'largura' => 3, 
					'value' => old($input ?? ''),
					'attributes' => ['id' => 'quantidade', 'required' => '' ]])

					@include('form.number', [
					'input' => 'codigo',
					'label' => 'Código', 
					'largura' => 3, 
					'value' => old($input ?? ''),
					'attributes' => ['id' => 'codigo' ]])
					
					@include('form.select', [
					'input' => 'unidade', 
					'label' => 'Unidade',
					'largura' => 3,  
					'selected' => old($input ?? ''), 
					'options' => $unidades, 
					'attributes' => ['id' => 'unidade', 'required' => '']])

					@include('form.select', [
					'input' => 'grupo', 
					'label' => 'Grupo', 
					'largura' => 3,  
					'selected' => old($input ?? ''), 
					'options' => $grupos ?? '', 
					'attributes' => ['id' => 'grupo', 'disabled' => '']])
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
			   
				<div class="row">
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
		</div>
	</div>
</div>
@endsection

 