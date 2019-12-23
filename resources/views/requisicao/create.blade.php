@extends('layouts.index')

@section('content')
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Nova Contratação</h1>
		</div>
	</div>

	{{ Form::open(['url' => 'requisicao/store', 'method' => 'post', 'class' => 'form-padrao']) }}
		
		<div class="row">
			@include('form.select', [
			'input' => 'requisitante', 
			'label' => 'Requisitante *', 
			'selected' => old($input ?? ''), 
			'largura' => 6,
			'options' => $requisitantes, 
			'attributes' => ['id' => 'requisitante', 'required' => '']])
		</div>
		
		<div class="row">
			@include('form.text', [
			'input' => 'descricao',
			'label' => 'Objeto *',
			'value' => old($input ?? ''),
			'largura' => 12, 
			'attributes' => ['id' => 'descricao', 'required' => '']])
	   </div>

	   	<div class="row">
			@include('form.textarea', [
			'input' => 'justificativa',
			'label' => 'Justificativa da Contratação *',
			'value' => old($input ?? ''),
			'largura' => 12, 
			'attributes' => ['id' => 'justificativa', 'required' => '',  'rows'=>'5']])
	    </div>
	   
	    <div class="row">
	    	@include('form.button', [
	    	'value' => 'Cancelar',
	    	'largura' 	=> 3,
	    	'class'		=> 'btn btn-primary btn-block',
	    	'url' 		=> 	route('requisicao'),
	    	'recuo' 	=> 3 ])

	    	@include('form.submit', [
	    	'input' => 'Cadastrar', 
	    	'largura' => 3])
	    </div>	
	{{ Form::close() }} 
@endsection

 