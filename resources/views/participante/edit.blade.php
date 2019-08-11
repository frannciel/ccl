@extends('layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Alterar Item</h1>
		</div>
	</div>

	{{Form::open(['url' => '/participante/update', 'method' => 'post', 'class' => 'form-padrao'])}}
		
		<div class="row">
			@include('form.number', [
			'input' => 'uasg',
			'label' => 'Código Uasg',			
			'largura' => 3, 
			'value' => old($input ?? '') ?? $participante->codigo,
			'attributes' => ['id' => 'uasg', 'required' => '' ]])

			@include('form.text', [
			'input' => 'nome',
			'label' => 'Nome da Uasg', 
			'largura' => 9, 
			'value' => old($input ?? '') ?? $participante->nome,
			'attributes' => ['id' => 'nome' ]])
		</div>
	   
		<div class="row">
			@include('form.submit', [
			'input' => 'Salvar',
			'largura' => 6,
			'recuo' => 3 ])
		</div>
	{{Form::close()}} 
</div>
@endsection
