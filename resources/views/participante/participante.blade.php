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
			@include('form.select', [
			'input' => 'itens',
			'label' => 'Código Uasg',			
			'largura' => 3, 
			'value' => old($input ?? '') ?? $licitacao->codigo ?? '',
			'attributes' => ['id' => 'uasg', 'required' => '' ]])

			@include('form.text', [
			'input' => 'nome',
			'label' => 'Nome da Uasg', 
			'largura' => 9, 
			'value' => old($input ?? '') ?? $uasg->codigo ?? '',
			'attributes' => ['id' => 'nome', 'required' => '' ]])
			
			@include('form.text', [
			'input' => 'telefone',
			'label' => 'Telefone', 
			'largura' => 9, 
			'value' => old($input ?? '') ?? $uasg->telefone ?? '',
			'attributes' => ['id' => 'telefone' ]])
			
			@include('form.text', [
			'input' => 'email',
			'label' => 'E-mail', 
			'largura' => 9, 
			'value' => old($input ?? '') ?? $uasg->email ?? '',
			'attributes' => ['id' => 'email']])
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

 