@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Novo Participante</h1>
		</div>
	</div>
	
	{{Form::open(['url' => 'participante/store', 'method' => 'post', 'class' => 'form-padrao'])}}
	
		<div class="row">
			@include('form.number', [
			'input' => 'uasg',
			'label' => 'Código Uasg',			
			'largura' => 3, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'uasg', 'required' => '' ]])

			@include('form.text', [
			'input' => 'nome',
			'label' => 'Nome da Uasg', 
			'largura' => 9, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'nome' ]])
		</div>
		
		<div class="row">
			@include('form.submit', [
			'input' => 'Cadastrar',
			'largura' => 6,
			'recuo' => 3 ])
		</div>	
	{{Form::close()}} 
</div>
@endsection

 