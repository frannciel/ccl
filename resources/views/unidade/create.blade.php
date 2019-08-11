@extends('index.app')

@section('content')

	{{Form::open(['rota' => '/item/stored', 'method' => 'post', 'class' => 'form-padrao'])}}
				
		<div class="row">
			@include('form.number', [
			'input' => 'quantidade',
			'label' => 'Quantidade', 
			'attributes' => ['id' => 'quantidade', 'required' => '', 'class' => 'form-control form-control-sm', 'value' => '{{ old($input) }}' ]])
			
			@include('form.number', [
			'input' => 'codigo',
			'label' => 'Código', 
			'attributes' => ['id' => 'codigo', 'required' => '', 'class' => 'form-control form-control-sm', 'value' => '{{ old($input) }}' ]])
		</div>
		
		<div class="row">
			@include('form.select', [
			'input' => 'unidade', 
			'label' => 'Unidade', 
			'selected' => '{{ old($input) }}', 
			'options' => $unidades,
			'attributes' => ['id' => 'unidade', 'class' => 'form-control form-control-sm']])
			
			@include('form.select', [
			'input' => 'grupo', 
			'label' => 'Grupo', 
			'selected' => '{{ old($input) }}', 
			'options' => $grupos,
			'attributes' => ['id' => 'grupo', 'class' => 'form-control form-control-sm']])
		</div>
					
		<div class="row">
			@include('form.textaraea', [
			'input' => 'descricao', 
			'label' => 'Descricao Detalhada do Item', 
			'attributes' => ['id' => 'dados', 'descricao' => '', 'class' => 'form-control form-control-sm', 'value' => '{{ old($input) }}' ]
			])
		</div>
	   
		<div class="row">
			@include('form.submit', [
			'input' => 'Cadastrar', 
			'attributes' => ['class' => 'btn btn-primary btn-block']])
		</div>	
		
	{{Form::close()}} 
@endsection

 