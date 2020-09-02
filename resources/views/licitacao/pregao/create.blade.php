@extends('layouts.index')

@section('content')

<div class="panel panel-default mb-4">
	<div class="panel-heading text-center">
		<h2>CADASTRAR PREGÃO</h1>
	</div>

	<div class="panel-body">
		{{ Form::open(['url' => 'pregao/store', 'method' => 'post', 'class' => 'form-padrao']) }}

			<div class="row">
				@include('form.text', [
				'input' => 'ordem',
				'label' => 'Número', 
				'largura' => 2,
				'value' => old($input ?? ''),
				'attributes' => ['id' => 'ordem', 'placeholder' => '000/0000']])

				@include('form.text', [
				'input' => 'processo',
				'label' => 'Processo *',
				'value' => old($input ?? ''),
				'largura' => 3, 
				'attributes' => ['id' => 'processo', 'required' => '']])

				@include('form.select', [
				'input' => 'tipo', 
				'label' => 'Tipo *', 
				'selected' => old($input ?? '') ?? '3', 
				'largura' => 2,
				'options' => $tipos ?? '', 
				'attributes' => ['id' => 'tipo', 'readonly' => '']])

				@include('form.radioButton', [
				'input' => 'forma', 
				'label' => 'Forma *', 
				'value' => old($input ?? '') ?? $licitacao->licitacaoable->forma ?? '', 
				'largura' => 3,
				'options' => $formas ?? '', 
				'attributes' => ['id' => 'forma']])

				@include('form.radioButton', [
				'input' => 'srp',
				'label' => 'SRP ?*',
				'value' => old($input ?? '') ?? $licitacao->licitacaoable->srp ?? '',
				'largura' => 2,
				'options' => ['1' => 'SIM', '2' => 'NÃO',], 
				'attributes' => ['id' => 'srp', 'title' => 'Sistema de Registro de preços']])
			</div>
			
			<div class="row">
				@include('form.textarea', [
				'input' => 'objeto',
				'label' => 'Objeto*',
				'value' => old($input ?? '') ?? $licitacao->objeto ?? '',
				'largura' => 12, 
				'attributes' => ['id' => 'objeto', 'required' => '',  'rows'=>'5']])
			</div>

			<div class="row mt-2">
				<div class="col-md-3 col-md-offset-3">
					<a href="{{route('licitacao')}}" class="btn btn-primary btn-block" type="button">Voltar</a>
				</div>

				@include('form.submit', [
				'input' => 'Salvar', 
				'largura' => 3])
			</div>
		{{ Form::close() }} 
	</div>
</div>
@endsection