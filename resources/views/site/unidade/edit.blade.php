@extends('index.app')

<!-- View de atualização de Requsisção -->
@section('content')

	{{Form::open(['rota' => '/unidade/update', 'method' => 'post', 'class' => 'form-padrao'])}}
				
		<div class="row">
			@include('form.text', [
			'input' => 'unidade',
			'label' => 'Unidade de Medida', 
			'attributes' => ['id' => 'unidade', 'required' => '', 'class' => 'form-control form-control-sm', 'value' => '{{ old($input) ?? $unidade->nome }}' ]])
			
			@include('form.text', [
			'input' => 'sigla',
			'label' => 'Sigla', 
			'attributes' => ['id' => 'sigla', 'required' => '', 'class' => 'form-control form-control-sm', 'value' => '{{ old($input) ?? $unidade->sigla }}' ]])
		</div>
	   
		<div class="row">
			@include('form.submit', [
			'input' => 'Cadastrar', 
			'attributes' => ['class' => 'btn btn-primary btn-block']])
		</div>	
		
	{{Form::close()}} 

@endsection
