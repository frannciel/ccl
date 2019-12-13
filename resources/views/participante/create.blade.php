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
			'input' => 'codigo',
			'label' => 'Código Uasg *',			
			'largura' => 3, 
			'value' => old($input ?? '') ?? $uasg->codigo ?? '',
			'attributes' => ['id' => 'codigo', 'required' => '' ]])

			@include('form.text', [
			'input' => 'nome',
			'label' => 'Nome da Uasg *', 
			'largura' => 9, 
			'value' => old($input ?? '') ?? $uasg->nome ?? '',
			'attributes' => ['id' => 'nome', 'required' => '' ]])
		</div> <!-- / row-->

		<div class="row">
			@include('form.text', [
			'input' => 'telefone',
			'label' => 'Telefone', 
			'largura' => 4, 
			'value' => old($input ?? '') ?? $uasg->telefone ?? '',
			'attributes' => ['id' => 'telefone' ]])
			
			@include('form.text', [
			'input' => 'email',
			'label' => 'E-mail', 
			'largura' => 4, 
			'value' => old($input ?? '') ?? $uasg->email ?? '',
			'attributes' => ['id' => 'email']])

			@include('form.text', [
			'input' => 'cidade',
			'label' => 'Cidade *', 
			'largura' => 4, 
			'value' => old($input ?? '') ?? $uasg->cidade ?? '',
			'attributes' => ['id' => 'cidade', 'required' => '' ]])
		</div> <!-- / row-->
		
		<div class="row">
			@include('form.submit', [
			'input' => 'Cadastrar',
			'largura' => 6,
			'recuo' => 3 ])
		</div>	<!-- / row-->
	{{Form::close()}} 
</div>
@endsection

 