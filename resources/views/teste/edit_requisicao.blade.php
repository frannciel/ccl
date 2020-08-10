@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Editar Solicitação de Contratação</h1>
		</div>
	</div>

	{{ Form::open(['url' => '/requisicao/update', 'method' => 'post', 'class' => 'form-padrao']) }}
				
		<div class="row">
			@include('form.text', [
			'input' => 'numero',
			'label' => 'Número', 
			'largura' => 3,
			'value' => $requisicao->numero,
			'attributes' => ['id' => 'numero', 'disabled' => '', 'class' => 'form-control form-control-sm' ]])

			@include('form.text', [
			'input' => 'ano',
			'label' => 'Ano', 
			'largura' => 3,
			'value' => $requisicao->ano,
			'attributes' => ['id' => 'ano', 'disabled' => '', 'class' => 'form-control form-control-sm']])

			@include('form.select', [
			'input' => 'requisitante', 
			'label' => 'Requisitante', 
			'largura' => 6,
			'selected' => $requisicao->requisitantes, 
			'options' => $requisitantes,
			'attributes' => ['id' => 'requisitante']])
		</div>
		
		<div class="row">
			@include('form.text', [
			'input' => 'descricao',
			'label' => 'Objeto', 
			'value' =>  $requisicao->descricao,
			'attributes' => ['id' => 'descricao', 'required' => '', 'class' => 'form-control form-control-sm' ]])
	   </div>
	   
		<div class="row">
			@include('form.button', [
	    	'value' => 'Cancelar',
	    	'largura' 	=> 3,
	    	'class'		=> 'btn btn-primary btn-block',
	    	'url' 		=> 	route('requisicao'),
	    	'recuo' 	=> 3 ])

			@include('form.submit', [
			'input' => 'Salvar', 
			'largura' 	=> 3])
		</div>	
	{{ Form::close() }} 
</div>
@endsection
