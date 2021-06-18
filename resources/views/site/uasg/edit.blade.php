@extends('layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')
<div class="panel panel-default mt-2">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h1 Class="center">Alterar (UASG)</h1>
			</div>
		</div>
	</div>

	<div class="panel-body">
	{{Form::open(['url' => 'uasg/update', 'method' => 'post', 'class' => 'form-padrao'])}}
		{{ Form::hidden('uasg', $uasg->uuid)}}
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
			@include('form.select', [
			'input' => 'estado',
			'label' => 'Estado *',
			'largura' => 6,
			'selected' => old($input ?? '') ?? $uasg->cidade->estado->sigla ?? '',
			'options' => $estados ?? '',
			'attributes' => ['id' => 'estado', 'required' => '']])

			@include('form.text', [
			'input' => 'cidade',
			'label' => 'Cidade *', 
			'largura' => 6, 
			'value' => old($input ?? '') ?? $uasg->cidade->nome ?? '',
			'attributes' => ['id' => 'cidade', 'required' => '' ]])
		</div> <!-- / row-->

		<div class="row">
			@include('form.text', [
			'input' => 'telefone',
			'label' => 'Telefone', 
			'largura' => 6, 
			'value' => old($input ?? '') ?? $uasg->telefone ?? '',
			'attributes' => ['id' => 'telefone' ]])
			
			@include('form.text', [
			'input' => 'email',
			'label' => 'E-mail', 
			'largura' => 6, 
			'value' => old($input ?? '') ?? $uasg->email ?? '',
			'attributes' => ['id' => 'email']])
		</div> <!-- / row-->
		
		<div class="row">
			@include('form.button', [
			'value' => 'Voltar',
			'largura' 	=> 3,
			'class'		=> 'btn btn-primary btn-block',
			'url' 		=> 	route('uasg'),
			'recuo' 	=> 3 ])

			@include('form.submit', [
			'input' => 'Cadastrar',
			'largura' => 3 ])
		</div>	<!-- / row-->
	{{Form::close()}} 
	</div><!-- / panel-body-->
@endsection
